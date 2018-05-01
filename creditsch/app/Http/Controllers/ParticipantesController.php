<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Participante; //Es el nombre del modelo con el que va a trabajar el controlador
use Laracasts\Flash\Flash; //Es el paquete para poder usar los mensajes de alerta tipo bootstrap
use App\Actividad;
use App\Evidencia;
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
        // La varianle $id es pa portadora del id de la actividad, es usada para realizar la consulta de los participantes
        $id=0;
        if($request->actividades_id){//Validamos si el Request contiene un id de una actividad
            $id=$request->actividades_id;//Asignamos el id de la actividad a nuestra variable $id
        }
        //Consulta de los participantes para traer id de la actividad, id de la evidencia y sus datos
        $participantes = DB::table('actividad as act')->join('actividad_evidencia as act_evi',function($join) use ($id){
                $join->on('act_evi.actividad_id','=','act.id')->where('act.id','=',$id);
        })->select('act.nombre')->join('evidencia as e','e.id_asig_actividades','=','act_evi.id')->join('participantes as p','p.id_evidencia','=','e.id')->join('alumnos as a','a.no_control','=','p.no_control')->select('p.id','p.no_control','a.nombre','a.carrera','e.id as id_evidencia','act.id as id_actividad')->get();

        $id_evidencia=-1; //Variable para guardar el id de la evidencia, en caso de no existir el valor por defeto es -1
        $id_actividad=0; //Variable para guardar el id de la actividad */
        foreach ($participantes as $par) {
            $id_actividad=$par->id_actividad;
            $id_evidencia=$par->id_evidencia;
            break;
        }
        $id_evidencia=Evidencia::select('id_asig_actividades')->where('id_asig_actividades',"=",$id)->get();
        //$id_evidencia=$id_evidencia->id_asig_actividades;
        $cont=0;
        foreach ($id_evidencia as $key) {
            $id_evidencia=$key->id_asig_actividades;
            $cont=1;
            break;
        }
        //dd($id_evidencia);
        if($cont==0){
            $id_evidencia=-1;
        }
        $participantes->id_actividad=$id_actividad;
        //dd($participantes);
        $collection = collect(Actividad::select('id','nombre')->orderBy('nombre','ASC')->get());
        $actividades = $collection->pluck('nombre','id');
        $actividades->all();
        //Retorna la vista de Agregar participantes
        return view('admin.participantes.index')->with('participantes',$participantes)->with('actividades',$actividades)->with('id_evidencia',$id_evidencia); //Llama a la vista y le envia los usuarios
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
        //Validamos si la id evidencia existe en caso contrario se regresa a la pestaña anterior
        //dd($request);
        if($request->id_evidencia==-1){
            Flash::error('No puedes registrar participantes sin evidencia');
            return back()->withInput();
        }

        // Validamos si el numero de control existe
        $valida = collect(DB::table('alumnos')->where('no_control','=',$request->no_control)->get());
        if($valida->count()==0){
            Flash::error('El número de control no es valido');
            return back()->withInput();
        }
        $participante = new Participante($request->all());
        $participante->id_evidencia=$request->id_evidencia;//Le asignamos al participante su evidencia
        $participante->save(); //Guardamos al participantes
        Flash::success('El participante se agrego correctamente');
        return back()->withInput();
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
        //Eliminamos al participantes por medio de su ID
        $participante = Participante::find($id);
        $participante->delete();
        Flash('El participante ha sido eliminado')->error();
        return back()->withInput();
    }
}
