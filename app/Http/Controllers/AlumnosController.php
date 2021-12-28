<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utilities\DataTableAttr;
use App\Http\Controllers\Utilities\DataTableHelper;
use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Area;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AlumnosController extends Controller
{
    public function __construct(){
        $this->middleware('permission:VIP|VIP_SOLO_LECTURA|VER_ALUMNOS')->only(['index','show', 'cargarAlumnosAjax']);
        $this->middleware('permission:VIP|CREAR_ALUMNOS')->only(['store','create']);
        $this->middleware('permission:VIP|MODIFICAR_ALUMNOS')->only(['edit','update']);
        $this->middleware('permission:VIP|ELIMINAR_ALUMNOS')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.alumnos.index');
    }

    public function cargarAlumnosAjax(Request $request) {
        $selectColumns = ['alu.nombre','alu.no_control','alu.status','alu.id as alumno_id','a.nombre as carrera'];
        $dtAttr = new DataTableAttr($request, $selectColumns);

        $alumnos = DB::table('alumnos as alu')
            ->join('areas as a','a.id','=','alu.carrera')
            ->select($selectColumns);

        DataTableHelper::applyAll($alumnos, $dtAttr, ['paginatorResponse']);

        foreach ($alumnos as $alumno) {
            $alumno->status = ucwords($alumno->status);
            $alumno->acciones = "";

            if (Auth::User()->hasAnyPermission(['VIP','MODIFICAR_ALUMNOS'])) {
                $alumno->acciones = $alumno->acciones . '<a href="'.route('alumnos.edit',[$alumno->alumno_id]) .'"
                    class="btn btn-warning btn-sm" title="Modificar alumno"><i class="fas fa-user-edit" style="font-size:14px"></i></a>';
            }

            if (Auth::User()->hasAnyPermission(['VIP','ELIMINAR_ALUMNOS'])) {
                $alumno->acciones = $alumno->acciones . '<a  class="btn btn-danger btn-sm ml-1" onclick="undo_alumno(' .
                    $alumno->alumno_id . ')" data-toggle="modal" data-target="#myModalMsg" title="Eliminar alumno">
                    <i class="far fa-trash-alt" style="font-size:14px"></i></a>';
            }

            if (empty($alumno->acciones))
                $alumno->acciones = 'NA';
        }

        $paginatorResponse = DataTableHelper::paginatorResponse($alumnos, $dtAttr);
        return response()->json($paginatorResponse, 200);
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
            return redirect()->back()->withInput()
            ->with('error','El No de control ya existe');
        }
        $alumno->save();
        return redirect()->route('alumnos.index')
        ->with('success','El alumno  '.$alumno->name.' se ha registrado de forma exitosa');
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
            return redirect()->back()
            ->with('error','El alumno no existe');
        }


        $areas = Area::all();

        return view('admin.alumnos.edit')
        ->with('alumno',$alumno)
        ->with('areas',$areas);
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
            return redirect()->back()
            ->with('error','El alumno no existe');
        }
        $avance = DB::table('avance')->where('no_control','=',$alumno->no_control)->get()->count()>0?true: false;
        $participante = DB::table('participantes')->where('no_control','=',$alumno->no_control)->get()->count()>0?true: false;
        $alumno->nombre=$request->nombre;
        $alumno->carrera=$request->carrera;
        if($alumno->password!=$request->password)
        {
            if($request->password==$request->passwordV)
            {
                $alumno->password= bcrypt($request->password);
            }
            else
            {
                return redirect()->route('alumnos.index')
                ->with('error','Error de credenciales, las contraseñas deben ser iguales para el alumno: '.$alumno->nombre);
            }
        }
        $alumno->save();
        return redirect('admin/alumnos')
        ->with('warning','El alumno '. $alumno->nombre .' a sido editado de forma exitosa');//llama a la pagina de consultas
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
