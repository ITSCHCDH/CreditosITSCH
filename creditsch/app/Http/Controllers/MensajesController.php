<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Laracasts\Flash\Flash;
use App\User;
use App\Mensaje;
use App\Receptor;
use DB;

class MensajesController extends Controller
{
    
    public function index(){
		$mensajes = Receptor::where('user_id','=',Auth::User()->id)->whereNull('fecha_visto')->join('mensajes','mensajes.id','=','receptores.mensaje_id')->join('users','users.id','=','mensajes.creador_id')->select('users.name as usuario_nombre','mensajes.notificacion','mensajes.id as mensaje_id','mensajes.created_at as fecha','receptores.visto','receptores.id as receptor_id')->paginate(5);
		return view('admin.mensajes.bandeja')
		->with('mensajes',$mensajes);	
    }
    public function crear(){
    	$users = User::where([
    		['active','=','true'],
    		['id','<>',Auth::User()->id]
    	])->select('id','name')->get();
    	return view('admin.mensajes.crear')
    	->with('users',$users);
    }
    public function ver(Request $request){
    	$mensaje = Mensaje::where('mensajes.id','=',$request->mensaje_id)->join('users','users.id','=','mensajes.creador_id')->get();
        $ruta = $request->has('ruta');
    	if ($request->has('receptor_id')) {
    		$receptor = Receptor::find($request->receptor_id);
    		if ($receptor->visto=="false") {
    			$receptor->visto="true";
    			$receptor->fecha_visto=Carbon::now()->setTimezone('CDT');
    			$receptor->save();
    		}	
    	}
        $mensaje = $mensaje[0];
        $actividad_id = null;
        $pos = strpos($mensaje->mensaje, "#",0);
        if($pos != false){
            $actividad_id = substr($mensaje->mensaje,$pos+1);
            $mensaje->mensaje = substr($mensaje->mensaje, 0,$pos);
        }      
    	return view('admin.mensajes.ver')
    	->with('mensaje',$mensaje)
    	->with('ruta',$ruta)
        ->with('actividad_id',$actividad_id);
    }

    public function enviar(Request $request){
    	$mensaje = new Mensaje($request->all());
    	$mensaje->save();
    	for ($i = 0; $i < count($request->destinatarios_id); $i++) {
    		$destinatario = new Receptor();
    		$destinatario->mensaje_id = $mensaje->id;
    		$destinatario->user_id = $request->destinatarios_id[$i];
    		$destinatario->save();
    	}
    	Flash::success("El mensaje fue enviado correctamente");
    	return redirect()->route('mensajes.index');
    }
    public function enviados(){
    	$mensajes = Mensaje::where('creador_id','=',Auth::User()->id)->paginate(5);
    	return view('admin.mensajes.enviados')
    	->with('mensajes',$mensajes);
    }

    public function destinatarios(Request $request){
    	$receptores = Receptor::where('mensaje_id','=',$request->mensaje_id)->join('users','users.id','=','receptores.user_id')->select('receptores.visto','receptores.fecha_visto','users.name as usuario_nombre')->get();
    	return view('admin.mensajes.receptores')
    	->with('receptores',$receptores);
    }

    public function nuevosMensajes(){
        $mensajes = DB::table('users as u')->join('receptores as r', function($join){
            $join->on('r.user_id','=','u.id');
            $join->where('u.id','=',Auth::User()->id);
        })->join('mensajes as m','m.id','=','r.mensaje_id')->where('r.visto','<>','true')->select('r.mensaje_id','u.id as usuario_id','m.notificacion','m.created_at as fecha','r.id as receptor_id')->get();
        return response()->json(array('data' => $mensajes,'no_mensajes' => $mensajes->count()));
	}
	
	public function mensajesVistos(){
		$mensajes = Receptor::where('user_id','=',Auth::User()->id)->whereNotNull('fecha_visto')->join('mensajes','mensajes.id','=','receptores.mensaje_id')->join('users','users.id','=','mensajes.creador_id')->select('users.name as usuario_nombre','mensajes.notificacion','mensajes.id as mensaje_id','mensajes.created_at as fecha','receptores.visto','receptores.id as receptor_id')->paginate(5);
		return view('admin.mensajes.vistos')
		->with('mensajes',$mensajes);	
	}
}
