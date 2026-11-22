<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\AlumnoCreditosPerfil;
use App\Models\Datos_familiares;
use App\Models\Direccion;
use App\Models\Familiar;
use App\Models\Historial_clinico;
use App\Models\Motivoreprobacion;
use App\Models\Padres;
use App\Models\Personales;
use App\Models\Social;
use App\Models\Sit\Alumno as SitAlumno;
use App\Services\Sit\CarrerasSitService;
use App\Services\Sit\TrayectoriaAcademicaService;
use Alert;
use App\Services\Sta\FichaAlumnoService;

class JefesController extends Controller
{
    public function __construct(
        private FichaAlumnoService $fichaAlumno,
        private TrayectoriaAcademicaService $trayectoria
    )
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

        $fichas = AlumnoCreditosPerfil::whereIn('no_control', $grupo->pluck('control'))
            ->select('no_control', 'ficha_completada')
            ->get()
            ->keyBy('no_control');

        foreach ($grupo as $alu) {
            $alu->ficha = optional($fichas->get($alu->control))->ficha_completada ? 1 : 0;
            $alu->semaforos = $this->calSemaforos($alu->control);
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
            'observaciones' => AlumnoCreditosPerfil::where('no_control', $alumno->no_control)
                ->value('observaciones_tutoria') ?: 'Sin observaciones',
        ];

        $buscarAlumno->semaforos = $this->calSemaforos($alumno->no_control);

        // Grupos en los que está inscrito el alumno
        $GetGrupos = DB::connection('sit')->table('listas')
            ->join('grupos', 'grupos.id', '=', 'listas.grupo_id')
            ->where('listas.alumno_id', $alumno->id)
            ->select('grupos.clave_grupo as gse_Observaciones')
            ->distinct()
            ->orderBy('grupos.clave_grupo')
            ->get();

        // Calificaciones parciales centralizadas en el servicio de trayectoria.
        $calificaciones = $this->trayectoria->materiasUnidades($alumno)
            ->map(fn ($fila) => (object) [
                'profesor' => $fila->docente,
                'ret_NomCompleto' => $fila->materia ?: 'Materia sin registrar',
                'ret_NumUnidades' => (int) ($fila->num_unidades ?? 0),
                'lsc_Calificacion' => $fila->calificacion,
                'lsc_NumUnidad' => $fila->numero_unidad,
                'lsc_Corte' => $fila->corte,
                'lse_clave' => $fila->lista_id,
            ]);

        // Una sola fila por unidad (la última oportunidad capturada)
        $unicaPorUnidad = [];
        foreach ($calificaciones as $fila) {
            $clave = $fila->lse_clave.'|'.($fila->lsc_NumUnidad ?? '-');
            if (! isset($unicaPorUnidad[$clave])) {
                $unicaPorUnidad[$clave] = $fila;
            }
        }
        $calificaciones = collect(array_values($unicaPorUnidad))
            ->sortBy([['lse_clave', 'asc'], ['lsc_NumUnidad', 'asc']])
            ->values();

        // Columnas: todas las unidades de la materia con más temas del alumno
        // (para las demás, las unidades que no existen se marcan aparte).
        $maxUnidades = max(
            (int) $calificaciones->max('ret_NumUnidades'),
            (int) $calificaciones->max('lsc_NumUnidad')
        );
        $GetMaxUnidad = $maxUnidades > 0
            ? collect(range(1, $maxUnidades))->map(fn ($unidad) => (object) ['lsc_NumUnidad' => $unidad])
            : collect();

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
            ->with('sitUrl', (string) config('services.sit.perfil_url'))
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
    public function calSemaforos($nc)
    {
        $alumno = SitAlumno::where('no_control', $nc)->first();
        if (! $alumno) {
            return [
                'semaforoAcad' => 'CirculoNegro',
                'titleAcad' => 'Este alumno aún no tiene indicadores académicos registrados',
                'semaforoPsico' => 'CirculoNegro',
                'semaforoMedico' => 'CirculoNegro',
                'semaforoServicio' => 'CirculoNegro',
                'titleSS' => 'Este alumno no tiene registros de servicio social',
            ];
        }

        return $this->trayectoria->semaforos($alumno);
    }

