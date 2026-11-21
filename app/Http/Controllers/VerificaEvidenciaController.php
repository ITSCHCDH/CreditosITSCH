<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Avance;
use App\Models\Alumno;
use App\Models\Credito;
use App\Models\Participante;
use App\Models\Actividad_Evidencia;
use App\Models\Actividad;
use App\Models\Area;
use App\Models\Sit\Alumno as SitAlumno;
use App\Services\Sit\CarrerasSitService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Alert;

class VerificaEvidenciaController extends Controller
{
    const MAX_FETCH_SIZE_LIMIT = 100;

    public function __construct(){
        $this->middleware('permission:VIP|VIP_SOLO_LECTURA|VIP_REPORTES|VER_REPORTES_CARRERA')->only('reportes');
        $this->middleware('permission:VIP|VIP_SOLO_LECTURA|VIP_EVIDENCIA|VERIFICAR_EVIDENCIA')->only(['index','show']);
        $this->middleware('permission:VIP|VIP_EVIDENCIA|VERIFICAR_EVIDENCIA')->only(['create','store']);
        $this->middleware('permission:VIP|VIP_EVIDENCIA|VERIFICAR_EVIDENCIA|VIP_SOLO_LECTURA')->only('verEvidencia');
        $this->middleware('permission:VIP|VIP_SOLO_LECTURA|VER_AVANCE_ALUMNO|VIP_AVANCE_ALUMNO')->only('avanceAlumno');
        $this->middleware('permission:VIP|VIP_SOLO_LECTURA|VER_AVANCE_ALUMNO|VIP_AVANCE_ALUMNO|VIP_REPORTES|VER_REPORTES_CARRERA')->only('alumnosBusqueda');
    }

    public function index(Request $request){
        $validadas = 'true'; // Variable para filtrar las activides no validadas de las validadas
        $busqueda = $request->busqueda;
        $actividades_link = 'false';
        if($request->has('actividades_link') && $request->actividades_link == 'true'){
            $actividades_link = 'true';
        }
        if($request->has('validadas') || (!$request->has('validadas') && !$request->has('busqueda'))){
            if($request->has('validadas') && $request->validadas == 'true')
                $validadas = 'true';
            else
                $validadas = 'false';
        }
        if(Auth::User()->hasAnyPermission(['VIP','VIP_EVIDENCIA','VIP_SOLO_LECTURA'])){
            $evidencias_data = DB::table('evidencia as e')
            ->join('actividad_evidencia as ae','e.id_asig_actividades','=','ae.id')
            ->join('users as u','ae.user_id','=','u.id')
            ->join('actividad as a','ae.actividad_id','=','a.id')
            ->join('creditos as c','a.id_actividad','=','c.id')
            ->join('users as validador','validador.id','=','ae.validador_id')
            ->join('participantes as p','p.id_evidencia','=','ae.id')
            ->where(function($query) use($request){
                $query->where('a.nombre','LIKE',"%$request->busqueda%")
                ->orwhere('c.nombre','LIKE',"%$request->busqueda%")
                ->orwhere('u.name','LIKE',"%$request->busqueda%")
                ->orwhere('validador.name','LIKE',"%$request->busqueda%");
            })
            ->where('ae.validado','=',$validadas)
            ->select('e.nom_imagen','e.id','ae.validado','u.name','a.nombre','a.por_cred_actividad','c.nombre as nombre_credito','c.id as id_credito','ae.id as actividad_evidencia_id','validador.name as validador_nombre','validador.id as validador_id','c.vigente')
            ->groupBy('ae.id')->get();
        }else{
            $evidencias_data = DB::table('evidencia as e')
            ->join('actividad_evidencia as ae','e.id_asig_actividades','=','ae.id')
            ->join('users as u','ae.user_id','=','u.id')
            ->join('actividad as a','ae.actividad_id','=','a.id')
            ->join('creditos as c','a.id_actividad','=','c.id')
            ->join('users as validador','validador.id','=','ae.validador_id')
            ->join('participantes as p','p.id_evidencia','=','ae.id')
            ->where(function($query) use($request){
                $query->where('a.nombre','LIKE',"%$request->busqueda%")
                ->orwhere('c.nombre','LIKE',"%$request->busqueda%")
                ->orwhere('u.name','LIKE',"%$request->busqueda%")
                ->orwhere('validador.name','LIKE',"%$request->busqueda%");
            })
            ->where([
                ['validador.id','=',Auth::User()->id],
                ['ae.validado','=',$validadas]
            ])
            ->select('e.nom_imagen','e.id','ae.validado','u.name','a.nombre','a.por_cred_actividad','c.nombre as nombre_credito','c.id as id_credito','ae.id as actividad_evidencia_id','validador.name as validador_nombre','validador.id as validador_id','c.vigente')
            ->groupBy('ae.id')->get();
        }
        return view('admin.verifica_evidencia.index')
        ->with('evidencias_data',$evidencias_data)
        ->with('validadas',$validadas)
        ->with('actividades_link',$actividades_link)
        ->with('busqueda',$busqueda);
    }

