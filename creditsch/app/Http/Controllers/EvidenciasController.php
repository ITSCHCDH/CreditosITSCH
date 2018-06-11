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

class EvidenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Llama al index de evidencias
        return view('admin.evidencias.index');
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
        //dd($request);
        if($request->hasFile('image')){
            // Creamos un arrelglo con las extemsiones validas
            $allowedfileExtension=['pdf','jpg','png','jpeg'];
             
            $file = $request->file('image');
            // Obtenmos la exetnsion original del archivo
            $extension = $file->getClientOriginalExtension();
            // Funcion para saber si la extension se encuentra dentro de las extensiones permitidas
            $check=in_array($extension,$allowedfileExtension);
            if(!$check){
                Flash::error('Formato de archivo no valido');
                return back()->withInput();
            }
        }
        $id_actividad_evidencia = DB::table('actividad_evidencia')->where([
            ['actividad_id','=',$request->id_asig_actividades],
            ['user_id','=',$request->responsables],
        ])->select('id')->get();
        //Consulta para averiguar con cuantas evidencias cuenta la actividad
        $evidencia_duplicada = DB::table('evidencia')->where('id_asig_actividades','=',$id_actividad_evidencia[0]->id)->get();
        //Validamos que no haya evidencia guardada previamente
        if($evidencia_duplicada->count()>=1){
            Flash::error('Actualmente ya se cuenta con la evidencia de la actividad');
            return back()->withInput();
        }
        //Manipulacion de imagenes
        if($request->file('image'))//Validamos si existe una imagen
        {
            //En el metodo file ponemos el nombre del campo file que pusimos en la vista, que sera el que tenga los datos de la imagen
            $file=$request->file('image');
            //Para evitar nombres repetidos en las imagenes, creamos un nombre antes de guardar
            $name='credITSCH_'.time().'.'.$file->getClientOriginalExtension();
            //Generamos la ruta donde se guardaran las imagenes de los articulos
            $path=public_path().'/images/evidencias/';
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
        $responsables = DB::table('actividad_evidencia as ae')->join('users as u','u.id','ae.user_id')->where('ae.actividad_id','=',$request->id)->select('u.id','u.name')->orderBy('u.name')->get();
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
}
