<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware('permission:VIP|VER_USUARIOS|VIP_SOLO_LECTURA')->only(['index','show']);
        $this->middleware('permission:VIP|CREAR_USUARIOS')->only(['store','create']);
        $this->middleware('permission:VIP|MODIFICAR_USUARIOS')->only(['update','edit']);
        $this->middleware('permission:VIP|ELIMINAR_USUARIOS')->only(['destroy']);
        $this->middleware('permission:VIP|ASIGNAR_REMOVER_ROLES_USUARIOS')->only(['guardarRoles','asignarRoles']);
    }
    public function index(){
    	$users = User::all();
    	return view('admin.usuarios.index')
    	->with('users',$users);
    }
    public function create(){
    	$carreras = [
    		['carrera' => 'Ing. en Sistemas Computacionales','valor' => 'Sistemas'],
    		['carrera' => 'Ing. en Nanotecnología', 'valor' => 'Nanotecnología'],
    		['carrera' => 'Ing. en Mecatrónica','valor' => 'Mecatrónica'],
    		['carrera' => 'Ing. en Bioquímica','valor' => 'Bioquímica'],
    		['carrera' => 'Ing. en Tecnologías de la Información y Comunicaciones','valor' =>"TIC's"],
    		['carrera' => 'Ing. en Gestión Empresarial','valor' => 'Gestión Empresarial'],
    		['carrera' => 'Ing. Industrial', 'valor' => 'Industrial']
    	];
    	return view('admin.usuarios.registrar')->with('carreras',$carreras);
    }
    public function store(UserRequest $request){
    	$user = new User($request->all());
    	$user->password = bcrypt($request->password);
    	$user->save();
    	Flash::success('El usuario '.$user->name.' has sido registrado exitosamente!');
    	return redirect()->route('usuarios.index');
    }

    public function edit($id){
        $carreras = [
            ['carrera' => 'Ing. en Sistemas Computacionales','valor' => 'Sistemas'],
            ['carrera' => 'Ing. en Nanotecnología', 'valor' => 'Nanotecnología'],
            ['carrera' => 'Ing. en Mecatrónica','valor' => 'Mecatrónica'],
            ['carrera' => 'Ing. en Bioquímica','valor' => 'Bioquímica'],
            ['carrera' => 'Ing. en Tecnologías de la Información y Comunicaciones','valor' =>"TIC's"],
            ['carrera' => 'Ing. en Gestión Empresarial','valor' => 'Gestión Empresarial'],
            ['carrera' => 'Ing. Industrial', 'valor' => 'Industrial']
        ];
        $user = User::find($id);
        return view('admin.usuarios.edit')
        ->with('carreras',$carreras)
        ->with('user',$user);
    }

    public function update(UserRequest $request, $id){
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->area = $request->area;
        $user->active = $request->active;
        if($user->password!=$request->password) $user->password= bcrypt($request->password);
        $user->save();
        return redirect()->route('usuarios.index');
    }

    public function destroy($id){
        if(Auth::User()->id==$id){
            Flash::error('No te puedes autoeliminar');
            return redirect()->route('usuarios.index');
        }
        $user = User::find($id);
        if($user==null){
            Flash::error('El usuario no existe');
            return redirect()->route('usuarios.index');
        }
        $actividades = DB::table('actividad as a')->where('a.id_user','=',$id)->get()->count()>0? true: false;
        $responsable = DB::table('actividad_evidencia as ae')->where('ae.user_id','=',$id)->orwhere('ae.user_id','=',$id)->get()->count()>0?true:false;
        $roles = DB::table('model_has_roles')->where('model_id','=',$id)->get()->count()>0?true:false;

        if($roles || $actividades || $responsable){
            Flash::error('El usuarios '.$user->name.' no puede ser eliminado debido debido a claves foraneas');
            return redirect()->route('usuarios.index');
        }
        $user->delete();
        return redirect()->back();
    }

    public function asignarRoles($id){
        $user = User::find($id);
        $roles_data = DB::table('roles')->leftjoin('model_has_roles as model',function($join) use($id){
            $join->on('model.role_id','=','roles.id');
            $join->where('model.model_type','=','App\user');
            $join->where('model.model_id','=',$id);
        })->leftjoin('users',function($join) use($id){
            $join->on('users.id','=','model.model_id');
            $join->where('users.id','=',$id);
        })->select('users.name as user_name','roles.name','roles.id as id')->get();
        return view('admin.usuarios.asignar_roles')
        ->with('roles',$roles_data)
        ->with('user',$user);
    }

    public function guardarRoles(Request $request){
        if(!$request->has('user_id')) return redirect()->route('usuarios.index');
        if($request->has('roles_id')){
            $user = User::find($request->user_id);
            $user->syncRoles($request->roles_id);
        }else{
            $user= User::find($request->user_id);
            $roles = $user->getRoleNames();
            if(count($roles)>0){
                $user->syncRoles([]);
            }
        }
        Flash::success('Roles asignados correctamente');
        return redirect()->route('usuarios.index');
    }
}