    public function eliminarAlumnosSinEvidencia($todos_los_alumnos, $alumnos_con_evidencia){
        foreach($todos_los_alumnos as $alumno){
            $tiene_evidencia = false;
            foreach($alumnos_con_evidencia as $alumno_con_evidencia){
                if($alumno->no_control == $alumno_con_evidencia->no_control){
                    $tiene_evidencia = true;
                    break;
                }
            }
            if(!$tiene_evidencia){
                Participante::destroy($alumno->id);
            }
        }
    }
    public function store(Request $request){
        // Validamos si el request viene con las evidencias
    	if($request->id_evidencias){
            // Variable index no ayudará como apuntador para saber el porcentaje de liberación de la actividad y el identificador del crédito al que pertenece
            for($x=0; $x<count($request->id_evidencias); $x++){
                $validados = DB::table('actividad_evidencia as ae')->where([
                    ['ae.id','=',$request->id_evidencias[$x]],
                    ['ae.validado','=','true']
                ])->get();
                // Si la evidencia ya esta validada continuamos
                if($validados->count()>0)continue;
                // Validamos que el crédito se encuentre vigente
                $credito_vigente = DB::table('actividad_evidencia as ae')->join('actividad as a', function($join) use($request,$x){
                    $join->on('a.id','=','ae.actividad_id');
                    $join->where('ae.id','=',$request->id_evidencias[$x]);
                })->join('creditos as c','c.id','=','a.id_actividad')->where('c.vigente','=','true')->get()->count()>0?true: false;
                if(!$credito_vigente)continue;

                // Validamos la evidencia
                $validar_evidencia = Actividad_Evidencia::find($request->id_evidencias[$x]);
                $validar_evidencia->validado = 'true';
                // Traemos la actidad en cuestión
                $actividad = Actividad::find($validar_evidencia->actividad_id);
                // Validamos que la actividad este vigente en caso contrario omitimos esta actividad
                if($actividad->vigente == 'false') continue;

                // Consulta para traer los números de control vinculados con la actividad
                // Validamos si la actividad es de alumnos responsables (Cada alumno es responsable de su
                // evidencia y lo que no cuenten con ella son eliminados de la actividad)
                if($actividad->alumnos == 'true'){
                    $participantes_lista = DB::table('participantes as p')->join('actividad_evidencia as ae','ae.id','=','p.id_evidencia')->where('ae.id','=',$request->id_evidencias[$x])->select('p.no_control','p.id')->get();
                    $participantes_con_evidencia = DB::table('participantes as p')->join('actividad_evidencia as ae', function($join) use($request,$x){
                        $join->on('ae.id','=',DB::raw($request->id_evidencias[$x]));
                    })->join('evidencia as e',function($join){
                        $join->on('e.id_asig_actividades','=','ae.id');
                        $join->on('e.alumno_no_control','=','p.no_control');
                    })->select('p.no_control')->groupBy('p.no_control')->get();
                    $this->eliminarAlumnosSinEvidencia($participantes_lista, $participantes_con_evidencia);
                }
                $participantes_lista = DB::table('participantes as p')->join('actividad_evidencia as ae','ae.id','=','p.id_evidencia')->where('ae.id','=',$request->id_evidencias[$x])->select('p.no_control')->get();
                // Se le asigna el porcentaje de crédito a los participantes una vez validada
                for ($i=0; $i < count($participantes_lista); $i++) {
                    $credito_avance = Avance::where([
                        ['no_control','=',$participantes_lista[$i]->no_control],
                        ['id_credito','=',$actividad->id_actividad]
                    ])->get();
                    //Si no existe un registro con su numero de control y el id del credito se le crea uno en caso contrario se le suma el procentaje de liberacion
                    if($credito_avance->count()>0){
                        $avance = Avance::find($credito_avance[0]->id);
                        $avance->por_credito += (int)$actividad->por_cred_actividad;
                        $avance->save();
                    }else{
                        $avance = new Avance();
                        $avance->no_control=$participantes_lista[$i]->no_control;
                        $avance->id_credito=$actividad->id_actividad;
                        $avance->por_credito = (int)$actividad->por_cred_actividad;
                        $avance->save();
                    }
                    // Liberamos al alumo en caso de que ya tengo los 5 créditos complementarios
                    $this->liberar($participantes_lista[$i]->no_control);
                }
                $validar_evidencia->save();
            }
        }
    	return redirect()->route('verifica_evidencia.index');
    }


