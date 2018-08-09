<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alumno; //Es el nombre del modelo con el que va a trabajar el controlador
use Laracasts\Flash\Flash; //Es el paquete para poder usar los mensajes de alerta tipo bootstrap
use DB;

class AlumnosController extends Controller
{
    public function __construct(){
        $this->middleware('permission:VIP|VIP_SOLO_LECTURA|VER_ALUMNOS')->only(['index','show']);
        $this->middleware('permission:VIP|CREAR_ALUMNOS')->only(['store','create']);
        $this->middleware('permission:VIP|MODIFICAR_ALUMNOS')->only(['edit','update']);
        $this->middleware('permission:VIP|ELIMINAR_ALUMNOS')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Aqui mandamos llamar la vista de la pagina de inicio de alumnos
        $alumno=Alumno::Search($request->valor)->orderby('id','asc')->paginate(10); //Consulta todos los usuarios y los ordena, ademas pagina la consulta
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
        $no_control_existe = Alumno::where('no_control','=',$request->no_control)->select('no_control')->get();
        if($no_control_existe->count()>0){
            Flash::error('El No de control ya existe');
            return redirect()->back()->withInput();
        }
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
        $valida_no_control = DB::table('alumnos as alu')->join('participantes as p','p.no_control','=','alu.no_control')->join('avance as av','av.no_control','=','alu.no_control')->where('alu.no_control','=',$alumno->no_control)->select('alu.no_control')->get();
        $valida_no_control_evidencia = DB::table('alumnos as alu')->join('evidencia as e','e.alumno_no_control','=','alu.no_control')->where('alu.no_control','=',$alumno->no_control)->select('alu.no_control')->get();
        if(($valida_no_control->count()>0 || $valida_no_control_evidencia->count()>0) && $alumno->no_control!=$request->no_control){
            Flash::error('El numero de control del alumno no puede ser modificado debido a claves foraneas');
            return back()->withInput();
        }
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
        if($alumno==null){
            Flash::error('El alumno no existe');
            return redirect('/home');
        }
        $participante = DB::table('participantes')->where('no_control','=',$alumno->no_control)->get()->count()>0?true:false;
        $evidencia = DB::table('evidencia')->where('alumno_no_control','=',$alumno->no_control)->get()->count()>0?true:false;
        $avance = DB::table('avance')->where('no_control','=',$alumno->no_control)->get()->count()>0?true:false;
        if($participante || $evidencia || $avance){
            Flash::error('El alumno '.$alumno->nombre.' no puede ser eliminado debido a claves foraneas');
            return redirect()->route('alumnos.index');
        }
        $alumno->delete();//Elimina el registro
        Flash::error('El alumno '. $alumno->nombre .' a sido borrado de forma exitosa');//Envia mensaje
        return redirect('admin/alumnos');//llama a la pagina de consultas
    }
}
