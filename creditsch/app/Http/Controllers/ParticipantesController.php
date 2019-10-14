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
use Illuminate\Support\Facades\Storage;

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
        if(Auth::User()->hasAnyPermission(['VIP','VIP_EVIDENCIA','VIP_SOLO_LECTURA','VIP_ACTIVIDAD'])){
            //Consultamos todas las actividades disponibles
            $actividades = Actividad::select('id','nombre')->orderBy('nombre','ASC')->pluck('nombre','id');
            //Retorna la vista de Agregar participantes
            return view('admin.participantes.index')
            ->with('actividades',$actividades);
        }else if(Auth::User()->hasAnyPermission(['CREAR_ACTIVIDAD','VER_ACTIVIDAD'])){
            //Consultamos todas las actividades disponibles
            $actividades = DB::table('users as u')->join('actividad_evidencia as ae', function($join){
                $join->on('ae.user_id','=','u.id');
            })->join('actividad as a','a.id','=','ae.actividad_id')->where('u.id','=',Auth::User()->id)->orwhere('a.id_user','=',Auth::User()->id)->select('a.id','a.nombre')->orderBy('nombre','ASC')->pluck('nombre','id');
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

    public function eliminarEvidenciasAlumno($no_control, $actividad_evidencia_id, $actividad_nombre){
        $evidencias = DB::table('evidencia')->where([
            ['id_asig_actividades','=',$actividad_evidencia_id],
            ['alumno_no_control','=',$no_control]
        ])->select('nom_imagen')->get();
        foreach($evidencias as $evidencia){
            Storage::delete('public/evidencias/'.$actividad_nombre.'/'.$evidencia->nom_imagen);
            Evidencia::where([
                ['id_asig_actividades','=',$actividad_evidencia_id],
                ['alumno_no_control','=',$no_control]
            ])->delete();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Validamos que el participante exista
        if(Participante::find($id) == null){
            return response()->json(array('mensaje' => 'El participante que estas buscando no existe', 'mensaje_tipo' => 'error'));
        }
        // Validamos que el credito siga vigente para realizar modificaciones
        $credito_vigente = DB::table('participantes as p')->join('actividad_evidencia as ae', function($join) use($id){
            $join->on('ae.id','=','p.id_evidencia');
            $join->where('p.id','=',$id);
        })->join('actividad as a','a.id','=','ae.actividad_id')->join('creditos as c','c.id','=','a.id_actividad')->where('c.vigente','=','true')->get()->count()>0?true: false;
        if(!$credito_vigente){
            return response()->json(array("mensaje" => "El crédito actualmente ya no esta vigente","mensaje_tipo" => "error"));
        }
        $actividad_data = DB::table('participantes as p')->join('actividad_evidencia as ae', function($join) use($id){
            $join->on('p.id','=',DB::raw($id));
            $join->on('ae.id','=','p.id_evidencia');
        })->join('actividad as act','act.id','=','ae.actividad_id')->select('act.id as actividad_id','act.alumnos as evidencia_individual','ae.id as ae_id','p.no_control as no_control','act.nombre as actividad_nombre')->get()[0];
        if (Auth::User()->hasAnyPermission(['VIP'])) {
            // Consulta para saber si la actividad ya ha sido validada
            $participante_data = DB::table('participantes as p')->join('actividad_evidencia as ae','p.id_evidencia','=','ae.id')->join('evidencia as e','e.id_asig_actividades','=','ae.id')->join('actividad as a','a.id','=','ae.actividad_id')->join('creditos as c','c.id','=','a.id_actividad')->where([
                ['ae.validado','=','true'],
                ['p.id','=',$id]
            ])->select('p.no_control','c.id as credito_id','a.por_cred_actividad')->groupBy('p.id')->get();
            // Si la actividad ya ha sido validada descontamos el porcentaje de avance del crédito correspondiente al participante en cuestión
            if($participante_data->count()>0){
                $temp = Avance::where([
                    ['no_control','=',$participante_data[0]->no_control],
                    ['id_credito','=',$participante_data[0]->credito_id]
                ])->get();
                if($temp->count() > 0){
                    $avance = Avance::find($temp[0]->id);
                    $avance->por_credito -= (int)$participante_data[0]->por_cred_actividad;
                    if($avance->por_credito<0)$avance->por_credito=0;
                    $avance->save();
                }
                // La function liberar cambia es estado del alumno (parámetro: no_control) segun su avance
                // Si el participante ya cuenta con sus 5 créditos liberados pasa a estado "Liberado"
                // en caso contratio a "Pendiente"
                $this->liberar($participante_data[0]->no_control);
            }
            // Eliminamos al participante
            Participante::destroy($id);
            if($actividad_data->evidencia_individual == 'true'){
                // Eliminamos todas las evidencias que haya subido el participante
                $this->eliminarEvidenciasAlumno($actividad_data->no_control, $actividad_data->ae_id, $actividad_data->actividad_nombre);
            }
            return response()->json(array("mensaje" => "El participante ha sido eliminado de la actividad","mensaje_tipo" => "advertencia"));
        }if(Auth::User()->can('ELIMINAR_PARTICIPANTES')){
            // Consulta para saber si el participante a eliminar, pertenece a la actividad del responsable
            $participante_ajeno = DB::table('participantes as p')->join('actividad_evidencia as ae', function($join) use($id){
                $join->on('ae.id','=','p.id_evidencia');
                $join->where('p.id','=',$id);
                $join->where('ae.user_id','<>',Auth::User()->id);
            })->get()->count()>0? true: false;
            // Validamos que el respondable no intente eliminar participantes de otras actividades ajenas
            if($participante_ajeno){
                return response()->json(array('mensaje' => 'Este participante no pertenece a tu actividad','mensaje_tipo' => 'error'));
            }
            // Consulta para saber si la evidencia ya ha sido validada
            $evidencia_validada = DB::table('participantes as p')->join('actividad_evidencia as ae', function($join) use($id){
                $join->on('ae.id','=','p.id_evidencia');
                $join->where('p.id','=',$id);
                $join->where('ae.validado','=','true');
            })->get()->count()>0?true: false;

            if($evidencia_validada){
                return response()->json(array('mensaje' => 'La actividad ya ha sido validada, ya no puede recibir modificaciones','mensaje_tipo' => 'error'));
            }else{
                // Eliminamos al participante
                Participante::destroy($id);
                if($actividad_data->evidencia_individual == 'true'){
                    // Eliminamos todas la evidencias que haya subido el participante
                    $this->eliminarEvidenciasAlumno($actividad_data->no_control, $actividad_data->ae_id, $actividad_data->actividad_nombre);
                }
                return response()->json(array("mensaje" => "El participante ha sido eliminado de la actividad","mensaje_tipo" => "advertencia"));
            }
        }else{
            return response()->json(array("mensaje" => "No puedes eliminar participantes de esta actividad","mensaje_tipo" => "advertencia"));
        }
        
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
        })->select('ae.validador_id as validador_id')->get();
        $dommie = [['id'=> -1]];
        $id_actividad_evidencia = DB::table('actividad_evidencia as ae')->select('ae.id','ae.validado','ae.user_id','ae.validador_id')->where([
            ['ae.user_id','=',$request->id_responsable],
            ['ae.actividad_id','=',$request->id_actividad],
        ])->get();
        if($id_actividad_evidencia->count()==0){
            return response()->json(array('participantes_data' => $dommie,'no_evidencias' => $evidencias->count(),'validado' => 'false'));
        }
        //La variable participante_data guarda los participante vinculado a una evidencia
        $participantes_data = DB::table('participantes as p')->join('alumnos as a','a.no_control','=','p.no_control')->join('areas','areas.id','=','a.carrera')->where('p.id_evidencia','=',$id_actividad_evidencia[0]->id)->select('a.nombre','areas.nombre as carrera','p.id','p.id_evidencia','a.no_control')->get();
        if($participantes_data->count()==0){
            //En caso de que la actividad aun no cuente con participantes retornara -1
            return response()->json(array('participantes_data' => $dommie,'no_evidencias' => $evidencias->count(),'validado' => $id_actividad_evidencia[0]->validado,'user_id' => $id_actividad_evidencia[0]->user_id));
        }
        //Retornamos los datos un json
        return response()->json(array('participantes_data' => $participantes_data,'no_evidencias' => $evidencias->count(),'validador_id' => $id_actividad_evidencia[0]->validador_id,'validado' => $id_actividad_evidencia[0]->validado,'user_id' => $id_actividad_evidencia[0]->user_id));
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
            $actividad = Actividad::find($request->get('id'));

            if($actividad->id_user==Auth::User()->id){
                //Consultamos todos los responsables asignadoas a una actividad
                $evidencias = DB::table('actividad_evidencia as ae')->join('evidencia as e',function($join) use($request){
                    $join->on('e.id_asig_actividades','=','ae.id');
                    $join->where('ae.actividad_id','=',$request->get('id'));
                })->get();
                $responsables = DB::table('actividad_evidencia as ae')->join('users as u','u.id','ae.user_id')->where('ae.actividad_id','=',$request->get('id'))->select('u.id','u.name')->orderBy('u.name')->get();
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
                //Retornamos los responsables en un json
                return response()->json(array('responsables' => $responsables,'actividad' => $actividad,'no_evidencias' => $evidencias->count()));
            }  
        }
    }

    public function ajaxGuardar(Request $request){
        $evidencias = DB::table('actividad_evidencia as ae')->where([
            ['ae.user_id','=',$request->get('id_responsable')],
            ['ae.actividad_id','=',$request->get('id_actividad')]
        ])->select('ae.id')->get();
        if($evidencias->count()==0){
            return response()->json(array('mensaje' => 'Algun error ocurrió durante el proceso','mensaje_tipo' => 'error'));
        }
        $credito_vigente = DB::table('actividad as a')->join('creditos as c','c.id','=','a.id_actividad')->where([
            ['a.id','=',$request->get('id_actividad')],
            ['c.vigente','=','true']
        ])->get()->count()>0? true: false;

        if(!$credito_vigente){
            return response()->json(array('mensaje' => 'El crédito actualmente ya no esta vigente, por lo que no puede ser modificado', 'mensaje_tipo' => 'error'));
        }
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
        $actividad = Actividad::find($request->get('id_actividad'));
        if($actividad->vigente == 'false'){
            return response()->json(array('mensaje' => 'La actividad '.$actividad->nombre.' ya no se encuentra vigente','mensaje_tipo' => 'error' ));
        }
        if($validado->validado == 'true' && $actividad->alumnos == 'true'){
            return response()->json(array('mensaje' => 'La actividad '.$actividad->nombre.' ya no puede ser modificada al estar validada y ser exclusiva para alumnos','mensaje_tipo' => 'error' ));
        }
        if(Auth::User()->hasAnyPermission('VIP')){
            if($validado->validado=='true'){
                $temp = Avance::where([
                    ['no_control','=',$request->get('no_control')],
                    ['id_credito','=',$actividad->id_actividad]
                ])->get();
                if($temp->count()==0){
                    $avance = new Avance();
                    $avance->no_control = $request->get('no_control');
                    $avance->por_credito = (int)$actividad->por_cred_actividad;
                    $avance->id_credito=$actividad->id_actividad;
                    $avance->save();
                }else{
                    $avance = Avance::find($temp[0]->id);
                    $avance->por_credito += (int)$actividad->por_cred_actividad;
                    $avance->save();
                }
            }else{
                $temp = Avance::where([
                    ['no_control','=',$request->get('no_control')],
                    ['id_credito','=',$actividad->id_actividad]
                ])->get();
                if($temp->count()==0){
                    $avance = new Avance();
                    $avance->no_control = $request->get('no_control');
                    $avance->por_credito = 0;
                    $avance->id_credito=$actividad->id_actividad;
                    $avance->save();
                }
            }

            $participante = new Participante();
            $participante->no_control = $request->get('no_control');
            $participante->id_evidencia = $evidencias[0]->id;
            $participante->save();
            $this->liberar($request->get('no_control'));
            return response()->json(array('mensaje' => 'Participante agregado correctamente','mensaje_tipo' => 'exito' ));
        }else{
            if($validado->validado!='false'){
                return response()->json(array('mensaje' => 'Ya no se pueden agregar participantes','mensaje_tipo' => 'error' ));
            }
            $participante = new Participante();
            $participante->no_control = $request->get('no_control');
            $participante->id_evidencia = $evidencias[0]->id;
            $participante->save();
            return response()->json(array('mensaje' => 'Participante agregado correctamente','mensaje_tipo' => 'exito' ));
        }
        
       
    }
        
    public function liberar($no_control){
        $avance = Avance::where('no_control','=',$no_control)->get();
        $creditos = 0;
        for($i = 0; $i<count($avance); ++$i){
            if($avance[$i]->por_credito >= 100) ++$creditos;
        }
        if($creditos >= 5){
            $alumno = Alumno::where('no_control','=',$no_control)->get()[0];
            $alumno->status = "Liberado";
            $alumno->save();
        }else{
            $alumno = Alumno::where('no_control','=',$no_control)->get()[0];
            $alumno->status = "Pendiente";
            $alumno->save();
        }
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
