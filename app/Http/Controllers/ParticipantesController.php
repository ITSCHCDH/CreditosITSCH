<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participante; //Es el nombre del modelo con el que va a trabajar el controlador
use App\Models\Actividad;
use App\Models\Evidencia;
use App\Models\Avance;
use App\Models\Alumno;
use App\Models\Actividad_Evidencia;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Alert;

class ParticipantesController extends Controller
{

    public function __construct(){
        $this->middleware('permission:VIP_SOLO_LECTURA|VIP|VER_PARTICIPANTES')->only(['index','peticionAjax']);
        $this->middleware('permission:VIP|AGREGAR_PARTICIPANTES|ELIMINAR_PARTICIPANTES')->only(['destroy','ajaxGuardar','create','store','show','edit','update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $actividades_link = 'false';
        if($request->has('actividades_link') && $request->actividades_link == 'true'){
            $actividades_link = 'true';
        }
        if(Auth::User()->hasAnyPermission(['VIP','VIP_EVIDENCIA','VIP_SOLO_LECTURA','VIP_ACTIVIDAD']))
        {
            //Consultamos todas las actividades disponibles
            $actividades = Actividad::select('id','nombre')->orderBy('nombre','ASC')->get();
        }
        else if(Auth::User()->hasAnyPermission(['CREAR_ACTIVIDAD','VER_ACTIVIDAD']))
        {
            //Consultamos todas las actividades disponibles
            $actividades = DB::table('users as u')
                ->join('actividad_evidencia as ae', function($join){
                    $join->on('ae.user_id','=','u.id');
                })
                ->join('actividad as a','a.id','=','ae.actividad_id')
                ->where('u.id','=',Auth::User()->id)
                ->orWhere('a.id_user','=',Auth::User()->id)
                ->select('a.id','a.nombre')
                ->orderBy('nombre','ASC')
                ->groupBy('a.id')
                ->get();
        }
        else
        {
            //Consultamos todas las actividades disponibles
            $actividades = DB::table('users as u')
                ->join('actividad_evidencia as ae', function($join){
                    $join->on('ae.user_id','=','u.id');
                    $join->where('u.id','=',Auth::User()->id);
                })
                ->join('actividad as a','a.id','=','ae.actividad_id')
                ->select('a.id','a.nombre')
                ->orderBy('nombre','ASC')
                ->get();
        }
        //Retorna la vista de Agregar participantes
        return view('admin.participantes.index')
        ->with('actividades',$actividades)
        ->with('actividades_link',$actividades_link);
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
        })->join('actividad as act','act.id','=','ae.actividad_id')->select('act.id as actividad_id','act.alumnos as evidencia_individual','act.vigente','ae.id as ae_id','p.no_control as no_control','act.nombre as actividad_nombre')->get()[0];
        if($actividad_data->vigente == 'false'){
            return response()->json(array('mensaje' => 'La actividad ya no es vigente, no puede ser modificada','mensaje_tipo' => 'error'));
        }
        if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD'])) {
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
            $participante_ajeno = DB::table('participantes as p')
            ->join('actividad_evidencia as ae', function($join) use($id){
                $join->on('ae.id','=','p.id_evidencia');
                $join->where('p.id','=',$id);
                $join->where('ae.user_id','<>',Auth::User()->id);
            })->get();
            // Varible boleana para saber si el usuario actual es quien creo la actividad
            $es_creador_actividad = DB::table('participantes as p')
            ->join('actividad_evidencia as ae', function($join) use($id){
                $join->on('ae.id','=','p.id_evidencia');
                $join->where('p.id','=',$id);
            })->select('ae.validador_id')->get()[0]->validador_id == Auth::User()->id;

            // Validamos que el respondable no intente eliminar participantes de otras actividades ajenas
            if($participante_ajeno->count() > 0 && !$es_creador_actividad){
                return response()->json(array('mensaje' => 'Este participante no pertenece a tu actividad','mensaje_tipo' => 'error'));
            }
            // Consulta para saber si la evidencia ya ha sido validada
            $participante = Participante::find($id);
            $actividad_evidencia = DB::table('participantes as p')->join('actividad_evidencia as ae', function($join){
                $join->on('ae.id','=','p.id_evidencia');
            })->join('actividad as act','act.id','=','ae.actividad_id')
            ->where('p.id','=',$participante->id)->select('ae.actividad_id','ae.validado','act.alumnos as alumnos_responsables')->get()[0];

            if(!$es_creador_actividad && $actividad_evidencia->alumnos_responsables == "false" && $actividad_evidencia->validado == "true"){
                return response()->json(array('mensaje' => 'La actividad ya ha sido validada, ya no puede recibir modificaciones','mensaje_tipo' => 'error'));
            }else if(!$es_creador_actividad && $actividad_evidencia->alumnos_responsables == "true" && $actividad_evidencia->validado == "true" && ($participante->evidencia_validada == "si" || $participante->evidencia_validada == "na")){
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
        if($id_actividad_evidencia->count() == 0){
            return response()->json(array('participantes_data' => $dommie,'no_evidencias' => $evidencias->count(),'validado' => 'false','actividad_id' => $request->get('id_actividad'),'responsable_id' => $request->get('id_responsable')));
        }
        //La variable participante_data guarda los participante vinculado a una evidencia
        $participantes_data = DB::table('participantes as p')
        ->join('alumnos as a','a.no_control','=','p.no_control')
        ->join('areas','areas.id','=','a.carrera')
        ->leftJoin('evidencia as e', function ($join) use($id_actividad_evidencia){
            $join->on('e.alumno_no_control','=','p.no_control');
            $join->on('e.id_asig_actividades','=',DB::raw($id_actividad_evidencia[0]->id));
        })
        ->where('p.id_evidencia','=',$id_actividad_evidencia[0]->id)
        ->select('a.nombre','areas.nombre as carrera','p.id','p.id_evidencia','a.no_control','e.alumno_no_control as tiene_evidencia','p.momento_agregado','p.evidencia_validada')->groupBy('p.no_control')->get();
        if($participantes_data->count() == 0){
            //En caso de que la actividad aun no cuente con participantes retornara -1
            return response()->json(array('participantes_data' => $dommie,'no_evidencias' => $evidencias->count(),'validado' => $id_actividad_evidencia[0]->validado,'user_id' => $id_actividad_evidencia[0]->user_id,'actividad_id' => $request->get('id_actividad'),'responsable_id' => $request->get('id_responsable')));
        }
        //Retornamos los datos un json
        return response()->json(array('participantes_data' => $participantes_data,'no_evidencias' => $evidencias->count(),'validador_id' => $id_actividad_evidencia[0]->validador_id,'validado' => $id_actividad_evidencia[0]->validado,'user_id' => $id_actividad_evidencia[0]->user_id,'actividad_id' => $request->get('id_actividad'),'responsable_id' => $request->get('id_responsable')));
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

        $actividad = Actividad::find($request->get('id_actividad'));
        // Validamos que la actividad exista
        if($actividad == null){
            return response()->json(array('mensaje' => 'La actividad no existe', 'mensaje_tipo' => 'error'));
        }
        $es_creador_actividad = $actividad->id_user == Auth::User()->id;
        // Validamos que la actividad este vigente
        if($actividad->vigente == 'false'){
            return response()->json(array('mensaje' => 'La actividad ya no se encuentra vigente, no puede ser modificada','mensaje_tipo' => 'error'));
        }

        $evidencias = DB::table('actividad_evidencia as ae')->where([
            ['ae.user_id','=',$request->get('id_responsable')],
            ['ae.actividad_id','=',$request->get('id_actividad')]
        ])->select('ae.id','ae.validado')->get();
        if($evidencias->count()==0){
            return response()->json(array('mensaje' => 'Algun error ocurrió durante el proceso','mensaje_tipo' => 'error'));
        }
        // Validamos que el crédito este vigente
        $credito_vigente = DB::table('actividad as a')->join('creditos as c','c.id','=','a.id_actividad')->where([
            ['a.id','=',$request->get('id_actividad')],
            ['c.vigente','=','true']
        ])->get()->count()>0? true: false;

        if(!$credito_vigente){
            return response()->json(array('mensaje' => 'El crédito actualmente ya no esta vigente, por lo que no puede ser modificado', 'mensaje_tipo' => 'error'));
        }
        // Validamos que el número de contro exista
        $existe_no_control = DB::table('alumnos')->select('no_control')->where('no_control','=',$request->get('no_control'))->get();

        if($existe_no_control->count()==0){
            return response()->json(array('mensaje' => 'El numero de control no exite','mensaje_tipo' => 'error' ));
        }
        // Validamos que el participane no este agreagado en la misma actividad solo que con otro responsable
        $participante_duplicado = DB::table('participantes')->select('no_control')->where([
            ['no_control','=',$request->get('no_control')],
            ['id_evidencia','=',$evidencias[0]->id]
        ])->get();
        if($participante_duplicado->count()>0){
            return response()->json(array('mensaje' => 'El participante actualmente ya se encuentra agregado','mensaje_tipo' => 'error' ));
        }
        // Consulta para saber si el participante esta ya esta en la misma actividad pero con otro responsable
        $participante_otra_actividad = DB::table('participantes as p')->join('actividad_evidencia as ae', function($join) use($request){
            $join->on('p.id_evidencia','=','ae.id');
            $join->where('p.no_control','=',$request->get('no_control'));
            $join->where('ae.actividad_id','=',$request->get('id_actividad'));
        })->get();
        // Validamos si el participante esta ya esta en la misma actividad pero con otro responsable
        if($participante_otra_actividad->count()>0){
            return response()->json(array('mensaje' => 'El participante ya esta registrado en esta actividad solo que con otro responsable','mensaje_tipo' => 'error' ));
        }
        if($actividad->vigente == 'false'){
            return response()->json(array('mensaje' => 'La actividad '.$actividad->nombre.' ya no se encuentra vigente','mensaje_tipo' => 'error' ));
        }
        if($evidencias[0]->validado == 'true' && $actividad->alumnos == 'true' && (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD']) || $es_creador_actividad)){
            $tiene_avance = Avance::where([
                ['no_control','=',$request->get('no_control')],
                ['id_credito','=',$actividad->id_actividad]
            ])->get();
            if($tiene_avance->count() == 0){
                $avance = new Avance();
                $avance->no_control = $request->get('no_control');
                $avance->por_credito = 0;
                $avance->id_credito=$actividad->id_actividad;
                $avance->save();
            }
            $participante = new Participante();
            $participante->no_control = $request->get('no_control');
            $participante->id_evidencia = $evidencias[0]->id;
            $participante->momento_agregado = 'posteriormente';
            $participante->evidencia_validada = 'no';
            $participante->save();
            return response()->json(array('mensaje' => 'Participante agregado correctamente','mensaje_tipo' => 'exito' ));
        }else{
            if(Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD']) || $es_creador_actividad){
                if($evidencias[0]->validado == 'true'){
                    $tiene_avance = Avance::where([
                        ['no_control','=',$request->get('no_control')],
                        ['id_credito','=',$actividad->id_actividad]
                    ])->get();
                    if($tiene_avance->count() == 0){
                        $avance = new Avance();
                        $avance->no_control = $request->get('no_control');
                        $avance->por_credito = (int)$actividad->por_cred_actividad;
                        $avance->id_credito=$actividad->id_actividad;
                        $avance->save();
                    }else{
                        $avance = Avance::find($tiene_avance[0]->id);
                        $avance->por_credito += (int)$actividad->por_cred_actividad;
                        $avance->save();
                    }
                }else{
                    $tiene_avance = Avance::where([
                        ['no_control','=',$request->get('no_control')],
                        ['id_credito','=',$actividad->id_actividad]
                    ])->get();
                    if($tiene_avance->count() == 0){
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
                if($evidencias[0]->validado == 'true'){
                    return response()->json(array('mensaje' => 'La actividad ya ha sido validada','mensaje_tipo' => 'error' ));
                }
                if(Auth::User()->id == $actividad->id_user || Auth::User()->id == $request->get('id_responsable')){
                    $participante = new Participante();
                    $participante->no_control = $request->get('no_control');
                    $participante->id_evidencia = $evidencias[0]->id;
                    $participante->save();
                    return response()->json(array('mensaje' => 'Participante agregado correctamente','mensaje_tipo' => 'exito' ));
                }
                return response()->json(array('mensaje' => 'No estas autorizado para realizar las modificaciones que solicitas','mensaje_tipo' => 'error' ));
            }
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

    public function verEvidencia(Request $request){
        if(!$request->has('id') || !$request->has('actividad_id') || !$request->has('responsable_id'))
            return redirect()->route('participantes.index');
        $actividad = Actividad::find($request->actividad_id);
        $responsable = User::find($request->responsable_id);
        $participante = Participante::find($request->id);
        if($participante == null || $responsable == null || $actividad == null)
            return redirect()->route('participantes.index');
        if(Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VIP_EVIDENCIA','VIP_ACTIVIDAD']) || Auth::User()->id == $request->responsable_id || Auth::User()->id == $actividad->id_user){
            $evidencias = DB::table('actividad_evidencia as ae')->join('evidencia as e', function($join) use($request,$participante){
                $join->on('e.id_asig_actividades','=','ae.id');
                $join->where('ae.user_id','=',$request->responsable_id);
                $join->where('ae.actividad_id','=',$request->actividad_id);
                $join->where('e.alumno_no_control','=',$participante->no_control);
            })->join('actividad as a','a.id','=','ae.actividad_id')->join('users as u','u.id','=','ae.user_id')->select('a.nombre as actividad_nombre','a.id as actividad_id','e.nom_imagen as evidencia_nombre','ae.user_id','e.created_at as fecha','e.id as evidencia_id','u.name as usuario_nombre')->get();
            $actividad = Actividad::find($request->actividad_id);
            $actividad_evidencia = DB::table('actividad_evidencia as ae')->join('participantes as p','p.id_evidencia','=','ae.id')->where([
                ['p.no_control','=',$participante->no_control],
                ['ae.user_id','=',$request->responsable_id],
                ['ae.actividad_id','=',$request->actividad_id]
            ])->select('ae.id')->get();
            if($actividad_evidencia->count() == 0)$actividad=null;
            $validado = Actividad_Evidencia::where([
                ['user_id','=',$request->responsable_id],
                ['actividad_id','=',$request->actividad_id]
            ])->select('validado','id')->get();
            $participante_data = Participante::where([
                ['id_evidencia','=',$validado[0]->id],
                ['no_control','=',$participante->no_control]
            ])->get();
            if($participante_data->count() == 0){
                return redirect()->route('alumnos.actividades');
            }
            $alumno = Alumno::where('no_control','=',$participante->no_control)->get()[0];
            return view('admin.participantes.evidencia')
            ->with('evidencias',$evidencias)
            ->with('actividad',$actividad)
            ->with('validado',$validado)
            ->with('participante_data',$participante_data[0])
            ->with('alumno',$alumno)
            ->with('participante',$participante);
        }
        return redirect()->route('participantes.index');
    }
    public function eliminarEvidencia(Request $request){
    	if($request->has('actividad') && $request->has('archivo') && $request->has('archivo_nombre') && $request->has('no_control')){
            $validado = DB::table('evidencia as e')->join('actividad_evidencia as ae', function($join) use($request){
                $join->on('ae.id','=','e.id_asig_actividades');
                $join->where('e.id','=',$request->get('archivo'));
            })->select('ae.validado','ae.id')->get();
            if($validado->count() == 0){
                return response()->json(array('mensaje' => 'Error al eliminar la evidencia', 'tipo' => 'error'));
            }else{
                if($validado[0]->validado == "true"){
                    $participante_data = Participante::where([
                        ['id_evidencia','=',$validado[0]->id],
                        ['no_control','=',$request->no_control]
                    ])->get()[0];
                    if($participante_data->momento_agregado == "posteriormente" && $participante_data->evidencia_validada == "si"){
                        return response()->json(array('mensaje' => 'La evidencia ya ha sido validada', 'tipo' => 'error'));
                    }
                }
            }
    	    Evidencia::destroy($request->get('archivo'));
    	    Storage::delete('public/evidencias/'.$request->get('actividad').'/'.$request->get('archivo_nombre'));
    	    return response()->json(array('mensaje' => 'Evidencia eliminada con exito','tipo' => 'exito'));
    	}
    	return response()->json(array('mensaje' => 'Error al eliminar la evidencia', 'tipo' => 'error'));
    }
    public function validarEvidencia(Request $request){ 
        $participante = Participante::find($request->get('participante_id'));        
        if($participante == null){
            Alert::error('Error','Participante no encontrado');
            return back();
        }
        $actividad_data = DB::table('participantes as p')
        ->join('actividad_evidencia as ae', function($join){
            $join->on('ae.id','=','p.id_evidencia');
        })
        ->join('actividad as act','act.id','=','ae.actividad_id')
        ->join('creditos as c','c.id','=','act.id_actividad')
        ->where([
            ['ae.id','=',$participante[0]->id_evidencia],
            ['p.no_control','=',$participante[0]->no_control]
        ])
        ->select('ae.id as ae_id','p.no_control','act.nombre','c.vigente as credito_vigente','act.vigente as actividad_vigente','act.alumnos as alumnos_responsables','act.id_user as administrador_id','act.id as actividad_id','act.por_cred_actividad','ae.validado as actividad_validada','c.id as credito_id')->get();
        if($actividad_data->count() == 0) return back();
        $actividad_data = $actividad_data[0];
        if($actividad_data->actividad_validada == "false"){
            Alert::error('Error',' Hasta que la actividad haya sido validada se puede validar la evidencia de los participantes de forma individual');
            return redirect()->route('participantes.index');
        }
        if($actividad_data->actividad_vigente == "false" || $actividad_data->credito_vigente == "false"){
            Alert::error('Error','La actividad no vigente, ya no puede ser modificada');
            return redirect()->route('participantes.index');
        }
        if($actividad_data->alumnos_responsables == "false"){
            Alert::error('Error','Esta actividad no es para alumnos responsables');
            return redirect()->route('participantes.index');
        }
        if($participante[0]->evidencia_validada == "si"){
            Alert::error('Error','Ya se ha validado la evidencia para este participante');
            return redirect()->route('participantes.index');
        }
        if($actividad_data->actividad_validada == "true" && $participante[0]->momento_agregado == "anteriormente"){
            Alert::error('Error','Ya se ha validado la evidencia para este participante');
            return redirect()->route('participantes.index');
        }
        if(Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD','VERIFICAR_EVIDENCIA']) || $actividad_data->administrador_id == Auth::User()->id){
            $tiene_avance = Avance::where([
                ['no_control','=',$participante[0]->no_control],
                ['id_credito','=',$actividad_data->credito_id]
            ])->get();
            $tiene_evidencias = DB::table('actividad_evidencia as ae')
            ->join('evidencia as evi','evi.id_asig_actividades','=','ae.id')
            ->where([
                ['ae.id','=',$participante[0]->id_evidencia],
                ['evi.alumno_no_control','=',$participante[0]->no_control]
            ])->get()->count() == 0 ? false : true;
            if(!$tiene_evidencias){
                Alert::error('Error','El participante no cuenta con evidencias');
                return redirect()->route('participantes.index');
            }
            if($tiene_avance->count() == 0){
                $avance = new Avance();
                $avance->no_control = $participante[0]->no_control;
                $avance->por_credito = (int)$actividad_data->por_cred_actividad;
                $avance->id_credito=$actividad_data->actividad_id;
                $avance->save();
            }else{
                $avance = Avance::find($tiene_avance[0]->id);
                $avance->por_credito += (int)$actividad_data->por_cred_actividad;
                $avance->save();
            }
            $participante[0]->evidencia_validada = "si";
            $participante[0]->save();
            $this->liberar($participante[0]->no_control);
            Alert::success('Correcto','Evidencia validada con exito');
            return redirect()->route('participantes.index');
        }
        Alert::error('Error','No tienes autorización para validar esta evidencia');
        return redirect()->route('participantes.index');
    }
}