    public function ficha($nc, $usr)
    {
        try {
            $ficha = $this->fichaAlumno->obtener($nc);
            if (! $ficha) {
                Alert::error('Error', 'El alumno no existe en SIT');
                return $usr == 1 ? redirect()->route('analisis.index') : back();
            }
            $alumnoSit = $ficha['sit']['alumno'];
            $historico = $ficha['historico_legacy'];
            $sitUrl = $ficha['url'];

            $alu1 = (object) [
                'alu_NumControl' => $alumnoSit->no_control,
                'alu_Nombre' => $alumnoSit->user?->nombre,
                'alu_ApePaterno' => $alumnoSit->user?->apellido_paterno,
                'alu_ApeMaterno' => $alumnoSit->user?->apellido_materno,
                'alu_Sexo' => $alumnoSit->genero,
            ];
            $car = (object) ['car_NombreCorto' => $alumnoSit->carrera?->nombre_corto ?: $alumnoSit->carrera?->nombre];
            $alu2 = (object) [
                'alc_FechaNac' => $alumnoSit->fecha_nacimiento,
                'alc_Direccion' => $ficha['complemento']?->direccion,
                'alc_Colonia' => $ficha['complemento']?->colonia,
                'alc_CodPostal' => $ficha['complemento']?->cp,
                'alc_TipoSangre' => $ficha['dato_medico']?->tipo_sangre,
            ];

            $perfil = AlumnoCreditosPerfil::where('no_control', $nc)->first();
            $alu = (object) [
                'id' => $alumnoSit->id,
                'no_control' => $alumnoSit->no_control,
                'ficha_completada' => (bool) ($perfil?->ficha_completada),
                'foto' => $perfil?->foto,
                'lug_pro' => $ficha['complemento']?->ciudad
                    ?: ($ficha['complemento']?->municipio?->nombre ?: 'No registrado'),
                'tel' => $alumnoSit->user?->celular,
                'email' => $alumnoSit->email_institucional ?: $alumnoSit->user?->email,
                'emailPer' => $ficha['complemento']?->email_personal,
                'est_civ' => 'No registrada',
                'grupo' => null,
            ];
            $idAlu = $alumnoSit->id;

            $datoMedico = $ficha['dato_medico'];
            $nombresDiscapacidades = collect($ficha['discapacidades'] ?? [])
                ->pluck('nombre')
                ->filter()
                ->implode(', ');
            $clinicos = $historico['clinicos'] ?: (object) [
                'enfermedad' => $datoMedico?->enfermedades_cronicas ?: 'No registrada',
                'diabetes' => '', 'hipertension' => '', 'epilepsia' => '',
                'anorexia' => '', 'bulimia' => '', 'sexual' => '',
                'depresion' => '', 'tristeza' => '',
                'otra_enf' => $datoMedico?->medicamentos_controlados ?: '',
                'cap_dif' => $datoMedico?->discapacidad ? 'Sí' : 'No',
                'vista' => '', 'oido' => '', 'lenguaje' => '', 'motora' => '',
                'otra_dif' => $nombresDiscapacidades ?: '',
                'dia_med' => 'No registrada', 'cuanto_med' => '',
                'dia_psico' => 'No registrada', 'cuanto_psico' => '',
                'estatura' => '', 'peso' => '',
                'sangre' => $alu2->alc_TipoSangre ?: 'No registrada',
            ];
            foreach ([
                'enfermedad' => 'No registrada', 'diabetes' => '', 'hipertension' => '',
                'epilepsia' => '', 'anorexia' => '', 'bulimia' => '', 'sexual' => '',
                'depresion' => '', 'tristeza' => '', 'otra_enf' => '',
                'cap_dif' => 'No', 'vista' => '', 'oido' => '', 'lenguaje' => '',
                'motora' => '', 'otra_dif' => '',
                'dia_med' => 'No registrada', 'cuanto_med' => '',
                'dia_psico' => 'No registrada', 'cuanto_psico' => '',
                'estatura' => '', 'peso' => '',
                'sangre' => $alu2->alc_TipoSangre ?: 'No registrada',
            ] as $propiedad => $valor) {
                if (! property_exists($clinicos, $propiedad) || $clinicos->{$propiedad} === null) {
                    $clinicos->{$propiedad} = $valor;
                }
            }
            $padres = collect($historico['padres'] ?? []);
            $padre = $padres->firstWhere('parentesco', 'Padre') ?: (object) [
                'nombre' => $ficha['complemento']?->nombre_padre ?: 'No registrado',
                'edad' => '',
                'tel' => $ficha['complemento']?->telefono_padre ?: '',
                'profesion' => '',
                'ocupacion' => $ficha['complemento']?->ocupacion_padre ?: 'No registrada',
            ];
            $madre = $padres->firstWhere('parentesco', 'Madre') ?: (object) [
                'nombre' => $ficha['complemento']?->nombre_madre ?: 'No registrada',
                'edad' => '',
                'tel' => $ficha['complemento']?->telefono_madre ?: '',
                'profesion' => '',
                'ocupacion' => $ficha['complemento']?->ocupacion_madre ?: 'No registrada',
            ];
            $padres = collect([$padre, $madre]);
            $direccion = $historico['direccion'] ?: (object) [
                'estado' => $ficha['complemento']?->estado?->nombre,
                'municipio' => $ficha['complemento']?->municipio?->nombre,
                'cp' => $alu2->alc_CodPostal,
                'colonia' => $alu2->alc_Colonia,
                'direccion' => $alu2->alc_Direccion,
            ];
            $direccionP = $historico['direccion_padre'] ?? (object) [
                'estado' => '', 'municipio' => '', 'cp' => '', 'colonia' => '', 'direccion' => '',
            ];
            $direccionM = $historico['direccion_madre'] ?? (object) [
                'estado' => '', 'municipio' => '', 'cp' => '', 'colonia' => '', 'direccion' => '',
            ];
            $familiares = collect($historico['familiares'] ?? []);
            $person = $historico['personales'] ?: (object) [
                'trab' => 'No registrada',
                'casa' => 'No registrada',
                'num_person' => '',
                'parentesco' => '',
            ];
            foreach (['trab' => 'No registrada', 'casa' => 'No registrada', 'num_person' => '', 'parentesco' => ''] as $propiedad => $valor) {
                if (! property_exists($person, $propiedad) || $person->{$propiedad} === null) {
                    $person->{$propiedad} = $valor;
                }
            }
            $fam = $historico['datos_familiares'] ?: (object) [
                'dificultades' => 'No registrada',
                'ligado' => '',
                'ligado_por' => '',
                'edu' => '',
                'carrera' => '',
                'otro_dato' => '',
            ];
            foreach ([
                'dificultades' => 'No registrada', 'ligado' => '', 'ligado_por' => '',
                'edu' => '', 'carrera' => '', 'otro_dato' => '',
            ] as $propiedad => $valor) {
                if (! property_exists($fam, $propiedad) || $fam->{$propiedad} === null) {
                    $fam->{$propiedad} = $valor;
                }
            }
            $soc = $historico['social'] ?: (object) [
                'rel_comp' => 'No registrada', 'comp_por' => '',
                'rel_amig' => 'No registrada', 'amig_por' => '',
                'pareja' => 'No registrada',
                'rel_prof' => 'No registrada', 'prof_por' => '',
                'rel_auto_ac' => 'No registrada', 'auto_ac_por' => '',
                'tiempo_lib' => 'No registrado', 'recreativa' => 'No registrada',
                'planes_in' => 'No registrados', 'metas_vida' => 'No registradas',
                'yo_soy' => 'No registrado', 'caracter' => 'No registrado',
                'me_gusta' => 'No registrado', 'aspiraciones' => 'No registradas',
                'miedo' => 'No registrado',
            ];
            foreach ([
                'rel_comp' => 'No registrada', 'comp_por' => '',
                'rel_amig' => 'No registrada', 'amig_por' => '',
                'pareja' => 'No registrada',
                'rel_prof' => 'No registrada', 'prof_por' => '',
                'rel_auto_ac' => 'No registrada', 'auto_ac_por' => '',
                'tiempo_lib' => 'No registrado', 'recreativa' => 'No registrada',
                'planes_in' => 'No registrados', 'metas_vida' => 'No registradas',
                'yo_soy' => 'No registrado', 'caracter' => 'No registrado',
                'me_gusta' => 'No registrado', 'aspiraciones' => 'No registradas',
                'miedo' => 'No registrado',
            ] as $propiedad => $valor) {
                if (! property_exists($soc, $propiedad) || $soc->{$propiedad} === null) {
                    $soc->{$propiedad} = $valor;
                }
            }
            $discapacidades = $ficha['discapacidades'];

            return view('sta.analisis_alumnos.ficha', compact(
                'familiares', 'alu1', 'alu2', 'car', 'padres', 'direccion',
                'direccionP', 'direccionM', 'soc', 'alu', 'clinicos', 'person',
                'fam', 'sitUrl', 'discapacidades'
            ));
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

            $perfil = AlumnoCreditosPerfil::obtenerOCrear($noControl);
            $perfil->observaciones_tutoria = $request->observaciones;
            $perfil->save();

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
        return $this->trayectoria->generaciones()
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
