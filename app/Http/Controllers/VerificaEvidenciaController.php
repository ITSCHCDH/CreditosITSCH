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
        $this->middleware('permission:VIP|VIP_SOLO_LECTURA|VER_AVANCE_ALUMNO|VIP_AVANCE_ALUMNO')->only('alumnosBusqueda');
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
            //Verificamos que el numero de control exista
    		$alumno = DB::table('alumnos')->where('no_control','=',$request->get('no_control'))->get();
    		if($alumno->count() == 0){
    			Alert::error('Error','El numero de control no exite');
    			return redirect()->route('verifica_evidencia.avance_alumno');

    		}else{
                if(!Auth::User()->hasAnyPermission(['VIP','VIP_AVANCE_ALUMNO']) && $alumno[0]->carrera!=Auth::User()->area){
                    Alert::error('Error','No puedes consultar avances de alumnos de otras carreras');
                    return redirect()->route('verifica_evidencia.avance_alumno');
                }
            }
            //Consulta para obterner el avance del alumno
    		$alumno_data = DB::table('alumnos as alu')->join('participantes as p', function($join) use ($request){
    			$join->on('p.no_control','=','alu.no_control');
    			$join->where('alu.no_control','=',$request->get('no_control'));
    		})->join('actividad_evidencia as ae',function($join){
                $join->on('ae.id','=','p.id_evidencia');
                $join->where('ae.validado','=','true');
            })->join('evidencia as e',function($join){
                $join->on('e.id_asig_actividades','=','ae.id');
            })->join('actividad as a','a.id','=','ae.actividad_id')
            ->join('creditos as c','c.id','=','a.id_actividad')
            ->join('avance as av',function($join) use ($request){
    			$join->on('av.id_credito','=','c.id');
    			$join->where('av.no_control','=',$request->get('no_control'));
            })->join('areas','alu.carrera','=','areas.id')
            ->where(function($query){
                $query->where('p.evidencia_validada','=','na')->orwhere('p.evidencia_validada','=','si');
            })->where('ae.validado','=','true')
            ->select('alu.no_control','alu.nombre as nombre_alumno','areas.nombre as carrera','c.nombre as nombre_credito','a.nombre as nombre_actividad','a.por_cred_actividad','av.por_credito')->orderBy('nombre_credito')->groupBy('nombre_actividad')->get();
            $liberado = $this->verificarProgreso($request->get('no_control'));
            //Validamos que el alumnos tenga algun avance
    		if($alumno_data->count()==0){
                //SI no tiene avance solo retornamos los datos del alumno los datos del alumno
                $avance = false;
                $alumno_data= DB::table('alumnos as alu')->join('areas as a','a.id','=','alu.carrera')->select('alu.nombre as nombre_alumno','a.nombre as carrera','alu.no_control','alu.foto')->where('alu.no_control','=',$request->get('no_control'))->get();
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
        $alumno = Alumno::where('no_control', '=', $no_control)->get();

        if (!$alumno) return false;
        $alumno = $alumno[0];

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

        if ($creditos_liberados >= 5 && $alumno->status === 'pendiente') {
            $alumno->status = 'Liberado';
            $alumno->save();
        } else if ($alumno->status === 'Liberado') {
            $alumno->status = 'pendiente';
            $alumno->save();
        }
        return $creditos_liberados >= 5;
    }

    public function reportes(Request $request){
    	$creditos_count = Credito::all();
    	$creditos = count($creditos_count);
        $carreras = Area::Carreras()->get();
        $busqueda = $request->get('busqueda');
        if (Auth::User()->hasAnyPermission(['VIP','VIP_REPORTES','VIP_SOLO_LECTURA'])) {
            $carrera = null;
            if($request->has('generacion')){
                //Substraemos los dos ultimos digitos del año de generacion
                $generacion = substr($request->generacion,2,4);
                $carrera = $request->get('carrera');
                //Consulta para traer los creditos y su avance indibidual de cada uno
                if($request->status=="todos")
                {
                    $reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join creditos on ((alumnos.nombre like "%'.$busqueda.'%" or alumnos.no_control like "%'.$busqueda.'%") and (alumnos.no_control like "'.$generacion.'%" or alumnos.no_control like "_'.$generacion.'%")) and alumnos.carrera="'.$carrera.'" join areas on areas.id = alumnos.carrera left join avance on avance.id_credito = creditos.id and alumnos.no_control = avance.no_control order by alumnos.nombre asc, alumnos.no_control asc, creditos.nombre asc');
                    //dd($reportes_data);
                    //Cosulta para traer la suma total de todos creditos
                    $suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join creditos on ((alumnos.nombre like "%'.$busqueda.'%" or alumnos.no_control like "%'.$busqueda.'%") and (alumnos.no_control like "'.$generacion.'%" or alumnos.no_control like "_'.$generacion.'%")) and alumnos.carrera="'.$carrera.'" join areas on areas.id = alumnos.carrera left join avance on avance.id_credito = creditos.id and alumnos.no_control = avance.no_control group by alumnos.no_control order by alumnos.nombre asc, alumnos.no_control asc');
                }
                else
                {
                    $reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join creditos on ((alumnos.nombre like "%'.$busqueda.'%" or alumnos.no_control like "%'.$busqueda.'%") and (alumnos.no_control like "'.$generacion.'%" or alumnos.no_control like "_'.$generacion.'%")) and alumnos.carrera="'.$carrera.'" join areas on areas.id = alumnos.carrera left join avance on avance.id_credito = creditos.id and alumnos.no_control = avance.no_control WHERE alumnos.status = "'.$request->status.'" order by alumnos.nombre asc, alumnos.no_control asc, creditos.nombre asc');
                    //dd($reportes_data);
                    //Cosulta para traer la suma total de todos creditos
                    $suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join creditos on ((alumnos.nombre like "%'.$busqueda.'%" or alumnos.no_control like "%'.$busqueda.'%") and (alumnos.no_control like "'.$generacion.'%" or alumnos.no_control like "_'.$generacion.'%")) and alumnos.carrera="'.$carrera.'" join areas on areas.id = alumnos.carrera left join avance on avance.id_credito = creditos.id and alumnos.no_control = avance.no_control WHERE alumnos.status = "'.$request->status.'" group by alumnos.no_control order by alumnos.nombre asc, alumnos.no_control asc');
                }

            }
            else
            {
                $reportes_data = null;
                $suma_creditos = null;
            }
        }
        else
        {
            $carrera = null;
            if($request->has('generacion')){
                //Substraemos los dos ultimos digitos del año de generacion
                $generacion = substr($request->generacion,2,4);
                $carrera = $request->get('carrera');
                //Consulta para traer los creditos y su avance indibidual de cada uno
                if($request->status=="todos")
                {
                    $reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join creditos on ((alumnos.nombre like "%'.$busqueda.'%" or alumnos.no_control like "%'.$busqueda.'%") and (alumnos.no_control like "'.$generacion.'%" or alumnos.no_control like "_'.$generacion.'%")) and alumnos.carrera="'.$carrera.'" join areas on areas.id = alumnos.carrera left join avance on avance.id_credito = creditos.id and alumnos.no_control = avance.no_control order by alumnos.nombre asc, alumnos.no_control asc, creditos.nombre asc');
                    //Cosulta para traer la suma total de todos creditos
                    $suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre, alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join creditos on ((alumnos.nombre like "%'.$busqueda.'%" or alumnos.no_control like "%'.$busqueda.'%") and (alumnos.no_control like "'.$generacion.'%" or alumnos.no_control like "_'.$generacion.'%")) and alumnos.carrera="'.$carrera.'" join areas on areas.id = alumnos.carrera left join avance on avance.id_credito = creditos.id and alumnos.no_control = avance.no_control group by alumnos.no_control order by alumnos.nombre asc, alumnos.no_control asc');
                }
                else
                {
                    $reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join creditos on ((alumnos.nombre like "%'.$busqueda.'%" or alumnos.no_control like "%'.$busqueda.'%") and (alumnos.no_control like "'.$generacion.'%" or alumnos.no_control like "_'.$generacion.'%")) and alumnos.carrera="'.$carrera.'" join areas on areas.id = alumnos.carrera left join avance on avance.id_credito = creditos.id and alumnos.no_control = avance.no_control WHERE alumnos.status = "'.$request->status.'" order by alumnos.nombre asc, alumnos.no_control asc, creditos.nombre asc');
                    //Cosulta para traer la suma total de todos creditos
                    $suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre, alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join creditos on ((alumnos.nombre like "%'.$busqueda.'%" or alumnos.no_control like "%'.$busqueda.'%") and (alumnos.no_control like "'.$generacion.'%" or alumnos.no_control like "_'.$generacion.'%")) and alumnos.carrera="'.$carrera.'" join areas on areas.id = alumnos.carrera left join avance on avance.id_credito = creditos.id and alumnos.no_control = avance.no_control WHERE alumnos.status = "'.$request->status.'" group by alumnos.no_control order by alumnos.nombre asc, alumnos.no_control asc');
                }

            }
            else
            {
                $reportes_data = null;
                $suma_creditos = null;
            }
            $carreras = Area::CarrerasUsuario(Auth::User()->id)->get();
        }
        return view('admin.verifica_evidencia.reportes')
        ->with('reportes_data',$reportes_data)
        ->with('creditos',$creditos)
        ->with('suma_creditos',$suma_creditos)
        ->with('carreras',$carreras)
        ->with('carrera_seleccionada',$carrera)
        ->with('busqueda', $busqueda)
        ->with('status',$request->status)
        ->with('generacion',$request->generacion);
    }

    public function verEvidencia($id){
        $evidencias = DB::table('actividad_evidencia as ae')->join('users as u','u.id','=','ae.user_id')->join('actividad as a','a.id','=','ae.actividad_id')->join('evidencia as e','e.id_asig_actividades','=','ae.id')->where('ae.id','=',$id)->select('u.name as usuario_nombre','a.nombre as actividad_nombre','e.created_at as fecha_subida','ae.id as actividad_evidencia_id','e.nom_imagen')->get();
        return view('admin.verifica_evidencia.ver_evidencia')
        ->with('evidencias',$evidencias);
    }

    public function alumnosBusqueda(Request $request){
        if (Auth::User()->hasAnyPermission(['VIP','VIP_AVANCE_ALUMNO'])) {
            if($request->peticion == 0){
                $lista_alumnos = Alumno::select('nombre','no_control')->where('nombre','like',"%$request->nombre%")->orderBy('nombre');
            }else{
                $lista_alumnos = Alumno::select('nombre')->where('no_control','=',$request->no_control);
            }
        }else{
            if($request->peticion == 0){
                $lista_alumnos = Alumno::select('nombre','no_control')->where([
                    ['nombre','like',"%$request->nombre%"],
                    ['carrera','=',Auth::User()->area]
                ])->orderBy('nombre');
            }else{
                $lista_alumnos = Alumno::select('nombre')->where([
                    ['no_control','=',$request->no_control],
                    ['carrera','=',Auth::User()->area]
                ]);
            }
        }
        $lista_alumnos = $lista_alumnos->limit(100)->get();
        return response()->json($lista_alumnos);
    }

}

