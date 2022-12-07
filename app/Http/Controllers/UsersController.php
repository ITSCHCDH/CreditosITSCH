<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Area;
use Spatie\Permission\Models\Role;
use DB;
use Alert;

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
        if (Auth::User()->can('VIP')) {
                $users = DB::table('users as u')->join('areas as a','a.id','=','u.area')->select('a.nombre as area','u.name','u.active','u.id','u.email')->get();
                return view('admin.usuarios.index')
                ->with('users',$users);
        }else{
                $users = DB::table('users as u')->join('areas as a','a.id','=','u.area')->where([
                    ['u.area','=',Auth::User()->area],
                    ['u.id','<>','1']
                ])->select('a.nombre as area','u.name','u.active','u.id','u.email')->get();
                return view('admin.usuarios.index')
                ->with('users',$users);
        }

    }
    public function create(){
        if (Auth::User()->can('VIP')) {
            $areas = Area::orderBy('nombre','ASC')->get();
            $roles = Role::all();
            return view('admin.usuarios.registrar')
            ->with('areas',$areas)
            ->with('roles',$roles);
        }else{
            $permisos = Auth::User()->getPermissionsViaRoles();
            $arreglo_roles = array();
            $id = Auth::User()->id;
            foreach (Role::all() as $role) {
                $temp_permisos_role = $role->permissions;
                $valido = true;
                for ($x=0; $x < count($temp_permisos_role); $x++) {
                    $tiene_permiso = false;
                    for ($y=0; $y < count($permisos); $y++) {
                        if($temp_permisos_role[$x]->name == $permisos[$y]->name){
                            $tiene_permiso = true;
                            break;
                        }
                    }
                    if(!$tiene_permiso){
                        $valido = false;
                        break;
                    }
                }
                if($valido){
                    array_push($arreglo_roles,$role->name);
                }
            }
            $roles = DB::table('roles')->leftjoin('model_has_roles as model',function($join) use($id){
                $join->on('model.role_id','=','roles.id');
                $join->where('model.model_type','=','App\user');
                $join->where('model.model_id','=',$id);
            })->leftjoin('users',function($join) use($id){
                $join->on('users.id','=','model.model_id');
                $join->where('users.id','=',$id);
            })->whereIn("roles.name",$arreglo_roles)->select('users.name as user_name','roles.name','roles.id as id')->get();
            $areas = Area::where('id','=',Auth::User()->area)->orderBy('nombre','ASC')->get();
            return view('admin.usuarios.registrar')
            ->with('areas',$areas)
            ->with('roles',$roles);
        }
    }
    public function store(UserRequest $request){
    	$user = new User($request->all());
        $correo_duplicado = User::where('email','=',$user->email)->get()->count() > 0;
        if($correo_duplicado){

            Alert::error('Error','El correo '.$user->email.' ya se encuentra en uso');
            return back()->withInput();

        }
    	$user->password = bcrypt($request->password);
        $user->save();
        if($request->has('roles_id')){
            $user->syncRoles($request->roles_id);
        }
        Alert::success('Correcto','El usuario '.$user->name.' has sido registrado exitosamente!');
    	return redirect()->route('usuarios.index');
    }

    public function edit($id){
        $user = User::find($id);
        if($user==null){
            return redirect()->back()
            ->with("error","El usuario no existe");
        }
        if (Auth::User()->can('VIP')) {
            $areas = Area::orderBy('nombre','ASC')->get();
            return view('admin.usuarios.edit')
            ->with('areas',$areas)
            ->with('user',$user);
        }else{
            if($user->area!=Auth::User()->area){
                Alert::error('Error','No puedes editar usuarios que no te corresponden');
                return redirect()->back();
            }
            if($user->id==1){
                Alert::error('Error','No le puedes hacer modificaciones al administrador');
                return redirect()->back();
            }
            $areas = Area::where('id','=',Auth::User()->area)->orderBy('nombre','ASC')->get();
            return view('admin.usuarios.edit')
            ->with('areas',$areas)
            ->with('user',$user);
        }

    }

    public function update(UserRequest $request, $id){
        $user = User::find($id);
        if($user==null){
            Alert::error('Error','El usuario no existe');
            return redirect()->back();
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->area = $request->area;
        $user->active = $request->active;
        $correo_duplicado = User::where('email','=',$request->email)->get()->count() > 1;
        if($correo_duplicado){
            Alert::error('Error','El correo '.$request->email.' ya se encuentra en uso por otro usuario');
            return back()->withInput();
        }
        if($user->password!=$request->password) {
            if($request->password==$request->password_confirmation)
            {
                $user->password=bcrypt($request->password);
            }
            else
            {
                Alert::error('Error','Error de credenciales, las contraseñas deben ser iguales para el usuario: '.$user->nombre);
                return redirect()->route('alumnos.index');
            }
        }
        $user->save();

        Alert::success('Correcto','El usuario '.$request->name.' se modifico correctamente');
        return redirect()->route('usuarios.index');
    }


    public function destroy($id){
        if(Auth::User()->id==$id){
            Alert::error('Error','No te puedes autoeliminar');
            return redirect()->route('usuarios.index');
        }
        $user = User::find($id);
        if($user==null){
            Alert::error('Error','El usuario no existe');
            return redirect()->route('usuarios.index');
        }

        if(Auth::User()->can('VIP')){
            $actividades = DB::table('actividad as a')->where('a.id_user','=',$id)->get()->count()>0? true: false;
            $responsable = DB::table('actividad_evidencia as ae')->where('ae.user_id','=',$id)->orwhere('ae.user_id','=',$id)->get()->count()>0?true:false;
            $roles = DB::table('model_has_roles')->where('model_id','=',$id)->get()->count()>0?true:false;

            if($roles || $actividades || $responsable){
                return redirect()->route('usuarios.index')
                ->with("error","El usuarios ".$user->name." no puede ser eliminado debido debido a claves foraneas");
            }
            $user->delete();
            return redirect()->back();
        }else{
            if($user->area!=Auth::User()->area){
                Alert::error('Error','No puedes eliminar usuarios que no te corresponden');
                return redirect()->back();
            }
            if($user->id==1){
                Alert::error('Error','El administrador no puede ser modificado');
                return redirect()->back();
            }
            $actividades = DB::table('actividad as a')->where('a.id_user','=',$id)->get()->count()>0? true: false;
            $responsable = DB::table('actividad_evidencia as ae')->where('ae.user_id','=',$id)->orwhere('ae.user_id','=',$id)->get()->count()>0?true:false;
            $roles = DB::table('model_has_roles')->where('model_id','=',$id)->get()->count()>0?true:false;

            if($roles || $actividades || $responsable){
                Alert::error('Error','El usuarios '.$user->name.' no puede ser eliminado debido debido a claves foraneas');
                return redirect()->route('usuarios.index');
            }
            $user->delete();
            Alert::success('Correcto','El usuario se elimino correctamente');
            return redirect()->back();
        }

    }

    public function asignarRoles($id){
        $user = User::find($id);
        $area = Area::find($user->area);
        if(Auth::User()->can('VIP')){
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
            ->with('user',$user)
            ->with('area',$area);
        }else{
            $permisos = Auth::User()->getPermissionsViaRoles();
            $arreglo_roles = array();
            foreach (Role::all() as $role) {
                $temp_permisos_role = $role->permissions;
                $valido = true;
                for ($x=0; $x < count($temp_permisos_role); $x++) {
                    $tiene_permiso = false;
                    for ($y=0; $y < count($permisos); $y++) {
                        if($temp_permisos_role[$x]->name == $permisos[$y]->name){
                            $tiene_permiso = true;
                            break;
                        }
                    }
                    if(!$tiene_permiso){
                        $valido = false;
                        break;
                    }
                }
                if($valido){
                    array_push($arreglo_roles,$role->name);
                }
            }
            $roles_data = DB::table('roles')->leftjoin('model_has_roles as model',function($join) use($id){
                $join->on('model.role_id','=','roles.id');
                $join->where('model.model_type','=','App\user');
                $join->where('model.model_id','=',$id);
            })->leftjoin('users',function($join) use($id){
                $join->on('users.id','=','model.model_id');
                $join->where('users.id','=',$id);
            })->whereIn("roles.name",$arreglo_roles)->select('users.name as user_name','roles.name','roles.id as id')->get();
            return view('admin.usuarios.asignar_roles')
            ->with('roles',$roles_data)
            ->with('user',$user)
            ->with('area',$area);
        }

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

        return redirect()->route('usuarios.index')
        ->with("success","Roles asignados correctamente");
    }
}
