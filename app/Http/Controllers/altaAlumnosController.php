<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Imports\AlumnosAgregar;
use Maatwebsite\Excel\Facades\Excel;

class altaAlumnosController extends Controller
{
    public function index()
    {     
    	return view('admin.ImportExcel.altAlumnos');
  	}

  	public function altaAlumnos(Request $request)
  	{   
	    ini_set('max_execution_time',0);  //Quita el limite de tiempo a la ejecucion de archivos
	    $array = Excel::toArray(new AlumnosAgregar,$request->excel->path());    //Selecciona la ruta del archivo excel que contiene los datos de los alumnos        
		foreach ($array[0] as $row)       
	    {     
			//Validacion para verificar que la categoria no exista, antes de registrarla
			$alumno_ya_existe = Alumno::where('no_control','=',$row[1])->get()->count() > 0? true: false;
			if($alumno_ya_existe==false){            
				Alumno::insert(['no_control' => $row[1], 'nombre' =>$row[2], 'password' => bcrypt($row[3]),'carrera'=>$row[5],'status'=>'pendiente' ]);
			}   	                      
	    }   
	    Flash::success('Los alumnos se importaron de forma exitosa');
      	return redirect()->route('ImportExcel.altaAlumnos');  
    }
}
