<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alumno; //Es el nombre del modelo con el que va a trabajar el controlador
use App\Area;
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
        $alumnos = DB::table('alumnos as alu')->join('areas as a','a.id','=','alu.carrera')->where('alu.nombre','LIKE',"%".$request->valor."%")->orwhere('no_control','LIKE',"%$request->valor%")->orwhere('carrera','LIKE',"%$request->valor%")->orderBy('alu.id')->select('alu.nombre','alu.no_control','alu.status','alu.id','a.nombre as carrera')->paginate(5);
        return view('admin.alumnos.index')->with('alumno',$alumnos); //Llama a la vista y le envia los usuarios
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $carreras = Area::where('tipo','=','carrera')->orderBy('nombre','ASC')->get();
        return view('admin.alumnos.create')
        ->with('carreras',$carreras);
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
        if($alumno==null){
            Flash::error('El alumno no existe');
            return redirect()->back();
        }
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
        if($alumno==null){
            Flash::error('El alumno no existe');
            return redirect()->back();
        }
        $avance = DB::table('avance')->where('no_control','=',$alumno->no_control)->get()->count()>0?true: false;
        $participante = DB::table('participantes')->where('no_control','=',$alumno->no_control)->get()->count()>0?true: false;
        if($avance || $participante){
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
