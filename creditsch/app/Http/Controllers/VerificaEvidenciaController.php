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
class VerificaEvidenciaController extends Controller
{
    public function index(){
    	//select e.nom_imagen, e.status, e.id, u.name, a.nombre, a.por_cred_actividad,c.nombre from evidencia as e join actividad_evidencia as ae on e.id_asig_actividades = ae.id join users as u on ae.user_id = u.id join actividad as a on ae.actividad_id = a.id join creditos as c on a.id_actividad = c.id;

    	$evidencias_data = DB::table('evidencia as e')->join('actividad_evidencia as ae','e.id_asig_actividades','=','ae.id')->join('users as u','ae.user_id','=','u.id')->join('actividad as a','ae.actividad_id','=','a.id')->join('creditos as c','a.id_actividad','=','c.id')->select('e.nom_imagen','e.status','e.id','u.name','a.nombre','a.por_cred_actividad','c.nombre as nombre_credito','c.id as id_credito','ae.id as actividad_evidencia_id')->groupBy('ae.id')->get();
    	return view('admin.verifica_evidencia.index')->with('evidencias_data',$evidencias_data);
    }
    public function store(Request $request){
    	if($request->id_evidencias){
            $index=0;
            for($x=0; $x<count($request->id_evidencias); $x++){
                $validados = DB::table('actividad_evidencia as ae')->join('evidencia as e', function($join) use($request,$x){
                    $join->on('e.id_asig_actividades','=','ae.id');
                    $join->where('ae.id','=',$request->id_evidencias[$x]);
                    $join->where('e.status','=',1);
                })->get();
                if($validados->count()>0)continue;
                $evidencias_a_validar = DB::table('actividad_evidencia as ae')->join('evidencia as e', function($join) use($request,$x){
                    $join->on('e.id_asig_actividades','=','ae.id');
                    $join->where('ae.id','=',$request->id_evidencias[$x]);
                })->select('e.id')->get();
                for(; $index<count($request->array_de_ids); $index++){
                    if($request->array_de_ids[$index]==$request->id_evidencias[$x])break;
                }
                $participantes_lista = DB::table('participantes')->where('id_evidencia','=',$request->id_evidencias[$x])->select('id','no_control')->get();
                for ($i=0; $i < count($evidencias_a_validar); $i++) { 
                    $evidencia = Evidencia::find($evidencias_a_validar[$i]->id);
                    $evidencia->status=1;
                    $evidencia->save();
                }
                for ($i=0; $i < count($participantes_lista); $i++) {
                    $temp = Avance::where([
                        ['no_control','=',$participantes_lista[$i]->no_control],
                        ['id_credito','=',$request->id_creditos[$index]]
                    ])->get();
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
        if($request->has('ruta_carrera') && $request->has('ruta_generacion')){
            array_push($ruta_data,$request->ruta_carrera,$request->ruta_generacion);
        }
        $creditos = Credito::select('nombre')->orderBy('nombre')->get();
    	if($request->has('no_control')){
    		$alumno = DB::table('alumnos')->where('no_control','=',$request->get('no_control'))->get();
    		if($alumno->count()==0){
    			Flash::error('El numero de control no exite');
    			return redirect()->route('verifica_evidencia.avance_alumno');

    		}
    		$alumno_data = DB::table('alumnos as alu')->join('participantes as p', function($join) use ($request){
    			$join->on('p.no_control','=','alu.no_control');
    			$join->where('alu.no_control','=',$request->get('no_control'));
    		})->join('actividad_evidencia as ae','ae.id','=','p.id_evidencia')->join('evidencia as e',function($join){
                $join->on('e.id_asig_actividades','=','ae.id');
                $join->on('e.status','=',DB::raw('1'));
            })->join('actividad as a','a.id','=','ae.actividad_id')->join('creditos as c','c.id','=','a.id_actividad')->join('avance as av',function($join) use ($request){
    			$join->on('av.id_credito','=','c.id');
    			$join->where('av.no_control','=',$request->get('no_control'));
    		})->select('alu.no_control','alu.nombre as nombre_alumno','alu.carrera','c.nombre as nombre_credito','a.nombre as nombre_actividad','a.por_cred_actividad','av.por_credito')->orderBy('nombre_credito')->groupBy('nombre_actividad')->get();

    		if($alumno_data->count()==0){
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
    		
    		$generacion = substr($request->generacion,2,4);
    		$carrera = $request->get('carrera');
    		$reportes_data = DB::select('select alumnos.nombre, alumnos.no_control, alumnos.carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join creditos on (alumnos.no_control like "'.$generacion.'%" or alumnos.no_control like "_'.$generacion.'%") and alumnos.carrera="'.$carrera.'" left join avance on avance.id_credito = creditos.id and alumnos.no_control = avance.no_control order by alumnos.nombre asc, creditos.nombre asc');
    		$suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre, alumnos.no_control, alumnos.carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join creditos on (alumnos.no_control like "'.$generacion.'%" or alumnos.no_control like "_'.$generacion.'%") and alumnos.carrera="'.$carrera.'" left join avance on avance.id_credito = creditos.id and alumnos.no_control = avance.no_control group by alumnos.nombre order by alumnos.nombre asc');
    		//dd($reportes_data);
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
