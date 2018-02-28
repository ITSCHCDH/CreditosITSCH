<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class ResponsablesController extends Controller
{
	/* Controllador para mostrar los responsables y seleccionarlos +*/
    public function show(){
    	$responsables = User::orderBy('id','ASC')->paginate(5);
    	return view ('admin.actividades.addusers')->with('responsables',$responsables);
    }
}
