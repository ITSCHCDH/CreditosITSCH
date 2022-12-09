<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evidencia;
use App\User;
use App\Models\Actividad;
use App\Models\Actividad_Evidencia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Alert;
use App\Http\Controllers\Utilities\HttpCode;
use Exception;

class EvidenciasController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:VIP_SOLO_LECTURA|VIP|VER_EVIDENCIA')->only(['index','show']);
        $this->middleware('permission:VIP|CREAR_EVIDENCIA')->only('create','store');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ruta = $request->has('ruta');
        if(Auth::User()->can('VIP') || Auth::User()->can('VIP_SOLO_LECTURA')){
            $actividades = Actividad::select('nombre','id')->orderBy('nombre')->get();
        }else{
            $actividades = DB::table('users as u')
                ->join('actividad_evidencia as ae',function($join){
                    $join->on('ae.user_id','=','u.id');
                })
                ->join('actividad as a','a.id','=','ae.actividad_id')
                ->where('u.id','=',Auth::guard('web')->User()->id)
                ->orwhere('a.id_user','=',Auth::User()->id)
                ->select('a.nombre','a.id')
                ->orderBy('nombre')
                ->get();
        }
        return view('admin.evidencias.index')
            ->with('actividades',$actividades)
            ->with('ruta',$ruta);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!$request->has("id_actividad")){
            Alert::error('Error',"Debes seleccionar una actividad");
            return redirect()->back();
        }
        $actividad_evidencia = Actividad_Evidencia::where([
            ['user_id','=',$request->id_responsable],
            ['actividad_id','=',$request->id_actividad]
        ])->get();
        if($actividad_evidencia->count()==0){
            Alert::error('Error',"No actividad o responsable seleccionado");
            return redirect()->back();
        }
        $validador = User::find($actividad_evidencia[0]->validador_id);
        $responsable = User::select('id','name')->where('id','=',$request->id_responsable)->get();
        $actividad = Actividad::select('id','nombre')->where('id','=',$request->id_actividad)->get();
        if($actividad->count()==0 || $responsable->count()==0){
            Alert::error('Error','No hay actividad o responsable seleccinado');
            return redirect()->back();
        }
        return view('admin.evidencias.create')
            ->with('responsable',$responsable[0])
            ->with('actividad',$actividad[0])
            ->with('validador',$validador);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Storage::has('public/evidencias')){
            Storage::makeDirectory('public/evidencias');
        }
        $actividad = Actividad::find($request->actividad_id);
        if($request->has('archivos')){
            // Creamos un arreglo con las extensiones validas
            $allowedfileExtension=['pdf','jpg','png','jpeg'];
            for ($i = 0; $i < count($request->archivos); $i++) {
               $file = $request->archivos[$i];
               // Obtenemos la extension original del archivo
               $extension = strtolower($file->getClientOriginalExtension());
               // Funcion para saber si la extension se encuentra dentro de las extensiones permitidas
               $check=in_array($extension,$allowedfileExtension);
               if(!$check){
                   Alert::error('Error','La extensión '.$extension.' no es valida. Solo se admiten archivos: pdf, jpg, png, jpeg');
                   return back()->withInput();
               }
            }
        }
        $id_actividad_evidencia = DB::table('actividad_evidencia')->where([
            ['actividad_id', '=', $request->actividad_id],
            ['user_id', '=', $request->responsables],
        ])->select('id')->first()->id;

        $actividad_evidencia = Actividad_Evidencia::find($id_actividad_evidencia);

        if (is_null($actividad_evidencia)) {
            Alert::error('Error','Actividad no encontrada.');
            return back();
        }

        //Manipulacion de imagenes
        if($request->has('archivos'))//Validamos si existe una imagen
        {
            //Generamos la ruta donde se guardaran las imagenes de los articulos
            $path = storage_path() . '/app/public/evidencias/' . $actividad->nombre . '/';
            $storage_path = 'public/evidencias/' . $actividad->nombre;
            $uploaded_files = [];

            DB::beginTransaction();
            try {
                if (!Storage::has($storage_path)) {
                    Storage::makeDirectory($storage_path);
                }
                for ($i = 0; $i < count($request->archivos); $i++) {
                    //En el metodo file ponemos el nombre del campo file que pusimos en la vista, que sera el que tenga los datos de la imagen
                    $file = $request->archivos[$i];
                    //Para evitar nombres repetidos en las imagenes, creamos un nombre antes de guardar
                    $name = 'credITSCH_' . time() . '_' . $i . '.' . strtolower($file->getClientOriginalExtension());
                    //Guardamos la imagen en la carpeta creada en la ruta que marcamos anteriormente
                    $file->move($path, $name);
                    array_push($uploaded_files, $name);

                    $evidencia = new Evidencia(); //Obtiene todos los datos de la evidencia de la vista create
                    $evidencia->id_asig_actividades = $actividad_evidencia->id;
                    $evidencia->nom_imagen = $name; //Obtiene el nombre de la imagen para guardarlo en la bd
                    $evidencia->nom_original = $file->getClientOriginalName();
                    $evidencia->save(); //Guarda la evidencia en su tabla
                }
                $actividad_evidencia->save();
            } catch (Exception $e) {
                DB::rollBack();
                $this->rollbackFiles($storage_path, $uploaded_files);
                Alert::error('Error', $e->getMessage());
                return back();
            }
            DB::commit();
        }
        Alert::success('Correcto','La evidencia fue guardada correctamente');
        return redirect()->route('participantes.index');
    }

    private function rollbackFiles($path, $files) {
        for ($i = 0; $i < count($files); ++$i) {
            $filepath = $path . '/' . $files[$i];
            if (Storage::exists($filepath)) {
                Storage::delete($filepath);
            }
        }
    }

    public function peticionAjax(Request $request){
        //Consultamos todos los responsables asignados a una activdad
        $responsables = null;
        if(Auth::User()->can('VIP') || Auth::User()->can('VIP_SOLO_LECTURA')){
            $responsables = DB::table('actividad_evidencia as ae')
                ->join('users as u','u.id','ae.user_id')
                ->where('ae.actividad_id','=',$request->get('id'))
                ->select('u.id','u.name')
                ->orderBy('u.name')
                ->get();
        }else{
            $actividad = Actividad::find($request->get('id'));
            if($actividad->id_user==Auth::User()->id){
                $responsables = DB::table('actividad_evidencia as ae')
                    ->join('users as u','u.id','ae.user_id')
                    ->where('ae.actividad_id','=',$request->get('id'))
                    ->select('u.id','u.name')
                    ->orderBy('u.name')
                    ->get();
            }else{
                $responsables = User::where('id','=',Auth::User()->id)->select('id','name')->get();
            }
        }
        return response()->json($responsables);
    }

    public function peticionGaleria(Request $request){
        if($request->has('responsable_id') && $request->has('actividad_id')){
            if($request->get('responsable_id')=='nulo'){
                $evidencias = DB::table('evidencia as e')
                    ->join('actividad_evidencia as ae',function($join) use($request){
                        $join->on('ae.id','=','e.id_asig_actividades');
                        $join->where('ae.actividad_id','=',$request->get('actividad_id'));
                    })
                    ->join('users as u','u.id','=','ae.user_id')
                    ->join('actividad as a','a.id','=','ae.actividad_id')
                    ->leftjoin('alumnos as alu','alu.no_control','=','e.alumno_no_control')
                    ->select('e.nom_imagen',DB::raw('DATE_FORMAT(e.created_at, "%d-%m-%Y") as fecha_creacion'),'u.name as responsable_nombre',
                        'a.nombre as actividad_nombre','e.id as evidencia_id','alu.nombre as alumno_nombre'
                        ,'ae.validado','u.id as user_id', 'e.nom_original', 'a.id as actividad_id')
                    ->get();
                return response()->json($evidencias);
            }
            $evidencias = DB::table('users')
                ->join('actividad_evidencia as ae',function($join) use($request){
                    $join->where('ae.user_id','=',$request->get('responsable_id'));
                    $join->where('ae.actividad_id','=',$request->get('actividad_id'));
                    $join->where('users.id','=',$request->get('responsable_id'));
                })
                ->join('actividad as a','a.id','=','ae.actividad_id')
                ->join('evidencia as e','e.id_asig_actividades','=','ae.id')
                ->leftjoin('alumnos as alu','alu.no_control','=','e.alumno_no_control')
                ->select('users.name as responsable_nombre','a.nombre as actividad_nombre','e.nom_imagen',
                    DB::raw('DATE_FORMAT(e.created_at, "%d-%m-%Y") as fecha_creacion'),'e.id as evidencia_id','alu.nombre as alumno_nombre',
                    'ae.validado','users.id as user_id', 'e.nom_original', 'a.id as actividad_id')
                ->get();
            return response()->json($evidencias);
        }
        return response()->json(0);
    }

    public function peticionEliminar(Request $request){
        if($request->has('actividad') && $request->has('archivo')){
            $evidencia_data = DB::table('evidencia as e')
                ->join('actividad_evidencia as ae', 'ae.id', '=', 'e.id_asig_actividades')
                ->join('actividad as a', 'a.id', '=', 'ae.actividad_id')
                ->where('e.id', '=', $request->get('archivo'))
                ->where('a.id', '=', $request->get('actividad'))
                ->select('a.nombre as actividad_nombre', 'e.nom_imagen as archivo_nombre', 'ae.validado', 'ae.user_id as responsable', 'a.id_user as owner_id', 'e.id as archivo')
                ->get();

            if ($evidencia_data->count() != 1) {
                return response()->json('No se encontraron registros', HttpCode::BAD_REQUEST);
            }

            $evidencia_data = $evidencia_data[0];
            $validado = (bool)json_decode($evidencia_data->validado);

            try {
                $puede_eliminar = Auth::User()->can('VIP') || Auth::User()->can('VIP_EVIDENCIA');
                $puede_eliminar = (Auth::User()->id == $evidencia_data->owner_id) || $pude_eliminar;
                $puede_eliminar = (!$validado && Auth::User()->id==$evidencia_data->responsable && Auth::User()->can('ELIMINAR_EVIDENCIA')) || $puede_eliminar;

                if ($puede_eliminar) {
                    $this->eliminarEvidencia($evidencia_data->actividad_nombre, $evidencia_data->archivo, $evidencia_data->archivo_nombre);
                    return response()->json('Evidencia eliminada con exito', HttpCode::OK);
                } else if($validado) {
                    return response()->json('La evidencia ya se encuentra validada. No esta permitida esta acción.', HttpCode::NOT_ACCEPTABLE);
                } else {
                    return response()->json('No cuentas con los permisos necesarios para realizar esta acción', HttpCode::UNAUTHORIZED);
                }
            } catch (\Exception $e) {
                return response()->json('Se proceso con el siguiente error: '.$e->getMessage(), HttpCode::BAD_REQUEST);
            }
        }
        return response()->json('Error al eliminar la evidencia', HttpCode::BAD_REQUEST);
    }

    private function eliminarEvidencia($actividad, $archivo_id, $archivo) {
        Evidencia::destroy($archivo_id);
        Storage::delete('public/evidencias/'.$actividad.'/'.$archivo);
    }
}
