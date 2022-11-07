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
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isEmpty;

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

    public function editPerfil($id, Request $request)
    {
        try
        {
            if(!Storage::has('public/alumnos/img')){
                Storage::makeDirectory('public/alumnos/img');
            }
            $alumno = Alumno::find($id);
            if($request->has('foto'))
            {
                // Creamos un arrelglo con las extensiones validas
                $allowedfileExtension=['jpg','png','jpeg'];           
                $file = $request->foto; 
                // Obtenemos la extension original del archivo
                $extension = strtolower($file->getClientOriginalExtension());
                // Funcion para saber si la extension se encuentra dentro de las extensiones permitidas
                $check=in_array($extension,$allowedfileExtension);
                if(!$check){
                    Alert::error('Error','La extensión '.$extension.' no es valida.');
                    return back()->withInput();
                }
                //Verificamos  el ancho y largo de la imagen, antes de subirla:

                $imgsize=getimagesize($file); 

                $width=$imgsize[0];

                $height=$imgsize[1];              

                if($width<700  &&  $height<700 )
                { 
                    Alert::error('Error','El tamaño de las imagenes debe ser de mas de 600px de alto y 600px de ancho');
                    return back()->withInput();
                }
                //Generamos la ruta donde se guardaran las imagenes de los articulos
                $path=storage_path().'/app/public/alumnos/img';
                $path_to_verify = 'public/alumnos/img';
                if(!Storage::has($path_to_verify)){
                    Storage::makeDirectory($path_to_verify);
                }          
                //Para evitar nombres repetidos en las imagenes, creamos un nombre antes de guardar
                $name='foto_'.$alumno->no_control.'.'.strtolower($file->getClientOriginalExtension());
                //Guardamos la imagen en la carpeta creada en la ruta que marcamos anteriormente
                $file->move($path,$name);  
                $alumno->foto=$name;//Obtiene el nombre de la imagen para guardarlo en la bd
                $alumno->save();//Guarda el perfil del usuario                   
            }  
            if($request->txtPassword!=$alumno->password)
            {
                if($request->txtPassword==$request->txtConfirmPassword && strlen($request->txtPassword)>=6)
                {                           
                    $alumno->password=bcrypt($request->txtPassword);               
                    $alumno->save();//Guarda el perfil del usuario          
                }
                else
                {
                    Alert::error('Error','Las contraseñas no son iguales y recuerda que minimo deben ser 6 caracteres');
                    return back()->withInput();
                }  
            }          
          
          
        }
        catch (\Exception $e)
        {    
            Alert::error('Error','Ocurrio un error inesperado '.$e);
            return back()->withInput();
        }      
        Alert::success('Correcto','Su perfil fue modificado con exito');
        return redirect()->route('alumnos.perfil',$id);
    }

    public function bajas()
    {
        $alumno=[];
        return view('admin.alumnos.bajas')
        ->with('alumno',$alumno);
    }

    public function buscar(Request $request)
    {
        $selectColumns = ['alu.nombre','alu.no_control','alu.status','alu.id as alumno_id','a.nombre as carrera'];      

        $alumno = DB::table('alumnos as alu')
            ->join('areas as a','a.id','=','alu.carrera')
            ->select($selectColumns)
            ->where('alu.no_control',$request->control)->get();  

        if($alumno->isEmpty())
        {
            Alert::error('Error','Alumno no encontrado');
            return view('admin.alumnos.bajas')
            ->with('alumno',$alumno);
        }
        else
        {
            return view('admin.alumnos.bajas')
            ->with('alumno',$alumno);
        }       
    }

    public function editStatus(Request $request)
    {
        $alumno=Alumno::where('no_control',$request->cont)->get();
        $alumno[0]->status=$request->status;        
        $alumno[0]->save();

        Alert::success('Correcto','El status del alumno se modifico con exito');
            return view('admin.alumnos.bajas')
            ->with('alumno',$alumno);

    }
}
