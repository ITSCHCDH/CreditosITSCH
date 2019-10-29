<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alumno;
use App\Imports\AlumnosImport;
use App\Imports\AlumnosAgregar;
use Maatwebsite\Excel\Facades\Excel;
use Laracasts\Flash\Flash;
use Symfony\Component\HttpFoundation\StreamedResponse;

class altaAlumnosController extends Controller
{
    public function index(Request $request)
    {     
    	return view('admin.ImportExcel.altAlumnos');
  	}

  	public function altaAlumnos(Request $request)
  	{     
	    ini_set('max_execution_time',0);  //Quita el limite de tiempo a la ejecucion de archivos
	    $array = Excel::toArray(new AlumnosAgregar,$request->excel->path());    //Selecciona la ruta del archivo excel que contiene los datos de los alumnos        
	    foreach ($array[0] as $row)       
	    {                     
	       
	      Alumno::insert(['no_control' => $row[1], 'nombre' =>$row[2], 'password' => bcrypt($row[3]),'carrera'=>$row[5],'status'=>'pendiente' ]);              
	    }   
	    Flash::success('Los alumnos se importaron de forma exitosa');
      	return redirect()->route('ImportExcel.altaAlumnos');  
    }
}
