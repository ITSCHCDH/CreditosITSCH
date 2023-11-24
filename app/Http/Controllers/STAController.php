<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Motivoreprobacion;
use App\Models\AsignacionTutores;
use App\Models\Grupo;
use App\Models\GpoTutorias;
use App\User;


class STAController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:VIP_STA|STA_DEP_TUTORIA|STA_PROFESOR')->only(['indexProfesores','findProfesores','findMaterias','findListaCali','saveComent']);
        $this->middleware('permission:VIP_STA|STA_DEP_TUTORIA')->only(['indexTutorias']);       
        $this->middleware('permission:VIP_STA|STA_DEP_TUTORIA|STA_TUTOR')->only(['indexTutores','showGrupo','storeGrupo','deleteAlumno']);
    }  

    public function indexProfesores()
    {
        //Verificamos si el usuario tiene permiso para ver la vista de profesores
        if(Auth::User()->hasAnyPermission(['VIP_STA','STA_DEP_TUTORIA'])){  
            $carreras = DB::connection('contEsc')->table('carreras')
            ->where('car_Status','VIGENTE')
            ->get();             
        }else if(Auth::User()->hasAnyPermission(['STA_PROFESOR'])){
            $carreras = DB::connection('contEsc')->table('carreras')           
            ->where('car_Clave',Auth::User()->area)
            ->get(); 
        }       
        return view('sta.profesores.index',compact('carreras')); 
    }

    public function findProfesores(Request $request)
    {
        $carrera=$request->carrera;
        //Llamado a función para obtener el departamento de adscripción
        $dpto=$this->obtDpto($carrera);
        //Verificamos que el usuario tenga permiso para ver todos los profesores
        if(Auth::User()->hasAnyPermission(['VIP_STA','STA_DEP_TUTORIA'])){ 
            $profesores = DB::connection('contEsc')->table('carreras as c')
            ->select('d.dep_Clave','ca.cat_Clave','ca.cat_Nombre','ca.cat_ApePat','ca.cat_ApeMat')
            ->join('planesestudios as p','c.car_Clave','=','p.car_Clave')
            ->join('reticula as r','p.pes_Clave','=','r.pes_Clave')
            ->join('departamentos as d','r.dep_Clave','=','d.dep_Clave') 
            ->join('catedraticos as ca','ca.dep_Clave','=','d.dep_Clave')  
            ->where('d.dep_Clave',$dpto->dep_Clave)
            ->where('c.car_Status','VIGENTE')
            ->where('ca.cat_Status','VI')
            ->groupBy('ca.cat_Clave','d.dep_Clave','ca.cat_Nombre','ca.cat_ApePat','ca.cat_ApeMat')
            ->orderBy('ca.cat_Nombre','desc')
            ->get();
        }else if(Auth::User()->hasAnyPermission(['STA_PROFESOR'])){ 
            $cat_Clave=$this->obtCatClave();     
            $profesores = DB::connection('contEsc')->table('carreras as c')
            ->select('d.dep_Clave','ca.cat_Clave','ca.cat_Nombre','ca.cat_ApePat','ca.cat_ApeMat')
            ->join('planesestudios as p','c.car_Clave','=','p.car_Clave')
            ->join('reticula as r','p.pes_Clave','=','r.pes_Clave')
            ->join('departamentos as d','r.dep_Clave','=','d.dep_Clave') 
            ->join('catedraticos as ca','ca.dep_Clave','=','d.dep_Clave')            
            ->where('ca.cat_Clave', $cat_Clave)
            ->groupBy('ca.cat_Clave','d.dep_Clave','ca.cat_Nombre','ca.cat_ApePat','ca.cat_ApeMat')
            ->get();
        }   
        return response()->json($profesores);       
    }

    public function obtCatClave()
    {
        $catClave=0;
        //Obtenemos el usuario que esta conectado           
        $userName=Auth::User()->name;
        //Convertimos el nombre del usuario a minusculas sin acentos
        $userName=strtolower($userName);
        $userName=$this->quitarCaracteres($userName);
        //Obtenemos la lista de catedraticos para comparar con el nombre del usuario
        $catedraticos = DB::connection('contEsc')->table('catedraticos as ca')
        ->select('cat_Clave','ca.cat_Nombre','ca.cat_ApePat','ca.cat_ApeMat')
        ->get();
        //Concatenamos los nombres y apellidos de los catedraticos
        foreach($catedraticos as $catedratico){
            $catNombre=$catedratico->cat_Nombre;
            $catApePat=$catedratico->cat_ApePat;
            $catApeMat=$catedratico->cat_ApeMat;
            $catNombre=strtolower($catNombre);
            $catApePat=strtolower($catApePat);
            $catApeMat=strtolower($catApeMat);
            $catNombre=$catNombre." ".$catApePat." ".$catApeMat;
            //Llamamos a la funcion quitar caracteres especiales
            $catNombre=$this->quitarCaracteres($catNombre);            
            //Verificamos la similitud entre el nombre del usuario y el nombre del catedrático          
            similar_text($userName, $catNombre, $similarity);
            $threshold = 85; // Establece el umbral de similitud mínimo requerido
            if ($similarity >= $threshold) {
                $catClave = $catedratico->cat_Clave;
                //Salimos del ciclo foreach
                break;
            }
        }
        return $catClave;        
    }

    //Función para quitar caracteres especiales a una cadena
    function quitarCaracteres($cadena){
        $cadena=strtolower($cadena);
        $cadena=str_replace("á","a",$cadena);
        $cadena=str_replace("é","e",$cadena);
        $cadena=str_replace("í","i",$cadena);
        $cadena=str_replace("ó","o",$cadena);
        $cadena=str_replace("ú","u",$cadena);
        $cadena=str_replace("ñ","n",$cadena);
        $cadena=str_replace("ü","u",$cadena);
        $cadena=str_replace(" ","",$cadena);
        $cadena=str_replace(".","",$cadena);
        $cadena=str_replace(",","",$cadena);
        $cadena=str_replace("-","",$cadena);
        $cadena=str_replace("_","",$cadena);
        $cadena=str_replace("´","",$cadena);
        $cadena=str_replace("`","",$cadena);
        $cadena=str_replace("¨","",$cadena);
        $cadena=str_replace("¿","",$cadena);
        $cadena=str_replace("?","",$cadena);
        $cadena=str_replace("¡","",$cadena);
        $cadena=str_replace("!","",$cadena);
        return $cadena;
    }

    public function findMaterias(Request $request)
    {          
        //Obtener las materias del profesor seleccionada
        $materias=DB::connection('contEsc')->table('reticula')
        ->join('grupossemestre','reticula.ret_Clave','=','grupossemestre.ret_Clave')
        ->where('grupossemestre.cat_Clave',$request->profesor)
        ->select('reticula.ret_NomCompleto','reticula.ret_NumUnidades','grupossemestre.ret_Clave','grupossemestre.gse_Anio','grupossemestre.gse_Observaciones','grupossemestre.gse_Clave')
        ->orderBy('reticula.ret_NomCompleto','asc')
        ->get();

        //Verificamos si el profesor tiene materias asignadas y si no tiene le asignamos un mensaje de error 500 
        if($materias->isEmpty()){
            $materias = array(
                'error' => '500',
                'message' => 'El profesor no tiene materias asignadas'
            );
        }       
      
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
    public function showGrupo($id, $gpo_Nombre)
    {  
        //Llamamos a la función para completar el grupo
        $grupo = $this->completarGrupo($id); 
        //Obtenemos el año actual
        $anio = date('Y');
        //Seleccionamos todos los alumnos de los ultimos 7 años para llenar el select de alumnos
        $alumnos = DB::connection('contEsc')->table('alumnos')
        ->where('alu_AnioIngreso','>=',$anio-7)
        ->select('alu_NumControl','alu_Nombre','alu_ApePaterno','alu_ApeMaterno')
        ->get();       
       
        //Obtenemos los alumnos del grupo
        $alumnosGrupo=GpoTutorias::where('gpo_Nombre',$gpo_Nombre)->get(); 
        //Agregamos el nombre del alumno al grupo        
        foreach($alumnosGrupo as $alumno)
        {
            $alumnoTem = DB::connection('contEsc')->table('alumnos')
            ->where('alu_NumControl',$alumno->no_Control)
            ->first();
            //Verificamos que el alumno exista en la base de datos
            if($alumnoTem===null)
            {
                $alumno->alu_Nombre='NO EXISTE';
            }                
            else 
            {
                $alumno->alu_Nombre=strtoupper($alumnoTem->alu_Nombre).' '.strtoupper($alumnoTem->alu_ApePaterno).' '.strtoupper($alumnoTem->alu_ApeMaterno);     
                $alumno->status=$alumnoTem->alu_StatusAct; 
            }                             
        }

        //Agregamos la ficha de cada alumno del grupo
        foreach($alumnosGrupo as $alumno)   
        {
            $ficha = DB::table('alumnos')
            ->where('no_control',$alumno->no_Control)
            ->first();
            //Si no existe la ficha le asignamos un valor de 0
            if($ficha==null)
                $alumno->ficha=0;
            else            
                $alumno->ficha=$ficha->ficha;
        }        
       
         //Creamos una instancia de la clase JefesController
         $jefe = new JefesController;

         foreach ($alumnosGrupo as $row) {             
             $row->semaforos = $jefe->calSemaforos($row->no_Control);            
         }     
             
        return view('sta.tutores.showGrupo',compact('grupo','alumnos','alumnosGrupo'));
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
    public function storeGrupo(Request $request)
    {
        try
        {
            //Guardamos el numero de contro y grupo en la tabla gpoTutorias            
            GpoTutorias::updateOrCreate(
                ['no_Control' => $request->no_Control],
                ['gpo_Nombre' => $request->gpo_Nombre]
            );
            //Retornamos status 200 y el mensaje de que se guardo correctamente
            return response()->json(['message' => 'Correcto'], 200);          
        }
        catch(\Exception $e)
        {
            return response()->json(['message' => 'No se pudo dar de alta el registro'], 500);
        }
    }

    //Función para eliminar un alumno de un grupo
    public function deleteAlumno(Request $request)
    {
        try
        {
            //Eliminamos el registro de la tabla gpoTutorias
            GpoTutorias::where('no_Control',$request->no_Control)->delete();
            //Retornamos status 200 y el mensaje de que se guardo correctamente
            return response()->json(['message' => 'Correcto'], 200);          
        }
        catch(\Exception $e)
        {
            return response()->json(['message' => 'No se pudo eliminar el registro'], 500);
        }
    }
   
}