    public function liberar($no_control){
        $avance = Avance::where('no_control','=',$no_control)->get();
        $creditos = 0;
        for($i = 0; $i<count($avance); ++$i){
            if($avance[$i]->por_credito >= 100) ++$creditos;
        }
        if($creditos >= 5){
            $alumno = Alumno::where('no_control','=',$no_control)->get()[0];
            $alumno->status = "Liberado";
            $alumno->save();
        }
    }

    public function visualizar($imagen){
        $file= public_path(). "/images/evidencias/".$imagen;
        return response()->file($file);
    }

    public function avanceAlumno(Request $request){
    	$alumno_data=null;
        $avance = true;
        $ruta_data = array();
        $liberado = false;

        //Aqui se valida si la peticiom viene de la ruta reportes o de la de avance, para generar las rutas correctamente dependiendo de su origen
        if($request->has('ruta_carrera') && $request->has('ruta_generacion')){
            array_push($ruta_data,$request->ruta_carrera,$request->ruta_generacion);
        }
        //Traemos todos los creditos existentes
        $creditos = Credito::select('nombre')->orderBy('nombre')->get();
    	if($request->has('no_control')){
            $sitAlumno = SitAlumno::with(['user','carrera'])
                ->where('no_control', $request->get('no_control'))
                ->first();

    		if(!$sitAlumno){
    			Alert::error('Error','El numero de control no exite');
    			return redirect()->route('verifica_evidencia.avance_alumno');

    		}else{
                if(!Auth::User()->hasAnyPermission(['VIP','VIP_AVANCE_ALUMNO']) && $sitAlumno->carrera_id != Auth::User()->area){
                    Alert::error('Error','No puedes consultar avances de alumnos de otras carreras');
                    return redirect()->route('verifica_evidencia.avance_alumno');
                }
            }
            $alumno_data = DB::table('participantes as p')
            ->join('actividad_evidencia as ae',function($join){
                $join->on('ae.id','=','p.id_evidencia');
                $join->where('ae.validado','=','true');
            })->join('evidencia as e',function($join){
                $join->on('e.id_asig_actividades','=','ae.id');
            })->join('actividad as a','a.id','=','ae.actividad_id')
            ->join('creditos as c','c.id','=','a.id_actividad')
            ->join('avance as av',function($join) use ($request){
    			$join->on('av.id_credito','=','c.id');
    			$join->where('av.no_control','=',$request->get('no_control'));
            })
            ->where(function($query){
                $query->where('p.evidencia_validada','=','na')->orwhere('p.evidencia_validada','=','si');
            })->where('p.no_control','=',$request->get('no_control'))
            ->where('ae.validado','=','true')
            ->select('p.no_control','c.nombre as nombre_credito','a.nombre as nombre_actividad','a.por_cred_actividad','av.por_credito')
            ->orderBy('nombre_credito')
            ->groupBy('nombre_actividad')
            ->get()
            ->map(function ($row) use ($sitAlumno) {
                $row->nombre_alumno = $sitAlumno->nombreCompleto;
                $row->carrera = $sitAlumno->carrera?->nombre;
                $row->foto = null;
                return $row;
            });
            $liberado = $this->verificarProgreso($request->get('no_control'));
            //Validamos que el alumnos tenga algun avance
    		if($alumno_data->count()==0){
                //SI no tiene avance solo retornamos los datos del alumno los datos del alumno
                $avance = false;
                $alumno_data = collect([(object) [
                    'nombre_alumno' => $sitAlumno->nombreCompleto,
                    'carrera' => $sitAlumno->carrera?->nombre,
                    'no_control' => $sitAlumno->no_control,
                    'foto' => null,
                ]]);
            }
        }
    	return view('admin.verifica_evidencia.avance_alumno')
        ->with('alumno_data',$alumno_data)
        ->with('creditos',$creditos)
        ->with('ruta_data',$ruta_data)
        ->with('avance',$avance)
        ->with('liberado',$liberado);
    }

