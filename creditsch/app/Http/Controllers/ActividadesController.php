<?php

namespace App\Http\Controllers;

use App\Credito;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use App\Actividad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ActividadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   //Aqui mandamos llamar todos los datos de las actividades creadas
        $act=Actividad::Search($request->nombre)->orderby('id','asc')->paginate(5); //Consulta todos los usuarios y los ordena, ademas pagina la consulta
        //Creamos un metodo que llame a las relaciones de cada una de las actividades
        $act->each(function ($act){
            $act->credito;
        });

        //dd($act);
        return view('admin.actividades.index')->with('actividad',$act); //Llama a la vista y le envia los usuarios

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $creditos=Credito::orderBy('nombre','asc')->pluck('nombre','id');//Traemos todas las categorias que existen en la bd
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
        if($actividad_con_mismo_nombre->count()>0){
            Flash::error('El nombre '.$act->nombre.' ya ha sido tomado, ingrese uno diferente');
            return back()->withInput();
        }
        $act->save(); //Guarda el articulo en su tabla

        Flash::success('La actividad '.$act->nombre.' se registro de forma correcta');
        return redirect()->route('actividades.index');
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
        $act=Actividad::find($id);//Busca el registro
        $creditos=Credito::orderBy('nombre','asc')->pluck('nombre','id');
        return view('admin.actividades.edit')->with('actividad',$act)->with('creditos',$creditos);
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
            Flash::error('El nombre '.$act_nueva->nombre.' ya ha sido tomado, ingrese uno diferente');
            return back()->withInput();
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
        Flash::warning('La actividad '.$act_nueva->nombre.' ha sido editada con exito');
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
        $act->delete();
        Flash::error('La actividad '.$act->nombre.' ha sido borrada con exito');
        return redirect()->route('actividades.index');
    }
}
