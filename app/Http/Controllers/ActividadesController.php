<?php

namespace App\Http\Controllers;

use App\Models\Credito;
use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\Actividad_Evidencia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DB;

class ActividadesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:VIP_SOLO_LECTURA|VIP|VER_ACTIVIDAD|VIP_ACTIVIDAD')->only(['index','show']);
        $this->middleware('permission:VIP|VIP_ACTIVIDAD|CREAR_ACTIVIDAD')->only(['create','store']);
        $this->middleware('permission:VIP|VIP_ACTIVIDAD|MODIFICAR_ACTIVIDAD')->only(['edit','update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vigente = 'true';
        if(!$request->has('vigente')){
            if($request->has('nombre'))
                $vigente = 'false';
        }
        //Aqui mandamos llamar todos los datos de las actividades creadas
        if(Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD','VIP_SOLO_LECTURA'])){
            $act = DB::table('actividad as a')->leftjoin('actividad_evidencia as act_evi',function($join){
                $join->on('act_evi.actividad_id','=','a.id');
            })->leftjoin('participantes as par','par.id_evidencia','=','act_evi.id')->leftjoin('users as u','u.id','=','a.id_user')->leftjoin('creditos as c','c.id','=','a.id_actividad')->where(function($query) use($request){
                $query->where('a.nombre','LIKE',"%$request->nombre%")->orwhere('u.name','like',"%$request->nombre%")->orwhere('c.nombre','like',"%$request->nombre%");
            })->where(function($query) use($vigente){
                if($vigente == 'false'){
                    $query->where('a.vigente','=','false');
                }else{
                    $query->where('a.vigente','=','true');
                }
            })->select('a.nombre as actividad_nombre','a.id','a.por_cred_actividad','a.vigente','a.alumnos','c.nombre as credito_nombre','u.name as usuario_nombre','a.id_user',DB::raw('count(par.id) as no_alumnos'))->groupBy('a.id')->orderby('id','asc')->paginate(5);
        }else{
            $act = DB::table('actividad as a')->join('users as u', function($join){
                $join->on('u.id','=','a.id_user');
                $join->where('u.id','=',Auth::User()->id);
            })->leftjoin('creditos as c','c.id','=','a.id_actividad')->leftjoin('actividad_evidencia as act_evi','act_evi.actividad_id','=','a.id')->leftjoin('participantes as par','par.id_evidencia','=','act_evi.id')->where(function($query) use($request){
                $query->where('a.nombre','LIKE',"%$request->nombre%")->orwhere('u.name','like',"%$request->nombre%")->orwhere('c.nombre','like',"%$request->nombre%");
            })->where(function($query) use($vigente){
                if($vigente == 'false'){
                    $query->where('a.vigente','=','false');
                }else{
                    $query->where('a.vigente','=','true');
                }
            })->select('a.nombre as actividad_nombre','a.id','a.por_cred_actividad','a.vigente','a.alumnos','c.nombre as credito_nombre','u.name as usuario_nombre','a.id_user',DB::raw('count(par.id) as no_alumnos'))->groupBy('a.id')->orderby('id','asc')->paginate(5);
        }
        return view('admin.actividades.index')
        ->with('actividad',$act)
        ->with('nombre',$request->nombre)
        ->with('vigente',$vigente);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD'])) {
            $creditos = Credito::where('vigente','=','true')->orderBy('nombre','asc')->get();
           
        }else{
            $creditos = Credito::leftjoin('creditos_areas as ca','ca.credito_id','=','creditos.id')->where([
                ['ca.credito_area','=',Auth::User()->area],
                ['creditos.vigente','=','true']
            ])->groupBy('creditos.id')->orderBy('creditos.nombre','asc')->pluck('creditos.nombre','creditos.id');
        }
        
       return view('admin.actividades.create')->with('creditos',$creditos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $act=new Actividad($request->all()); //Obtiene todos los datos de la vista para guardarlos en la BD
        $act->id_user = Auth::User()->id;
        $actividad_con_mismo_nombre = Actividad::where('nombre','=',$act->nombre)->get();
        if(!Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD'])){
            $areas_del_credito = DB::table('creditos as c')->join('creditos_areas as ca', function($join) use($request){
                $join->on('c.id','=','ca.credito_id');
                $join->where('c.id','=',$request->id_actividad);
            })->select('ca.credito_area as area_id')->get();
            $tiene_permitido = false;
            foreach ($areas_del_credito as $area) {
                if($area->area_id == Auth::User()->area){
                    $tiene_permitido = true;
                }
            }
            if(!$tiene_permitido){                
                return redirect()->back()
                ->with("error","No puedes crear actividades de este crédito");
            }
        }
        if($actividad_con_mismo_nombre->count()>0){            
            return back()->withInput()
            ->with("error","El nombre ".$act->nombre." ya ha sido tomado, ingrese uno diferente");
        }
        if($act->por_cred_actividad>100){           
            return back()->withInput()
            ->with("error","El porcentaje de liberación no debe exceder el 100% del credito");
        }
        $act->save(); //Guarda el articulo en su tabla        
        return redirect()->route('actividades.index')
        ->with("success","La actividad ".$act->nombre." se registro de forma correcta");
    }

   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $act=Actividad::find($id);//Busca el registro        
        if($act==null){            
            return redirect()->route('actividades.index')
            ->with("error","La actividad no existe");
        }
        if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD'])) {
            
            $creditos=Credito::orderBy('nombre','asc')->get();         
            return view('admin.actividades.edit')->with('actividad',$act)->with('creditos',$creditos);
        }else{
            $creditos=Credito::orderBy('nombre','asc')->get();
            return view('admin.actividades.edit')->with('actividad',$act)->with('creditos',$creditos);
        }
        //Codigo de modificaciones
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { dd('Si llega');

        $act_anterior=Actividad::find($id);
        $act_nueva=Actividad::find($id);
        $act_nueva->fill($request->all());
        $actividad_con_mismo_nombre = Actividad::where('nombre','=',$act_nueva->nombre)->get();
        if($actividad_con_mismo_nombre->count()>0){
            if($actividad_con_mismo_nombre[0]->id!=$id){                
                return back()->withInput()
                ->with("error","El nombre ".$act_nueva->nombre." ya ha sido tomado, ingrese uno diferente");
            }
        }
        if($act_nueva->por_cred_actividad>100){            
            return back()->withInput()
            ->with("error","El porcentaje de liberación no debe exceder el 100% del credito");
        }
        if($act_anterior->id_actividad != $act_nueva->id_actividad || $act_anterior->por_cred_actividad != $act_nueva->por_cred_actividad){
            $tiene_foraneas = DB::table('actividad as a')->join('actividad_evidencia as ae', function($join) use($id){
                $join->on('ae.actividad_id','=','a.id');
                //$join->where('a.id','=',$id);
                $join->where([
                    ['a.id','=',$id],
                    ['ae.validado','=','true']
                ]);
            })->get()->count()>0? true: false;
            if($tiene_foraneas){                
                return redirect()->back()
                ->with("error","La actividad ya tiene evidencias validadas");
            }
        }
        $act_nueva->save();
        //En caso de la actividad ya cuente con evidencias y a esta se le cambie el nombre
        //el directorio de la misma tambien debe ser cambiado
        if($act_anterior->nombre!=$act_nueva->nombre && Storage::has('public/evidencias')){
            // Validamos si existe el directorio con el nombre anterios si no significa que no tenia evidencia agregada aun
            if(Storage::has('public/evidencias/'.$act_anterior->nombre)){
                //Traemos todos los archivos del directorio
                $archivos = Storage::allFiles('public/evidencias/'.$act_anterior->nombre);
                if(!Storage::has('public/evidencias/'.$act_nueva->nombre)){
                    //En caso de que no exista el nuevo directorio lo creamos
                    Storage::makeDirectory('public/evidencias/'.$act_nueva->nombre);
                }
                //Iteramos entre todos los archivos y los vamos moviendo uno por uno
                for ($i = 0; $i < count($archivos); $i++) {
                    $tokenizer = strtok($archivos[$i],"/");
                    //Existen 3 diagonales antes de llegar al nombre del archivo
                    for ($x = 0; $x < 4 && $tokenizer; $x++) {
                        echo "$tokenizer $x ";
                        if($x==3)break;
                        $tokenizer = strtok("/");
                    }
                    //Movemos los archivos al nuevo directorio
                    Storage::move('public/evidencias/'.$act_anterior->nombre.'/'.$tokenizer,'public/evidencias/'.$act_nueva->nombre.'/'.$tokenizer);
                }
                //Eliminamos el directorio anterior
                Storage::deleteDirectory('public/evidencias/'.$act_anterior->nombre);
            }
        }
        
        return redirect()->route('actividades.index')
        ->with("warning","La actividad ".$act_nueva->nombre." ha sido editada con exito");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $act=Actividad::find($id);
        if($act==null){            
            return redirect()->route('actividades.index')
            ->with("error","La actividad no existe");
        }
        if (Auth::User()->hasAnyPermission(['VIP_ACTIVIDAD','VIP'])) {
            $asignada = Actividad_Evidencia::where('actividad_id','=',$act->id)->get()->count()>0?true: false;
            if($asignada){               
                return redirect()->route('actividades.index')
                ->with("error","La actividad no puede ser eliminada debido a que cuenta con responsables asignados.");
            }
            $act->delete();            
            return redirect()->route('actividades.index')
            ->with("error","La actividad ".$act->nombre." ha sido borrada con exito");
        }else if(Auth::User()->can('ELIMINAR_ACTIVIDAD') && Auth::User()->id==$act->id_user){
            $asignada = Actividad_Evidencia::where('actividad_id','=',$act->id)->get()->count()>0?true: false;
            if($asignada){               
                return redirect()->route('actividades.index')
                ->with("error","La actividad no puede ser eliminada debido a que cuenta con responsables asignados.");
            }
            $act->delete();            
            return redirect()->route('actividades.index')
                ->with("warning","La actividad '.$act->nombre.' ha sido borrada con exito");
        }else{            
            return redirect()->route('actividades.index')
            ->with("error","No tienes permisos para eliminar esta actividad");
        }      
    }

   
}
