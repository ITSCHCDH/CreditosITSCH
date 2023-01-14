<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\ALumno;



use Illuminate\Http\Request;

class AlumnosStaController extends Controller
{
   public function ficha()
   {    
        $alumno_data = Alumno::where('no_control',Auth::User()->no_control)->select('id as alumno_id')->get();
        return view('alumnos.sta.ficha')
        ->with('alumno_data',$alumno_data);
   }
}
