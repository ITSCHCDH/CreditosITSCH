<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ALumno;
use Alert;

class STAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexProfesores()
    {
        $carreras = DB::connection('contEsc')->table('carreras')->get(); 
        return view('sta.profesores.index',compact('carreras'));
    }

   public function findProfesores(Request $request)
   {
        $carreras = DB::connection('contEsc')->table('carreras')->get(); 
        $profesores = DB::connection('contEsc')->table('catedraticos')
        ->where('dep_clave',$request->carrera)
        ->where('cat_Status','VI')
        ->get(); 
        return view('sta.profesores.index')
        ->with('profesores',$profesores)
        ->with('carreras',$carreras);
   }
}
