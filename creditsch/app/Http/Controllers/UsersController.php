<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\User;
use Laracasts\Flash\Flash;

class UsersController extends Controller
{
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
    		['carrera' => 'Gestión Empresarial','valor' => 'Gestión Empresarial'],
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
}
