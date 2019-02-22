<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alumno;
use App\Imports\AlumnosImport;
use Maatwebsite\Excel\Facades\Excel;
use Laracasts\Flash\Flash;

class ExcelController extends Controller
{
   /* public function importClaves(){
    	$var = Excel::import(new AlumnosImport, request()->file('excel'));
    	dd($var);
    	Flash::success('El archivo se importo de forma exitosa');
    	return back();
    }*/

    public function index(){
    	return view('admin.ImportExcel.index');
    }


	public function importClaves(Request $request)
	{
       
		//$request->excel->move(storage_path().'/app/public/',$request->excel->getClientOriginalName());
       //dd(storage_path().'/app/public/'.$request->excel->getClientOriginalName());
	    //$array=Excel::import(new AlumnosImport,$request->excel->path());
	  
       $array = Excel::toArray(new AlumnosImport,$request->excel->path());

       if ($array) 
       {
       		/*return collect(head($array))->each(function ($row, $key) 
       		{
            	dd($row[2]);
        	});*/
            $alumnos = Alumno::all();

            //dd($alumnos[2]['no_control']);
            //dd(count($array));
        	foreach ($array[0] as $row) {        		
        		//dd($row[3]);
      					
        				Alumno::where('no_control', $row[2])
                		->update(['password' => bcrypt($row[3])]);
        	
        		}
        			Flash::success('Los alumnos se importaron de forma exitosa');
                return redirect()->route('ImportExcel.index');
    
        		
        	}

       		
        	

	   
	 
	}

       
       
        
}



/*return collect(head($array))
        		->each(function ($row, $key) {
            	DB::table('alumnos')
                ->where('alumnos', $row['no_control'])
                ->update(array_except($row, ['password']));
        	});*/
