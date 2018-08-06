<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Actividad;
use App\Actividad_Evidencia;
use App\Evidencia;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
class Actividad_EvidenciasController extends Controller
{
	public function destroy($id){
		//Eliminacion de responsables de una actividad
		$actividad_evidencia = Actividad_Evidencia::find($id);
		if(count($actividad_evidencia->evidencias)>0){
			Flash::error('Error al eliminar, el responsable cuenta con evidencias registradas');
		}
		if(count($actividad_evidencia->evidencias)==0){
			Actividad_Evidencia::destroy($id);
			Flash::sucess('El responsable fue retirado de la actividad con exito');
		}
		//Retornamos la ruta de los responsables con el parametro que resibe que es el id de la actividad
		return redirect()->route('responsables',['id'=>$actividad_evidencia->actividad_id]);
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

		return response()->json("Responsables asignados correctamente");

	}

	
}
