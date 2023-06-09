<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Motivoreprobacion;
use App\Models\AsignacionTutores;
use App\Models\Grupo;
use App\User;
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
        //Obtener las materias del profesor seleccionada
        $materias=DB::connection('contEsc')->table('reticula')
        ->join('grupossemestre','reticula.ret_Clave','=','grupossemestre.ret_Clave')
        ->where('grupossemestre.cat_Clave',$request->profesor)
        ->select('reticula.ret_NomCompleto','reticula.ret_NumUnidades','grupossemestre.ret_Clave','grupossemestre.gse_Anio','grupossemestre.gse_Observaciones','grupossemestre.gse_Clave')
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
        ->join('planesestudios','alumnos.pes_Clave','=','planesestudios.pes_Clave')
        ->join('reticula','planesestudios.pes_Clave','=','reticula.pes_Clave')
        ->where('reticula.ret_Clave',$request->materia)
        ->where('listassemestrecom.lsc_NumUnidad',$request->unidad)
        ->where('listassemestre.gse_Clave',$request->grupo) 
        ->select('listassemestre.gse_Clave','listassemestre.lse_Clave','alumnos.alu_NumControl','alumnos.alu_Nombre','alumnos.alu_ApePaterno','alumnos.alu_ApeMaterno','listassemestrecom.lsc_Calificacion')  
        ->orderBy('alumnos.alu_Nombre','asc')
        ->get();        

        $coment=Motivoreprobacion::select('no_control','motivos','comentario')
        ->where('grup_cla',$request->materia)
        ->where('num_tema',$request->unidad)
        ->get();

        return response()->json( ['listaCali'=>$listaCali,'coment'=>$coment]);
    }

    public function saveComent(Request $request)
    {
        Motivoreprobacion::updateOrCreate(
            ['no_control' => $request->alumno, 'grup_cla' => $request->gse_clave, 'num_tema'=>$request->unidad],
            ['materia' =>  $request->materia, 'lse_clave' => $request->lse_clave,'motivos'=>$request->motivos,'comentario'=>$request->comentario]
        );
       
        return response()->json("correcto");       

    }

    //Funciones para el modulo del departamento de tutorias
    public function indexTutorias()
    {
        //Obtener los profesores
        $profesores = User::select('id',DB::raw('UPPER(name) as nombre'))
        ->where('active','true')
        ->where('tutor','1')
        ->orderBy('name','asc')
        ->get();   
        
        //Obtener las carreras
        $carreras = DB::connection('contEsc')->table('carreras')
        ->where('car_Status','VIGENTE')
        ->orderBy('car_Nombre','asc')
        ->get();

        //Unimos la tabla grupos con la de AsignacionTutores
        $gruTutorias = Grupo::select('gpo_Nombre','at.*')
        ->join('asignaciones_tutores as at','grupos.id','=','at.gpo_Id')
        ->orderBy('gpo_Nombre','asc')
        ->get(); 
        
        //Obtenemos el nombre de la carrera y lo agregamos al objeto $gruTutorias
        foreach($gruTutorias as $gru)
        {
            $carrera = DB::connection('contEsc')->table('carreras')
            ->where('car_Clave',$gru->car_Clave)
            ->first();
            $gru->car_Nombre=$carrera->car_Nombre;
        }

        //Obtenemos el nombre del profesor y lo agregamos al objeto $gruTutorias
        foreach($gruTutorias as $gru)
        {
            $profesor = User::where('id',$gru->tut_Clave)
            ->first();
            $gru->name=strtoupper($profesor->name); 
        }

        return view('sta.tutorias.index',compact('profesores','carreras','gruTutorias')); 
    }

    //Función para vista de tutores
    public function indexTutores()
    {   
        if( Auth::User()->can('VIP_STA'))        
            $grupos=AsignacionTutores::all();        
        else       
            $grupos=AsignacionTutores::where('tut_Clave',Auth::user()->id)->get();        
        //Agregamos el nombre del tutor al grupo
        foreach($grupos as $gru)
        {
            $tutor = User::where('id',$gru->tut_Clave)
            ->first();
            $gru->name=strtoupper($tutor->name); 
        }
        //Agregamos el nombre del grupo al grupo de tutorias
        foreach($grupos as $gru)
        {
            $grupo = Grupo::where('id',$gru->gpo_Id)
            ->first();
            $gru->gpo_Nombre=strtoupper($grupo->gpo_Nombre); 
        }
        //Agregamos el nombre de la carrera al grupo de tutorias
        foreach($grupos as $gru)
        {
            $carrera = DB::connection('contEsc')->table('carreras')
            ->where('car_Clave',$gru->car_Clave)
            ->first();
            $gru->car_Nombre=strtoupper($carrera->car_Nombre);
        }
        return view('sta.tutores.index',compact('grupos'));
    }

    //Funcion para mostrar los grupos de tutorias
    public function showGrupo($id)
    {
        //Llamamos a la función para completar el grupo
        $grupo = $this->completarGrupo($id); 
        //Obtenemos el año actual
        $anio = date('Y');
        //Seleccionamos todos los alumnos de los ultimos 7 años
        $alumnos = DB::connection('contEsc')->table('alumnos')
        ->where('alu_AnioIngreso','>=',$anio-7)
        ->select('alu_NumControl','alu_Nombre','alu_ApePaterno','alu_ApeMaterno')
        ->get();
       
             
        return view('sta.tutores.showGrupo',compact('grupo','alumnos'));
    }

    //Función para completar un grupo con la información de nombre de tutor, carrera y grupo
    public function completarGrupo($id)
    {              
        $grupo=AsignacionTutores::where('id',$id)->get();  
         //Agregamos el nombre del tutor al grupo
         foreach($grupo as $gru)
         {
             $tutor = User::where('id',$gru->tut_Clave)
             ->first();
             $gru->nomTutor=strtoupper($tutor->name); 
         } 
         //Agregamos el nombre del grupo al grupo de tutorias
         foreach($grupo as $gru)
         {
             $grupoTem = Grupo::where('id',$gru->gpo_Id)
             ->first();
             $gru->gpo_Nombre=strtoupper($grupoTem->gpo_Nombre); 
         }  
         //Agregamos el nombre de la carrera al grupo de tutorias
         foreach($grupo as $gru)
         {
             $carrera = DB::connection('contEsc')->table('carreras')
             ->where('car_Clave',$gru->car_Clave)
             ->first();
             $gru->car_Nombre=strtoupper($carrera->car_Nombre);
         }      
         
        return $grupo;
    }

    //Función para guardar los alumnos de un grupo
    public function storeGrupo()
    {
        //retornamos un json con la respuesta de que se guardo el grupo correctamente
        return response()->json("ok");
    }
   
}
