<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Actividad;
use Illuminate\Support\Facades\DB;
class ResponsablesController extends Controller
{
	/* Controllador para mostrar los responsables y seleccionarlos +*/
    public function show($id,Request $request){
        //Muestra los resposanbles asignados a la actividad
    	$actividad = Actividad::find($id);
        $responsables = User::Search($request->nombre)->join('actividad_evidencia as act_evi','act_evi.user_id','=','users.id')->where('act_evi.actividad_id','=',$id)->select('act_evi.id as actividad_evidencia_id','act_evi.actividad_id','act_evi.user_id','users.name','users.area')->get();
    	return view ('admin.actividades.responsableshow')->with('responsables',$responsables)->with('actividad',$actividad);
    }
    public function index($id,Request $request){
        //Muestra todos los responsables incluyendo lo que noe stan asignados
    	$actividad = Actividad::find($id);
       $responsables = DB::table('actividad_evidencia')->join('actividad',function($join) use($id){
            $join->where('actividad_evidencia.actividad_id','=',$id)->on('actividad_evidencia.actividad_id','=','actividad.id');
        })->rightjoin('users','actividad_evidencia.user_id','=','users.id')->where('users.name','LIKE',"%$request->nombre%")->select('actividad_evidencia.id','actividad_evidencia.user_id as asignado','actividad_evidencia.actividad_id','users.id as user_id','users.name','users.area')->get();
    	return view ('admin.actividades.responsablesindex')->with('responsables',$responsables)->with('actividad',$actividad);
    }
}
