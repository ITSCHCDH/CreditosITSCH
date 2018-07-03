<?php

namespace App\Http\Controllers;

use App\Evidencia;
use Illuminate\Http\Request;
use App\User;
use App\Actividad;
use App\Http\Requests\EvidenciasRequest;
use Laracasts\Flash\Flash; //Es el paquete para poder usar los mensajes de alerta tipo bootstrap
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use PDF;
use Illuminate\Support\Facades\Storage;
class EvidenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actividades = Actividad::select('nombre','id')->orderBy('nombre')->pluck('nombre','id');
        return view('admin.evidencias.index')
        ->with('actividades',$actividades);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //$evidencia->user_id=\Auth::user()->id;//Obtiene el id del usuario que esta logueado
        //Ponemos el codigo de la vista que se llamara para las altas de los creditos
        $dommie_actividad = new Actividad();
        $dommie_actividad->nombre = 'Actividad actualmente no disponible';
        $dommie_actividad->id=-1;
        $dommie_responsable = new User();
        $dommie_responsable->name = 'Actualmente no disponible';
        $dommie_responsable->id=-1;
        $usuarios = User::select('name','id')->get()->pluck('name','id');
        $responsable = User::select('id','name')->where('id','=',$request->id_responsable)->get();
        $actividad = Actividad::select('id','nombre')->where('id','=',$request->id_actividad)->get();
        if($actividad->count()==0 || $responsable->count()==0){
            Flash::error('No actividad o responsable seleccinado');
            return redirect()->route('participantes.index');
        }
        return view('admin.evidencias.create')
            ->with('responsable',$responsable[0])
            ->with('actividad',$actividad[0])
            ->with('usuarios',$usuarios);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EvidenciasRequest $request)
    {
        if(!Storage::has('public/evidencias')){
            Storage::makeDirectory('public/evidencias');
        }
        $actividad = Actividad::where('id','=',$request->actividad_id)->get();
        if($request->hasFile('image')){
            // Creamos un arrelglo con las extemsiones validas
            $allowedfileExtension=['pdf','jpg','png','jpeg'];
            $file = $request->file('image');
            // Obtenmos la exetnsion original del archivo
            $extension = strtolower($file->getClientOriginalExtension());
            // Funcion para saber si la extension se encuentra dentro de las extensiones permitidas
            $check=in_array($extension,$allowedfileExtension);
            if(!$check){
                Flash::error('Formato de archivo no valido');
                return back()->withInput();
            }
        }
        $id_actividad_evidencia = DB::table('actividad_evidencia')->where([
            ['actividad_id','=',$request->actividad_id],
            ['user_id','=',$request->responsables],
        ])->select('id')->get();

        //Manipulacion de imagenes
        if($request->file('image'))//Validamos si existe una imagen
        {
            //En el metodo file ponemos el nombre del campo file que pusimos en la vista, que sera el que tenga los datos de la imagen
            $file=$request->file('image');
            //Para evitar nombres repetidos en las imagenes, creamos un nombre antes de guardar
            $name='credITSCH_'.time().'.'.$file->getClientOriginalExtension();
            //Generamos la ruta donde se guardaran las imagenes de los articulos
            $path=storage_path().'/app/public/evidencias/'.$actividad[0]->nombre.'/';
            $path_to_verify = 'public/evidencias/'.$actividad[0]->nombre;
            if(!Storage::has($path_to_verify)){
                Storage::makeDirectory($path_to_verify);
            }
            //Guardamos la imagen en la carpeta creada en la ruta que marcamos anteriormente
            $file->move($path,$name);
        }
        
        $evidencia=new Evidencia($request->all()); //Obtiene todos los datos de la evidencia de la vista create
        $evidencia->id_asig_actividades=$id_actividad_evidencia[0]->id;
        $evidencia->nom_imagen=$name;//Obtiene el nombre de la imagen para guardarlo en la bd
        $evidencia->save();//Guarda la evidencia en su tabla
        Flash::success('El articulo '.$evidencia->nombre.' se guardo con exito');
        return redirect()->route('participantes.index');
    }

    public function peticionAjax(Request $request){
        //Consultamos todos los responsables asignadoas a una activdad
        $responsables = DB::table('actividad_evidencia as ae')->join('users as u','u.id','ae.user_id')->where('ae.actividad_id','=',$request->get('id'))->select('u.id','u.name')->orderBy('u.name')->get();
        //Retornamos los responsables en un json
        return response()->json($responsables);
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
                })->join('users as u','u.id','=','ae.user_id')->join('actividad as a','a.id','=','ae.actividad_id')->select('e.nom_imagen','e.created_at','u.name as responsable_nombre','a.nombre as actividad_nombre')->get();
                return response()->json($evidencias);
            }
            $evidencias = DB::table('users')->join('actividad_evidencia as ae',function($join) use($request){
                $join->where('ae.user_id','=',$request->get('responsable_id'));
                $join->where('ae.actividad_id','=',$request->get('actividad_id'));
                $join->where('users.id','=',$request->get('responsable_id'));
            })->join('actividad as a','a.id','=','ae.actividad_id')->join('evidencia as e','e.id_asig_actividades','=','ae.id')->select('users.name as responsable_nombre','a.nombre as actividad_nombre','e.nom_imagen','e.created_at')->get();
            return response()->json($evidencias);
        }
        return response()->json(0);
    }
}
