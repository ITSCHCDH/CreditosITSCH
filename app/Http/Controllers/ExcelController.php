<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Imports\AlumnosImport;
use Maatwebsite\Excel\Facades\Excel;
use Alert;



class ExcelController extends Controller
{
   
  public function index(Request $request)
  {     
    return view('admin.ImportExcel.index');
  }


  public function importClaves(Request $request)
  {      
      try{
        ini_set('max_execution_time',0);  //Quita el limite de tiempo a la ejecucion de archivos
        $array = Excel::toArray(new AlumnosImport,$request->excel->path());    //Importa el archivo de excel a la base de datos
        if ($array) 
        {          
            $alumnos = Alumno::all();  //Hace la consulta de los alumnos existentes en la base de datos           
            foreach ($array[0] as $row)       
            {                     
                Alumno::where('no_control', $row[2])->update(['password' => bcrypt($row[3])]);  //Modifica a los alumnos que coinsiden en el archivo de excel con la bd y les cambia el password                   
            }            
            
              Alert::success('Correcto','Los alumnos se importaron de forma exitosa');
              return redirect()->route('ImportExcel.index');           
        }
      } catch (\Exception $e)
      {    
          Alert::error('Error','Ocurrio un error durante la actualización');
          return back()->withInput();
      }  
  }    
      
  
}








