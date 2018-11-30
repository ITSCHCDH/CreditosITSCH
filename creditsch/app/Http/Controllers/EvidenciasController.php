<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evidencia;
use App\User;
use App\Actividad;
use App\Actividad_Evidencia;
use App\Http\Requests\EvidenciasRequest;
use Laracasts\Flash\Flash; //Es el paquete para poder usar los mensajes de alerta tipo bootstrap
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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
            $actividades = Actividad::select('nombre','id')->orderBy('nombre')->pluck('nombre','id');
            return view('admin.evidencias.index')
            ->with('actividades',$actividades)
            ->with('ruta',$ruta);
        }else{
            $actividades = DB::table('users as u')->join('actividad_evidencia as ae',function($join){
                $join->on('ae.user_id','=','u.id');
            })->join('actividad as a','a.id','=','ae.actividad_id')->where('u.id','=',Auth::guard('web')->User()->id)->orwhere('a.id_user','=',Auth::User()->id)->select('a.nombre','a.id')->orderBy('nombre')->pluck('nombre','id');
            return view('admin.evidencias.index')
            ->with('actividades',$actividades)
            ->with('ruta',$ruta);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!$request->has('user_id') || !$request->has('actividad_id')){
            Flash::error("Debes seleccionar una actividad");
            return redirect()->back();
        }
        $actividad_evidencia = Actividad_Evidencia::where([
            ['user_id','=',$request->id_responsable],
            ['actividad_id','=',$request->id_actividad]
        ])->get();
        if($actividad_evidencia->count()==0){
            Flash::error("No actividad o responsable seleccionado");
            return redirect()->back();
        }
        $validador = User::find($actividad_evidencia[0]->validador_id);
        $responsable = User::select('id','name')->where('id','=',$request->id_responsable)->get();
        $actividad = Actividad::select('id','nombre')->where('id','=',$request->id_actividad)->get();
        if($actividad->count()==0 || $responsable->count()==0){
            Flash::error('No actividad o responsable seleccinado');
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
        //dd(Storage::deleteDirectory('public/evidencias'));
        if(!Storage::has('public/evidencias')){
            Storage::makeDirectory('public/evidencias');
        }
        $actividad = Actividad::where('id','=',$request->actividad_id)->get();
        if($request->has('archivos')){
            // Creamos un arrelglo con las extemsiones validas
            $allowedfileExtension=['pdf','jpg','png','jpeg'];
            for ($i = 0; $i < count($request->archivos); $i++) {
               $file = $request->archivos[$i];
               // Obtenemos la exetension original del archivo
               $extension = strtolower($file->getClientOriginalExtension());
               // Funcion para saber si la extension se encuentra dentro de las extensiones permitidas
               $check=in_array($extension,$allowedfileExtension);
               if(!$check){
                   Flash::error('La extensión '.$extension.' no es valida.');
                   return back()->withInput();
               }
            }
        }
        
        $id_actividad_evidencia = DB::table('actividad_evidencia')->where([
            ['actividad_id','=',$request->actividad_id],
            ['user_id','=',$request->responsables],
        ])->select('id')->get();
        //Manipulacion de imagenes
        if($request->has('archivos'))//Validamos si existe una imagen
        {
            //Generamos la ruta donde se guardaran las imagenes de los articulos
            $path=storage_path().'/app/public/evidencias/'.$actividad[0]->nombre.'/';
            $path_to_verify = 'public/evidencias/'.$actividad[0]->nombre;
            if(!Storage::has($path_to_verify)){
                Storage::makeDirectory($path_to_verify);
            }
            for ($i = 0; $i < count($request->archivos) ; $i++) {
                //En el metodo file ponemos el nombre del campo file que pusimos en la vista, que sera el que tenga los datos de la imagen
                $file=$request->archivos[$i];
                //Para evitar nombres repetidos en las imagenes, creamos un nombre antes de guardar
                $name='credITSCH_'.time().'_'.$i.'.'.strtolower($file->getClientOriginalExtension());
                //Guardamos la imagen en la carpeta creada en la ruta que marcamos anteriormente
                $file->move($path,$name);

                $evidencia=new Evidencia(); //Obtiene todos los datos de la evidencia de la vista create
                $evidencia->id_asig_actividades=$id_actividad_evidencia[0]->id;
                $evidencia->nom_imagen=$name;//Obtiene el nombre de la imagen para guardarlo en la bd
                $evidencia->save();//Guarda la evidencia en su tabla
                
            }
            $actividad_evidencia = Actividad_Evidencia::find($id_actividad_evidencia[0]->id);
            $actividad_evidencia->save();
        }
        Flash::success('La evidencia fue guardada correctamente');
        return redirect()->route('participantes.index');
    }

    public function peticionAjax(Request $request){
        //Consultamos todos los responsables asignados a una activdad
        if(Auth::User()->can('VIP') || Auth::User()->can('VIP_SOLO_LECTURA')){
            $responsables = DB::table('actividad_evidencia as ae')->join('users as u','u.id','ae.user_id')->where('ae.actividad_id','=',$request->get('id'))->select('u.id','u.name')->orderBy('u.name')->get();
            //Retornamos los responsables en un json
            return response()->json($responsables);
        }else{
            $actividad = Actividad::find($request->get('id'));
            if($actividad->id_user==Auth::User()->id){
                $responsables = DB::table('actividad_evidencia as ae')->join('users as u','u.id','ae.user_id')->where('ae.actividad_id','=',$request->get('id'))->select('u.id','u.name')->orderBy('u.name')->get();
            }else{
                $responsables = User::where('id','=',Auth::User()->id)->select('id','name')->get();
            }
            
            //Retornamos los responsables en un json
            return response()->json($responsables);   
        }
        
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

    public function peticionGaleria(Request $request){
        if($request->has('responsable_id') && $request->has('actividad_id')){
            if($request->get('responsable_id')=='nulo'){
                $evidencias = DB::table('evidencia as e')->join('actividad_evidencia as ae',function($join) use($request){
                    $join->on('ae.id','=','e.id_asig_actividades');
                    $join->where('ae.actividad_id','=',$request->get('actividad_id'));
                })->join('users as u','u.id','=','ae.user_id')->join('actividad as a','a.id','=','ae.actividad_id')->leftjoin('alumnos as alu','alu.no_control','=','e.alumno_no_control')->select('e.nom_imagen','e.created_at','u.name as responsable_nombre','a.nombre as actividad_nombre','e.id as evidencia_id','alu.nombre as alumno_nombre','ae.validado','u.id as user_id')->get();
                return response()->json($evidencias);
            }
            $evidencias = DB::table('users')->join('actividad_evidencia as ae',function($join) use($request){
                $join->where('ae.user_id','=',$request->get('responsable_id'));
                $join->where('ae.actividad_id','=',$request->get('actividad_id'));
                $join->where('users.id','=',$request->get('responsable_id'));
            })->join('actividad as a','a.id','=','ae.actividad_id')->join('evidencia as e','e.id_asig_actividades','=','ae.id')->leftjoin('alumnos as alu','alu.no_control','=','e.alumno_no_control')->select('users.name as responsable_nombre','a.nombre as actividad_nombre','e.nom_imagen','e.created_at','e.id as evidencia_id','alu.nombre as alumno_nombre','ae.validado','users.id as user_id')->get();
            return response()->json($evidencias);
        }
        return response()->json(0);
    }

    public function peticionEliminar(Request $request){
        if($request->has('actividad') && $request->has('archivo') && $request->has('archivo_nombre')){
            if(Auth::User()->can('VIP') || Auth::User()->can('VIP_EVIDENCIA')){
                Evidencia::destroy($request->get('archivo'));
                Storage::delete('public/evidencias/'.$request->get('actividad').'/'.$request->get('archivo_nombre'));
                return response()->json(array('mensaje' => 'Evidencia eliminada con exito','tipo' => 'exito'));
            }
            $evidencia_validada = DB::table('evidencia as e')->join('actividad_evidencia as ae',function($join) use($request){
                $join->on('ae.id','=','e.id_asig_actividades');
                $join->where('e.id','=',$request->get('archivo'));
            })->select('ae.validado','ae.user_id')->get();
            if($evidencia_validada->count()==0){
                return response()->json(array('mensaje' => 'Error al eliminar la evidencia', 'tipo' => 'error'));
            }else{
                if($evidencia_validada[0]->validado=="true"){
                    return response()->json(array('mensaje' => 'La evidencia ya se encuentra validada. No esta permitida esta acción.', 'tipo' => 'error'));
                }else if(Auth::User()->id==$evidencia_validada[0]->user_id && Auth::User()->can('ELIMINAR_EVIDENCIA')){
                    Evidencia::destroy($request->get('archivo'));
                    Storage::delete('public/evidencias/'.$request->get('actividad').'/'.$request->get('archivo_nombre'));
                    return response()->json(array('mensaje' => 'Evidencia eliminada con exito','tipo' => 'exito'));
                }else{
                    return response()->json(array('mensaje' => 'No cuentas con los permisos necesarios para realizar esta acción', 'tipo' => 'error'));
                }
            }
        }
        return response()->json(array('mensaje' => 'Error al eliminar la evidencia', 'tipo' => 'error'));
    }
}
