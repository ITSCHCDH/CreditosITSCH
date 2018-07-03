<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesPermisosController extends Controller
{
    public function index(){
    	return view('admin.roles.index');
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
    	$permiso = Permission::create(['name' => $request->get('name')]);
    	return redirect()->route('roles.permisos_crear');
    }
    public function rolesIndex(){
    	$roles = Role::all();
    	return view('admin.roles.roles_index')
    	->with('roles',$roles);
    }
    public function rolesAsignarPermisosVista($id){
    	$permisos = Permission::all();
    	$role = Role::findById($id);
    	return view('admin.roles.roles_asignar_permisos_vista')
    	->with('permisos',$permisos)
    	->with('role',$role);
    }
    public function rolesAsignarPermiso(Request $request){
    	$role = Role::findById($request->role_id);
    	for($x=0; $x<count($request->permisos_id); $x++){
    		$permiso = Permission::findById($request->permisos_id[$x]);
   			if(!$role->hasPermissionTo($permiso))$role->givepermissionTo($permiso);
    	}
    	return $request;
    }
}
