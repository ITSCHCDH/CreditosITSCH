<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Participante; //Es el nombre del modelo con el que va a trabajar el controlador
use Laracasts\Flash\Flash; //Es el paquete para poder usar los mensajes de alerta tipo bootstrap
use App\Actividad;
use App\Evidencia;
use App\Avance;
use App\Alumno;
use App\Actividad_Evidencia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ParticipantesController extends Controller
{

    public function __construct(){
        $this->middleware('permission:VIP|VIP_SOLO_LECTURA|AGREGAR_PARTICIPANTES|ELIMINAR_PARTICIPANTES|VER_PARTICIPANTES')->only(['index','create','store','show','edit','update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if(Auth::User()->hasAnyPermission(['VIP','VIP_EVIDENCIA','VIP_SOLO_LECTURA'])){
            //Consultamos todas las actividades disponibles
            $actividades = Actividad::select('id','nombre')->orderBy('nombre','ASC')->pluck('nombre','id');
            //Retorna la vista de Agregar participantes
            return view('admin.participantes.index')
            ->with('actividades',$actividades);
        }else{
            //Consultamos todas las actividades disponibles
            $actividades = DB::table('users as u')->join('actividad_evidencia as ae', function($join){
                $join->on('ae.user_id','=','u.id');
                $join->where('u.id','=',Auth::User()->id);
            })->join('actividad as a','a.id','=','ae.actividad_id')->select('a.id','a.nombre')->orderBy('nombre','ASC')->pluck('nombre','id');
            //Retorna la vista de Agregar participantes
            return view('admin.participantes.index')
            ->with('actividades',$actividades);
        }
        
    }

    /** 
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $participante_data = DB::table('participantes as p')->join('actividad_evidencia as ae','p.id_evidencia','=','ae.id')->join('evidencia as e','e.id_asig_actividades','=','ae.id')->join('actividad as a','a.id','=','ae.actividad_id')->join('creditos as c','c.id','=','a.id_actividad')->where([
            ['ae.validado','=','true'],
            ['p.id','=',$id]
        ])->select('p.no_control','c.id as credito_id','a.por_cred_actividad')->groupBy('p.id')->get();
        if($participante_data->count()>0){
           $temp = Avance::where([
               ['no_control','=',$participante_data[0]->no_control],
               ['id_credito','=',$participante_data[0]->credito_id]
           ])->get();
           if($temp->count()>0){
               $avance = Avance::find($temp[0]->id);
               $avance->por_credito -= (int)$participante_data[0]->por_cred_actividad;
               if($avance->por_credito<0)$avance->por_credito=0;
               $avance->save();
           } 
        }
        Participante::destroy($id);
        return response()->json(array("mensaje" => "El participante ha sido eliminado de la actividad","mensaje_tipo" => "advertencia"));
    }
    public function peticionAjax(Request $request){
        /*
            En esta funcion se realiza la consulta de los participantes relacionados a una evidencia
        */
        ///Retorna -1 en caso de que uno de los id recibidos por la ajax sono sean validos

        $evidencias = DB::table('actividad_evidencia as ae')->join('evidencia as e', function($join) use($request){
            $join->on('e.id_asig_actividades','=','ae.id');
            $join->where('ae.user_id','=',$request->get('id_responsable'));
            $join->where('ae.actividad_id','=',$request->get('id_actividad'));
        })->get();
        $dommie = [['id'=> -1]];
        $id_actividad_evidencia = DB::table('actividad_evidencia as ae')->select('ae.id','ae.validado','ae.user_id')->where([
            ['ae.user_id','=',$request->id_responsable],
            ['ae.actividad_id','=',$request->id_actividad],
        ])->get();
        if($id_actividad_evidencia->count()==0){
            return response()->json(array('participantes_data' => $dommie,'no_evidencias' => $evidencias->count(),'validado' => 'false'));
        }
        //La variable participante_data guarda los participante vinculado a una evidencia
        $participantes_data = DB::table('participantes as p')->join('alumnos as a','a.no_control','=','p.no_control')->where('p.id_evidencia','=',$id_actividad_evidencia[0]->id)->select('a.nombre','a.carrera','p.id','p.id_evidencia','a.no_control')->get();
        if($participantes_data->count()==0){
            //En caso de que la actividad aun no cuente con participantes retornara -1
            return response()->json(array('participantes_data' => $dommie,'no_evidencias' => $evidencias->count(),'validado' => $id_actividad_evidencia[0]->validado,'user_id' => $id_actividad_evidencia[0]->user_id));
        }
        //Retornamos los datos un json
        return response()->json(array('participantes_data' => $participantes_data,'no_evidencias' => $evidencias->count(),'validado' => $id_actividad_evidencia[0]->validado,'user_id' => $id_actividad_evidencia[0]->user_id));
    }

    public function peticionAjaxResponsables(Request $request){
        if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VIP_EVIDENCIA'])) {
            //Consultamos todos los responsables asignadoas a una actividad
            $evidencias = DB::table('actividad_evidencia as ae')->join('evidencia as e',function($join) use($request){
                $join->on('e.id_asig_actividades','=','ae.id');
                $join->where('ae.actividad_id','=',$request->get('id'));
            })->get();
            $responsables = DB::table('actividad_evidencia as ae')->join('users as u','u.id','ae.user_id')->where('ae.actividad_id','=',$request->get('id'))->select('u.id','u.name')->orderBy('u.name')->get();
            $actividad = Actividad::find($request->get('id'));
            //Retornamos los responsables en un json
            return response()->json(array('responsables' => $responsables,'actividad' => $actividad,'no_evidencias' => $evidencias->count()));   
        }else{
            //Consultamos todos los responsables asignadoas a una actividad
            $evidencias = DB::table('actividad_evidencia as ae')->join('evidencia as e',function($join) use($request){
                $join->on('e.id_asig_actividades','=','ae.id');
                $join->where('ae.actividad_id','=',$request->get('id'));
                $join->where('ae.user_id','=',Auth::User()->id);
            })->get();
            $responsables = DB::table('actividad_evidencia as ae')->join('users as u','u.id','ae.user_id')->where('ae.actividad_id','=',$request->get('id'))->where('ae.user_id','=',Auth::User()->id)->select('u.id','u.name')->orderBy('u.name')->get();
            $actividad = Actividad::find($request->get('id'));
            //Retornamos los responsables en un json
            return response()->json(array('responsables' => $responsables,'actividad' => $actividad,'no_evidencias' => $evidencias->count()));
        }
    }

    public function ajaxGuardar(Request $request){
        
        $evidencias = DB::table('actividad_evidencia as ae')->where([
            ['ae.user_id','=',$request->get('id_responsable')],
            ['ae.actividad_id','=',$request->get('id_actividad')]
        ])->select('ae.id')->get();

        if($evidencias)
        $existe_no_control = DB::table('alumnos')->select('no_control')->where('no_control','=',$request->get('no_control'))->get();

        if($existe_no_control->count()==0){
            return response()->json(array('mensaje' => 'El numero de control no exite','mensaje_tipo' => 'error' ));
        }
        
        $participante_duplicado = DB::table('participantes')->select('no_control')->where([
            ['no_control','=',$request->get('no_control')],
            ['id_evidencia','=',$evidencias[0]->id]
        ])->get();
        if($participante_duplicado->count()>0){
            return response()->json(array('mensaje' => 'El participante actualmente ya se encuentra agregado','mensaje_tipo' => 'error' ));
        }
        //Consulta para saber si el participante esta ya esta en la misma actividad pero con otro responsable
        $participante_otra_actividad = DB::table('participantes as p')->join('actividad_evidencia as ae', function($join) use($request){
            $join->on('p.id_evidencia','=','ae.id');
            $join->where('p.no_control','=',$request->get('no_control'));
            $join->where('ae.actividad_id','=',$request->get('id_actividad'));
        })->get();
        //Validamos si el participante esta ya esta en la misma actividad pero con otro responsable
        if($participante_otra_actividad->count()>0){
            return response()->json(array('mensaje' => 'El participante ya esta registrado en esta actividad solo que con otro responsable','mensaje_tipo' => 'error' ));
        }

        $validado = Actividad_Evidencia::find($evidencias[0]->id);
        $evidencia_data = Actividad::find($request->get('id_actividad'))->select('por_cred_actividad','id_actividad as credito_id')->get();
        if($validado->validado=='true'){
            $temp = Avance::where([
                ['no_control','=',$request->get('no_control')],
                ['id_credito','=',$evidencia_data[0]->credito_id]
            ])->get();
            if($temp->count()==0){
                $avance = new Avance();
                $avance->no_control = $request->get('no_control');
                $avance->por_credito = (int)$evidencia_data->por_cred_actividad;
                $avance->id_credito=$evidencia_data[0]->credito_id;
                $avance->save();
            }else{
                $avance = Avance::find($temp[0]->id);
                $avance->por_credito += (int)$evidencia_data[0]->por_cred_actividad;
                $avance->save();
            }
        }else{
            $temp = Avance::where([
                ['no_control','=',$request->get('no_control')],
                ['id_credito','=',$evidencia_data[0]->credito_id]
            ])->get();
            if($temp->count()==0){
                $avance = new Avance();
                $avance->no_control = $request->get('no_control');
                $avance->por_credito = 0;
                $avance->id_credito=$evidencia_data[0]->credito_id;
                $avance->save();
            }else{
                $avance = Avance::find($temp[0]->id);
                $avance->por_credito += (int)$evidencia_data[0]->por_cred_actividad;
                $avance->save();
            }
        }
        $participante = new Participante();
        $participante->no_control = $request->get('no_control');
        $participante->id_evidencia = $evidencias[0]->id;
        $participante->save();
        return response()->json(array('mensaje' => 'Participante agregado correctamente','mensaje_tipo' => 'exito' ));
    }

    public function participantesBusqueda(Request $request){
        if($request->peticion == 0){
            $lista_alumnos = Alumno::select('nombre','no_control')->where('nombre','like',"%$request->nombre%")->orderBy('nombre')->get();
        }else{
            $lista_alumnos = Alumno::select('nombre')->where('no_control','=',$request->no_control)->get();
        }
        return response()->json($lista_alumnos);
    }
}
