<?php

namespace App\Http\Controllers;

use App\Models\Credito;
use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\Actividad_Evidencia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Alert;
use App\Http\Controllers\Utilities\DataTableAttr;
use App\Http\Controllers\Utilities\DataTableHelper;
use App\Http\Controllers\Utilities\HttpCode;
use Exception;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        return view('admin.actividades.index');
    }

    public function cargarActividadesAjax(Request $request)
    {
        try {
            $mostrar_no_vigentes = $request->input('vigente');

            $selectColumns = [
                'a.nombre as actividad_nombre','a.id','a.por_cred_actividad','a.vigente',
                'a.alumnos','c.nombre as credito_nombre','u.name as administrador','a.id_user',
                DB::raw('count(par.id) as no_alumnos'), DB::raw('DATE_FORMAT(a.created_at, "%d-%m-%Y") as fecha_creacion'), DB::raw('DATE_FORMAT(a.fecCierre,"%d-%m-%Y") as fecCierre')
            ];

            $dtAttr = new DataTableAttr($request, $selectColumns);

            $fecHoy = Carbon::now();

            $actividades = DB::table('actividad as a')
                ->leftjoin('users as u',$this->indexActFiltroJoinVIP())
                ->leftjoin('actividad_evidencia as act_evi', 'act_evi.actividad_id', '=', 'a.id')
                ->leftjoin('participantes as par','par.id_evidencia','=','act_evi.id')
                ->leftjoin('creditos as c','c.id','=','a.id_actividad')
                ->select($selectColumns)
                ->groupBy('a.id');

            DataTableHelper::applyOnly($actividades, $dtAttr, [DataTableHelper::WHERE, DataTableHelper::ORDER_BY]);

            $actividades->where('a.vigente','<>', $mostrar_no_vigentes)->where('fecCierre','>=',$fecHoy);

            DataTableHelper::applyOnly($actividades, $dtAttr, [DataTableHelper::PAGINATE]);

            $this->agregarActividadesAcciones($actividades);

            $paginatorResponse = DataTableHelper::paginatorResponse($actividades, $dtAttr);

            return response()->json($paginatorResponse, HttpCode::SUCCESS);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), HttpCode::NOT_ACCEPTABLE);
        }
    }

    private function indexActFiltroJoinVIP()
    {
        if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD','VIP_SOLO_LECTURA'])) {
            return function($join){
                $join->on('u.id','=','a.id_user');
            };
        } else {
            return function($join) {
                $join->on('u.id','=','a.id_user');
                $join->where('u.id','=',Auth::User()->id);
            };
        }
    }

    private function agregarActividadesAcciones(&$actividades)
    {
        foreach ($actividades as $actividad) {
            $actividad->acciones = "";

            if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD','MODIFICAR_ACTIVIDAD','CREAR_ACTIVIDAD','ELIMINAR_ACTIVIDAD','AGREGAR_RESPONSABLES','VIP_SOLO_LECTURA'])) {
                if ($actividad->vigente == 'true' && Auth::User()->hasAnyPermission(['VIP','CREAR_ACTIVIDAD','VIP_ACTIVIDAD'])) {
                    $actividad->acciones .= '<a href="#" class="btn btn-info btn-sm ms-1" ' .
                        'onclick="redireccionar(' . $actividad->id . ');" title="Agregar participantes (Alumnos) a la actividad">' .
                        '<i class="fas fa-users" style="font-size:14px"></i></a>';
                }

                if (Auth::User()->hasAnyPermission(['VIP','VER_RESPONSABLES','VIP_ACTIVIDAD','VIP_SOLO_LECTURA'])) {
                    if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD','VIP_SOLO_LECTURA'])) {
                        $actividad->acciones .= '<a href="' . route('responsables',$actividad->id) . '" ' .
                            'class="btn btn-primary btn-sm ms-1">' .
                            '<i class="fas fa-user-plus" style="font-size:14px" title="Ver/Asignar responsables"></i></a>';
                    } else if ($actividad->id_user == Auth::User()->id) {
                        $actividad->acciones .= '<a href="' . route('responsables',$actividad->id) . '" ' .
                            'class="btn btn-primary btn-sm ms-1">' .
                            '<i class="fas fa-user-plus" style="font-size:14px" title="Ver/Asignar responsables"></i></a>';
                    }
                }

                if (Auth::User()->hasAnyPermission(['VIP','VIP_EVIDENCIA','VERIFICAR_EVIDENCIA','VIP_ACTIVIDAD'])) {
                    $actividad->acciones .= '<a href="' . route('verifica_evidencia.index',
                        [
                            'validadas=on',
                            'busqueda=' . $actividad->actividad_nombre,
                            'actividades_link=true'
                        ]) .
                        '" class="btn btn-success btn-sm ms-1" title="Verificar evidencias de esta actividad">' .
                        '<i class="far fa-edit" style="font-size:14px"></i></a>';
                }

                if (Auth::User()->hasAnyPermission(['VIP','MODIFICAR_ACTIVIDAD','VIP_ACTIVIDAD'])) {
                    if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD'])) {
                        $actividad->acciones .= '<a href="' . route('actividades.edit',[$actividad->id]) .
                            '" class="btn btn-warning btn-sm ms-1" title="Editar actividad"><i class="fas fa-pencil-alt" ' .
                            'style="font-size:14px"></i></a>';
                    } else if ($actividad->id_user==Auth::User()->id) {
                        $actividad->acciones .= '<a href="' . route('actividades.edit',[$act->id]) .
                            '" class="btn btn-warning btn-sm ms-1" title="Editar actividad"><i class="fas fa-pencil-alt" ' .
                            'style="font-size:14px"></i></a>';
                    }
                }

                if (Auth::User()->hasAnyPermission(['VIP','ELIMINAR_ACTIVIDAD','VIP_ACTIVIDAD'])) {
                    if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD'])) {
                        $actividad->acciones .= '<button data-mdb-toggle="modal"  data-mdb-target="#modEliminar" ' .
                            'onclick="eliminar(' . $actividad->id . ')" class="btn btn-danger btn-sm ms-1" title="Eliminar actividad">' .
                            '<i class="far fa-trash-alt" style="font-size:14px"></i></button>';
                    } else if ($act->id_user==Auth::User()->id) {
                        $actividad->acciones .= '<button data-mdb-toggle="modal"  data-mdb-target="#modEliminar" ' .
                            'onclick="eliminar(' . $actividad->id . ')" class="btn btn-danger btn-sm ms-1" title="Eliminar actividad">' .
                            '<i class="far fa-trash-alt" style="font-size:14px"></i></button>';
                    }
                }
            } else {
                $actividad->acciones .= 'NA';
            }
        }
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
            Alert::error('Error', 'El nombre '.$act->nombre.' ya ha sido tomado, ingrese uno diferente');
            return back()->withInput();
        }
        if($act->por_cred_actividad>100){

            //Llamado a mensajes con la libreria Sweet Alert
            Alert::error('Error', 'El porcentaje de liberación no debe exceder el 100% del credito');
            return back()->withInput();
        }
        $act->save(); //Guarda el articulo en su tabla

        //Llamado a mensajes con la libreria Sweet Alert
        Alert::success('Correcto', 'La actividad '.$act->nombre.' se registro de forma correcta');
        return redirect()->route('actividades.index');

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
            Alert::error('Error', 'La actividad no existe');
            return redirect()->route('actividades.index');

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
    {

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
            Alert::error('Error','El porcentaje de liberación no debe exceder el 100% del credito');
            return back()->withInput();
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
                Alert::error('Error','La actividad ya tiene evidencias validadas');
                return redirect()->back();

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

        Alert::warning('Alerta', 'La actividad '.$act_nueva->nombre.' ha sido editada con exito');

        return redirect()->route('actividades.index');

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
            Alert::error('Error','La actividad no existe');
            return redirect()->route('actividades.index');
        }
        if (Auth::User()->hasAnyPermission(['VIP_ACTIVIDAD','VIP'])) {
            $asignada = Actividad_Evidencia::where('actividad_id','=',$act->id)->get()->count()>0?true: false;
            if($asignada){
                Alert::error('Error','La actividad no puede ser eliminada debido a que cuenta con responsables asignados.');
                return redirect()->route('actividades.index');
            }
            $act->delete();
            Alert::success('Correcto','La actividad '.$act->nombre.' ha sido borrada con exito');
            return redirect()->route('actividades.index');

        }else if(Auth::User()->can('ELIMINAR_ACTIVIDAD') && Auth::User()->id==$act->id_user){
            $asignada = Actividad_Evidencia::where('actividad_id','=',$act->id)->get()->count()>0?true: false;
            if($asignada){
                Alert::error('Error','La actividad no puede ser eliminada debido a que cuenta con responsables asignados.');
                return redirect()->route('actividades.index');

            }
            $act->delete();
            Alert::success('Correcto','La actividad '.$act->nombre.' ha sido borrada con exito');
            return redirect()->route('actividades.index');
        }else{
            Alert::error('Error','No tienes permisos para eliminar esta actividad');
            return redirect()->route('actividades.index');
        }
    }


}
