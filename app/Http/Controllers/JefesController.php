<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use App\Models\Historial_clinico;
use App\Models\Datos_familiares;
use App\Models\Motivoreprobacion;
use Illuminate\Support\Facades\Auth;
use App\Models\Alumno;
use App\Models\Direccion;
use App\Models\Familiar;
use App\Models\Personales;
use App\Models\Padres;
use App\Models\Social;
use Alert;

class JefesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
         $this->middleware('permission:VIP_STA|STA_DEP_TUTORIA|STA_COR_CARRERA')->only(['index']);
         $this->middleware('permission:VIP_STA|STA_DEP_TUTORIA|STA_TUTOR|STA_COR_CARRERA')->only(['generacion','diagnostico','calSemaforos','ficha','storeAlumnoObs']);            
     }      

    public function index()
    {       
        //Verificamos si el usuario tiene permiso VIP_STA para darle acceso a todas las carreras si no, lo limitamos solo a su carrera
        if(Auth::User()->hasAnyPermission(['VIP_STA','STA_DEP_TUTORIA'])){       
            $carreras = DB::connection('contEsc')->table('carreras')->where('car_Status','VIGENTE')->get();
        }
        else{
            $carreras = DB::connection('contEsc')->table('carreras')->where('car_Clave',auth()->user()->area)->get();
        }           
       
        $grupo="";
        $generacion="";
        $carrera="";      
        $generaciones = DB::connection('contEsc')->table('alumnos')
        ->select("alumnos.Alu_AnioIngreso")
        ->where('alumnos.Alu_AnioIngreso', '!=', 0)
        ->whereNotNull('alumnos.Alu_AnioIngreso')
        ->orderBy('Alu_AnioIngreso', 'desc')
        ->distinct()
        ->get();
       
        return view('sta/analisis_alumnos/index')
        ->with('grupo',$grupo)
        ->with('carreras',$carreras)
        ->with('generaciones',$generaciones)
        ->with('generacion',$generacion)
        ->with('carrera',$carrera);
    }

   public function generacion(Request $request)
{ 
    // Obtener el grupo de alumnos basado en carrera y año de ingreso
    $grupo = DB::connection('contEsc')->table('alumnos')
        ->select(
            "alu_NumControl AS control",
            "alu_ApePaterno AS aPaterno",
            "alu_ApeMaterno AS aMaterno",
            "alu_Nombre AS nombre",
            "alu_SemestreAct AS semestre",
            'alu_StatusAct AS status'
        )
        ->where('alumnos.car_Clave', '=', $request->carrera)
        ->where('alumnos.Alu_AnioIngreso', '=', $request->generacion)
        ->orderBy('alumnos.alu_ApePaterno', 'asc')
        ->get();

    // Si no hay alumnos, enviar advertencia y retornar
    if ($grupo->isEmpty()) {
        Alert::warning('No hay alumnos registrados en esta generación')->showConfirmButton('Ok', '#3085d6');
        return redirect()->back();
    }

    // Obtener las fichas de los alumnos en una sola consulta usando la tabla Alumno
    $fichas = Alumno::whereIn('no_control', $grupo->pluck('control'))
        ->select('no_control', 'ficha')
        ->get()
        ->keyBy('no_control'); // Estructuramos por no_control para fácil acceso

    // Iterar sobre el grupo y asignar las fichas y semáforos correspondientes
    foreach ($grupo as $alu) {
        // Asignar ficha si existe, de lo contrario, asignar 0
        $alu->ficha = $fichas->get($alu->control)->ficha ?? 0;

        // Calcular semáforos
        $alu->semaforos = self::calSemaforos($alu->control);
    }

    // Obtener el usuario actual y determinar permisos
    $usuario = Auth::User();
    $hasVipOrTutoriaPermission = $usuario->hasAnyPermission(['VIP_STA', 'STA_DEP_TUTORIA']);

    // Optimización: Obtener carreras basado en los permisos del usuario
    $carrerasQuery = DB::connection('contEsc')->table('carreras')->where('car_Status', 'VIGENTE');
    if (!$hasVipOrTutoriaPermission) {
        $carrerasQuery->where('car_Clave', $usuario->area);
    }
    $carreras = $carrerasQuery->get();

    // Optimización: Obtener generaciones únicas
    $generaciones = DB::connection('contEsc')->table('alumnos')
        ->select("Alu_AnioIngreso")
        ->where('Alu_AnioIngreso', '!=', 0)
        ->whereNotNull('Alu_AnioIngreso')
        ->distinct()
        ->orderBy('Alu_AnioIngreso', 'desc')
        ->get(); 

    // Retornar la vista con los datos procesados
    return view('sta.analisis_alumnos.index', compact('grupo', 'carreras', 'generaciones'))
        ->with('generacion', $request->generacion)
        ->with('carrera', $request->carrera);
}

    

    public function diagnostico($nc)
    {		
        $buscarAlumno = DB::connection('contEsc')->table('alumnos')
        ->join('carreras','carreras.car_Clave', '=','alumnos.car_Clave')
        ->select("alumnos.alu_NumControl",'alumnos.alu_StatusAct',"alumnos.alu_Nombre","alumnos.alu_ApePaterno","alumnos.alu_ApeMaterno","alumnos.alu_SemestreAct","carreras.car_Nombre","alumnos.alu_Sexo")
        ->where("alu_NumControl","=",$nc)
        ->first(); 
       
        //Consultamos las observaciones de cada alumno y las agregamos a $buscarAlumno
        $obs=DB::table('alumnos')->where('no_control',$nc)->select('observaciones')->first();
        if(is_null($obs))
            $buscarAlumno->observaciones = "Sin observaciones";
        else
            $buscarAlumno->observaciones =$obs->observaciones;
            
        if($buscarAlumno->alu_Sexo == "F"){
            $buscarAlumno->alu_Sexo = "Femenino";
        }else{
            $buscarAlumno->alu_Sexo = " Masculino";
        }

        //Obtenemos el semaforo academico correspondiente para este alumno
        $buscarAlumno->semaforos = self::calSemaforos($buscarAlumno->alu_NumControl); 

        $GetGrupos = DB::connection('contEsc')->table('alumnos')
        ->join('listassemestre','listassemestre.alu_NumControl','=','alumnos.alu_NumControl')
        ->join('grupossemestre','grupossemestre.gse_Clave','=','listassemestre.gse_Clave')
        ->select("grupossemestre.gse_Observaciones")
        ->where("alumnos.alu_NumControl","=",$nc)
        ->DISTINCT()
        ->get();

        if(sizeof($GetGrupos)>0){
            $variablegrupo = 'Grupos : ';
        }else{
            $variablegrupo = '';
        }

        $GetTablaCalificaciones = DB::connection('contEsc')->table('listassemestre')
        ->join('listassemestrecom','listassemestrecom.lse_Clave','=','listassemestre.lse_Clave')        
        ->join('grupossemestre','listassemestre.gse_Clave','=','grupossemestre.gse_Clave')
        ->join('reticula','reticula.ret_Clave','=','grupossemestre.ret_Clave')
        ->join('catedraticos','catedraticos.cat_Clave','=','grupossemestre.cat_Clave')
        ->select (DB::raw("CONCAT(catedraticos.cat_Nombre,' ',catedraticos.cat_ApePat,' ',catedraticos.cat_ApeMat) as profesor"),'reticula.ret_NomCompleto','listassemestrecom.lsc_Calificacion','reticula.ret_NumUnidades','listassemestrecom.lsc_NumUnidad','listassemestrecom.lsc_Corte','listassemestrecom.lse_clave')
        ->where('listassemestre.alu_NumControl','=',$nc)
        ->DISTINCT()
        ->get();

        $GetMaxUnidad = DB::connection('contEsc')->table('listassemestre')
        ->join('listassemestrecom','listassemestrecom.lse_Clave','=','listassemestre.lse_Clave')
        ->join('grupossemestre','listassemestre.gse_Clave','=','grupossemestre.gse_Clave')
        ->join('reticula','reticula.ret_Clave','=','grupossemestre.ret_Clave')
        ->select ('listassemestrecom.lsc_NumUnidad')
        ->where('listassemestre.alu_NumControl','=',$nc)
        ->DISTINCT()
        ->get(); 

        if(sizeof($GetMaxUnidad)>0){
            $variableCalificaciones = 'Calificaciones Parciales';
            $unidadesvariable = 'Materias';
        }else{
            $variableCalificaciones = 'Sin calificaciones parciales';
            $unidadesvariable = 'Sin materias asignadas';
        }


        $GetCardex = DB::connection('contEsc')->table('cardex')
        ->join('reticula','cardex.ret_Clave','=','reticula.ret_Clave')
        ->select ('cardex.cdx_AnioXPrime','reticula.ret_NomCompleto','cardex.cdx_Calif','cardex.cdx_SemXPrime','cardex.cdx_UltOpcAcred')
        ->where('cardex.alu_NumControl','=',$nc)
        ->orderBy('cardex.cdx_SemXPrime', 'asc')
        ->get();      

       
        $comentarios = Motivoreprobacion::select('*')              
        ->where('no_control','=',$nc)
        ->get(); 


        //Guardar las calificaciones en forma de arreglos
        $temp="";
        $con=0;
        $materias=[];         
       
        foreach($GetTablaCalificaciones as $calificaciones)
        {            
            if($temp!=$calificaciones->lse_clave)
            {
                $temp=$calificaciones->lse_clave;
                $con++;                               
            }
            //Agregamos los comentarios a cada calificación
            $calificaciones->comentario = "";
            $calificaciones->motivo = 0;
            foreach($comentarios as $comentario){
                if($calificaciones->lse_clave == $comentario->lse_clave && $calificaciones->lsc_NumUnidad == $comentario->num_tema){
                    $calificaciones->comentario = $comentario->comentario;
                    $calificaciones->motivo = $comentario->motivos;
                }
            }
            $materias[$con][]=$calificaciones;                                                
        }                
        return view('sta.analisis_alumnos.diagnostico')        
        -> with ('alumnos',$buscarAlumno)
        -> with ('grupos',$GetGrupos)       
        -> with ('unidades',$GetMaxUnidad)
        -> with ('calificacionesvariable',$variableCalificaciones)
        -> with ('unidadesvariable',$unidadesvariable)
        -> with ('variablegrupo',$variablegrupo)
        -> with ('cardex',$GetCardex)       
        -> with('materias',$materias);				      
    }

    public static function calSemaforos($nc) {
        
        $indicesAcad = DB::connection('contEsc')->table("cardex")
        ->select(
            'alumnos.alu_StatusAct',
            DB::raw('SUM(CASE WHEN cdx_UltOpcAcred = 2 THEN 1 ELSE 0 END) AS nivelacionesOrdinario'),
            DB::raw('SUM(CASE WHEN cdx_UltOpcAcred = 3 THEN 1 ELSE 0 END) AS repeticiones'),
            DB::raw('SUM(CASE WHEN cdx_UltOpcAcred = 4 THEN 1 ELSE 0 END) AS nivelacionesRepe'),
            DB::raw('SUM(CASE WHEN cdx_UltOpcAcred = 5 THEN 1 ELSE 0 END) AS especiales'),
            DB::raw('SUM(CASE WHEN cdx_UltOpcAcred = 6 THEN 1 ELSE 0 END) AS nivelacionesEspecial')
        )
        ->join('alumnos', 'alumnos.alu_NumControl', '=', 'cardex.alu_NumControl')
        ->where('cardex.alu_NumControl', '=', $nc)
        ->groupBy('alumnos.alu_StatusAct')
        ->first(); 
        //Declaramos un arreglo para guardar los semaforos
        $semaforos = [];

        // Revisamos que las nivelaciónes no sean nulas        
        if ($indicesAcad !== null && property_exists($indicesAcad, 'nivelacionesOrdinario')) {
            // El objeto $indicesAcad no es nulo y tiene la propiedad 'nivelacionesOrdinario'
            // Calculamos el total de nivelaciones
            $nivelaciones = $indicesAcad->nivelacionesOrdinario + $indicesAcad->nivelacionesRepe + $indicesAcad->nivelacionesEspecial;

            // Calculamos el semáforo académico
            switch (true) {
                case $indicesAcad->alu_StatusAct == 'BD':
                    $semaforos['semaforoAcad'] = 'CirculoNegro';
                    $semaforos['titleAcad'] = 'Ya no es posible realizar acciones de seguimiento con este alumno';
                    break;
                case $indicesAcad->especiales > 0 || $nivelaciones >= 10 || $indicesAcad->repeticiones > 2 || $indicesAcad->alu_StatusAct == 'BT':
                    $semaforos['semaforoAcad'] = 'CirculoRojo';
                    $semaforos['titleAcad'] = 'El alumno tiene problemas académicos graves, urgente dar seguimiento';
                    break;
                case ($indicesAcad->repeticiones <= 2 && ($nivelaciones >= 3 && $nivelaciones < 10)):
                    $semaforos['semaforoAcad'] = 'CirculoNaranja';
                    $semaforos['titleAcad'] = 'El alumno tiene problemas académicos moderados, se recomienda dar seguimiento';
                    break;
                case $nivelaciones > 1 && $nivelaciones < 3:
                    $semaforos['semaforoAcad'] = 'CirculoAmarillo';
                    $semaforos['titleAcad'] = 'El alumno tiene problemas académicos leves, se recomienda observación';
                    break;
                case $nivelaciones <= 1:
                    $semaforos['semaforoAcad'] = 'CirculoVerde';
                    $semaforos['titleAcad'] = 'El alumno no tiene problemas académicos';
                    break;
                default:
                    $semaforos['semaforoAcad'] = 'CirculoNegro';
                    $semaforos['titleAcad'] = 'No se pudo calcular el semáforo académico';
                    break;
            }
        } 
        else 
        {
            // El objeto $indicesAcad es nulo o no tiene la propiedad 'nivelacionesOrdinario'
            $semaforos['semaforoAcad'] = 'CirculoNegro'; 
            $semaforos['titleAcad'] = 'Este alumno aún no tiene indicadores académicos registrados';
        }
       
        $semPsico=5;

        // Calculamos el semáforo psicológico
        switch ($semPsico) {
            case 1:
                $semaforos['semaforoPsico'] = 'CirculoVerde';
                break;
            case 2:
                $semaforos['semaforoPsico'] = 'CirculoAmarillo';
                break;
            case 3:
                $semaforos['semaforoPsico'] = 'CirculoNaranja';
                break;
            case 4:
                $semaforos['semaforoPsico'] = 'CirculoRojo';
                break;
            default:
                $semaforos['semaforoPsico'] = 'CirculoNegro';
        }

        $semMedico=5;
        // Calculamos el semáforo médico
        switch ($semMedico) {
            case 1:
                $semaforos['semaforoMedico'] = 'CirculoVerde';
                break;
            case 2:
                $semaforos['semaforoMedico'] = 'CirculoAmarillo';
                break;
            case 3:
                $semaforos['semaforoMedico'] = 'CirculoNaranja';
                break;
            case 4:
                $semaforos['semaforoMedico'] = 'CirculoRojo';
                break;
            default:
                $semaforos['semaforoMedico'] = 'CirculoNegro';
        }     
                   
        //Verificamos si el alumno ya tiene registrado el servicio social en cardex
        $listaDeClaves = [720,790,791,792,793,794,838]; // Lista de valores a verificar
        $ssExists = DB::connection('contEsc')->table('cardex')
        ->where('cardex.alu_NumControl', '=', $nc)
        ->whereIn('cardex.ret_Clave', $listaDeClaves)
        ->exists(); // Devuelve true o false  
       
        //cambiamos el semaforo si el alumno ya tiene registrado el servicio social
        if($ssExists)
        { 
            $semaforos['semaforoServicio'] = 'CirculoVerde';
            $semaforos['titleSS'] = 'El servicio social ya fue registrado';
        }
        else
        {
            $status= DB::connection('contEsc')->table('alumnos')
            ->select('alumnos.alu_NumControl','alumnos.alu_SemestreAct','alumnos.alu_StatusAct','planesestudios.pes_CredTot','alumnos.alu_CreditosAcum','alumnos.alu_Inscrito')        
            ->join('planesestudios','planesestudios.pes_Clave','=','alumnos.pes_Clave')                
            ->where('alumnos.alu_NumControl','=',$nc)->first(); 

            //Verificamos si la variable es nula y en caso afirmativo enviamos el semaforo negro
            if($status==null)
            {
                $semaforos['semaforoServicio'] = 'CirculoNegro';
                $semaforos['titleSS'] = 'Este alumno no tiene registros de servicio social';
            }
            else
            {
                if($status->alu_StatusAct=='BT'||$status->alu_StatusAct=='BD')
                {
                    $semaforos['semaforoServicio'] = 'CirculoNegro';
                    $semaforos['titleSS'] = 'El status del alumno es baja, consultar con servicios escolares';
                }
                else
                {
                    //Calculamos el avance en creditos acumulados
                    $credAcum=($status->alu_CreditosAcum*100)/$status->pes_CredTot; 

                    if($status->alu_SemestreAct<=7)
                    { 
                        $semaforos['semaforoServicio'] = 'CirculoAzul';
                        $semaforos['titleSS'] = 'Este alumno aún no reune los requicitos para tramitar servicio social';
                    }
                    else if($status->alu_SemestreAct==8 && $credAcum>=80)
                    {
                        $semaforos['semaforoServicio'] = 'CirculoNaranja';
                        $semaforos['titleSS'] = 'Verificar que el alumno este realizando servicio social';
                    }
                    else if($status->alu_SemestreAct>=9)
                    {
                        $semaforos['semaforoServicio'] = 'CirculoRojo';
                        $semaforos['titleSS'] = 'Servicio social retrasado, urgente dar seguimiento';
                    }  
                    else
                    {
                        $semaforos['semaforoServicio'] = 'CirculoNegro';
                        $semaforos['titleSS'] = 'Este alumno no tiene registros de servicio social';
                    }
                }               
            }           
        }
        return $semaforos;
    }

    public function ficha($nc, $usr)
    { 
        try {
            $alu = Alumno::where('no_control',$nc)->first(); 
            $alu1 = DB::connection('contEsc')->table('alumnos')->where('alu_NumControl', $nc)->first(); 
            $car = DB::connection('contEsc')->table('carreras')->where('car_Clave', $alu1->car_Clave)->first();
            $alu2 = DB::connection('contEsc')->table('alumcom')->where('alu_NumControl', $alu1->alu_NumControl)->first();
    
            $clinicos = Historial_clinico::where('id_alu', $alu->id)->first();
    
            $padres = Padres::where('id_alu', $alu->id)
            ->whereIn('parentesco', ['Padre', 'Madre'])
            ->get(); 

            if ($padres->count() == 2) { 
                $direccion = Direccion::where('id_alu', $alu->id)->first();  
                $direccionP = Direccion::where('id_fam', $padres[0]->id)->first();
                $direccionM = Direccion::where('id_fam', $padres[1]->id)->first();  
        
                $familiares = Familiar::where('id_alu', $alu->id)->get(); 
        
                $person = Personales::where('id_alu', $alu->id)->first(); 
                $fam = Datos_familiares::where('id_alu', $alu->id)->first(); 
                $soc = Social::where('id_alu', $alu->id)->first(); 
            
                return view('sta.analisis_alumnos.ficha', compact('familiares', 'alu1', 'alu2', 'car','padres', 'direccion', 'direccionP', 'direccionM', 'soc', 'alu',  'clinicos', 'person', 'fam'));
            }    
            else
            { 
                
                if($usr==1)
                {
                    Alert::error('Error', 'Este alumno no ha llenado su ficha académica');
                    return redirect()->route('analisis.index');
                }
                else
                {
                    Alert::error('Error', 'Este alumno no ha llenado su ficha académica');
                    return back();
                }
                
            }                         
        
        } catch (\Exception $e) {
            Alert::error('Error', 'A ocurrido un error: ',$e);
            return back();
        }      
    }
    //Funcion para guardar las observaciones del alumno
    public function storeAlumnoObs(Request $request)
    {
        $noControl = $request->no_Control;
        try {
            $alumno = Alumno::where('no_control', $noControl)->firstOrFail();
            $alumno->observaciones = $request->observaciones;
            $alumno->save();
            
            return response()->json(['mensaje' => 'Observaciones guardadas correctamente', 'status' => 200, 'noControl' => $noControl]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['mensaje' => 'No se encontró el registro del alumno'.$noControl.', informalo al administrador de sistemas', 'status' => 404]);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al guardar las observaciones: '.$e->getMessage(), 'status' => 500]);
        }
    }
}
