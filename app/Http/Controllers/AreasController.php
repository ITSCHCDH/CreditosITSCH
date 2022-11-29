<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\User;
use App\Models\ALumno;
use Alert;

class AreasController extends Controller
{

	public function __construct(){
		$this->middleware('permission:VIP|VER_AREAS|SOLO_LECTURA')->only(['inicio','usuarios']);
		$this->middleware('permission:VIP|ELIMINAR_AREAS|SOLO_LECTURA')->only(['eliminar']);
		$this->middleware('permission:VIP|CREAR_AREAS|SOLO_LECTURA')->only(['guardar','crear']);
		$this->middleware('permission:VIP|MODIFICAR_AREAS|SOLO_LECTURA')->only(['editar','actualizar']);
	}
    public function inicio(){
    	$areas = Area::all();
    	return view('admin.areas.index')->with('areas',$areas);
    }

    public function crear(){
    	return view('admin.areas.crear');
    }

    public function guardar(Request $request){

    	$nombre_ya_existe = Area::where('nombre','=',$request->nombre)->get()->count() > 0? true: false;
    	if($nombre_ya_existe){
    		Alert::error('Error','Una area ya existe con este nombre');
    		return redirect()->back();
    	}
    	$area = new Area($request->all());
    	$area->save();
    	Alert::success('Correcto','La area '.$area->nombre.' se ha guardado correctamente');
    	return redirect()->route('areas.inicio');
    }

    public function editar($id){
    	$area = Area::find($id);
    	if($area==null){
    		Alert::error('Error','El area no existe');
    		return redirect()->back();
    	}
    	return view('admin.areas.editar')
    	->with('area',$area);
    }

    public function actualizar(Request $request, $id){
    	$nombre_ya_existe = Area::where([
    		['nombre','=',$request->nombre],
    		['id','<>',$id]
    	])->get()->count()>0?true: false;
    	if($nombre_ya_existe){
    		Alert::error('Error','El nombre del area ya ha sido tomado');
    		return redirect()->back();
    	}
    	$area = Area::find($id);
    	$area->fill($request->all());
    	$area->save();
    	Alert::success('Correcto','El area '.$area->nombre.' ha sido guardada correctamente');
    	return redirect()->route('areas.inicio');
    }

    public function eliminar($id){
    	$area = Area::find($id);
    	if($area==null){
    		Alert::error('Error','El area no existe');
    		return redirect()->back();
    	}
    	$tiene_usuarios = User::where('area','=',$id)->get()->count() > 0? true: false;
    	$tiene_alumnos = Alumno::where('carrera','=',$id)->get()->count() > 0?true: false;
    	if($tiene_alumnos || $tiene_usuarios){
    		Alert::error('Error','No se puede eliminar debido a claves foraneas');
    		return redirect()->route('areas.inicio');
    	}
    	$area->delete();
    	Alert::success('Alert','Area eliminada correctamente');
    	return redirect()->route('areas.inicio');
    }

    public function usuarios($id){
    	if(Area::find($id)==null){
    		Alert::error('Error','El area no existe');
    		return redirect()->back();
    	}
    	$usuarios = User::where('area','=',$id)->get();
    	return view('admin.areas.usuarios')
    	->with('usuarios',$usuarios)
    	->with('area',Area::find($id));
    }
}
