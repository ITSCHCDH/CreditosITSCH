<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return view('sta/jefes/index')
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

        $carreras = DB::connection('contEsc')->table('carreras')->get();

        $generaciones = DB::connection('contEsc')->table('alumnos')			
			->select("alumnos.Alu_AnioIngreso")
			->orderBy('Alu_AnioIngreso', 'asc')
			->distinct()
			->get();
               
        return view('sta.jefes.index')
        ->with('grupo',$grupo)
        ->with('carreras',$carreras)
        ->with('generaciones',$generaciones)
        ->with('generacion',$request->generacion)
        ->with('carrera',$request->carrera);
    }

    public function diagnostico($id)
    {		
        $buscarAlumno = DB::connection('contEsc')->table('alumnos')
        ->join('carreras','carreras.car_Clave', '=','alumnos.car_Clave')
        ->select("alumnos.alu_NumControl",'alumnos.alu_StatusAct',"alumnos.alu_Nombre","alumnos.alu_ApePaterno","alumnos.alu_ApeMaterno","alumnos.alu_SemestreAct","carreras.car_Nombre","alumnos.alu_Sexo")
        ->where("alu_NumControl","=",$id)
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
        ->where("alumnos.alu_NumControl","=",$id)
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
        ->where('listassemestre.alu_NumControl','=',$id)
        ->DISTINCT()
        ->get();

        $GetMaxUnidad = DB::connection('contEsc')->table('listassemestre')
        ->join('listassemestrecom','listassemestrecom.lse_Clave','=','listassemestre.lse_Clave')
        ->join('grupossemestre','listassemestre.gse_Clave','=','grupossemestre.gse_Clave')
        ->join('reticula','reticula.ret_Clave','=','grupossemestre.ret_Clave')
        ->select ('listassemestrecom.lsc_NumUnidad')
        ->where('listassemestre.alu_NumControl','=',$id)
        ->DISTINCT()
        ->get();

        if(sizeof($GetMaxUnidad)>0){
            $variableCalificaciones = 'Calificaciones Parciales';
            $unidadesvariable = 'Unidades';
        }else{
            $variableCalificaciones = 'Sin calificaciones parciales';
            $unidadesvariable = 'Sin unidades vigentes';
        }


        $GetCardex = DB::connection('contEsc')->table('cardex')
        ->join('reticula','cardex.ret_Clave','=','reticula.ret_Clave')
        ->select ('cardex.cdx_AnioXPrime','reticula.ret_NomCompleto','cardex.cdx_Calif','cardex.cdx_SemXPrime','cardex.cdx_UltOpcAcred')
        ->where('cardex.alu_NumControl','=',$id)
        ->orderBy('cardex.cdx_SemXPrime', 'asc')
        ->get();


        $semaforoMedico = DB::table('psicoclin.alumnos')
        ->select('alumnos.status_medico')
        ->where('no_control','=',$id)
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
            ->where('alumnos.no_control','=',$id)
            ->get();
            if(sizeof($MSMMedico) == 0){
                $tam_msm_medico = 0;
            }

        }

        $semaforoPsicologico = DB::table('psicoclin.alumnos')
        ->select('alumnos.status_psico')
        ->where('no_control','=',$id)
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
            ->where('alumnos.no_control','=',$id)
            ->get();
            if(sizeof($MSMPsicologico) == 0){
                $tam_msm_psicologico = 0;
            }
        }


        $nivelacionesOrdinario = DB::connection('contEsc')->table("cardex")
        ->select('cardex.*')
        ->where('alu_NumControl', '=', $id)
        ->where('cdx_UltOpcAcred', '>=', '2')
        ->where('cdx_UltOpcAcred', '<', '3')
        ->count();

        $nivelacionesRepe = DB::connection('contEsc')->table("cardex")
        ->select('cardex.*')
        ->where('alu_NumControl', '=', $id)
        ->where('cdx_UltOpcAcred', '>=', '4')
        ->where('cdx_UltOpcAcred', '<', '5')
        ->count();

        $nivelacionesEspecial = DB::connection('contEsc')->table("cardex")
        ->select('cardex.*')
        ->where('alu_NumControl', '=', $id)
        ->where('cdx_UltOpcAcred', '>=', '6')
        ->count();

        $repeticiones = DB::connection('contEsc')->table("cardex")
        ->select('cardex.*')
        ->where('alu_NumControl', '=', $id)
        ->where('cdx_UltOpcAcred', '>=', '3')
        ->where('cdx_UltOpcAcred', '<', '4')
        ->count();

        $especiales = DB::connection('contEsc')->table("cardex")
        ->select('cardex.*')
        ->where('alu_NumControl', '=', $id)
        ->where('cdx_UltOpcAcred', '>=', '5')
        ->where('cdx_UltOpcAcred', '<', '6')
        ->count();

        $nivelaciones = $nivelacionesOrdinario + $nivelacionesRepe + $nivelacionesEspecial;

        $tamComentarios = 1;
        $Comentarios = DB::table('stav2.motivosreprobacion')
        ->join('stav2.alumnos','alumnos.id','=','motivosreprobacion.id_alu')
        ->select('motivosreprobacion.materia','motivosreprobacion.num_tema','motivosreprobacion.comentario','motivosreprobacion.lse_clave')
        ->where('alumnos.no_cont','=',$id)
        ->get();
        if(sizeof($Comentarios) == 0){
            $tamComentarios = 0;
        }

        return view('sta.jefes.diagnostico')        
        -> with ('alumnos',$buscarAlumno)
        -> with ('grupos',$GetGrupos)
        -> with ('tablacalificaciones',$GetTablaCalificaciones)
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
        -> with('comentarios',$Comentarios)
        -> with('tamcomentarios',$tamComentarios);				      
    }

    public function analisis($gen, $car)
    {
        dd('Si llega');
    }
}
