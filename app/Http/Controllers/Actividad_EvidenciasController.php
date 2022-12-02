<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Actividad;
use App\Models\Actividad_Evidencia;
use App\Models\Mensaje;
use App\Models\Receptor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Alert;

class Actividad_EvidenciasController extends Controller
{
	public function destroy($id)
	{
		$actividad_evidencia = Actividad_Evidencia::find($id);
		if ($actividad_evidencia!=null) {
			if(Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD'])){
				//Eliminacion de responsables de una actividad
				$credito_vigente = DB::table('creditos as c')->join('actividad as a', function($join) use($actividad_evidencia){
					$join->on('a.id_actividad','=','c.id');
					$join->where('a.id','=',$actividad_evidencia->actividad_id);
					$join->where('c.vigente','=','true');
				})->get()->count()>0? true: false;
				if(!$credito_vigente){
					Alert::error('Error','Error es credito al que pertenece este responsable ya no es vigente por lo que esta operación esta restringida');					
					return redirect()->back();					
				}
				$participantes = DB::table('participantes as p')->where('p.id_evidencia','=',$id)->select('no_control')->get();
				if($actividad_evidencia->validado=="true"){	
					Alert::error('Error','Error al eliminar, este responsable ya tiene la evidencia validada');				
					return redirect()->back();					
				}
				if(count($actividad_evidencia->evidencias)>0){
					Alert::error('Error','Error al eliminar, el responsable cuenta con evidencias registradas');				
					return redirect()->back();				
				}
				if($participantes->count()>0){	
					Alert::error('Error','Error al eliminar, el responsable cuenta con participantes registrados');				
					return redirect()->back();					
				}
				if(count($actividad_evidencia->evidencias)==0 && $participantes->count()==0 && $actividad_evidencia->validado=="false"){
					Actividad_Evidencia::destroy($id);
					Alert::success('Correcto','El responsable fue retirado de la actividad con exito');					
					return redirect()->back();					
				}
				
			}else if(Auth::User()->can('ELIMINAR_RESPONSABLES')){
				$actividad = Actividad::find($actividad_evidencia->actividad_id);
				if($actividad->id_user!=Auth::User()->id){	
					Alert::error('Error','Error al eliminar, no puedes eliminar responsables de actividades que no te corresponden');				
					return redirect()->back();
					
				}
				
				$credito_vigente = DB::table('creditos as c')->join('actividad as a', function($join) use($actividad_evidencia){
					$join->on('a.id_actividad','=','c.id');
					$join->where('a.id','=',$actividad_evidencia->actividad_id);
					$join->where('c.vigente','=','true');
				})->get()->count()>0? true: false;
				if(!$credito_vigente){	
					Alert::error('Error','Error es credito al que pertenece este responsable ya no es vigente por lo que esta operación esta restringida');				
					return redirect()->back();					
				}
				$participantes = DB::table('participantes as p')->where('p.id_evidencia','=',$id)->select('no_control')->get();
				if($actividad_evidencia->validado=="true"){	
					Alert::error('Error','Error al eliminar, este responsable ya tiene la evidencia validada');				
					return redirect()->back();					
				}
				if(count($actividad_evidencia->evidencias)>0){	
					Alert::error('Error','Error al eliminar, el responsable cuenta con evidencias registradas');			
					return redirect()->back();					
				}
				if($participantes->count()>0){	
					Alert::error('Error','Error al eliminar, el responsable cuenta con participantes registrados');				
					return redirect()->back();					
				}
				if(count($actividad_evidencia->evidencias)==0 && $participantes->count()==0 && $actividad_evidencia->validado=="false"){
					Actividad_Evidencia::destroy($id);
					Alert::success('Correcto','El responsable fue retirado de la actividad con exito');
					return redirect()->back();					
				}
							
			}
		}
		Alert::error('Error','Lo que tratas de eliminar no existe');	
		return redirect()->back();		
	}

