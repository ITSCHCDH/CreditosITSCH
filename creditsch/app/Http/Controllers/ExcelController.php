<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alumno;
use App\Imports\AlumnosImport;
use Maatwebsite\Excel\Facades\Excel;
use Laracasts\Flash\Flash;
use Symfony\Component\HttpFoundation\StreamedResponse;
use DB;

class ExcelController extends Controller
{
   

  public function index(Request $request){  

   	return view('admin.ImportExcel.index');
  }


  //Codigo para el funcionamiento del progress bar***********
     public function fileUploadPost(Request $request)
      {
        $value = $request->session()->get('progreso');
        return response()->json(array('progreso'=> $value));
        
      }


      //********************************************

  public function camMsg(Request $request)
  {
      $msg = "Mensaje de respuesta del controlador.";
      $value = $request->session()->get('prueba');
      return response()->json($value);
  }

	public function importClaves(Request $request)
	{
       
		//$request->excel->move(storage_path().'/app/public/',$request->excel->getClientOriginalName());
       //dd(storage_path().'/app/public/'.$request->excel->getClientOriginalName());
	    //$array=Excel::import(new AlumnosImport,$request->excel->path());
      // $request->validate(['excel' => 'required',]);

       //ini_set('max_execution_time', 500);
       $array = Excel::toArray(new AlumnosImport,$request->excel);    

       \DB::connection()->disableQueryLog();
       if ($array) 
       {
          $total = count($array[0]);
          $x=0;
          $request->session()->put('progreso', $x);
        	//foreach ($array[0] as $row)
          for($i = 0; $i < $total; $i++)
          {        		

      				$row = $array[0][$i];
              Alumno::where('no_control','=', $row[2])->update(['password' => bcrypt($row[3])]);
              //DB::statement("UPDATE alumnos SET password='".bcrypt('1234')."' where no_control='$row[2]'");
        	    $x = $i / $total * 100;
              $request->session()->put('progreso', $x);
          }
          
            $request->session()->put('progreso', '100'); 
        		Flash::success('Los alumnos se importaron de forma exitosa');
            return redirect()->route('ImportExcel.index');
        }       	
	}
        
}








