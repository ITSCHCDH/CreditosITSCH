<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Credito; //Es el nombre del modelo con el que va a trabajar el controlador
use App\Models\Area;
use App\Models\CreditoArea;
use App\User;
use DB;
use Alert;

class CreditosController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:VIP_SOLO_LECTURA|VIP|VER_CREDITOS')->only(['index']);
        $this->middleware('permission:VIP|CREAR_CREDITOS')->only(['create','store']);
        $this->middleware('permission:VIP|ELIMINAR_CREDITOS')->only('destroy');
        $this->middleware('permission:VIP|MODIFICAR_CREDITOS')->only(['edit','update']);
    }

    public function show()
    {
        dd('show');
    }
   
    public function index()
    {
        //Aqui mandamos llamar la vista de la pagina de inicio de alumnos
        $credito = Credito::leftjoin('users as u','u.id','=','creditos.credito_jefe')->select('creditos.nombre','creditos.vigente','creditos.id','u.name as jefe_nombre')->paginate(5);

        $faltan_jefes = Credito::whereNull('credito_jefe')->get()->count() > 0;
        
        return view('admin.creditos.index')
        ->with('credito',$credito)
        ->with('faltan_jefes',$faltan_jefes);
    }

   
    public function create()
    {
        //Ponemos el codigo de la vista que se llamara para las altas de los creditos
        $areas = Area::orderby('nombre','ASC')->get();
        $usuarios = User::where('active','=','true')->get();
        return view('admin.creditos.create')
        ->with('areas',$areas)
        ->with('usuarios',$usuarios);
    }

 
    public function store(Request $request)
    {
        dd('Si llega');
        //Recibimos los datos de la vista de altas y en este metodo es donde registramos los datos a la BD
        $credito = new Credito($request->all());
        //Comando para guardar el registro
        $credito->save();
        for($x=0; $x<count($request->areas); $x++){
            $credito_area = new CreditoArea();
            $credito_area->timestamps = false;
            $credito_area->credito_id=$credito->id;
            $credito_area->credito_area=$request->areas[$x];
            $credito_area->save();
        }     
        Alert::success('Correcto','El credito  '.$credito->nombre.' se ha registrado de forma exitosa');  
        return redirect()->route('creditos.index');      
    }

  
    public function edit($id)
    {
        //Codigo de modificaciones
        $areas = DB::table('areas as a')->leftjoin('creditos_areas as ca', function($join) use($id){
            $join->on('ca.credito_area','=','a.id');
            $join->where('ca.credito_id','=',$id);
        })->select('a.nombre','a.id','ca.credito_id')->orderBy('nombre','ASC')->get();
        $credito=Credito::find($id);//Busca el registro
        if($credito==null){
            Flash::error('El credito no existe');
            return redirect()->route('creditos.index');
        }
        $usuarios = User::where('active','=','true')->orwhere('id','=',$credito->credito_jefe)->get();
        return view('admin.creditos.edit')
        ->with('credito',$credito)
        ->with('areas',$areas)
        ->with('usuarios',$usuarios);
    }

  
    public function update(Request $request, $id)
    {
        CreditoArea::where('credito_id','=',$id)->delete();
        //Ejecuta la modificacion
        $credito= Credito::find($id);
        $credito->nombre=$request->nombre;
        $credito->credito_jefe = $request->credito_jefe;
        $credito->vigente = $request->vigente;
        $credito->save();
        for($x=0; $x<count($request->areas); $x++){
            $credito_area = new CreditoArea();
            $credito_area->timestamps = false;
            $credito_area->credito_id=$id;
            $credito_area->credito_area=$request->areas[$x];
            $credito_area->save();
        }
        Alert::warning('Alerta','El credito '. $credito->nombre .' a sido editado de forma exitosa');//Envia mensaje
        return redirect('admin/creditos');//llama a la pagina de consultas
    }

  
    public function destroy($id)
    {
        //Codigo de bajas
        $credito=Credito::find($id);//Busca el registro
        if($credito==null){
            Alert::error('Error','El credito no existe');
            return redirect()->route('creditos.index');
        }
        $tiene_actividades = DB::table('actividad as a')->join('creditos as c',function($join) use($id){
            $join->on('a.id_actividad','=','c.id');
            $join->where('c.id','=',$id);
        })->select('c.id')->get()->count()>0?true:false;

        $tiene_avance = DB::table('avance as a')->join('creditos as c', function($join) use($id){
            $join->on('c.id','=','a.id_credito');
            $join->where('c.id','=',$id);
        })->select('c.id')->get()->count()>0?true:false;
        if($tiene_avance || $tiene_actividades){
            Alert::error('Error','No se puede eliminar debido a claves foraneas');
            return redirect()->route('creditos.index');
        }
        $credito->delete();//Elimina el registro
        Alert::error('Error','El credito '. $credito->nombre .' a sido borrado de forma exitosa');//Envia mensaje
        return redirect('admin/creditos');//llama a la pagina de consultas
    }
}