    public function verificarProgreso($no_control) {
        $alumno = SitAlumno::where('no_control', $no_control)->first();
        if (!$alumno) return false;

        $avance_data = DB::table('participantes as p')
        ->join('actividad_evidencia as ae', 'ae.id', '=', 'p.id_evidencia')
        ->join('actividad as act', 'act.id', '=', 'ae.actividad_id')
        ->join('creditos as c', 'c.id', '=', 'act.id_actividad')
        ->where([
            ['ae.validado', '=', 'true'],
            ['p.no_control', '=', $no_control]
        ])
        ->whereIn('p.evidencia_validada', ['na', 'si'])
        ->select('act.nombre as act_nombre', 'act.por_cred_actividad as porcentaje',
            'act.id_actividad as act_cred_id')
        ->get();

        $creditos_cant = (int)Credito::max('id');
        $cred_porcen = array_fill(0, $creditos_cant + 1, 0);

        foreach ($avance_data as $avance) {
            $cred_porcen[$avance->act_cred_id] += $avance->porcentaje;
        }

        $avance_alu = Avance::where('no_control', $no_control)->get();
        $creditos_liberados = 0;
        foreach($avance_alu as $avance) {
            if ($cred_porcen[$avance->id_credito] !== (int)$avance->por_credito) {
                $avance->por_credito = $cred_porcen[$avance->id_credito];
                $avance->save();
            }

            if ($avance->por_credito >= 100)
                ++$creditos_liberados;
        }

        return $creditos_liberados >= 5;
    }

