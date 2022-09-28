<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utilities\DataTableAttr;
use App\Http\Controllers\Utilities\DataTableHelper;
use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Area;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Alert;
use App\Http\Controllers\Utilities\HttpCode;
use Exception;

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
        try {
            $selectColumns = ['alu.nombre','alu.no_control','alu.status','alu.id as alumno_id','a.nombre as carrera'];
            $dtAttr = new DataTableAttr($request, $selectColumns);

            $alumnos = DB::table('alumnos as alu')
                ->join('areas as a','a.id','=','alu.carrera')
                ->select($selectColumns);

            DataTableHelper::applyAllExcept($alumnos, $dtAttr, [DataTableHelper::PAGINATOR]);

            foreach ($alumnos as $alumno) {
                $alumno->status = ucwords($alumno->status);
                $alumno->acciones = "";

                if (Auth::User()->hasAnyPermission(['VIP','MODIFICAR_ALUMNOS'])) {
                    $alumno->acciones = $alumno->acciones . '<a href="'.route('alumnos.edit',[$alumno->alumno_id]) .'"
                        class="btn btn-warning btn-sm" title="Modificar alumno"><i class="fas fa-user-edit" style="font-size:14px"></i></a>';
                }

                if (Auth::User()->hasAnyPermission(['VIP','ELIMINAR_ALUMNOS'])) {
                    $alumno->acciones = $alumno->acciones . '<a  class="btn btn-danger btn-sm ml-1" onclick="undo_alumno(' .
                        $alumno->alumno_id .','."'". $alumno->nombre . "'". ')" data-toggle="modal" data-target="#myModalMsg" title="Eliminar alumno">
                        <i class="far fa-trash-alt" style="font-size:14px"></i></a>';
                }

                if (empty($alumno->acciones))
                    $alumno->acciones = 'NA';
            }

            $paginatorResponse = DataTableHelper::paginatorResponse($alumnos, $dtAttr);
            return response()->json($paginatorResponse, HttpCode::SUCCESS);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), HttpCode::NOT_ACCEPTABLE);
        }
    }

    public function create()
    {
        $carreras = Area::where('tipo','=','carrera')->orderBy('nombre','ASC')->get();
        return view('admin.alumnos.create')
        ->with('carreras',$carreras);
    }


    public function store(Request $request)
    {
        //Recibimos los datos de la vista de altas y en este metodo es donde registramos los datos a la BD
        $alumno = new Alumno($request->all());
        //Para encriptar la contraseña ponemos lo siguiente
        $alumno->password=bcrypt($request->password);
        //Comando para guardar el registro
        $no_control_existe = Alumno::where('no_control','=',$request->no_control)->select('no_control')->get();
        if($no_control_existe->count()>0){
            Alert::error('Error','El No de control ya existe');
            return redirect()->back()->withInput();
        }
        $alumno->save();

        Alert::success('Correcto', 'El alumno  '.$alumno->name.' se ha registrado de forma exitosa');
        return redirect()->route('alumnos.index');
    }


    public function edit($id)
    {
        //Codigo de modificaciones
        $alumno=Alumno::find($id);//Busca el registro
        if($alumno==null){
            Alert::error('Error','El alumno no existe');
            return redirect()->back();
        }

        $areas = Area::all();

        return view('admin.alumnos.edit')
        ->with('alumno',$alumno)
        ->with('areas',$areas);
    }




    public function update(Request $request, $id)
    {
        //Ejecuta la modificacion       
        $alumno= Alumno::find($id);
        if($alumno==null){
            Alert::error('Error','El alumno no existe');
            return redirect()->back();
        }
        //$avance = DB::table('avance')->where('no_control','=',$alumno->no_control)->get()->count()>0?true: false;
        //$participante = DB::table('participantes')->where('no_control','=',$alumno->no_control)->get()->count()>0?true: false;
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
                Alert::error('Error','Error de credenciales, las contraseñas deben ser iguales para el alumno: '.$alumno->nombre);
                return redirect()->route('alumnos.index');

            }
        }
        $alumno->save();

        Alert::warning('Alerta','El alumno '. $alumno->nombre .' a sido editado de forma exitosa');

        return redirect()->route('alumnos.index');
    }


    public function destroy($id)
    {
        //Codigo de bajas
        $alumno=Alumno::find($id);//Busca el registro
        if($alumno==null){
            Alert::error('Error','El alumno no existe');
            return redirect('/home');
        }
        $participante = DB::table('participantes')->where('no_control','=',$alumno->no_control)->get()->count()>0?true:false;
        $evidencia = DB::table('evidencia')->where('alumno_no_control','=',$alumno->no_control)->get()->count()>0?true:false;
        $avance = DB::table('avance')->where('no_control','=',$alumno->no_control)->get()->count()>0?true:false;
        if($participante || $evidencia || $avance){
            Alert::error('Error','El alumno '.$alumno->nombre.' no puede ser eliminado debido a claves foraneas');
            return redirect()->route('alumnos.index');
        }
        $alumno->delete();//Elimina el registro
        Alert::success('Correcto','El alumno '. $alumno->nombre .' a sido borrado de forma exitosa');//Envia mensaje
        return redirect('admin/alumnos');//llama a la pagina de consultas
    }

    public function perfil($id)
    {
        $selectColumns = ['alu.nombre','alu.no_control','alu.foto','alu.id as alumno_id','alu.password','a.nombre as carrera'];      

        $alumno_data = DB::table('alumnos as alu')
            ->join('areas as a','a.id','=','alu.carrera')
            ->select($selectColumns)
            ->where('alu.id',$id)->get();          

        return view('alumnos.perfil')
        ->with('alumno_data',$alumno_data);
    }

    public function editPerfil($id)
    {
        dd('Si llega');
    }
}
