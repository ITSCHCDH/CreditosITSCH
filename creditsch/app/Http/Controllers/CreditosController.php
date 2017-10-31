<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Credito; //Es el nombre del modelo con el que va a trabajar el controlador
use Laracasts\Flash\Flash; //Es el paquete para poder usar los mensajes de alerta tipo bootstrap

class CreditosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Aqui mandamos llamar la vista de la pagina de inicio de alumnos
        $credito=Credito::orderby('id','asc')->paginate(5); //Consulta todos los usuarios y los ordena, ademas pagina la consulta
        return view('admin.creditos.index')->with('credito',$credito); //Llama a la vista y le envia los usuarios
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Ponemos el codigo de la vista que se llamara para las altas de los creditos
        return view('admin.creditos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Recibimos los datos de la vista de altas y en este metodo es donde registramos los datos a la BD
        $credito = new Credito($request->all());
        //Comando para guardar el registro
        $credito->save();
        Flash::success('El credito  '.$credito->nombre.' se ha registrado de forma exitosa');
        return redirect()->route('creditos.index');
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
        //Codigo de modificaciones
        $credito=Credito::find($id);//Busca el registro
        return view('admin.creditos.edit')->with('credito',$credito);
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
        //Ejecuta la modificacion
        $credito= Credito::find($id);
        $credito->nombre=$request->nombre;
        $credito->save();
        Flash::warning('El credito '. $credito->nombre .' a sido editado de forma exitosa');//Envia mensaje
        return redirect('admin/creditos');//llama a la pagina de consultas
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Codigo de bajas
        $credito=Credito::find($id);//Busca el registro
        $credito->delete();//Elimina el registro
        Flash::error('El credito '. $credito->nombre .' a sido borrado de forma exitosa');//Envia mensaje
        return redirect('admin/creditos');//llama a la pagina de consultas
    }
}