    public function reportes(Request $request){
        $catalogoCreditos = Credito::select('id', 'nombre')->orderBy('nombre')->get();
        $creditos = $catalogoCreditos->count();
        $puntosTotales = max(1, $creditos * 100);

        $busqueda = $request->get('busqueda');
        $textoBusqueda = is_string($busqueda) ? trim($busqueda) : '';
        $carreraSit = $request->get('carrera');
        $generacion = (int) $request->get('generacion', 0);
        $anio = $generacion > 1 ? $generacion : null;
        $estadoFiltro = $request->get('status', 'todos');

        $puedeVerTodas = Auth::User()->hasAnyPermission(['VIP', 'VIP_REPORTES', 'VIP_SOLO_LECTURA']);
        $carrerasPermitidas = $puedeVerTodas
            ? CarrerasSitService::visibles()
            : CarrerasSitService::visibles(Area::CarrerasUsuario(Auth::User()->id)->pluck('id'));

        $reportes_data = null;
        $suma_creditos = null;
        $resumen = null;

        $carreraValida = $carreraSit !== null && $carreraSit !== ''
            && $carrerasPermitidas->contains(fn ($carrera) => (string) $carrera->id === (string) $carreraSit);

        // Filtros en cascada: la carrera se acota por la generación elegida
        $carreras = $carrerasPermitidas;
        if ($anio !== null) {
            $carrerasConAlumnos = SitAlumno::where('anio_ingreso', $anio)->pluck('carrera_id')->unique();
            $carreras = $carrerasPermitidas
                ->filter(fn ($carrera) => $carrerasConAlumnos->contains($carrera->id) || (string) $carrera->id === (string) $carreraSit)
                ->values();
        }

        // Y los años disponibles se acotan por la carrera elegida
        $consultaAnios = SitAlumno::query()->select('anio_ingreso')->distinct();
        if ($carreraValida) {
            $consultaAnios->where('carrera_id', $carreraSit);
        }
        $anios = $consultaAnios->orderByDesc('anio_ingreso')
            ->pluck('anio_ingreso')
            ->map(fn ($valor) => (int) $valor)
            ->filter()
            ->values();

        if ($anio !== null && ! $anios->contains($anio)) {
            $anios = $anios->push($anio)->sortDesc()->values();
        }

        $filtrosAplicados = $carreraValida || $anio !== null || $textoBusqueda !== '';

        if ($filtrosAplicados) {
            // Los alumnos salen exclusivamente de sit.alumnos
            $alumnos = $this->alumnosReporte(
                $carreraValida ? $carreraSit : null,
                $anio,
                $textoBusqueda,
                $puedeVerTodas ? null : $carrerasPermitidas->pluck('id')
            );

            $avance = $alumnos->isEmpty() ? collect() : DB::table('avance')
                ->whereIn('no_control', $alumnos->pluck('no_control')->all())
                ->select('no_control', 'id_credito', 'por_credito')
                ->get()
                ->groupBy('no_control');

            $calculados = [];
            foreach ($alumnos as $alumno) {
                $porCredito = $avance->get($alumno->no_control, collect())->pluck('por_credito', 'id_credito');
                $suma = 0;

                foreach ($catalogoCreditos as $credito) {
                    $suma += (int) min(100, max(0, (int) ($porCredito[$credito->id] ?? 0)));
                }

                $calculados[] = [
                    'alumno' => $alumno,
                    'porCredito' => $porCredito,
                    'suma' => $suma,
                    'estado' => $this->estadoReporte($alumno, $suma, $puntosTotales),
                ];
            }

            if ($estadoFiltro !== 'todos') {
                $calculados = array_values(array_filter($calculados, fn ($item) => $item['estado'] === $estadoFiltro));
            }

            $reportes_data = [];
            $suma_creditos = [];
            $resumen = ['total' => 0, 'liberados' => 0, 'enProceso' => 0, 'sinAvance' => 0, 'bajas' => 0, 'promedio' => 0];
            $acumuladoPorcentaje = 0;

            foreach ($calculados as $item) {
                $alumno = $item['alumno'];
                $porcentaje = min(100, (int) round($item['suma'] * 100 / $puntosTotales));

                $resumen['total']++;
                $acumuladoPorcentaje += $porcentaje;

                if ($item['estado'] === 'baja') {
                    $resumen['bajas']++;
                } elseif ($item['suma'] >= $puntosTotales) {
                    $resumen['liberados']++;
                } elseif ($item['suma'] > 0) {
                    $resumen['enProceso']++;
                } else {
                    $resumen['sinAvance']++;
                }

                $suma_creditos[] = (object) [
                    'alumno_id' => $alumno->id,
                    'nombre' => $alumno->nombreCompleto,
                    'no_control' => $alumno->no_control,
                    'carrera' => $alumno->carrera?->nombre,
                    'status' => $item['estado'],
                    'credito_suma' => $item['suma'],
                ];
            }

            $resumen['promedio'] = $resumen['total'] > 0 ? (int) round($acumuladoPorcentaje / $resumen['total']) : 0;

            $suma_creditos = $this->paginarReporte($suma_creditos, $request);

            // El detalle por crédito solo se arma para la página visible
            foreach ($suma_creditos as $fila) {
                $porCredito = $avance->get($fila->no_control, collect())->pluck('por_credito', 'id_credito');

                foreach ($catalogoCreditos as $credito) {
                    $reportes_data[] = (object) [
                        'nombre' => $fila->nombre,
                        'status' => $fila->status,
                        'no_control' => $fila->no_control,
                        'carrera' => $fila->carrera,
                        'por_credito' => (int) min(100, max(0, (int) ($porCredito[$credito->id] ?? 0))),
                        'nombre_credito' => $credito->nombre,
                    ];
                }
            }
        }

        // Datos del alumno elegido en el buscador (fuente SIT) para reconstruir el filtro
        $alumnoFiltro = null;
        if ($request->filled('busqueda')) {
            $sitAlumnoFiltro = SitAlumno::with('carrera')->where('no_control', $request->get('busqueda'))->first();
            if ($sitAlumnoFiltro) {
                $alumnoFiltro = [
                    'no_control' => $sitAlumnoFiltro->no_control,
                    'nombre' => $sitAlumnoFiltro->nombreCompleto,
                    'carrera' => $sitAlumnoFiltro->carrera?->nombre ?? '',
                ];
            }
        }

        return view('admin.verifica_evidencia.reportes')
        ->with('reportes_data', $reportes_data)
        ->with('creditos', $creditos)
        ->with('suma_creditos', $suma_creditos)
        ->with('resumen', $resumen)
        ->with('carreras', $carreras)
        ->with('anios', $anios)
        ->with('filtrosAplicados', $filtrosAplicados)
        ->with('carrera_seleccionada', $carreraSit)
        ->with('busqueda', $busqueda)
        ->with('status', $request->get('status'))
        ->with('generacion', $generacion)
        ->with('alumnoFiltro', $alumnoFiltro);
    }

