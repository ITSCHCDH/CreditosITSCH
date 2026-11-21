<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Alumno;
use App\Models\Datos_familiares;
use App\Models\Direccion;
use App\Models\Familiar;
use App\Models\Historial_clinico;
use App\Models\Motivoreprobacion;
use App\Models\ObservacionAlumno;
use App\Models\Padres;
use App\Models\Personales;
use App\Models\Social;
use App\Models\Sit\Alumno as SitAlumno;
use App\Services\Sit\CarrerasSitService;
use Alert;

class JefesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:VIP_STA|STA_DEP_TUTORIA|STA_COR_CARRERA')->only(['index']);
        $this->middleware('permission:VIP_STA|STA_DEP_TUTORIA|STA_TUTOR|STA_COR_CARRERA')->only(['generacion','diagnostico','calSemaforos','ficha','storeAlumnoObs']);
    }

    public function index()
    {
        $usuario = Auth::User();
        $todas = $usuario->hasAnyPermission(['VIP_STA', 'STA_DEP_TUTORIA']);

        return view('sta/analisis_alumnos/index', [
            'grupo' => '',
            'carreras' => $this->carrerasParaVista($todas ? null : collect([$usuario->area])),
            'generaciones' => $this->generacionesParaVista(),
            'generacion' => '',
            'carrera' => '',
        ]);
    }

    public function generacion(Request $request)
    {
        $usuario = Auth::User();
        $todas = $usuario->hasAnyPermission(['VIP_STA', 'STA_DEP_TUTORIA']);
        $carreras = CarrerasSitService::visibles($todas ? null : collect([$usuario->area]), true);

        $carrera = $carreras->firstWhere('id', (int) $request->carrera);
        if (! $carrera) {
            Alert::warning('No tienes acceso a la carrera seleccionada')->showConfirmButton('Ok', '#3085d6');
            return redirect()->back();
        }

        // Alumnos del SIT: identidad en sit.users, carrera en sit.cat_carreras
        $grupo = SitAlumno::query()
            ->join('users as u', 'u.id', '=', 'alumnos.user_id')
            ->where('alumnos.carrera_id', $carrera->id)
            ->where('alumnos.anio_ingreso', (int) $request->generacion)
            ->orderBy('u.apellido_paterno')
            ->orderBy('u.apellido_materno')
            ->orderBy('u.nombre')
            ->select(
                'alumnos.no_control as control',
                'u.apellido_paterno as aPaterno',
                'u.apellido_materno as aMaterno',
                'u.nombre as nombre',
                'alumnos.semestre_actual as semestre',
                'alumnos.estatus as estatus'
            )
            ->get()
            ->map(fn ($fila) => (object) [
                'control' => $fila->control,
                'aPaterno' => $fila->aPaterno,
                'aMaterno' => $fila->aMaterno,
                'nombre' => $fila->nombre,
                'semestre' => $fila->semestre,
                'status' => self::estatusCorto($fila->estatus),
            ]);

        if ($grupo->isEmpty()) {
            Alert::warning('No hay alumnos registrados en esta generación')->showConfirmButton('Ok', '#3085d6');
            return redirect()->back();
        }

        // La ficha académica sigue viviendo en creditos mientras termina la migración
        $fichas = Alumno::whereIn('no_control', $grupo->pluck('control'))
            ->select('no_control', 'ficha')
            ->get()
            ->keyBy('no_control');

        foreach ($grupo as $alu) {
            $alu->ficha = optional($fichas->get($alu->control))->ficha ?? 0;
            $alu->semaforos = self::calSemaforos($alu->control);
        }

        return view('sta.analisis_alumnos.index', [
            'grupo' => $grupo,
            'carreras' => $this->carrerasParaVista($todas ? null : collect([$usuario->area])),
            'generaciones' => $this->generacionesParaVista(),
            'generacion' => $request->generacion,
            'carrera' => $request->carrera,
        ]);
    }

    public function diagnostico($nc)
    {
        $alumno = SitAlumno::with(['user', 'carrera'])->where('no_control', $nc)->first();

        if (! $alumno) {
            Alert::error('Error', 'El alumno no existe en SIT');
            return redirect()->route('analisis.index');
        }

        $buscarAlumno = (object) [
            'alu_NumControl' => $alumno->no_control,
            'alu_StatusAct' => self::estatusCorto($alumno->estatus),
            'alu_Nombre' => $alumno->user?->nombre,
            'alu_ApePaterno' => $alumno->user?->apellido_paterno,
            'alu_ApeMaterno' => $alumno->user?->apellido_materno,
            'alu_SemestreAct' => $alumno->semestre_actual,
            'car_Nombre' => $alumno->carrera?->nombre,
            'alu_Sexo' => $alumno->genero === 'F' ? 'Femenino' : 'Masculino',
            'observaciones' => ObservacionAlumno::where('no_control', $alumno->no_control)->value('observaciones')
                ?: ($alumno->observaciones ?: 'Sin observaciones'),
        ];

        $buscarAlumno->semaforos = self::calSemaforos($alumno->no_control);

        // Grupos en los que está inscrito el alumno
        $GetGrupos = DB::connection('sit')->table('listas')
            ->join('grupos', 'grupos.id', '=', 'listas.grupo_id')
            ->where('listas.alumno_id', $alumno->id)
            ->select('grupos.clave_grupo as gse_Observaciones')
            ->distinct()
            ->orderBy('grupos.clave_grupo')
            ->get();

        // Calificaciones parciales por unidad: listas + lista_unidades + grupos
        $calificaciones = DB::connection('sit')->table('listas')
            ->join('grupos', 'grupos.id', '=', 'listas.grupo_id')
            ->join('cat_materias', 'cat_materias.id', '=', 'grupos.materia_id')
            ->join('catedraticos', 'catedraticos.id', '=', 'listas.catedratico_id')
            ->join('users as docente', 'docente.id', '=', 'catedraticos.user_id')
            ->join('lista_unidades', 'lista_unidades.lista_id', '=', 'listas.id')
            ->where('listas.alumno_id', $alumno->id)
            ->orderBy('listas.id')
            ->orderBy('lista_unidades.numero_unidad')
            ->orderByDesc('lista_unidades.oportunidad')
            ->orderByDesc('lista_unidades.id')
            ->select(
                DB::raw("CONCAT_WS(' ', docente.nombre, docente.apellido_paterno, docente.apellido_materno) as profesor"),
                'cat_materias.nombre as ret_NomCompleto',
                'cat_materias.num_temas as ret_NumUnidades',
                'lista_unidades.calificacion as lsc_Calificacion',
                'lista_unidades.numero_unidad as lsc_NumUnidad',
                'lista_unidades.corte as lsc_Corte',
                'listas.id as lse_clave'
            )
            ->get();

        // Una sola fila por unidad (la última oportunidad capturada)
        $unicaPorUnidad = [];
        foreach ($calificaciones as $fila) {
            $clave = $fila->lse_clave.'|'.$fila->lsc_NumUnidad;
            if (! isset($unicaPorUnidad[$clave])) {
                $unicaPorUnidad[$clave] = $fila;
            }
        }
        $calificaciones = collect(array_values($unicaPorUnidad))
            ->sortBy([['lse_clave', 'asc'], ['lsc_NumUnidad', 'asc']])
            ->values();

        $GetMaxUnidad = $calificaciones->pluck('lsc_NumUnidad')
            ->unique()
            ->sort()
            ->values()
            ->map(fn ($unidad) => (object) ['lsc_NumUnidad' => (int) $unidad]);

        $variablegrupo = $GetGrupos->isNotEmpty() ? 'Grupos : ' : '';
        if ($calificaciones->isNotEmpty()) {
            $variableCalificaciones = 'Calificaciones Parciales';
            $unidadesvariable = 'Materias';
        } else {
            $variableCalificaciones = 'Sin calificaciones parciales';
            $unidadesvariable = 'Sin materias asignadas';
        }

        // Kardex: calificaciones finales por materia
        $GetCardex = DB::connection('sit')->table('kardex')
            ->join('cat_materias', 'cat_materias.id', '=', 'kardex.materia_id')
            ->leftJoin('cat_periodos_escolares as periodo', 'periodo.id', '=', 'kardex.periodo_id')
            ->where('kardex.alumno_id', $alumno->id)
            ->orderBy('kardex.semestre')
            ->select(
                DB::raw('periodo.nombre as cdx_AnioXPrime'),
                'cat_materias.nombre as ret_NomCompleto',
                'kardex.calificacion_final as cdx_Calif',
                'kardex.semestre as cdx_SemXPrime',
                DB::raw('COALESCE(kardex.opcion_acreditacion_numerico, kardex.ultima_opcion) as cdx_UltOpcAcred')
            )
            ->get();

        $comentarios = Motivoreprobacion::where('no_control', $nc)->get();

        // Agrupar calificaciones por materia (mismo criterio que la vista)
        $temp = '';
        $con = 0;
        $materias = [];
        foreach ($calificaciones as $calificacion) {
            if ($temp != $calificacion->lse_clave) {
                $temp = $calificacion->lse_clave;
                $con++;
            }
            $calificacion->comentario = '';
            $calificacion->motivo = 0;
            foreach ($comentarios as $comentario) {
                if ((int) $comentario->num_tema === (int) $calificacion->lsc_NumUnidad
                    && ($comentario->materia === $calificacion->ret_NomCompleto || $comentario->lse_clave == $calificacion->lse_clave)) {
                    $calificacion->comentario = $comentario->comentario;
                    $calificacion->motivo = $comentario->motivos;
                }
            }
            $materias[$con][] = $calificacion;
        }

        return view('sta.analisis_alumnos.diagnostico')
            ->with('alumnos', $buscarAlumno)
            ->with('grupos', $GetGrupos)
            ->with('unidades', $GetMaxUnidad)
            ->with('calificacionesvariable', $variableCalificaciones)
            ->with('unidadesvariable', $unidadesvariable)
            ->with('variablegrupo', $variablegrupo)
            ->with('cardex', $GetCardex)
            ->with('materias', $materias);
    }

    /**
     * Semáforos del alumno. Los indicadores académicos salen de sit.kardex
     * (opcion_acreditacion_numerico) y el servicio social de las materias con
     * concepto 'servicio_social'.
     */
    public static function calSemaforos($nc)
    {
        $alumno = SitAlumno::where('no_control', $nc)->first();
        $semaforos = [];
        $status = $alumno ? self::estatusCorto($alumno->estatus) : null;

        $indicesAcad = $alumno ? DB::connection('sit')->table('kardex')
            ->where('alumno_id', $alumno->id)
            ->select(
                DB::raw('SUM(CASE WHEN opcion_acreditacion_numerico = 2 THEN 1 ELSE 0 END) AS nivelacionesOrdinario'),
                DB::raw('SUM(CASE WHEN opcion_acreditacion_numerico = 3 THEN 1 ELSE 0 END) AS repeticiones'),
                DB::raw('SUM(CASE WHEN opcion_acreditacion_numerico = 4 THEN 1 ELSE 0 END) AS nivelacionesRepe'),
                DB::raw('SUM(CASE WHEN opcion_acreditacion_numerico = 5 THEN 1 ELSE 0 END) AS especiales'),
                DB::raw('SUM(CASE WHEN opcion_acreditacion_numerico = 6 THEN 1 ELSE 0 END) AS nivelacionesEspecial')
            )
            ->first() : null;

        if ($indicesAcad !== null && $indicesAcad->nivelacionesOrdinario !== null) {
            $nivelaciones = (int) $indicesAcad->nivelacionesOrdinario
                + (int) $indicesAcad->nivelacionesRepe
                + (int) $indicesAcad->nivelacionesEspecial;

            switch (true) {
                case $status === 'BD':
                    $semaforos['semaforoAcad'] = 'CirculoNegro';
                    $semaforos['titleAcad'] = 'Ya no es posible realizar acciones de seguimiento con este alumno';
                    break;
                case (int) $indicesAcad->especiales > 0 || $nivelaciones >= 10 || (int) $indicesAcad->repeticiones > 2 || $status === 'BT':
                    $semaforos['semaforoAcad'] = 'CirculoRojo';
                    $semaforos['titleAcad'] = 'El alumno tiene problemas académicos graves, urgente dar seguimiento';
                    break;
                case ((int) $indicesAcad->repeticiones <= 2 && ($nivelaciones >= 3 && $nivelaciones < 10)):
                    $semaforos['semaforoAcad'] = 'CirculoNaranja';
                    $semaforos['titleAcad'] = 'El alumno tiene problemas académicos moderados, se recomienda dar seguimiento';
                    break;
                case $nivelaciones > 1 && $nivelaciones < 3:
                    $semaforos['semaforoAcad'] = 'CirculoAmarillo';
                    $semaforos['titleAcad'] = 'El alumno tiene problemas académicos leves, se recomienda observación';
                    break;
                case $nivelaciones <= 1:
                    $semaforos['semaforoAcad'] = 'CirculoVerde';
                    $semaforos['titleAcad'] = 'El alumno no tiene problemas académicos';
                    break;
                default:
                    $semaforos['semaforoAcad'] = 'CirculoNegro';
                    $semaforos['titleAcad'] = 'No se pudo calcular el semáforo académico';
                    break;
            }
        } else {
            $semaforos['semaforoAcad'] = 'CirculoNegro';
            $semaforos['titleAcad'] = 'Este alumno aún no tiene indicadores académicos registrados';
        }

        // Los semáforos médico y psicológico aún no tienen fuente en SIT
        $semaforos['semaforoPsico'] = 'CirculoNegro';
        $semaforos['semaforoMedico'] = 'CirculoNegro';

        // Servicio social: materias con concepto 'servicio_social' en el kardex
        $ssExists = $alumno && DB::connection('sit')->table('kardex')
            ->join('cat_materias', 'cat_materias.id', '=', 'kardex.materia_id')
            ->where('kardex.alumno_id', $alumno->id)
            ->where('cat_materias.concepto', 'servicio_social')
            ->exists();

        if ($ssExists) {
            $semaforos['semaforoServicio'] = 'CirculoVerde';
            $semaforos['titleSS'] = 'El servicio social ya fue registrado';
            return $semaforos;
        }

        $plan = $alumno?->planEstudio;
        if (! $alumno || ! $plan) {
            $semaforos['semaforoServicio'] = 'CirculoNegro';
            $semaforos['titleSS'] = 'Este alumno no tiene registros de servicio social';
            return $semaforos;
        }

        if ($status === 'BT' || $status === 'BD') {
            $semaforos['semaforoServicio'] = 'CirculoNegro';
            $semaforos['titleSS'] = 'El status del alumno es baja, consultar con servicios escolares';
            return $semaforos;
        }

        $creditosAcumulados = (int) DB::connection('sit')->table('kardex')
            ->where('alumno_id', $alumno->id)
            ->where('acreditada', 1)
            ->sum('creditos_materia');
        $creditosTotales = max(1, (int) $plan->creditos_totales);
        $credAvance = ($creditosAcumulados * 100) / $creditosTotales;
        $semestre = (int) $alumno->semestre_actual;

        if ($semestre <= 7) {
            $semaforos['semaforoServicio'] = 'CirculoAzul';
            $semaforos['titleSS'] = 'Este alumno aún no reune los requisitos para tramitar servicio social';
        } elseif ($semestre == 8 && $credAvance >= 80) {
            $semaforos['semaforoServicio'] = 'CirculoNaranja';
            $semaforos['titleSS'] = 'Verificar que el alumno este realizando servicio social';
        } elseif ($semestre >= 9) {
            $semaforos['semaforoServicio'] = 'CirculoRojo';
            $semaforos['titleSS'] = 'Servicio social retrasado, urgente dar seguimiento';
        } else {
            $semaforos['semaforoServicio'] = 'CirculoNegro';
            $semaforos['titleSS'] = 'Este alumno no tiene registros de servicio social';
        }

        return $semaforos;
    }

    public function ficha($nc, $usr)
    {
        try {
            $alumnoSit = SitAlumno::with(['user', 'carrera'])->where('no_control', $nc)->first();
            if (! $alumnoSit) {
                Alert::error('Error', 'El alumno no existe en SIT');
                return $usr == 1 ? redirect()->route('analisis.index') : back();
            }

            $alu1 = (object) [
                'alu_NumControl' => $alumnoSit->no_control,
                'alu_Nombre' => $alumnoSit->user?->nombre,
                'alu_ApePaterno' => $alumnoSit->user?->apellido_paterno,
                'alu_ApeMaterno' => $alumnoSit->user?->apellido_materno,
                'alu_Sexo' => $alumnoSit->genero,
            ];
            $car = (object) ['car_NombreCorto' => $alumnoSit->carrera?->nombre_corto ?: $alumnoSit->carrera?->nombre];
            $alu2 = (object) ['alc_FechaNac' => $alumnoSit->fecha_nacimiento];

            // Los datos socioeconómicos siguen en creditos y se enlazan por el id local
            $alu = Alumno::where('no_control', $nc)->first();
            $idAlu = $alu?->id;

            $clinicos = $idAlu ? Historial_clinico::where('id_alu', $idAlu)->first() : null;
            $padres = $idAlu
                ? Padres::where('id_alu', $idAlu)->whereIn('parentesco', ['Padre', 'Madre'])->get()
                : collect();

            if ($padres->count() == 2) {
                $direccion = Direccion::where('id_alu', $idAlu)->first();
                $direccionP = Direccion::where('id_fam', $padres[0]->id)->first();
                $direccionM = Direccion::where('id_fam', $padres[1]->id)->first();
                $familiares = Familiar::where('id_alu', $idAlu)->get();
                $person = Personales::where('id_alu', $idAlu)->first();
                $fam = Datos_familiares::where('id_alu', $idAlu)->first();
                $soc = Social::where('id_alu', $idAlu)->first();

                return view('sta.analisis_alumnos.ficha', compact('familiares', 'alu1', 'alu2', 'car', 'padres', 'direccion', 'direccionP', 'direccionM', 'soc', 'alu', 'clinicos', 'person', 'fam'));
            }

            Alert::error('Error', 'Este alumno no ha llenado su ficha académica');
            return $usr == 1 ? redirect()->route('analisis.index') : back();
        } catch (\Throwable $e) {
            report($e);
            Alert::error('Error', 'Ocurrió un error al cargar la ficha: '.$e->getMessage());
            return back();
        }
    }

    /**
     * Observaciones del alumno. SIT es solo de consulta: se guardan en
     * creditos.observaciones_alumnos, asociadas por número de control.
     */
    public function storeAlumnoObs(Request $request)
    {
        $noControl = trim((string) $request->no_Control);

        try {
            $existe = SitAlumno::where('no_control', $noControl)->exists();

            if (! $existe) {
                return response()->json([
                    'mensaje' => 'No se encontró el alumno '.$noControl.' en la base de datos de SIT',
                    'status' => 404,
                ], 404);
            }

            ObservacionAlumno::updateOrCreate(
                ['no_control' => $noControl],
                ['observaciones' => $request->observaciones]
            );

            return response()->json([
                'mensaje' => 'Observaciones guardadas correctamente',
                'status' => 200,
                'noControl' => $noControl,
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'mensaje' => 'Error al guardar las observaciones: '.$e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }

    /** Catálogo de carreras con los nombres que espera la vista. */
    private function carrerasParaVista($areasCredito = null)
    {
        return CarrerasSitService::visibles($areasCredito, true)
            ->map(fn ($carrera) => (object) [
                'car_Clave' => $carrera->id,
                'car_Nombre' => $carrera->nombre,
            ]);
    }

    /** Generaciones disponibles según sit.alumnos.anio_ingreso. */
    private function generacionesParaVista()
    {
        return SitAlumno::query()
            ->select('anio_ingreso')
            ->where('anio_ingreso', '>', 0)
            ->whereNotNull('anio_ingreso')
            ->distinct()
            ->orderByDesc('anio_ingreso')
            ->pluck('anio_ingreso')
            ->map(fn ($anio) => (object) ['Alu_AnioIngreso' => (int) $anio]);
    }

    /** Equivalencia entre el estatus de SIT y las claves que usa la vista. */
    private static function estatusCorto(?string $estatus): string
    {
        return match ($estatus) {
            'Baja definitiva' => 'BD',
            'Baja temporal' => 'BT',
            'Egresado', 'Titulado' => 'EG',
            default => 'VI',
        };
    }
}
