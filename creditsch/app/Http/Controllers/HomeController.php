<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Receptor;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(Auth::guard('alumno')->check()){
            return redirect()->route('alumnos.home_avance'); 
        }else if(Auth::guard('web')->check()){
            $mensajes = Receptor::where('user_id','=',Auth::User()->id)->whereNull('fecha_visto')->join('mensajes','mensajes.id','=','receptores.mensaje_id')->join('users','users.id','=','mensajes.creador_id')->select('users.name as usuario_nombre','mensajes.notificacion','mensajes.mensaje','mensajes.id as mensaje_id','mensajes.created_at as fecha','receptores.visto','receptores.id as receptor_id')->paginate(5);
            return view('admin.mensajes.bandeja')
            ->with('mensajes',$mensajes);
        }
        return redirect()->route('login');
    }
}