    /** Alumnos del reporte: fuente única sit.alumnos (nombre desde sit.users, carrera desde sit.cat_carreras). */
    private function alumnosReporte($carreraSit, $anio, $busqueda, $carrerasPermitidas = null)
    {
        $consulta = SitAlumno::query()->with(['user', 'carrera']);

        if ($carreraSit !== null && $carreraSit !== '') {
            $consulta->where('carrera_id', $carreraSit);
        }

        if ($anio !== null && (int) $anio > 1) {
            $consulta->where('anio_ingreso', (int) $anio);
        }

        // Los usuarios sin privilegios nunca pueden salir de sus carreras, aunque no elijan una
        if ($carrerasPermitidas !== null) {
            $ids = collect($carrerasPermitidas)->filter()->values();
            $consulta->whereIn('carrera_id', $ids->isEmpty() ? [-1] : $ids->all());
        }

        $texto = is_string($busqueda) ? trim($busqueda) : '';
        if ($texto !== '') {
            $consulta->where(function ($query) use ($texto) {
                $query->where('no_control', 'like', "%{$texto}%")
                    ->orWhereHas('user', function ($usuario) use ($texto) {
                        $usuario->where('nombre', 'like', "%{$texto}%")
                            ->orWhere('apellido_paterno', 'like', "%{$texto}%")
                            ->orWhere('apellido_materno', 'like', "%{$texto}%");
                    });
            });
        }

        return $consulta->orderBy('no_control')->get();
    }

