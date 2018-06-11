<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Participante; //Es el nombre del modelo con el que va a trabajar el controlador
use Laracasts\Flash\Flash; //Es el paquete para poder usar los mensajes de alerta tipo bootstrap
use App\Actividad;
use App\Evidencia;
use App\Avance;
use Illuminate\Support\Facades\DB;
class ParticipantesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $valorActividad=0;
        $id_responsable_oculto=0;
        //Consultamos todas las actividades disponibles
        $actividades = Actividad::select('id','nombre')->orderBy('nombre','ASC')->pluck('nombre','id');
        //Retorna la vista de Agregar participantes
        return view('admin.participantes.index')->with('actividades',$actividades)->with('valorActividad',$valorActividad)->with('id_responsable_oculto',$id_responsable_oculto)->with('id_responsable_oculto',$request->id_responsable_oculto); //Llama a la vista y le envia los usuarios
    }

    /** 
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        dd($request);
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
        //select p.no_control,p.id_evidencia, a.por_cred_actividad,c.id as credito_id from participantes as p join evidencia as e on p.id_evidencia = e.id join actividad_evidencia as ae on e.id_asig_actividades=ae.id join actividad as a on ae.actividad_id = a.id join creditos as c on a.id_actividad = c.id;

        $participante_data = DB::table('participantes as p')->join('evidencia as e','p.id_evidencia','=','e.id')->join('actividad_evidencia as ae','e.id_asig_actividades','=','ae.id')->join('actividad as a','ae.actividad_id','=','a.id')->join('creditos as c','a.id_actividad','=','c.id')->where('p.id','=',$id)->select('p.no_control','p.id_evidencia','a.por_cred_actividad','c.id as credito_id','e.status')->get();
        if($participante_data[0]->status==1){
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
        return response()->json("El participante ha sido aliminado con exito");
    }
    public function peticionAjax(Request $request){
        /*
            En esta funcion se realiza la consulta de los participantes relacionados a una evidencia
        */
        
        //No se puede insertar participantes sin evidencia, esta variable retornara un -1 en caso
        //de que no se cuente con dicha evidencia
        $dommie = [['id'=> -1, 'id_evidencia'=>-1]];
        $id_actividad_evidencia = DB::table('actividad_evidencia as ae')->select('ae.id')->where([
            ['ae.user_id','=',$request->id_responsable],
            ['ae.actividad_id','=',$request->id_actividad],
        ])->get();
        if($id_actividad_evidencia->count()==0){
            return response()->json($dommie);
        }
        $id_evidencia = DB::table('evidencia as e')->where('e.id_asig_actividades','=',$id_actividad_evidencia[0]->id)->select('e.id')->get();
        if($id_evidencia->count()==0){
            return response()->json($dommie);
        }
        //La variable participante_data guarda los participante vinculado a una evidencia
        $participantes_data = DB::table('participantes as p')->join('alumnos as a','a.no_control','=','p.no_control')->where('p.id_evidencia','=',$id_evidencia[0]->id)->select('a.nombre','a.carrera','p.id','p.id_evidencia','a.no_control')->get();
        if($participantes_data->count()==0){
            //En caso de contar con la evidencia pero no contar con participantes, esta variable retornara el id de la evidencia con la que actualmente se cuente
            $temp =[['id'=>-1,'id_evidencia'=>$id_evidencia[0]->id]];
            return response()->json($temp);
        }
        //Retornamos los datos un json
        return response()->json($participantes_data);
    }

    public function ajaxGuardar(Request $request){

        if($request->get('id_evidencia')=="-1"){
            return response()->json("No se cuenta evidencia");
        }
        $existe_no_control = DB::table('alumnos')->select('no_control')->where('no_control','=',$request->get('no_control'))->get();
        if($existe_no_control->count()==0){
            return response()->json('El numero de control no exite');
        }
        $participante_duplicado = DB::table('participantes')->select('no_control')->where([
            ['no_control','=',$request->get('no_control')],
            ['id_evidencia','=',$request->get('id_evidencia')]
        ])->get();
        if($participante_duplicado->count()>0){
            return response()->json('El participante actualmente ya se encuentra agregado');
        }

        //Consulta para saber si el participante esta ya esta en la misma actividad pero con otro responsable
        $participante_otra_actividad=DB::table('participantes as p')->join('evidencia as e',function($join) use($request){
            $join->on('e.id','=','p.id_evidencia');
            $join->on('p.no_control','=',DB::raw($request->get('no_control')));
        })->join('actividad_evidencia as ae',function($join) use($request){
            $join->on('ae.id','=','e.id_asig_actividades');
            $join->on('ae.actividad_id','=',DB::raw($request->get('id_actividad')));
        })->select('ae.actividad_id','p.no_control','e.id')->get();
        //Validamos si el participante esta ya esta en la misma actividad pero con otro responsable
        if($participante_otra_actividad->count()>0){
            return response()->json('El participante ya esta registrado en esta actividad solo que con otro responsable');
        }
        //select e.status,e.id,a.id as actividad_id,c.id as credito_id from evidencia as e join actividad_evidencia as ae on ae.id = e.id_asig_actividades join actividad as a on ae.actividad_id = a.id join creditos as c on a.id_actividad= c.id where e.id=1;

        $evidencia_data = DB::table('evidencia as e')->join('actividad_evidencia as ae','ae.id','=','e.id_asig_actividades')->join('actividad as a','ae.actividad_id','=','a.id')->join('creditos as c','a.id_actividad','=','c.id')->where('e.id','=',$request->get('id_evidencia'))->select('e.id')->select('e.status','a.id as id_de_la_actividad','c.id as credito_id','a.por_cred_actividad')->get();
        if($evidencia_data[0]->status==1){
            $temp = Avance::where([
                ['no_control','=',$request->get('no_control')],
                ['id_credito','=',$evidencia_data[0]->credito_id]
            ])->get();
            if($temp->count()==0){
                $avance = new Avance();
                $avance->no_control = $request->get('no_control');
                $avance->por_credito = (int)$evidencia_data[0]->por_cred_actividad;
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
            }
        }
        //return response()->json('Hola todo funciono');
        $participante = new Participante();
        $participante->no_control = $request->get('no_control');
        $participante->id_evidencia = $request->get('id_evidencia');
        $participante->save();
        return response()->json($request);
    }
}
