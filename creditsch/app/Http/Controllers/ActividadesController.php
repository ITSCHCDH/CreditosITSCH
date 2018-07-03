<?php

namespace App\Http\Controllers;

use App\Credito;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use App\Actividad;
use Illuminate\Support\Facades\Auth;

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
        $act=Actividad::find($id);
        $act->fill($request->all());
        $act->save();

        Flash::warning('La actividad '.$act->nombre.' ha sido editada con exito');
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
