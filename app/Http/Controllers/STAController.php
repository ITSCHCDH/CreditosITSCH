<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Motivoreprobacion;
use App\Models\AsignacionTutores;
use App\Models\Grupo;
use App\Models\GpoTutorias;
use App\Models\AlumnoCreditosPerfil;
use App\Models\Sit\Alumno as SitAlumno;
use App\Models\Sit\Catedratico;
use App\Models\Sit\Grupo as SitGrupo;
use App\Services\Sit\CarrerasSitService;
use App\Services\Sit\DocenteSitResolverService;
use App\User;


class STAController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:VIP_STA|STA_DEP_TUTORIA')->only(['indexProfesores','findProfesores','buscarProfesores']);
        $this->middleware('permission:VIP_STA|STA_DEP_TUTORIA|STA_PROFESOR')->only(['misGrupos','findMaterias','findUnits','findListaCali','saveComent']);
        $this->middleware('permission:VIP_STA|STA_DEP_TUTORIA')->only(['indexTutorias','buscarCatedraticosTutorias']);       
        $this->middleware('permission:VIP_STA|STA_DEP_TUTORIA|STA_TUTOR')->only(['indexTutores','showGrupo','storeGrupo','deleteAlumno']);
    }  

    public function misGrupos()
    {
        $docente = app(DocenteSitResolverService::class)->resolverCatedratico(Auth::user());

        $grupos = collect();
        $periodoActivo = null;
        if ($docente) {
            $grupos = SitGrupo::with(['materia', 'periodoEscolar'])
                ->withCount('listas')
                ->where('activo', 1)
                ->where('catedratico_id', $docente->id)
                ->whereHas('periodoEscolar', fn ($periodo) => $periodo->where('activo', 1))
                ->orderBy('clave_grupo')
                ->get();
            $periodoActivo = $grupos->first()?->periodoEscolar;
        }

        return view('sta.profesores.mis_grupos', [
            'docenteSit' => $docente,
            'docenteSitPendiente' => $docente === null,
            'gruposAsignados' => $grupos,
            'periodoActivo' => $periodoActivo,
        ]);
    }

    public function indexProfesores()
    {
        $docente = app(DocenteSitResolverService::class)->resolverCatedratico(Auth::user());
        return view('sta.profesores.index', [
            'docenteSit' => $docente,
            'docenteSitPendiente' => $docente === null,
        ]);
    }

    public function findProfesores(Request $request)
    {
        $consulta = DB::connection('sit')->table('catedraticos as c')
            ->join('users as u', 'u.id', '=', 'c.user_id')
            ->where('c.activo', 1)
            ->select(
                'c.id as cat_Clave',
                'u.nombre as cat_Nombre',
                'u.apellido_paterno as cat_ApePat',
                'u.apellido_materno as cat_ApeMat'
            );

        // Un profesor solo se ve a sí mismo
        if (! Auth::User()->hasAnyPermission(['VIP_STA', 'STA_DEP_TUTORIA'])) {
            $docente = app(DocenteSitResolverService::class)->resolverCatedratico(Auth::user());
            $consulta->where('c.id', $docente?->id ?: 0);
        }

        return response()->json($consulta->orderBy('u.apellido_paterno')->get());       
    }

    /** Búsqueda de profesores activos para el buscador combobox. */
    public function buscarCatedraticosTutorias(Request $request)
    {
        $termino = trim((string) $request->query('nombre', ''));
        if (mb_strlen($termino) < 2) {
            return response()->json([]);
        }

        $like = '%'.$termino.'%';
        $catedraticos = Catedratico::with('user')
            ->where('activo', 1)
            ->whereHas('user', function ($query) use ($like) {
                $query->where('nombre', 'like', $like)
                    ->orWhere('apellido_paterno', 'like', $like)
                    ->orWhere('apellido_materno', 'like', $like);
            })
            ->orderBy('numero_empleado')
            ->limit(8)
            ->get()
            ->map(fn ($catedratico) => [
                'cat_Clave' => (int) $catedratico->id,
                'nombre_completo' => trim(implode(' ', array_filter([
                    $catedratico->user?->nombre,
                    $catedratico->user?->apellido_paterno,
                    $catedratico->user?->apellido_materno,
                ]))),
                'departamento' => $catedratico->departamento_adscripcion ?: 'Catedrático activo',
                'numero_empleado' => $catedratico->numero_empleado,
            ]);

        return response()->json($catedraticos);
    }

    public function buscarProfesores(Request $request)
    {
        $termino = trim((string) $request->query('nombre', ''));

        if (mb_strlen($termino) < 2) {
            return response()->json([]);
        }

        $consulta = DB::connection('sit')->table('catedraticos as c')
            ->join('users as u', 'u.id', '=', 'c.user_id')
            ->where('c.activo', 1)
            ->where(function ($sub) {
                // Solo profesores con materias asignadas (grupo o lista)
                $sub->whereExists(function ($query) {
                    $query->select(DB::raw(1))->from('grupos')->whereColumn('grupos.catedratico_id', 'c.id');
                })->orWhereExists(function ($query) {
                    $query->select(DB::raw(1))->from('listas')->whereColumn('listas.catedratico_id', 'c.id');
                });
            })
            ->where(function ($sub) use ($termino) {
                $like = '%'.$termino.'%';
                $sub->where('u.nombre', 'like', $like)
                    ->orWhere('u.apellido_paterno', 'like', $like)
                    ->orWhere('u.apellido_materno', 'like', $like)
                    ->orWhereRaw("CONCAT_WS(' ', u.nombre, u.apellido_paterno, u.apellido_materno) like ?", [$like]);
            });

        // Un profesor solo se ve a sí mismo
        if (! Auth::User()->hasAnyPermission(['VIP_STA', 'STA_DEP_TUTORIA'])) {
            $consulta->where('c.id', $this->obtCatClave());
        }

        $profesores = $consulta
            ->orderBy('u.apellido_paterno')
            ->orderBy('u.apellido_materno')
            ->orderBy('u.nombre')
            ->limit(8)
            ->select(
                'c.id as cat_Clave',
                DB::raw("CONCAT_WS(' ', u.nombre, u.apellido_paterno, u.apellido_materno) as nombre_completo"),
                DB::raw("COALESCE(NULLIF(c.departamento_adscripcion, ''), 'Sin departamento') as departamento")
            )
            ->get();

        return response()->json($profesores);
    }

    /** Catedrático de SIT que corresponde al usuario autenticado (por nombre). */
    public function obtCatClave()
    {
        $docente = app(DocenteSitResolverService::class)->resolverCatedratico(Auth::user());
        return (int) ($docente?->id ?: 0);
    }

    //Función para quitar caracteres especiales a una cadena
    function quitarCaracteres($cadena){
        $cadena=strtolower($cadena);
        $cadena=str_replace("á","a",$cadena);
        $cadena=str_replace("é","e",$cadena);
        $cadena=str_replace("í","i",$cadena);
        $cadena=str_replace("ó","o",$cadena);
        $cadena=str_replace("ú","u",$cadena);
        $cadena=str_replace("ñ","n",$cadena);
        $cadena=str_replace("ü","u",$cadena);
        $cadena=str_replace(" ","",$cadena);
        $cadena=str_replace(".","",$cadena);
        $cadena=str_replace(",","",$cadena);
        $cadena=str_replace("-","",$cadena);
        $cadena=str_replace("_","",$cadena);
        $cadena=str_replace("´","",$cadena);
        $cadena=str_replace("`","",$cadena);
        $cadena=str_replace("¨","",$cadena);
        $cadena=str_replace("¿","",$cadena);
        $cadena=str_replace("?","",$cadena);
        $cadena=str_replace("¡","",$cadena);
        $cadena=str_replace("!","",$cadena);
        return $cadena;
    }

    public function findMaterias(Request $request)
    {
        $usuario = Auth::user();
        $docente = app(DocenteSitResolverService::class)->resolverCatedratico($usuario);
        $privilegiado = $usuario->hasAnyPermission(['VIP_STA', 'STA_DEP_TUTORIA']);
        if (! $privilegiado && ! $docente) {
            return response()->json([
                'error' => '403',
                'message' => 'Tu usuario no tiene vínculo con un catedrático activo de SIT.',
            ], 403);
        }
        if (! $privilegiado && $request->filled('profesor') && (int) $request->profesor !== (int) $docente->id) {
            return response()->json(['error' => 'Materia ajena al docente'], 403);
        }
        $catedraticoId = $privilegiado
            ? (int) $request->profesor
            : (int) ($docente?->id ?: 0);

        $periodoId = $request->filled('periodo') ? (int) $request->periodo : null;
        $grupos = SitGrupo::with(['materia', 'periodoEscolar'])
            ->withCount('listas')
            ->where('activo', true)
            ->where('catedratico_id', $catedraticoId)
            ->periodoActivoOSeleccionado($periodoId)
            ->orderBy('clave_grupo')
            ->get();

        $materias = $grupos->map(function (SitGrupo $grupo) {
            return (object) [
                'ret_NomCompleto' => $grupo->materia?->nombre,
                'ret_NumUnidades' => $grupo->materia?->num_temas,
                'ret_Clave' => $grupo->materia_id,
                'gse_Anio' => $grupo->periodoEscolar?->nombre,
                'gse_Observaciones' => $grupo->clave_grupo,
                'gse_Clave' => $grupo->id,
                'listas_count' => $grupo->listas_count,
            ];
        });

        if($materias->isEmpty()){
            $materias = $docente === null
                ? [
                    'error' => '500',
                    'message' => 'Tu usuario no tiene vínculo con un catedrático de SIT. Solicita la vinculación al administrador.',
                ]
                : [
                    'error' => '500',
                    'message' => 'El profesor no tiene materias asignadas en el periodo vigente.',
                ];
        }       

        return response()->json($materias);
    }

    public function findUnits(Request $request)
    {
        $usuario = Auth::user();
        $docente = app(DocenteSitResolverService::class)->resolverCatedratico($usuario);
        $privilegiado = $usuario->hasAnyPermission(['VIP_STA', 'STA_DEP_TUTORIA']);
        if (! $privilegiado && ! $docente) {
            return response()->json(['error' => 'Materia ajena al docente'], 403);
        }
        if (! $privilegiado && $request->filled('profesor') && (int) $request->profesor !== (int) $docente->id) {
            return response()->json(['error' => 'Materia ajena al docente'], 403);
        }
        $catedraticoId = $privilegiado
            ? (int) $request->profesor
            : (int) ($docente?->id ?: 0);

        $periodoId = $request->filled('periodo') ? (int) $request->periodo : null;
        $grupoValido = SitGrupo::query()
            ->where('activo', true)
            ->where('materia_id', $request->materia)
            ->when($catedraticoId > 0, fn ($query) => $query->where('catedratico_id', $catedraticoId))
            ->periodoActivoOSeleccionado($periodoId)
            ->exists();

        $units = $grupoValido
            ? DB::connection('sit')->table('cat_materias')
                ->where('activo', true)
                ->where('id', $request->materia)
                ->select('nombre as ret_NomCompleto', 'num_temas as ret_NumUnidades')
                ->first()
            : null;

        if (! $units) {
            return response()->json(['error' => 'Materia no asignada al docente'], 403);
        }
        return response()->json($units);
    }

    public function findListaCali(Request $request)
    {
        $usuario = Auth::user();
        $docente = app(DocenteSitResolverService::class)->resolverCatedratico($usuario);
        $privilegiado = $usuario->hasAnyPermission(['VIP_STA', 'STA_DEP_TUTORIA']);
        if (! $privilegiado && ! $docente) {
            return response()->json(['listaCali' => [], 'coment' => []], 403);
        }
        $catedraticoId = $privilegiado
            ? (int) $request->profesor
            : (int) ($docente?->id ?: 0);

        $periodoId = $request->filled('periodo') ? (int) $request->periodo : null;
        $grupoValido = SitGrupo::query()
            ->whereKey($request->grupo)
            ->where('activo', true)
            ->where('materia_id', $request->materia)
            ->when($catedraticoId > 0, fn ($query) => $query->where('catedratico_id', $catedraticoId))
            ->periodoActivoOSeleccionado($periodoId)
            ->exists();

        if (! $grupoValido) {
            return response()->json(['listaCali' => [], 'coment' => []], 403);
        }

        // Calificaciones por unidad de un grupo de SIT
        $listaCali = DB::connection('sit')->table('listas')
            ->join('grupos', 'grupos.id', '=', 'listas.grupo_id')
            ->join('alumnos', 'alumnos.id', '=', 'listas.alumno_id')
            ->join('users', 'users.id', '=', 'alumnos.user_id')
            ->join('lista_unidades', 'lista_unidades.lista_id', '=', 'listas.id')
            ->where('grupos.id', $request->grupo)
            ->where('grupos.materia_id', $request->materia)
            ->where('lista_unidades.numero_unidad', $request->unidad)
            ->orderByDesc('lista_unidades.oportunidad')
            ->select(
                'grupos.id as gse_Clave',
                'listas.id as lse_Clave',
                'alumnos.no_control as alu_NumControl',
                'users.nombre as alu_Nombre',
                'users.apellido_paterno as alu_ApePaterno',
                'users.apellido_materno as alu_ApeMaterno',
                'lista_unidades.calificacion as lsc_Calificacion'
            )
            ->get()
            ->unique(fn ($fila) => $fila->lse_Clave)
            ->sortBy('alu_ApePaterno')
            ->values();

        $coment = Motivoreprobacion::select('no_control','motivos','comentario')
            ->where('grup_cla', $request->materia)
            ->where('num_tema', $request->unidad)
            ->get();

        return response()->json(['listaCali' => $listaCali, 'coment' => $coment]);
    }

    public function saveComent(Request $request)
    {
        $usuario = Auth::user();
        $docente = app(DocenteSitResolverService::class)->resolverCatedratico($usuario);
        $privilegiado = $usuario->hasAnyPermission(['VIP_STA', 'STA_DEP_TUTORIA']);

        if (! $privilegiado) {
            if (! $docente) {
                return response()->json(['error' => 'Materia ajena al docente'], 403);
            }

            $grupoId = $request->filled('grupo') ? $request->grupo : $request->gse_clave;
            $grupoValido = SitGrupo::query()
                ->whereKey($grupoId)
                ->where('activo', 1)
                ->where('materia_id', $request->materia)
                ->where('catedratico_id', $docente->id)
                ->whereHas('periodoEscolar', fn ($periodo) => $periodo->where('activo', 1))
                ->exists();

            if (! $grupoValido) {
                return response()->json(['error' => 'Materia ajena al docente'], 403);
            }
        }

        Motivoreprobacion::updateOrCreate(
            ['no_control' => $request->alumno, 'grup_cla' => $request->gse_clave, 'num_tema'=>$request->unidad],
            ['materia' =>  $request->materia, 'lse_clave' => $request->lse_clave,'motivos'=>$request->motivos,'comentario'=>$request->comentario]
        );       
        return response()->json("correcto");
    }

    //Funciones para el modulo del departamento de tutorias
    public function indexTutorias()
    {
        // Catedráticos activos del catálogo institucional SIT
        $profesores = Catedratico::with('user')
            ->where('activo', 1)
            ->get()
            ->mapWithKeys(function ($catedratico) {
                $nombre = trim(implode(' ', array_filter([
                    $catedratico->user?->nombre,
                    $catedratico->user?->apellido_paterno,
                    $catedratico->user?->apellido_materno,
                ])));
                return [$catedratico->id => (object) ['nombre' => $nombre ?: 'Catedrático '.$catedratico->numero_empleado]];
            });

        // Carreras equivalentes en SIT, con la clave de área que guardan las tablas propias
        $carreras = CarrerasSitService::opcionesPorArea()->keyBy('car_Clave');

        // Obtener los grupos y asignaciones de tutores (desde MySQL)
        $gruTutorias = Grupo::select('grupos.gpo_Nombre', 'at.*')
        ->join('asignaciones_tutores as at', 'grupos.id', '=', 'at.gpo_Id')
        ->orderBy('grupos.gpo_Nombre', 'asc')
        ->get();

        // Agregar el nombre de la carrera a cada grupo
        foreach ($gruTutorias as $gru) {
            $gru->car_Nombre = isset($carreras[$gru->car_Clave])
                ? $carreras[$gru->car_Clave]->car_Nombre
                : 'Desconocido';
        }

        // Agregar el nombre del profesor a cada grupo
        foreach ($gruTutorias as $gru) {
        if (isset($profesores[$gru->tut_Clave])) {
            $gru->name = $profesores[$gru->tut_Clave]->nombre;
        }
        }

        // Retornar la vista con los datos
        return view('sta.tutorias.index', compact('profesores', 'carreras', 'gruTutorias'));
    }

    public function indexTutores()
    {
        // Obtener el usuario autenticado
        $user = Auth::User();
        
        // Obtener los grupos dependiendo de los permisos
        if ($user->can('VIP_STA')) {        
            $grupos = AsignacionTutores::all();        
        } else {
            $claveCatedratico = $this->obtCatClave();
            $grupos = $claveCatedratico > 0
                ? AsignacionTutores::where('tut_Clave', $claveCatedratico)->get()
                : AsignacionTutores::whereRaw('1 = 0')->get();
        }
    
        // Extraer las claves necesarias
        $tutClaves = $grupos->pluck('tut_Clave')->toArray();
        $gpoIds = $grupos->pluck('gpo_Id')->toArray();
    
        // Consultar los catedráticos institucionales y grupos en bloque
        $tutores = Catedratico::with('user')
            ->whereIn('id', $tutClaves)
            ->get()
            ->keyBy('id');
        $gruposInfo = Grupo::whereIn('id', $gpoIds)->get()->keyBy('id');
        $carreras = CarrerasSitService::opcionesPorArea()->keyBy('car_Clave');
    
        // Iterar sobre los grupos y agregar la información correspondiente
        foreach ($grupos as $gru) {
            // Asignar nombre del tutor
            if (isset($tutores[$gru->tut_Clave])) {
                $catedratico = $tutores[$gru->tut_Clave];
                $gru->name = strtoupper(trim(implode(' ', array_filter([
                    $catedratico->user?->nombre,
                    $catedratico->user?->apellido_paterno,
                    $catedratico->user?->apellido_materno,
                ]))));
            }
    
            // Asignar nombre del grupo
            if (isset($gruposInfo[$gru->gpo_Id])) {
                $gru->gpo_Nombre = strtoupper($gruposInfo[$gru->gpo_Id]->gpo_Nombre);
            }
    
            // Asignar nombre de la carrera
            if (isset($carreras[$gru->car_Clave])) {
                $gru->car_Nombre = strtoupper($carreras[$gru->car_Clave]->car_Nombre);
            }
        }
    
        // Retornar la vista con los datos
        return view('sta.tutores.index', compact('grupos'));
    }
    

    //Funcion para mostrar los grupos de tutorias
    public function showGrupo($id, $gpo_Nombre)
    {  
        //Llamamos a la función para completar el grupo
        $grupo = $this->completarGrupo($id); 
        //Obtenemos el año actual
        $anio = date('Y');
        //Seleccionamos todos los alumnos de los ultimos 7 años para llenar el select de alumnos
        $alumnos = DB::connection('sit')->table('alumnos')
            ->join('users', 'users.id', '=', 'alumnos.user_id')
            ->where('alumnos.anio_ingreso', '>=', $anio - 7)
            ->select(
                'alumnos.no_control as alu_NumControl',
                'users.nombre as alu_Nombre',
                'users.apellido_paterno as alu_ApePaterno',
                'users.apellido_materno as alu_ApeMaterno'
            )
            ->orderBy('users.apellido_paterno')
            ->get();

        // Obtén todos los alumnos del grupo en una sola consulta
        $alumnosGrupo = GpoTutorias::where('gpo_Nombre', $gpo_Nombre)->get();

        // Obtén los números de control de los alumnos del grupo
        $noControles = $alumnosGrupo->pluck('no_Control')->toArray();

        // Consulta todos los datos de los alumnos correspondientes en una sola consulta
        $alumnosDatos = DB::connection('sit')->table('alumnos')
            ->join('users', 'users.id', '=', 'alumnos.user_id')
            ->whereIn('alumnos.no_control', $noControles)
            ->select(
                'alumnos.no_control',
                'alumnos.estatus',
                'users.nombre',
                'users.apellido_paterno',
                'users.apellido_materno'
            )
            ->get()
            ->keyBy('no_control');

        // Consulta las fichas de los alumnos en una sola consulta
        $fichas = AlumnoCreditosPerfil::query()
            ->whereIn('no_control', $noControles)
            ->get()
            ->keyBy('no_control');

        // Itera sobre los alumnos del grupo y agrega los datos correspondientes
        foreach ($alumnosGrupo as $alumno) {
            if (isset($alumnosDatos[$alumno->no_Control])) {
                $alumnoTem = $alumnosDatos[$alumno->no_Control];
                $alumno->alu_Nombre = strtoupper($alumnoTem->nombre);
                $alumno->alu_ApePaterno = strtoupper($alumnoTem->apellido_paterno);
                $alumno->alu_ApeMaterno = strtoupper($alumnoTem->apellido_materno);
                $alumno->status = $alumnoTem->estatus;
            } else {
                $alumno->alu_Nombre = 'EL ALUMNO NO EXISTE, VERIFICA SU NUMERO DE CONTROL!';
                $alumno->alu_ApePaterno = '';
                $alumno->alu_ApeMaterno = '';
                $alumno->status = 'NA';
            }

            // Asigna la ficha correspondiente, o 0 si no existe
            if (isset($fichas[$alumno->no_Control])) {
                $alumno->ficha = $fichas[$alumno->no_Control]->ficha_completada ? 1 : 0;
            } else {
                $alumno->ficha = 0;
            }
        }      
      
        $jefes = app(JefesController::class);
        foreach ($alumnosGrupo as $row) {
            $row->semaforos = $jefes->calSemaforos($row->no_Control);
        }    
             
        return view('sta.tutores.showGrupo',compact('grupo','alumnos','alumnosGrupo'));
    }

    public function completarGrupo($id)
    {              
        // Obtén la información del grupo
        $grupo = AsignacionTutores::where('id', $id)->get();  
    
        // Extraer las claves de tutor, grupo y carrera
        $tutClaves = $grupo->pluck('tut_Clave')->toArray();
        $gpoIds = $grupo->pluck('gpo_Id')->toArray();
        $carClaves = $grupo->pluck('car_Clave')->toArray();
    
        // Obtener los datos de los tutores, grupos y carreras en una sola consulta
        $tutores = Catedratico::with('user')->whereIn('id', $tutClaves)->get()->keyBy('id');
        $grupos = Grupo::whereIn('id', $gpoIds)->get()->keyBy('id');
        $carreras = CarrerasSitService::opcionesPorArea()->keyBy('car_Clave');
    
        // Iterar sobre el grupo y agregar los datos del tutor, grupo y carrera
        foreach ($grupo as $gru) {
            // Asignar el nombre del tutor
            if (isset($tutores[$gru->tut_Clave])) {
                $catedratico = $tutores[$gru->tut_Clave];
                $gru->nomTutor = strtoupper(trim(implode(' ', array_filter([
                    $catedratico->user?->nombre,
                    $catedratico->user?->apellido_paterno,
                    $catedratico->user?->apellido_materno,
                ]))));
            }
    
            // Asignar el nombre del grupo
            if (isset($grupos[$gru->gpo_Id])) {
                $gru->gpo_Nombre = strtoupper($grupos[$gru->gpo_Id]->gpo_Nombre);
            }
    
            // Asignar el nombre de la carrera
            if (isset($carreras[$gru->car_Clave])) {
                $gru->car_Nombre = strtoupper($carreras[$gru->car_Clave]->car_Nombre);
            }
        }
    
        return $grupo;
    }
    

    //Función para guardar los alumnos de un grupo
    public function storeGrupo(Request $request)
    {
        try
        {
            $grupoNombre = strtoupper(trim((string) $request->gpo_Nombre));
            if ($grupoNombre === '') {
                return response()->json([
                    'message' => 'El nombre del grupo no es válido.',
                    'agregados' => [],
                    'existentes' => [],
                    'invalidos' => [],
                ], 422);
            }

            $entrada = $request->input(
                'controles',
                $request->input('no_Control', $request->input('lista', []))
            );
            $controles = is_array($entrada)
                ? $entrada
                : preg_split('/[\s,;]+/', (string) $entrada, -1, PREG_SPLIT_NO_EMPTY);

            $controles = collect($controles)
                ->map(fn ($control) => strtoupper(trim((string) $control)))
                ->filter()
                ->unique()
                ->values();

            if ($controles->isEmpty()) {
                return response()->json([
                    'message' => 'No se proporcionaron números de control.',
                    'agregados' => [],
                    'existentes' => [],
                    'invalidos' => [],
                ], 422);
            }

            $agregados = [];
            $existentes = [];
            $invalidos = [];
            $errores = [];

            $controlesValidos = SitAlumno::whereIn('no_control', $controles->all())
                ->pluck('no_control')
                ->map(fn ($control) => strtoupper(trim((string) $control)))
                ->flip();

            $asignaciones = GpoTutorias::whereIn('no_Control', $controles->all())
                ->get(['no_Control', 'gpo_Nombre'])
                ->keyBy(fn ($asignacion) => strtoupper(trim((string) $asignacion->no_Control)));

            foreach ($controles as $noControl) {
                if (! $controlesValidos->has($noControl)) {
                    $invalidos[] = $noControl;
                    continue;
                }

                $asignacion = $asignaciones->get($noControl);
                if ($asignacion && strtoupper(trim((string) $asignacion->gpo_Nombre)) === $grupoNombre) {
                    $existentes[] = $noControl;
                    continue;
                }

                try {
                    GpoTutorias::updateOrCreate(
                        ['no_Control' => $noControl],
                        ['gpo_Nombre' => $grupoNombre]
                    );
                    $agregados[] = $noControl;
                } catch (\Throwable $e) {
                    $errores[] = $noControl;
                }
            }

            $cantidad = count($agregados);
            $message = $cantidad === 1
                ? 'Se agregó 1 alumno nuevo al grupo.'
                : "Se agregaron {$cantidad} alumnos nuevos al grupo.";

            return response()->json([
                'message' => $message,
                'agregados' => $agregados,
                'existentes' => $existentes,
                'invalidos' => $invalidos,
                'errores' => $errores,
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['message' => 'No se pudo dar de alta el registro'], 500);
        }
    }

    //Función para eliminar un alumno de un grupo
    public function deleteAlumno(Request $request)
    {
        try
        {
            //Eliminamos el registro de la tabla gpoTutorias
            GpoTutorias::where('no_Control',$request->no_Control)->delete();
            //Retornamos status 200 y el mensaje de que se guardo correctamente
            return response()->json(['message' => 'Correcto'], 200);          
        }
        catch(\Exception $e)
        {
            return response()->json(['message' => 'No se pudo eliminar el registro'], 500);
        }
    }

    public function analisisGrupo($id)
    {
        // Obtener el grupo completo con una sola consulta
        $grupo = $this->completarGrupo($id); 
        
        // Obtener los alumnos del grupo
        $alumnosGrupo = GpoTutorias::where('gpo_Nombre', $grupo[0]->gpo_Nombre)->get();
    
        // Obtener todos los alumnos y sus datos en una sola consulta
        $noControles = $alumnosGrupo->pluck('no_Control');
        $alumnosTem = DB::connection('sit')->table('alumnos')
            ->join('users', 'users.id', '=', 'alumnos.user_id')
            ->whereIn('alumnos.no_control', $noControles)
            ->select('alumnos.no_control', 'alumnos.estatus', 'users.nombre', 'users.apellido_paterno', 'users.apellido_materno')
            ->get()
            ->keyBy('no_control');

        // Verificar y asignar datos del alumno en el grupo
        foreach($alumnosGrupo as $alumno) {
            if (isset($alumnosTem[$alumno->no_Control])) {
                $alumnoTem = $alumnosTem[$alumno->no_Control];
                $alumno->alu_Nombre = strtoupper($alumnoTem->nombre) . ' ' . strtoupper($alumnoTem->apellido_paterno) . ' ' . strtoupper($alumnoTem->apellido_materno);
                $alumno->status = $alumnoTem->estatus;
            } else {
                $alumno->alu_Nombre = 'EL ALUMNO NO EXISTE, VERIFICA SU NUMERO DE CONTROL!';
            }
        }
    
        // Obtener todas las materias y calificaciones de los alumnos en una sola consulta
        $materias = DB::connection('sit')->table('listas')
            ->join('grupos', 'grupos.id', '=', 'listas.grupo_id')
            ->join('cat_materias', 'cat_materias.id', '=', 'grupos.materia_id')
            ->join('lista_unidades', 'lista_unidades.lista_id', '=', 'listas.id')
            ->join('alumnos', 'alumnos.id', '=', 'listas.alumno_id')
            ->whereIn('alumnos.no_control', $noControles)
            ->select(
                'alumnos.no_control as alu_NumControl',
                'cat_materias.nombre_corto as ret_NomCorto',
                'lista_unidades.numero_unidad as lsc_NumUnidad',
                'lista_unidades.calificacion as lsc_Calificacion'
            )
            ->get()
            ->groupBy('alu_NumControl');

        // Asignar materias a cada alumno
        foreach($alumnosGrupo as $alumno) {
            $alumno->materias = $materias->get($alumno->no_Control, collect());
        }
    
        return view('sta.tutores.analisis', compact('grupo', 'alumnosGrupo'));
    }
    
   
}
