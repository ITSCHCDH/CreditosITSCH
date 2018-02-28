<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Participante; //Es el nombre del modelo con el que va a trabajar el controlador
use Laracasts\Flash\Flash; //Es el paquete para poder usar los mensajes de alerta tipo bootstrap
class ParticipantesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Retorna la vista de Agregar participantes
        $participante=Participante::orderby('id','asc')->paginate(5);
        return view('admin.participantes.index')->with('participante',$participante); //Llama a la vista y le envia los usuarios
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $participante = new Participante($request->all());
        $participante->id_evidencia=4;
        $participante->save();
        Flash::success('El participante se agrego correctamente');
        return redirect()->route('participantes.index');
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
        //
    }
}
