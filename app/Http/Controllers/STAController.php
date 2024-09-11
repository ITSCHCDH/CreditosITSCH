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
        $catClave = 0;
        // Obtener el nombre del usuario autenticado y procesarlo
        $userName = Auth::User()->name;
        $userName = strtolower($this->quitarCaracteres($userName));  // Minúsculas y sin caracteres especiales
        
        // Obtener la lista de catedráticos con nombres y apellidos en una sola consulta
        $catedraticos = DB::connection('contEsc')->table('catedraticos')
            ->select('cat_Clave', 'cat_Nombre', 'cat_ApePat', 'cat_ApeMat')
            ->get();
    
        // Iterar sobre los catedráticos y comparar nombres procesados
        foreach ($catedraticos as $catedratico) {
            // Procesar el nombre completo del catedrático
            $catNombre = strtolower($this->quitarCaracteres("{$catedratico->cat_Nombre} {$catedratico->cat_ApePat} {$catedratico->cat_ApeMat}"));
            
            // Verificar la similitud entre el nombre del usuario y el nombre del catedrático
            similar_text($userName, $catNombre, $similarity);
            $threshold = 85; // Umbral de similitud mínimo requerido
            if ($similarity >= $threshold) {
                $catClave = $catedratico->cat_Clave;
                break;  // Salir del bucle cuando se encuentre una coincidencia
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
        
        // Obtén todas las claves de carrera en un solo paso
        $carClaves = $gruTutorias->pluck('car_Clave')->toArray();

        // Realiza una sola consulta para obtener los nombres de las carreras
        $carreras = DB::connection('contEsc')->table('carreras')
            ->whereIn('car_Clave', $carClaves)
            ->get()
            ->keyBy('car_Clave'); // Usa keyBy para organizar por car_Clave

        // Agrega el nombre de la carrera a cada objeto $gru
        foreach($gruTutorias as $gru) {
            if (isset($carreras[$gru->car_Clave])) {
                $gru->car_Nombre = $carreras[$gru->car_Clave]->car_Nombre;
            }
        }

        // Obtén todas las claves tut_Clave de los tutores
        $tutClaves = $gruTutorias->pluck('tut_Clave')->toArray();

        // Realiza una sola consulta para obtener los nombres de los profesores
        $profesores = User::whereIn('id', $tutClaves)
            ->get()
            ->keyBy('id'); // Organiza por id para acceso rápido

        // Agrega el nombre del profesor en cada objeto $gru
        foreach ($gruTutorias as $gru) {
            if (isset($profesores[$gru->tut_Clave])) {
                $gru->name = strtoupper($profesores[$gru->tut_Clave]->name);
            }
        }
    

        return view('sta.tutorias.index',compact('profesores','carreras','gruTutorias')); 
    }

    public function indexTutores()
    {
        // Obtener el usuario autenticado
        $user = Auth::User();
        
        // Obtener los grupos dependiendo de los permisos
        if ($user->can('VIP_STA')) {        
            $grupos = AsignacionTutores::all();        
        } else {       
            $grupos = AsignacionTutores::where('tut_Clave', $user->id)->get();        
        }
    
        // Extraer las claves necesarias
        $tutClaves = $grupos->pluck('tut_Clave')->toArray();
        $gpoIds = $grupos->pluck('gpo_Id')->toArray();
        $carClaves = $grupos->pluck('car_Clave')->toArray();
    
        // Consultar los tutores, grupos y carreras en bloque
        $tutores = User::whereIn('id', $tutClaves)->get()->keyBy('id');
        $gruposInfo = Grupo::whereIn('id', $gpoIds)->get()->keyBy('id');
        $carreras = DB::connection('contEsc')->table('carreras')
            ->whereIn('car_Clave', $carClaves)
            ->get()
            ->keyBy('car_Clave');
    
        // Iterar sobre los grupos y agregar la información correspondiente
        foreach ($grupos as $gru) {
            // Asignar nombre del tutor
            if (isset($tutores[$gru->tut_Clave])) {
                $gru->name = strtoupper($tutores[$gru->tut_Clave]->name);
            }
    
            // Asignar nombre del grupo
            if (isset($gruposInfo[$gru->gpo_Id])) {
                $gru->gpo_Nombre = strtoupper($gruposInfo[$gru->gpo_Id]->gpo_Nombre);
            }
    
            // Asignar nombre de la carrera
            if (isset($carreras[$gru->car_Clave])) {
                $gru->car_Nombre = strtoupper($carreras[$gru->car_Clave]->car_Nombre);
            }
        }
    
        // Retornar la vista con los datos
        return view('sta.tutores.index', compact('grupos'));
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
       
        // Obtén todos los alumnos del grupo en una sola consulta
        $alumnosGrupo = GpoTutorias::where('gpo_Nombre', $gpo_Nombre)->get();

        // Obtén los números de control de los alumnos del grupo
        $noControles = $alumnosGrupo->pluck('no_Control')->toArray();

        // Consulta todos los datos de los alumnos correspondientes a los números de control en una sola consulta
        $alumnosDatos = DB::connection('contEsc')->table('alumnos')
            ->whereIn('alu_NumControl', $noControles)
            ->get()
            ->keyBy('alu_NumControl');

        // Consulta las fichas de los alumnos en una sola consulta
        $fichas = DB::table('alumnos')
            ->whereIn('no_control', $noControles)
            ->get()
            ->keyBy('no_control');

        // Itera sobre los alumnos del grupo y agrega los datos correspondientes
        foreach ($alumnosGrupo as $alumno) {
            // Verifica si el alumno existe en la base de datos contEsc
            if (isset($alumnosDatos[$alumno->no_Control])) {
                $alumnoTem = $alumnosDatos[$alumno->no_Control];
                $alumno->alu_Nombre = strtoupper($alumnoTem->alu_Nombre) . ' ' . strtoupper($alumnoTem->alu_ApePaterno) . ' ' . strtoupper($alumnoTem->alu_ApeMaterno);
                $alumno->status = $alumnoTem->alu_StatusAct;
            } else {
                $alumno->alu_Nombre = 'EL ALUMNO NO EXISTE, VERIFICA SU NUMERO DE CONTROL!';
            }

            // Asigna la ficha correspondiente, o 0 si no existe
            if (isset($fichas[$alumno->no_Control])) {
                $alumno->ficha = $fichas[$alumno->no_Control]->ficha;
            } else {
                $alumno->ficha = 0;
            }
        }
      
       
       // Asumiendo que calSemaforos es ahora estático
        foreach ($alumnosGrupo as $row) {             
            $row->semaforos = JefesController::calSemaforos($row->no_Control);            
        }    
             
        return view('sta.tutores.showGrupo',compact('grupo','alumnos','alumnosGrupo'));
    }

    public function completarGrupo($id)
    {              
        // Obtén la información del grupo
        $grupo = AsignacionTutores::where('id', $id)->get();  
    
        // Extraer las claves de tutor, grupo y carrera
        $tutClaves = $grupo->pluck('tut_Clave')->toArray();
        $gpoIds = $grupo->pluck('gpo_Id')->toArray();
        $carClaves = $grupo->pluck('car_Clave')->toArray();
    
        // Obtener los datos de los tutores, grupos y carreras en una sola consulta
        $tutores = User::whereIn('id', $tutClaves)->get()->keyBy('id');
        $grupos = Grupo::whereIn('id', $gpoIds)->get()->keyBy('id');
        $carreras = DB::connection('contEsc')->table('carreras')
            ->whereIn('car_Clave', $carClaves)
            ->get()
            ->keyBy('car_Clave');
    
        // Iterar sobre el grupo y agregar los datos del tutor, grupo y carrera
        foreach ($grupo as $gru) {
            // Asignar el nombre del tutor
            if (isset($tutores[$gru->tut_Clave])) {
                $gru->nomTutor = strtoupper($tutores[$gru->tut_Clave]->name);
            }
    
            // Asignar el nombre del grupo
            if (isset($grupos[$gru->gpo_Id])) {
                $gru->gpo_Nombre = strtoupper($grupos[$gru->gpo_Id]->gpo_Nombre);
            }
    
            // Asignar el nombre de la carrera
            if (isset($carreras[$gru->car_Clave])) {
                $gru->car_Nombre = strtoupper($carreras[$gru->car_Clave]->car_Nombre);
            }
        }
    
        return $grupo;
    }
    

    //Función para guardar los alumnos de un grupo
    public function storeGrupo(Request $request)
    {
        try
        {
            //Verificamos que el numero de control exista en la base de datos de control escolar
            $alumno = DB::connection('contEsc')->table('alumnos')
            ->where('alu_NumControl',$request->no_Control)
            ->first();
            if($alumno==null)
                return response()->json(['message' => 'El alumno con numero de control: '. $request->no_Control .', no existe en la base de datos de control escolar'], 500);
            else{
                //Guardamos el numero de control y grupo en la tabla gpoTutorias            
                GpoTutorias::updateOrCreate(
                    ['no_Control' => $request->no_Control],
                    ['gpo_Nombre' => $request->gpo_Nombre]
                );
                //Retornamos status 200 y el mensaje de que se guardo correctamente
                return response()->json(['message' => 'Correcto'], 200);  
            }        
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

    public function analisisGrupo($id)
    {
        // Obtener el grupo completo con una sola consulta
        $grupo = $this->completarGrupo($id); 
        
        // Obtener los alumnos del grupo
        $alumnosGrupo = GpoTutorias::where('gpo_Nombre', $grupo[0]->gpo_Nombre)->get();
    
        // Obtener todos los alumnos y sus datos en una sola consulta
        $noControles = $alumnosGrupo->pluck('no_Control'); // Recolectar los no_Control de los alumnos
        $alumnosTem = DB::connection('contEsc')->table('alumnos')
            ->whereIn('alu_NumControl', $noControles)
            ->get()
            ->keyBy('alu_NumControl'); // Indexar por número de control para acceso rápido
    
        // Verificar y asignar datos del alumno en el grupo
        foreach($alumnosGrupo as $alumno) {
            if (isset($alumnosTem[$alumno->no_Control])) {
                $alumnoTem = $alumnosTem[$alumno->no_Control];
                $alumno->alu_Nombre = strtoupper($alumnoTem->alu_Nombre) . ' ' . strtoupper($alumnoTem->alu_ApePaterno) . ' ' . strtoupper($alumnoTem->alu_ApeMaterno);
                $alumno->status = $alumnoTem->alu_StatusAct;
            } else {
                $alumno->alu_Nombre = 'EL ALUMNO NO EXISTE, VERIFICA SU NUMERO DE CONTROL!';
            }
        }
    
        // Obtener todas las materias y calificaciones de los alumnos en una sola consulta
        $materias = DB::connection('contEsc')->table('listassemestre')
            ->join('grupossemestre', 'listassemestre.gse_Clave', '=', 'grupossemestre.gse_Clave')
            ->join('reticula', 'grupossemestre.ret_Clave', '=', 'reticula.ret_Clave')
            ->join('listassemestrecom', 'listassemestre.lse_Clave', '=', 'listassemestrecom.lse_clave')
            ->whereIn('listassemestre.alu_NumControl', $noControles)
            ->select('listassemestre.alu_NumControl', 'reticula.ret_NomCorto', 'listassemestrecom.lsc_NumUnidad', 'listassemestrecom.lsc_Calificacion')
            ->get()
            ->groupBy('alu_NumControl'); // Agrupar materias por número de control
    
        // Asignar materias a cada alumno
        foreach($alumnosGrupo as $alumno) {
            $alumno->materias = $materias->get($alumno->no_Control, collect()); // Si no hay materias, asigna una colección vacía
        }
    
        return view('sta.tutores.analisis', compact('grupo', 'alumnosGrupo'));
    }
    
   
}
