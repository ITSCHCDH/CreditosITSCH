<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alumno; //Es el nombre del modelo con el que va a trabajar el controlador
use Laracasts\Flash\Flash; //Es el paquete para poder usar los mensajes de alerta tipo bootstrap

class AlumnosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Aqui mandamos llamar la vista de la pagina de inicio de alumnos
        $alumno=Alumno::Search($request->valor)->orderby('id','asc')->paginate(5); //Consulta todos los usuarios y los ordena, ademas pagina la consulta
        return view('admin.alumnos.index')->with('alumno',$alumno); //Llama a la vista y le envia los usuarios
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Ponemos el codigo de la vista que se llamara para las altas de los alumnos
        return view('admin.alumnos.create');
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
        $alumno = new Alumno($request->all());
        //Para encriptar la contraseña ponemos lo siguiente
       $alumno->password=bcrypt($request->password);
       //Comando para guardar el registro
       $alumno->save();
       Flash::success('El alumno  '.$alumno->name.' se ha registrado de forma exitosa');
       return redirect()->route('alumnos.index');
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
        $alumno=Alumno::find($id);//Busca el registro

        return view('admin.alumnos.edit')->with('alumno',$alumno);
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
        $alumno= Alumno::find($id);
        $alumno->no_control=$request->no_control;
        $alumno->nombre=$request->nombre;
        $alumno->carrera=$request->carrera;
        $alumno->password=bcrypt($request->password);
        $alumno->status=$request->status;
        $alumno->save();
        Flash::warning('El alumno '. $alumno->nombre .' a sido editado de forma exitosa');//Envia mensaje
        return redirect('admin/alumnos');//llama a la pagina de consultas
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
        $alumno=Alumno::find($id);//Busca el registro
        $alumno->delete();//Elimina el registro
        Flash::error('El alumno '. $alumno->nombre .' a sido borrado de forma exitosa');//Envia mensaje
        return redirect('admin/alumnos');//llama a la pagina de consultas
    }
}