	public function show(){

	}
	// Funcion para obtener la diferencia de 2 arreglo2
	//La diferecia se define como "Los elementos que estan en A que no estan en B"
	public function obtenerDiferencia($arreglo1, $arreglo2){
		sort($arreglo1);
		sort($arreglo2);
		$diferencia = array();
		$x=0; $y=0;
		while($x<count($arreglo1) && $y<count($arreglo2)){
			if($arreglo1[$x]==$arreglo2[$y]){
				++$x;
				++$y;
			}else{
				if($arreglo1[$x]<$arreglo2[$y]){
					array_push($diferencia,$arreglo1[$x]);
					++$x;
				}else{
					++$y;
				}		
			}
		}
		while($x<count($arreglo1)){
			array_push($diferencia,$arreglo1[$x]);
			++$x;
		}
		return $diferencia;
	}

	public function asignarResponsables(Request $request){ 
		if(!$request->has('responsables_id')){
			$actividad_evidencia = Actividad_Evidencia::where('actividad_id','=',$request->actividad_id)->select('user_id')->get();
			$responsables_anteriores = array();
			foreach ($actividad_evidencia as $data) {
				array_push($responsables_anteriores,(string)$data->user_id);
			}
			for ($i = 0; $i < count($responsables_anteriores); $i++) {
				$id = Actividad_Evidencia::where([
					['user_id','=',$responsables_anteriores[$i]],
					['actividad_id','=',$request->actividad_id]
				])->select('id')->get();
				if($id->count()>0){
					Actividad_Evidencia::destroy($id[0]->id);
				}
			}
			return response()->json('Responsables asignados correctamente');
		}

		$actividad_evidencia = Actividad_Evidencia::where('actividad_id','=',$request->actividad_id)->select('user_id')->get();
		$responsables_anteriores = array();
		foreach ($actividad_evidencia as $data) {
			array_push($responsables_anteriores,(string)$data->user_id);
		}

		$diferencia_eliminar = $this->obtenerDiferencia($responsables_anteriores, $request->responsables_id);
		for ($i = 0; $i < count($diferencia_eliminar); $i++) {
			$id = Actividad_Evidencia::where([
				['user_id','=',$diferencia_eliminar[$i]],
				['actividad_id','=',$request->actividad_id]
			])->select('id')->get();
			if($id->count()>0){
				Actividad_Evidencia::destroy($id[0]->id);
			}
		}

		$actividad_evidencia = Actividad_Evidencia::where('actividad_id','=',$request->actividad_id)->select('user_id')->get();
		$responsables_sobrevivientes = array();
		foreach ($actividad_evidencia as $data) {
			array_push($responsables_sobrevivientes,(string)$data->user_id);
		}
		$diferencia_agregar = $this->obtenerDiferencia($request->responsables_id,$responsables_sobrevivientes);
		$actividad = Actividad::find($request->actividad_id);
		for ($i = 0; $i < count($diferencia_agregar); $i++) {
			$actividad_evidencia = new Actividad_Evidencia();
			$actividad_evidencia->user_id = $diferencia_agregar[$i];
			$actividad_evidencia->actividad_id = $request->actividad_id;
			$actividad_evidencia->validador_id = $actividad->id_user;
			$actividad_evidencia->save();
		}
		if(count($diferencia_agregar)>0){
			$actividad = Actividad::find($request->actividad_id);
			$mensaje = new Mensaje();
			$mensaje->creador_id = Auth::User()->id;
			$mensaje->mensaje = "Has sido asignado a la actividad ".$actividad->nombre.". #".$actividad->id;
			$mensaje->notificacion = "Nueva actividad asignada";
			$mensaje->save();
			for ($i = 0; $i < count($diferencia_agregar); $i++) {
				$destinatario = new Receptor();
				$destinatario->mensaje_id = $mensaje->id;
				$destinatario->user_id = $diferencia_agregar[$i];
				$destinatario->save();
			}
		}
		

		return response()->json("Responsables asignados correctamente");

	}

	
}
