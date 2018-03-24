<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Actividad;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
class Actividad_EvidenciasController extends Controller
{
	public function store(Request $request){
		$actividad = Actividad::find($request->actividad_id);
		//Sincronizamos los respoansables una actividad
		$actividad->users()->sync($request->user_id);
		//Retornamos la ruta de los responsables con el parametro que resibe que es el id de la actividad
		return redirect()->route('responsables',['id'=>$request->actividad_id]);
	}
	public function destroy($id){
		//Eliminadion de responsables de una actividad
		$actividad=DB::table('actividad_evidencia as a')->find($id);
		DB::table('actividad_evidencia')->where('id','=',$id)->delete();
		Flash::error('El resposable ha sido eliminado');
		//Retornamos la ruta de los responsables con el parametro que resibe que es el id de la actividad
		return redirect()->route('responsables',['id'=>$actividad->actividad_id]);
	}

	public function show(){

	}
}
