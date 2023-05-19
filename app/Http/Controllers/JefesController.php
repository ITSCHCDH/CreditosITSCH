<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $carreras = DB::connection('contEsc')->table('carreras')->get();
        $grupo="";
        $generacion="";
        $carrera="";      
        $generaciones = DB::connection('contEsc')->table('alumnos')			
			->select("alumnos.Alu_AnioIngreso")
			->orderBy('Alu_AnioIngreso', 'asc')
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
        $grupo = DB::connection('contEsc')->table('alumnos')         
        ->select("alu_NumControl AS control","alu_ApePaterno AS aPaterno","alu_ApeMaterno AS aMaterno","alu_Nombre AS nombre","alu_SemestreAct AS semestre",'alu_StatusAct AS status')
        ->orderBy('alumnos.alu_ApePaterno', 'asc')       
        ->where('alumnos.car_Clave','=',$request->carrera)
        ->where('alumnos.Alu_AnioIngreso','=',$request->generacion)
        ->get();   

        foreach ($grupo as $row) {
            $row->semaforoAcad = self::calSemaforo($row->control);            
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
        ->get();

        if($buscarAlumno[0]->alu_Sexo == "F"){
            $buscarAlumno[0]->alu_Sexo = "Femenino";
        }else{
            $buscarAlumno[0]->alu_Sexo = " Masculino";
        }

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
        ->select ('reticula.ret_NomCompleto','listassemestrecom.lsc_Calificacion','reticula.ret_NumUnidades','listassemestrecom.lsc_NumUnidad','listassemestrecom.lsc_Corte','listassemestrecom.lse_clave')
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


        $semaforoMedico = DB::table('psicoclin.alumnos')
        ->select('alumnos.status_medico')
        ->where('no_control','=',$nc)
        ->get();

        $MSMMedico = null;
        $TamSemMedico = 1;
        $tam_msm_medico = 0;
        if(sizeof($semaforoMedico) == 0){
            $TamSemMedico = 0;
        }else{
            $tam_msm_medico = 1;
            $MSMMedico = DB::table('psicoclin.status')
            ->join('psicoclin.alumnos','alumnos.id','=','status.alumno_id')
            ->select ('status.mensaje')
            ->where('status.tipo','=','medico')
            ->where('alumnos.no_control','=',$nc)
            ->get();
            if(sizeof($MSMMedico) == 0){
                $tam_msm_medico = 0;
            }

        }

        $semaforoPsicologico = DB::table('psicoclin.alumnos')
        ->select('alumnos.status_psico')
        ->where('no_control','=',$nc)
        ->get();

        $MSMPsicologico = null;
        $tam_msm_psicologico = 0;
        $TamSemPsicologico = 1;
        if(sizeof($semaforoPsicologico) == 0){
            $TamSemPsicologico = 0;
        }else{
            $tam_msm_psicologico = 1;
            $MSMPsicologico = DB::table('psicoclin.status')
            ->join('psicoclin.alumnos','alumnos.id','=','status.alumno_id')
            ->select ('status.mensaje')
            ->where('status.tipo','=','psico')
            ->where('alumnos.no_control','=',$nc)
            ->get();
            if(sizeof($MSMPsicologico) == 0){
                $tam_msm_psicologico = 0;
            }
        }


        $nivelacionesOrdinario = DB::connection('contEsc')->table("cardex")
        ->select('cardex.*')
        ->where('alu_NumControl', '=', $nc)
        ->where('cdx_UltOpcAcred', '>=', '2')
        ->where('cdx_UltOpcAcred', '<', '3')
        ->count();

        $nivelacionesRepe = DB::connection('contEsc')->table("cardex")
        ->select('cardex.*')
        ->where('alu_NumControl', '=', $nc)
        ->where('cdx_UltOpcAcred', '>=', '4')
        ->where('cdx_UltOpcAcred', '<', '5')
        ->count();

        $nivelacionesEspecial = DB::connection('contEsc')->table("cardex")
        ->select('cardex.*')
        ->where('alu_NumControl', '=', $nc)
        ->where('cdx_UltOpcAcred', '>=', '6')
        ->count();

        $repeticiones = DB::connection('contEsc')->table("cardex")
        ->select('cardex.*')
        ->where('alu_NumControl', '=', $nc)
        ->where('cdx_UltOpcAcred', '>=', '3')
        ->where('cdx_UltOpcAcred', '<', '4')
        ->count();

        $especiales = DB::connection('contEsc')->table("cardex")
        ->select('cardex.*')
        ->where('alu_NumControl', '=', $nc)
        ->where('cdx_UltOpcAcred', '>=', '5')
        ->where('cdx_UltOpcAcred', '<', '6')
        ->count();

        $nivelaciones = $nivelacionesOrdinario + $nivelacionesRepe + $nivelacionesEspecial;

       
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

           // dd($materias);
                                                
        }      
            
        return view('sta.analisis_alumnos.diagnostico')        
        -> with ('alumnos',$buscarAlumno)
        -> with ('grupos',$GetGrupos)       
        -> with ('unidades',$GetMaxUnidad)
        -> with ('calificacionesvariable',$variableCalificaciones)
        -> with ('unidadesvariable',$unidadesvariable)
        -> with ('variablegrupo',$variablegrupo)
        -> with ('cardex',$GetCardex)
        -> with ('medico',$semaforoMedico)
        -> with ('psicologico',$semaforoPsicologico)
        -> with ('tamsemmedico',$TamSemMedico)
        -> with ('tamsempsicologico',$TamSemPsicologico)
        -> with('nivelaciones',$nivelaciones)
        -> with('repeticiones',$repeticiones)
        -> with('especiales',$especiales)
        -> with('msm_medico',$MSMMedico)
        -> with('tam_msm_medico',$tam_msm_medico)
        -> with('msm_psicologico',$MSMPsicologico)
        -> with('tam_msm_psicologico',$tam_msm_psicologico)        
        -> with('materias',$materias);				      
    }

    public function calSemaforo($nc) {
        $nivelacionesOrdinario = DB::connection('contEsc')->table("cardex")
        ->select('cardex.*')
        ->where('alu_NumControl', '=', $nc)
        ->where('cdx_UltOpcAcred', '>=', '2')
        ->where('cdx_UltOpcAcred', '<', '3')
        ->count();

        $nivelacionesRepe = DB::connection('contEsc')->table("cardex")
        ->select('cardex.*')
        ->where('alu_NumControl', '=', $nc)
        ->where('cdx_UltOpcAcred', '>=', '4')
        ->where('cdx_UltOpcAcred', '<', '5')
        ->count();

        $nivelacionesEspecial = DB::connection('contEsc')->table("cardex")
        ->select('cardex.*')
        ->where('alu_NumControl', '=', $nc)
        ->where('cdx_UltOpcAcred', '>=', '6')
        ->count();

        $repeticiones = DB::connection('contEsc')->table("cardex")
        ->select('cardex.*')
        ->where('alu_NumControl', '=', $nc)
        ->where('cdx_UltOpcAcred', '>=', '3')
        ->where('cdx_UltOpcAcred', '<', '4')
        ->count();

        $especiales = DB::connection('contEsc')->table("cardex")
        ->select('cardex.*')
        ->where('alu_NumControl', '=', $nc)
        ->where('cdx_UltOpcAcred', '>=', '5')
        ->where('cdx_UltOpcAcred', '<', '6')
        ->count();

        $nivelaciones = $nivelacionesOrdinario + $nivelacionesRepe + $nivelacionesEspecial;

        if ($especiales > 0 || $nivelaciones >= 10 || $repeticiones > 2)
            return "CirculoRojo";
        elseif ($repeticiones <= 2 && ($nivelaciones >= 3 && $nivelaciones <10))
            return "CirculoNaranja";
        elseif ($nivelaciones > 1 && $nivelaciones <=5)
            return "CirculoAmarillo";
        elseif ($nivelaciones <= 1)
            return "CirculoVerde";
        else
            return "CirculoNegro";
    }

    public function ficha($nc)
    {
        try {
            $alu = Alumno::where('no_control',$nc)->first();
            $alu1 = DB::connection('contEsc')->table('alumnos')->where('alu_NumControl', $nc)->first(); 
            $car = DB::connection('contEsc')->table('carreras')->where('car_Clave', $alu1->car_Clave)->first();
            $alu2 = DB::connection('contEsc')->table('alumcom')->where('alu_NumControl', $alu1->alu_NumControl)->first();
    
            $clinicos = Historial_clinico::where('id_alu', $alu->id)->first();
    
            $dPad = Padres::where('id_alu', $alu->id)->where('parentesco', 'Padre')->first();
            $dMad = Padres::where('id_alu', $alu->id)->where('parentesco', 'Madre')->first();
            if($dPad!=null && $dMad!=Null)
            {
                $direccion = Direccion::where('id_alu', $alu->id)->first();
                $direccionP = Direccion::where('id_fam', $dPad->id)->first();
                $direccionM = Direccion::where('id_fam', $dMad->id)->first();
        
                $familiares = Familiar::where('id_alu', $alu->id)->get();
        
                $person = Personales::where('id_alu', $alu->id)->first();
                $fam = Datos_familiares::where('id_alu', $alu->id)->first();
                $soc = Social::where('id_alu', $alu->id)->first();
            
                return view('sta.analisis_alumnos.ficha', compact('familiares', 'alu1', 'alu2', 'car', 'dPad', 'dMad', 'direccion', 'direccionP', 'direccionM', 'soc', 'alu',  'clinicos', 'person', 'fam'));
            }    
            else
            {
                Alert::error('Error', 'Este alumno no ha llenado su ficha académica');
                return redirect()->route('analisis.index');
            }                         
        
        } catch (Exception $e) {
            Alert::error('Error', 'A ocurrido un error: ',$e);
            return redirect()->route('analisis.index');
        }
       
    }
}
