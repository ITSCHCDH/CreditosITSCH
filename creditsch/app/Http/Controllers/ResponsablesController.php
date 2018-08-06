<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Actividad;
use App\AlumnosResponsables;
use Illuminate\Support\Facades\DB;
class ResponsablesController extends Controller
{
	/* Controllador para mostrar los responsables y seleccionarlos +*/
    public function show($id,Request $request){
        //Muestra los resposanbles asignados a la actividad
    	$actividad = Actividad::find($id);
        $responsables = User::join('actividad_evidencia as act_evi','act_evi.user_id','=','users.id')->where('act_evi.actividad_id','=',$id)->select('act_evi.id as actividad_evidencia_id','act_evi.actividad_id','act_evi.user_id','users.name','users.area','act_evi.validado')->get();
    	return view ('admin.actividades.responsableshow')->with('responsables',$responsables)->with('actividad',$actividad);
    }
    public function index($id,Request $request){
        //Muestra todos los responsables incluyendo lo que noe stan asignados
        $actividad = Actividad::find($id);
        $responsables = DB::table('users as u')->leftjoin('actividad_evidencia as ae',function($join) use($id){
            $join->on('ae.user_id','=','u.id');
            $join->where('ae.actividad_id','=',$id);
        })->leftjoin('actividad as a','a.id','=','ae.actividad_id')->leftjoin('evidencia as e','e.id_asig_actividades','=','ae.id')->leftjoin('participantes as p','p.id_evidencia','=','ae.id')->groupBy('usuario_id')->select('u.name as usuario_nombre','u.id as usuario_id','a.nombre as actividad_nombre','e.nom_imagen as evidencias','p.no_control as participantes','u.area','u.active')->get();
        //dd($responsables);
    	return view ('admin.actividades.responsablesindex')->with('responsables',$responsables)->with('actividad',$actividad);
    }
}
