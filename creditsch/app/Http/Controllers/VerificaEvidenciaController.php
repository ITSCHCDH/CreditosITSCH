<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use App\Evidencia;
use App\Avance;
class VerificaEvidenciaController extends Controller
{
    public function index(){
    	//select e.nom_imagen, e.status, e.id, u.name, a.nombre, a.por_cred_actividad,c.nombre from evidencia as e join actividad_evidencia as ae on e.id_asig_actividades = ae.id join users as u on ae.user_id = u.id join actividad as a on ae.actividad_id = a.id join creditos as c on a.id_actividad = c.id;

    	$evidencias_data = DB::table('evidencia as e')->join('actividad_evidencia as ae','e.id_asig_actividades','=','ae.id')->join('users as u','ae.user_id','=','u.id')->join('actividad as a','ae.actividad_id','=','a.id')->join('creditos as c','a.id_actividad','=','c.id')->select('e.nom_imagen','e.status','e.id','u.name','a.nombre','a.por_cred_actividad','c.nombre as nombre_credito','c.id as id_credito')->get();
    	return view('admin.verifica_evidencia.index')->with('evidencias_data',$evidencias_data);
    }
    public function store(Request $request){
    	if($request->id_evidencias){
    		for($x=0; $x<count($request->id_evidencias); $x++){
    			$temp = Evidencia::find($request->id_evidencias[$x]);
    			if($temp->status==1)continue;
    			$index=0;
    			for(; $index<count($request->array_de_ids); $index++){
    				if($request->array_de_ids[$index]==$request->id_evidencias[$x])break;
    			}
    			$participantes = DB::table('participantes')->where('id_evidencia','=',$request->id_evidencias[$x])->select('no_control')->get();
    			foreach ($participantes as $no_control) {
    				$temp = Avance::where([
    					['no_control','=',$no_control->no_control],
    					['id_credito','=',$request->id_creditos[$index]]
    				])->get();
    				if($temp->count()==0){
    					$avance = new Avance();
    					$avance->no_control = $no_control->no_control;
    					$avance->por_credito = (int)$request->por_cred_actividades[$index];
    					$avance->id_credito=$request->id_creditos[$index];
    					$avance->save();
    				}else{
    					$avance = Avance::find($temp[0]->id);
    					$avance->por_credito += (int)$request->por_cred_actividades[$index];
    					$avance->save();
    				}
    			}
    			$temp = Evidencia::find($request->id_evidencias[$x]);
    			$temp->status=1;
    			$temp->save();
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
    	//select e.id as evidencia_id,e.status,p.id as participante_id,alu.no_control,alu.nombre,alu.carrera,av.id_credito,av.por_credito,c.nombre as nombre_credito, a.nombre as nombre_actividad from evidencia as e join participantes as p on e.id = p.id_evidencia join alumnos as alu on alu.no_control=p.no_control join avance as av on av.no_control = p.no_control join creditos as c on c.id=av.id_credito join actividad_evidencia as ae on ae.id = e.id_asig_actividades join actividad as a on a.id = ae.actividad_id group by av.id order by nombre asc, nombre_credito asc;
    	$alumno_data=null;
    	if($request->has('no_control')){
    		$alumno = DB::table('alumnos')->where('no_control','=',$request->get('no_control'))->get();
    		if($alumno->count()==0){
    			Flash::error('El numero de control no exite');
    			return redirect()->route('verifica_evidencia.avance_alumno');

    		}
    		$alumno_data = DB::table('alumnos as alu')->join('participantes as p', function($join) use ($request){
    			$join->on('p.no_control','=','alu.no_control');
    			$join->on('alu.no_control','=',DB::raw($request->get('no_control')));
    		})->join('evidencia as e',function($join){
    			$join->on('e.id','=','p.id_evidencia');
    			$join->on('e.status','=',DB::raw('1'));
    		})->join('actividad_evidencia as ae','ae.id','=','e.id_asig_actividades')->join('actividad as a','a.id','=','ae.actividad_id')->join('creditos as c','c.id','=','a.id_actividad')->join('avance as av',function($join) use ($request){
    			$join->on('av.id_credito','=','c.id');
    			$join->on('av.no_control','=',DB::raw($request->get('no_control')));
    		})->select('alu.no_control','alu.nombre as nombre_alumno','alu.carrera','c.nombre as nombre_credito','a.nombre as nombre_actividad','a.por_cred_actividad','av.por_credito')->get();
    		if($alumno_data->count()==0)$alumno_data=null;
    	}
    	return view('admin.verifica_evidencia.avance_alumno')->with('alumno_data',$alumno_data);
    }
}
