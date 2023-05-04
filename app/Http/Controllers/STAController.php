<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Motivoreprobacion;
use Alert;

class STAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexProfesores()
    {
        $carreras = DB::connection('contEsc')->table('carreras')
        ->where('car_Status','VIGENTE')
        ->get();       
        return view('sta.profesores.index',compact('carreras'));
    }

    public function findProfesores(Request $request)
    {
        $carrera=$request->carrera;
        //Llamado a función para obtener el departamento de adscripción
        $dpto=$this->obtDpto($carrera);
        //Obtener los profesores de la carrera seleccionada
        $profesores = DB::connection('contEsc')->table('carreras as c')
        ->select('d.dep_Clave','ca.cat_Clave','ca.cat_Nombre','ca.cat_ApePat','ca.cat_ApeMat')
        ->join('planesestudios as p','c.car_Clave','=','p.car_Clave')
        ->join('reticula as r','p.pes_Clave','=','r.pes_Clave')
        ->join('departamentos as d','r.dep_Clave','=','d.dep_Clave') 
        ->join('catedraticos as ca','ca.dep_Clave','=','d.dep_Clave')  
        ->where('d.dep_Clave',$dpto->dep_Clave)
        ->where('c.car_Status','VIGENTE')
        ->where('ca.cat_Status','VI')
        ->groupBy('ca.cat_Clave')
        ->get();

        return response()->json($profesores);
    }

    public function findMaterias(Request $request)
    {          
        //Obtener los profesores de la carrera seleccionada
        $materias=DB::connection('contEsc')->table('reticula')
        ->join('grupossemestre','reticula.ret_Clave','=','grupossemestre.ret_Clave')
        ->where('grupossemestre.cat_Clave',$request->profesor)
        ->select('reticula.ret_NomCompleto','reticula.ret_NumUnidades','grupossemestre.gse_Clave','grupossemestre.gse_Anio','grupossemestre.gse_Observaciones')
        ->get();
      
        return response()->json($materias);
    }


    //Funcion para obtener la clave del departamento al que pertenece el profesor
    function obtDpto($carrera)
    {
        $dpto = DB::connection('contEsc')->table('carreras as c')
        ->select('d.dep_Clave')
        ->join('planesestudios as p','c.car_Clave','=','p.car_Clave')
        ->join('reticula as r','p.pes_Clave','=','r.pes_Clave')
        ->join('departamentos as d','r.dep_Clave','=','d.dep_Clave') 
        ->join('catedraticos as ca','ca.dep_Clave','=','d.dep_Clave')  
        ->where('c.car_Clave',$carrera)
        ->first();
        return $dpto;
    }

    public function findUnits(Request $request)
    {    
        $units=DB::connection('contEsc')->table('reticula')        
        ->where('ret_Clave', $request->materia)
        ->first();
        
        return response()->json($units);
            
    }

    public function findListaCali(Request $request)
    {
        $listaCali=DB::connection('contEsc')->table('listassemestre')
        ->join('alumnos','listassemestre.alu_NumControl','=','alumnos.alu_NumControl') 
        ->join('listassemestrecom','listassemestre.lse_Clave','=','listassemestrecom.lse_clave')
        ->where('listassemestre.gse_Clave',$request->materia)
        ->where('listassemestrecom.lsc_NumUnidad',$request->unidad) 
        ->select('listassemestre.gse_Clave','listassemestre.lse_Clave','alumnos.alu_NumControl','alumnos.alu_Nombre','alumnos.alu_ApePaterno','alumnos.alu_ApeMaterno','listassemestrecom.lsc_Calificacion')  
        ->get();   
        return response()->json($listaCali);
    }

    public function saveComent(Request $request)
    {
        $motivos = new Motivoreprobacion; 
        $motivos->no_control = $request->alumno; 
        $motivos->materia = $request->materia; 
        $motivos->grup_cla = $request->gse_clave; 
        $motivos->lse_clave = $request->lse_clave; 
        $motivos->num_tema = $request->unidad; 
        $motivos->motivos = $request->motivos; 
        $motivos->comentarios = $request->comentarios; 
        $motivos->save();
        return response()->json("correcto");
    }
}
