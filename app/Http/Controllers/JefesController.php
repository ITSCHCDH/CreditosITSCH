<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Exception;
use App\Models\Historial_clinico;
use App\Models\Datos_familiares;
use App\Models\Motivoreprobacion;
use App\Models\ALumno;
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
    public function index()
    {
        $carreras = DB::connection('contEsc')->table('carreras')->where('car_Status','VIGENTE')->get();
        $grupo="";
        $generacion="";
        $carrera="";      
        $generaciones = DB::connection('contEsc')->table('alumnos')			
			->select("alumnos.Alu_AnioIngreso")
			->orderBy('Alu_AnioIngreso', 'asc')
			->distinct()
            ->where('alumnos.Alu_AnioIngreso','!=',0)
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
        $grupo = DB::connection('contEsc')->table('alumnos')         
        ->select("alu_NumControl AS control","alu_ApePaterno AS aPaterno","alu_ApeMaterno AS aMaterno","alu_Nombre AS nombre","alu_SemestreAct AS semestre",'alu_StatusAct AS status')
        ->orderBy('alumnos.alu_ApePaterno', 'asc')       
        ->where('alumnos.car_Clave','=',$request->carrera)
        ->where('alumnos.Alu_AnioIngreso','=',$request->generacion)
        ->get();   
       
        foreach ($grupo as $row) {
            $row->semaforos = self::calSemaforos($row->control);            
        }

        $carreras = DB::connection('contEsc')->table('carreras')->get();

        $generaciones = DB::connection('contEsc')->table('alumnos')			
			->select("alumnos.Alu_AnioIngreso")
			->orderBy('Alu_AnioIngreso', 'asc')
			->distinct()
			->get();

               
        return view('sta.analisis_alumnos.index')
        ->with('grupo',$grupo)
        ->with('carreras',$carreras)
        ->with('generaciones',$generaciones)
        ->with('generacion',$request->generacion)
        ->with('carrera',$request->carrera);
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
        ->select (DB::raw('CONCAT(catedraticos.cat_Nombre," ",catedraticos.cat_ApePat," ",catedraticos.cat_ApeMat) as profesor'),'reticula.ret_NomCompleto','listassemestrecom.lsc_Calificacion','reticula.ret_NumUnidades','listassemestrecom.lsc_NumUnidad','listassemestrecom.lsc_Corte','listassemestrecom.lse_clave')
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

    public function calSemaforos($nc) {
        
        $indicesAcad = DB::connection('contEsc')->table("cardex")
        ->select(
            'alumnos.alu_StatusAct',
            DB::raw('SUM(cdx_UltOpcAcred = 2) AS nivelacionesOrdinario'),
            DB::raw('SUM(cdx_UltOpcAcred = 3) AS repeticiones'),
            DB::raw('SUM(cdx_UltOpcAcred = 4) AS nivelacionesRepe'),
            DB::raw('SUM(cdx_UltOpcAcred = 5) AS especiales'),
            DB::raw('SUM(cdx_UltOpcAcred = 6) AS nivelacionesEspecial')           
        )
        ->join('alumnos', 'alumnos.alu_NumControl', '=', 'cardex.alu_NumControl')
        ->where('cardex.alu_NumControl', '=', $nc)
        ->groupBy('alumnos.alu_StatusAct')
        ->first();
        //Declaramos un arreglo para guardar los semaforos
        $semaforos = [];

        $nivelaciones = $indicesAcad->nivelacionesOrdinario + $indicesAcad->nivelacionesRepe + $indicesAcad->nivelacionesEspecial;

        // Calculamos el semáforo académico
        switch (true) {
            case $indicesAcad->especiales > 0 || $nivelaciones >= 10 || $indicesAcad->repeticiones > 2 || $indicesAcad->alu_StatusAct == 'BD':
                $semaforos['semaforoAcad'] = 'CirculoRojo';
                break;
            case ($indicesAcad->repeticiones <= 2 && ($nivelaciones >= 3 && $nivelaciones < 10)) || $indicesAcad->alu_StatusAct == 'BT':
                $semaforos['semaforoAcad'] = 'CirculoNaranja';
                break;
            case $nivelaciones > 1 && $nivelaciones <= 5:
                $semaforos['semaforoAcad'] = 'CirculoAmarillo';
                break;
            case $nivelaciones <= 1:
                $semaforos['semaforoAcad'] = 'CirculoVerde';
                break;
            default:
                $semaforos['semaforoAcad'] = 'CirculoNegro';
        }

        $semPsico=2;

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

        $semMedico=1;
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
