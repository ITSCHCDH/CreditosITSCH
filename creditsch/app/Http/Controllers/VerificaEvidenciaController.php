<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use App\Evidencia;
use App\Avance;
use App\Alumno;
use App\Credito;
use App\Participante;
use App\Actividad_Evidencia;

class VerificaEvidenciaController extends Controller
{
    public function index(){

    	$evidencias_data = DB::table('evidencia as e')->join('actividad_evidencia as ae','e.id_asig_actividades','=','ae.id')->join('users as u','ae.user_id','=','u.id')->join('actividad as a','ae.actividad_id','=','a.id')->join('creditos as c','a.id_actividad','=','c.id')->select('e.nom_imagen','e.id','ae.validado','u.name','a.nombre','a.por_cred_actividad','c.nombre as nombre_credito','c.id as id_credito','ae.id as actividad_evidencia_id')->groupBy('ae.id')->get();
    	return view('admin.verifica_evidencia.index')->with('evidencias_data',$evidencias_data);
    }
    public function store(Request $request){
        //Validamos si el request viene con las evidencias
    	if($request->id_evidencias){
            //Variabla index no ayudara como apuntador para saber el porcetaje de liberacion de la actividad y el idencificador del credito al que pertenece
            $index=0;
            for($x=0; $x<count($request->id_evidencias); $x++){
                $validados = DB::table('actividad_evidencia as ae')->where([
                    ['ae.id','=',$request->id_evidencias[$x]],
                    ['ae.validado','=','true']
                ])->get();
                //Si la evidencia ya esta validada continuamos
                if($validados->count()>0)continue;
                //
                while($request->array_de_ids[$index]!=$request->id_evidencias[$x])$index++;
                //Validamos la evidencia
                $validar_evidencia = Actividad_Evidencia::find($request->id_evidencias[$x]);
                $validar_evidencia->validado = 'true';
                $validar_evidencia->save();
                //Consulta para traer los numeros de control vinculasdos con la actividad
                $participantes_lista = DB::table('participantes as p')->join('actividad_evidencia as ae','ae.id','=','p.id_evidencia')->where('ae.id','=',$request->id_evidencias[$x])->select('p.no_control')->get();
                //Se le asigna el porcentaje de credito a los participantes una vez validada
                for ($i=0; $i < count($participantes_lista); $i++) {
                    $temp = Avance::where([
                        ['no_control','=',$participantes_lista[$i]->no_control],
                        ['id_credito','=',$request->id_creditos[$index]]
                    ])->get();
                    //Si no existe un registro con su numero de control y el id del credito se le crea uno en caso contrario se le suma el procentaje de liberacion
                    if($temp->count()>0){
                        $avance = Avance::find($temp[0]->id);
                        $avance->por_credito += (int)$request->por_cred_actividades[$index];
                        $avance->save();
                    }else{
                        $avance = new Avance();
                        $avance->no_control=$participantes_lista[$i]->no_control;
                        $avance->id_credito=$request->id_creditos[$index];
                        $avance->por_credito = (int)$request->por_cred_actividades[$index];
                        $avance->save();
                    }
                }
            }
        }
    	return redirect()->route('verifica_evidencia.index');
    }

    public function destroy($id){

    }

    public function show(){
    	
    }

    public function descargar($imagen){
    	$file= public_path(). "/images/evidencias/".$imagen;
	    return response()->download($file);
    }
    public function visualizar($imagen){
    	    $file= public_path(). "/images/evidencias/".$imagen;
    		return response()->file($file);
    }
    public function avanceAlumno(Request $request){
    	$alumno_data=null;
        $avance = true;
        $ruta_data = array();
        //Aqui se valida si la peticiom viene de la ruta reportes o de la de avance, para generar las rutas correctamente dependiendo de su origen
        if($request->has('ruta_carrera') && $request->has('ruta_generacion')){
            array_push($ruta_data,$request->ruta_carrera,$request->ruta_generacion);
        }
        //Traemos todos los creditos existentes
        $creditos = Credito::select('nombre')->orderBy('nombre')->get();
    	if($request->has('no_control')){
            //Verificamos que el numero de control exista
    		$alumno = DB::table('alumnos')->where('no_control','=',$request->get('no_control'))->get();
    		if($alumno->count()==0){
    			Flash::error('El numero de control no exite');
    			return redirect()->route('verifica_evidencia.avance_alumno');

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
            })->join('actividad as a','a.id','=','ae.actividad_id')->join('creditos as c','c.id','=','a.id_actividad')->join('avance as av',function($join) use ($request){
    			$join->on('av.id_credito','=','c.id');
    			$join->where('av.no_control','=',$request->get('no_control'));
    		})->select('alu.no_control','alu.nombre as nombre_alumno','alu.carrera','c.nombre as nombre_credito','a.nombre as nombre_actividad','a.por_cred_actividad','av.por_credito')->orderBy('nombre_credito')->groupBy('nombre_actividad')->get();
            //Validamos que el alumnos tenga algun avance
    		if($alumno_data->count()==0){
                //SI no tiene avance solo retornamos los datos del alumno los datos del alumno
                $avance = false;
                $alumno_data= DB::table('alumnos')->select('nombre as nombre_alumno','carrera','no_control')->where('no_control','=',$request->get('no_control'))->get();
            }
    	}
    	return view('admin.verifica_evidencia.avance_alumno')
        ->with('alumno_data',$alumno_data)
        ->with('creditos',$creditos)
        ->with('ruta_data',$ruta_data)
        ->with('avance',$avance);
    }

    public function reportes(Request $request){
    	$creditos_count = Credito::all();
    	$creditos = count($creditos_count);
    	if($request->has('generacion')){
            //Substraemos los dos ultimos digitos del año de generacion
    		$generacion = substr($request->generacion,2,4);
    		$carrera = $request->get('carrera');
            //Consulta para traer los creditos y su avance indibidual de cada uno
    		$reportes_data = DB::select('select alumnos.nombre, alumnos.no_control, alumnos.carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join creditos on (alumnos.no_control like "'.$generacion.'%" or alumnos.no_control like "_'.$generacion.'%") and alumnos.carrera="'.$carrera.'" left join avance on avance.id_credito = creditos.id and alumnos.no_control = avance.no_control order by alumnos.nombre asc, creditos.nombre asc');
            //Cosulta para traer la suma total de todos creditos
    		$suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre, alumnos.no_control, alumnos.carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join creditos on (alumnos.no_control like "'.$generacion.'%" or alumnos.no_control like "_'.$generacion.'%") and alumnos.carrera="'.$carrera.'" left join avance on avance.id_credito = creditos.id and alumnos.no_control = avance.no_control group by alumnos.nombre order by alumnos.nombre asc');
    	}else{
    		$reportes_data = null;
    		$suma_creditos = null;
    	}

    	return view('admin.verifica_evidencia.reportes')
    	->with('reportes_data',$reportes_data)
    	->with('creditos',$creditos)
    	->with('suma_creditos',$suma_creditos);
    }

    public function verEvidencia($id){
        $evidencias = DB::table('actividad_evidencia as ae')->join('users as u','u.id','=','ae.user_id')->join('actividad as a','a.id','=','ae.actividad_id')->join('evidencia as e','e.id_asig_actividades','=','ae.id')->where('ae.id','=',$id)->select('u.name as usuario_nombre','a.nombre as actividad_nombre','e.created_at as fecha_subida','ae.id as actividad_evidencia_id','e.nom_imagen')->get();
        return view('admin.verifica_evidencia.ver_evidencia')
        ->with('evidencias',$evidencias);
    }

}
