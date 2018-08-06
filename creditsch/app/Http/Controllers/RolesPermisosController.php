<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesPermisosController extends Controller
{
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
    public function crearPermiso(){
    	return view('admin.roles.permisos_crear');
    }
    public function guardarPermiso(Request $request){
        $permisos = strtoupper($request->get('name'));
        $tokenizer = strtok($permisos, " \n\t");
        while($tokenizer){
            Permission::findOrCreate($tokenizer);
            $tokenizer = strtok(" \n\t");
        } 
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
        Role::destroy($id);
        return redirect()->back();
    }

    public function usuarios($id){
        $role = Role::findById($id);
        $users = $role->users;
        return view('admin.roles.roles_usuarios')
        ->with('users',$users);
    }

    public function usuariosRevocar(Request $request){
        $user = User::find(1);
    }
}
