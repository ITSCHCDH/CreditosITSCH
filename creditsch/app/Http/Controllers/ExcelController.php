<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
       
	    Excel::import(new AlumnosImport,asset('alumnos.xls'));
	    Flash::success('Los alumnos se importaron de forma exitosa');
        return redirect()->route('ImportExcel.index');
	 
	}

       
       
        
}