    /** Estado del reporte: baja por estatus académico; liberado o pendiente por créditos acumulados. */
    private function estadoReporte($alumno, int $suma, int $puntosTotales)
    {
        if (Str::contains(Str::lower((string) $alumno->estatus), 'baja')) {
            return 'baja';
        }

        return $suma >= $puntosTotales ? 'liberado' : 'pendiente';
    }

    private function paginarReporte(array $filas, Request $request)
    {
        $porPagina = 10;
        $pagina = max(1, (int) $request->get('page', 1));

        return new LengthAwarePaginator(
            array_slice($filas, ($pagina - 1) * $porPagina, $porPagina),
            count($filas),
            $porPagina,
            $pagina,
            ['path' => route('verifica_evidencia.reportes'), 'query' => $request->query()]
        );
    }

    public function verEvidencia($id){
        $evidencias = DB::table('actividad_evidencia as ae')->join('users as u','u.id','=','ae.user_id')->join('actividad as a','a.id','=','ae.actividad_id')->join('evidencia as e','e.id_asig_actividades','=','ae.id')->where('ae.id','=',$id)->select('u.name as usuario_nombre','a.nombre as actividad_nombre','e.created_at as fecha_subida','ae.id as actividad_evidencia_id','e.nom_imagen')->get();
        $actividadEvidencia = Actividad_Evidencia::find($id);
        $puedeValidar = $actividadEvidencia
            && (Auth::User()->hasAnyPermission(['VIP','VIP_EVIDENCIA','VERIFICAR_EVIDENCIA'])
                || Auth::User()->id == $actividadEvidencia->validador_id
                || Auth::User()->id == $actividadEvidencia->user_id);

        return view('admin.verifica_evidencia.ver_evidencia')
        ->with('evidencias',$evidencias)
        ->with('actividad_evidencia_id',$id)
        ->with('actividad_validada',$actividadEvidencia?->validado ?? 'false')
        ->with('puede_validar',$puedeValidar);
    }

    public function alumnosBusqueda(Request $request){
        $query = SitAlumno::with(['user','carrera']);

        if ((int) $request->peticion === 1) {
            $query->where('no_control', $request->no_control);
        } else {
            $search = trim((string) $request->nombre);
            if ($search !== '') {
                $query->where(function ($alumnoQuery) use ($search) {
                    $alumnoQuery->where('no_control', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('nombre', 'like', "%{$search}%")
                                ->orWhere('apellido_paterno', 'like', "%{$search}%")
                                ->orWhere('apellido_materno', 'like', "%{$search}%");
                        });
                });
            }
        }

        $puedeVerTodas = Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VIP_AVANCE_ALUMNO','VIP_REPORTES','VER_REPORTES_CARRERA']);

        if (! $puedeVerTodas) {
            // Se acota a las carreras SIT equivalentes al área del usuario
            $carrerasPermitidas = CarrerasSitService::visibles(Area::CarrerasUsuario(Auth::User()->id)->pluck('id'))->pluck('id');
            $query->whereIn('carrera_id', $carrerasPermitidas->isEmpty() ? [-1] : $carrerasPermitidas->all());
        } elseif ($request->filled('carrera')) {
            // El filtro llega con el id del catálogo SIT
            $query->where('carrera_id', $request->get('carrera'));
        }

        // Cascada desde el filtro de generación
        if ($request->filled('anio') && (int) $request->get('anio') > 1) {
            $query->where('anio_ingreso', (int) $request->get('anio'));
        }

        $lista = $query->orderBy('no_control')
            ->limit(5)
            ->get()
            ->map(function ($alumno) {
                return [
                    'nombre' => $alumno->nombreCompleto,
                    'no_control' => $alumno->no_control,
                    'carrera' => $alumno->carrera?->nombre,
                ];
            });

        return response()->json($lista);
    }

}

