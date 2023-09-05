<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Imports\AlumnosAgregar;
use Maatwebsite\Excel\Facades\Excel;
use Alert;

class altaAlumnosController extends Controller
{
    public function index()
    {     
    	return view('admin.ImportExcel.altAlumnos');
  	}

  	public function altaAlumnos(Request $request)
  	{   
		try{
			ini_set('max_execution_time',0);  //Quita el limite de tiempo a la ejecucion de archivos
			$array = Excel::toArray(new AlumnosAgregar,$request->excel->path());    //Selecciona la ruta del archivo excel que contiene los datos de los alumnos        
			if (!empty($array[0])) {
				array_shift($array[0]); // Descartar el primer elemento
			}	
			$aluRep=0;
			$aluInsert=0;		
			foreach ($array[0] as $row)       
			{    
				//Validacion para verificar que la categoria no exista, antes de registrarla
				$alumno_ya_existe = Alumno::where('no_control','=',$row[0])->get()->count() > 0? true: false;
				if($alumno_ya_existe==false){            
					Alumno::updateOrCreate(
						['no_control' => $row[0]], // Columna para buscar el registro existente
						[
							'nombre' => $row[1],
							'password' => bcrypt($row[2]),
							'email' => $row[3],
							'carrera' => $row[5],
							'status' => 'pendiente'
						] // Columnas y valores a actualizar o crear
					);
					$aluInsert++;
				} 
				else
				{
					//Aumentamos un contador que nos indica cuantos ya estaban registrados de esta lista
					$aluRep++;
					//Solo pasamos al siguiente registro si el alumno ya existe
					continue;					
				}  	                      
			}   
			Alert::success('Correcto','Se importaron '.$aluInsert.' alumnos de forma exitosa y se encontraron '.$aluRep.' alumnos repetidos');
			return redirect()->route('ImportExcel.altaAlumnos');  
		} catch (\Exception $e)
        {    
            Alert::error('Error','Ocurrio un error al cargar los alumnos error: '.$e->getMessage().'');
            return back()->withInput();
        }   
	   
    }
}
