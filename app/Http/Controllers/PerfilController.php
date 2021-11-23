<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordResetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Laracasts\Flash\Flash;
use App\User;

class PerfilController extends Controller
{
    public function index(){
    	$data_user = User::join('areas as a','a.id','=','users.area')->where('users.id','=',Auth::User()->id)->select('a.nombre as area_nombre','users.name as usuario_nombre','users.email as usuario_correo')->get();
    	$roles = User::find(Auth::User()->id)->getRoleNames();
    	return view('admin.perfil.index')
    	->with('data_usuario',$data_user[0])
    	->with('roles',$roles);
    }

    public function passwordResetView(){
    	return view('admin.perfil.password_reset');
    }

    public function passwordUpdate(PasswordResetRequest $request){
    	if(!Hash::check($request->old_password, Auth::User()->password)){
    		Flash::error("La contraseña actual no es correcta");
    		return redirect()->back();
    	}
    	$user = User::find(Auth::User()->id);
    	$user->password = bcrypt($request->new_password);
    	$user->save();
    	Flash::success("Contraseña reseteada correctamente");
    	return redirect()->route('perfil.index');
    }
}
