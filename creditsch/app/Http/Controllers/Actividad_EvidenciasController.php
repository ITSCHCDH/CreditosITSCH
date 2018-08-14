<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Actividad;
use App\Actividad_Evidencia;
use App\Evidencia;
use App\Mensaje;
use App\Receptor;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Auth;

class Actividad_EvidenciasController extends Controller
{
	public function destroy($id){
		$actividad_evidencia = Actividad_Evidencia::find($id);
		if ($actividad_evidencia!=null) {
			if(Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD'])){
				//Eliminacion de responsables de una actividad
				$participantes = DB::table('participantes as p')->where('p.id_evidencia','=',$id)->select('no_control')->get();
				if($actividad_evidencia->validado=="true"){
					Flash::error('Error al eliminar, este responsable ya tiene la evidencia validada');
				}
				if(count($actividad_evidencia->evidencias)>0){
					Flash::error('Error al eliminar, el responsable cuenta con evidencias registradas');
				}
				if($participantes->count()>0){
					Flash::error('Error al eliminar, el responsable cuenta con participantes registrados');	
				}
				if(count($actividad_evidencia->evidencias)==0 && $participantes->count()==0 && $actividad_evidencia->validado=="false"){
					Actividad_Evidencia::destroy($id);
					Flash::sucess('El responsable fue retirado de la actividad con exito');
				}
				return redirect()->back();
			}else if(Auth::User()->can('ELIMINAR_RESPONSABLES')){
				$actividad = Actividad::find($actividad_evidencia->actividad_id);
				if($actividad->id_user!=Auth::User()->id){
					Flash::error('Error al eliminar, no puedes eliminar responsables de actividades que no te corresponden');
					return redirect()->back();
				}
				$participantes = DB::table('participantes as p')->where('p.id_evidencia','=',$id)->select('no_control')->get();
				if($actividad_evidencia->validado=="true"){
					Flash::error('Error al eliminar, este responsable ya tiene la evidencia validada');
				}
				if(count($actividad_evidencia->evidencias)>0){
					Flash::error('Error al eliminar, el responsable cuenta con evidencias registradas');
				}
				if($participantes->count()>0){
					Flash::error('Error al eliminar, el responsable cuenta con participantes registrados');	
				}
				if(count($actividad_evidencia->evidencias)==0 && $participantes->count()==0 && $actividad_evidencia->validado=="false"){
					Actividad_Evidencia::destroy($id);
					Flash::success('El responsable fue retirado de la actividad con exito');
				}
				//Retornamos la ruta de los responsables con el parametro que resibe que es el id de la actividad
				return redirect()->back();
			}
		}
		Flash::error('Lo que tratas de eliminar no existe');	
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

		for ($i = 0; $i < count($diferencia_agregar); $i++) {
			$actividad_evidencia = new Actividad_Evidencia();
			$actividad_evidencia->user_id = $diferencia_agregar[$i];
			$actividad_evidencia->actividad_id = $request->actividad_id;
			$actividad_evidencia->save();
		}
		if(count($diferencia_agregar)>0){
			$actividad = Actividad::find($request->actividad_id);
			$mensaje = new Mensaje();
			$mensaje->creador_id = Auth::User()->id;
			$mensaje->mensaje = "Has sido asignado a la actividad ".$actividad->nombre.".";
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
