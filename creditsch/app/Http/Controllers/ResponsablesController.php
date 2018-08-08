<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Actividad;
use App\AlumnosResponsables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class ResponsablesController extends Controller
{
    public function __construct(){
        $this->middleware('permission:VIP|VIP_ACTIVIDAD|VIP_SOLO_LECTURA|VER_RESPONSABLES')->only('show');
        $this->middleware('permission:VIP|VIP_ACTIVIDAD|AGREGAR_RESPONSABLES|ELIMINAR_RESPONSABLES')->only('index');
    }
	/* Controllador para mostrar los responsables y seleccionarlos +*/
    public function show($id){
        //Muestra los resposanbles asignados a la actividad
    	$actividad = Actividad::find($id);
        $responsables = User::join('actividad_evidencia as act_evi','act_evi.user_id','=','users.id')->where('act_evi.actividad_id','=',$id)->select('act_evi.id as actividad_evidencia_id','act_evi.actividad_id','act_evi.user_id','users.name','users.area','act_evi.validado')->get();
    	return view ('admin.actividades.responsableshow')->with('responsables',$responsables)->with('actividad',$actividad);
    }
    public function index($id){
        //Muestra todos los responsables incluyendo los que no stan asignados
        $actividad = Actividad::find($id);
        if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD'])) {
                $responsables = DB::table('users as u')->leftjoin('actividad_evidencia as ae',function($join) use($id){
                    $join->on('ae.user_id','=','u.id');
                    $join->where('ae.actividad_id','=',$id);
                })->leftjoin('actividad as a','a.id','=','ae.actividad_id')->leftjoin('evidencia as e','e.id_asig_actividades','=','ae.id')->leftjoin('participantes as p','p.id_evidencia','=','ae.id')->groupBy('usuario_id')->select('u.name as usuario_nombre','u.id as usuario_id','a.nombre as actividad_nombre','e.nom_imagen as evidencias','p.no_control as participantes','u.area','u.active','ae.validado')->get();
                return view ('admin.actividades.responsablesindex')->with('responsables',$responsables)->with('actividad',$actividad);
        }else if(Auth::User()->hasAllPermissions(['ELIMINAR_RESPONSABLES','AGREGAR_RESPONSABLES'])){
            if($actividad!=null){
                if($actividad->id_user==Auth::User()->id){
                    $responsables = DB::table('users as u')->leftjoin('actividad_evidencia as ae',function($join) use($id){
                        $join->on('ae.user_id','=','u.id');
                        $join->where('ae.actividad_id','=',$id);
                    })->leftjoin('actividad as a','a.id','=','ae.actividad_id')->leftjoin('evidencia as e','e.id_asig_actividades','=','ae.id')->leftjoin('participantes as p','p.id_evidencia','=','ae.id')->groupBy('usuario_id')->select('u.name as usuario_nombre','u.id as usuario_id','a.nombre as actividad_nombre','e.nom_imagen as evidencias','p.no_control as participantes','u.area','u.active','ae.validado')->get();
                    return view ('admin.actividades.responsablesindex')->with('responsables',$responsables)->with('actividad',$actividad);
                }
            }else{
                return view ('admin.actividades.responsablesindex')->with('responsables',null)->with('actividad',$actividad);
            }
        }
        return view ('admin.actividades.responsablesindex')->with('responsables',null)->with('actividad',$actividad);
    }
}
