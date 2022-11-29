<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class RolesPermisosController extends Controller
{
    public function __construct(){
        $this->middleware('permission:VIP|VER_ROLES|VIP_SOLO_LECTURA')->only('index');
        $this->middleware('permission:VIP|CREAR_ROLES')->only(['crearRole','guardarRole']);
        $this->middleware('permission:VIP|VIP_SOLO_LECTURA|VER_ROLES_USUARIOS')->only('usuarios');
        $this->middleware('permission:VIP|ELIMINAR_ROLES_USUARIOS|ASIGNAR_REMOVER_ROLES_USUARIOS')->only('usuariosRevocarRol');
        $this->middleware('permission:VIP|MODIFICAR_ROLES')->only(['editarRole','actualizarRole']);
        $this->middleware('permission:VIP|ELIMINAR_ROLES')->only(['eliminarRole']);
        $this->middleware('permission:VIP|ASIGNAR_REMOVER_PERMISOS_A_ROLES')->only(['rolesAsignarPermiso','rolesAsignarPermisosVista']);
    }
    public function index(){
        $roles = Role::all();
    	return view('admin.roles.index')
        ->with('roles',$roles);
    }
    public function crearRole(){
    	return view('admin.roles.roles_crear');
    }
    public function guardarRole(Request $request){
    	$role = Role::create(['name' => $request->get('name')]);
    	return redirect()->route('roles.index');
    }
    public function rolesAsignarPermisosVista($id){
    	$permisos = Permission::leftjoin('role_has_permissions as r',function($join) use($id){
            $join->on('r.permission_id','=','id');
            $join->where('r.role_id','=',$id);
        })->select('name','id','role_id')->get();
    	$role = Role::find($id);
    	return view('admin.roles.roles_asignar_permisos_vista')
    	->with('permisos',$permisos)
    	->with('role',$role);
    }
    public function rolesAsignarPermiso(Request $request){
    	$role = Role::findById($request->role_id);
        if($request->has('permisos_id')){
            $role->syncPermissions($request->permisos_id);
            return response()->json("Permisos Agregados correctamente");
        }
        $role->syncPermissions([]);
    	return response()->json("Permisos Agregados correctamente");
    }
    public function roleVerPermisos(Request $request,$id){
        $user_id = null;
        if($request->has('user_id')) $user_id=$request->user_id;
        $role = Role::findById($id);
        $permisos = $role->permissions;
        return view('admin.roles.role_ver_permisos')
        ->with('permisos',$permisos)
        ->with('role',$role)
        ->with('user_id',$user_id);
    }
    public function editarRole($id){
        $role = Role::findById($id);
        return view('admin.roles.role_editar')
        ->with('role',$role);
    }

    public function actualizarRole(Request $request, $id){
        $role = Role::findById($id);
        $role->name = $request->name;
        $role->save();
        return redirect()->route('roles.index');
    }

    public function eliminarRole($id){
        $role = Role::find($id);
        if($role==null){
            Flash::error('El rol no existe');
            return redirect()->route('roles.index');
        }
        Role::destroy($id);
        Flash::success('Role eliminado correctamente');
        return redirect()->back();
    }

    public function usuarios($id){
        $role = Role::find($id);
        if($role==null){
            Flash::error('El rol no existe');
            return redirect()->route('roles.index');
        }
        $users = $role->users;
        return view('admin.roles.roles_usuarios')
        ->with('users',$users)
        ->with('role',$role);
    }

    public function usuariosRevocarRol(Request $request, $id){
        $role = Role::find($id);
        if($role==null){
            Flash::error('El rol no existe');
            return redirect()->back();
        }
        if(!$request->has('user_id')){
            return redirect()->back();
        }
        if($request->get('user_id') == Auth::User()->id){
            Flash::error('No puedes autoeliminarte');
            return redirect()->back();
        }
        $user = User::find($request->get('user_id'));
        if($user==null){
            Flash::error('El usuario no existe');
            return redirect()->back();
        }
        $user->removeRole($role->name);
        Flash::success('Roles removidos exitosamente');
        return redirect()->route('roles.usuarios',$role->id);
    }
}
