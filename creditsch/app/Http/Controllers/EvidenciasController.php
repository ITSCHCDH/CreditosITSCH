<?php

namespace App\Http\Controllers;

use App\Evidencia;
use Illuminate\Http\Request;
use App\User;
use App\Actividad;
use App\Http\Requests\EvidenciasRequest;
use Laracasts\Flash\Flash; //Es el paquete para poder usar los mensajes de alerta tipo bootstrap

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
    public function create()
    {
        //$evidencia->user_id=\Auth::user()->id;//Obtiene el id del usuario que esta logueado
        //Ponemos el codigo de la vista que se llamara para las altas de los creditos
        $usuarios=User::orderBy('name','asc')->pluck('name','id');//Traemos todas las categorias que existen en la bd
        $actividad=Actividad::orderBy('nombre','asc')->pluck('nombre','id');//Traemos todas las actividades
        /**********************************************************************************/
        $responsables=User::select('name','id')->orderBy('name')->pluck('name','id');
        return view('admin.evidencias.create')
            ->with('usuarios',$usuarios)
            ->with('actividad',$actividad)->with('responsables',$responsables);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EvidenciasRequest $request)
    {
        //Guarda la evidencia
        //dd($request);
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
        $evidencia->nom_imagen=$name;//Obtiene el nombre de la imagen para guardarlo en la bd
        $evidencia->save();//Guarda la evidencia en su tabla

        Flash::success('El articulo '.$evidencia->nombre.' se guardo con exito');
        return redirect()->route('evidencias.index');
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
