<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Credito; //Es el nombre del modelo con el que va a trabajar el controlador
use App\Models\CreditoArea;
use App\Services\Sit\CarrerasSitService;
use App\User;
use Illuminate\Support\Str;
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

    
    public function index()
    {
        //Aqui mandamos llamar la vista de la pagina de inicio de alumnos
        $credito = Credito::leftjoin('users as u','u.id','=','creditos.credito_jefe')->select('creditos.nombre','creditos.vigente','creditos.id','u.name as jefe_nombre')->get();

        $faltan_jefes = Credito::whereNull('credito_jefe')->get()->count() > 0;
        
        return view('admin.creditos.index')
        ->with('credito',$credito)
        ->with('faltan_jefes',$faltan_jefes);
    }

   
    public function create()
    {
        //Ponemos el codigo de la vista que se llamara para las altas de los creditos
        $areas = CarrerasSitService::visibles(null, true);
        $usuarios = User::where('active','=','true')->get();
        return view('admin.creditos.create')
        ->with('areas',$areas)
        ->with('usuarios',$usuarios);
    }

 
    public function store(Request $request)
    {
       
        //Recibimos los datos de la vista de altas y en este metodo es donde registramos los datos a la BD
        $request->validate([
            'nombre' => ['required','string','max:70'],
            'credito_jefe' => ['required','integer','exists:users,id'],
            'areas' => ['required','array','min:1'],
            'vigente' => ['nullable','in:true,false'],
        ]);

        $credito = new Credito($request->all());
        $credito->vigente = $request->input('vigente', 'true');
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
        //Codigo de modificaciones: carreras activas de SIT y cuáles ya están ligadas
        $seleccionadas = CreditoArea::where('credito_id','=',$id)->pluck('credito_area')->all();
        $areas = CarrerasSitService::visibles(null, true)->map(function ($carrera) use ($id, $seleccionadas) {
            return (object) [
                'id' => $carrera->id,
                'nombre' => $carrera->nombre,
                'credito_id' => in_array($carrera->id, $seleccionadas) ? $id : null,
            ];
        });

        $credito=Credito::find($id);//Busca el registro
        if($credito==null){
            Alert::error('Error','El credito no existe');
            return redirect()->route('creditos.index');
        }
        $usuarios = User::where('active','=','true')
            ->orWhere('id','=',$credito->credito_jefe)
            ->orderBy('name')
            ->get()
            ->map(function ($usuario) {
                $usuario->name = Str::upper($usuario->name);
                return $usuario;
            });
        return view('admin.creditos.edit')
        ->with('credito',$credito)
        ->with('areas',$areas)
        ->with('usuarios',$usuarios);
    }

    public function buscarJefes(Request $request)
    {
        $texto = trim((string) $request->get('nombre'));
        $consulta = User::where('active','=','true');

        if ($texto !== '') {
            $consulta->where('name','like',"%{$texto}%");
        }

        return response()->json(
            $consulta->orderBy('name')
                ->limit(20)
                ->get(['id','name'])
                ->map(function ($usuario) {
                    $usuario->name = Str::upper($usuario->name);
                    return $usuario;
                })
        );
    }

  
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => ['required','string','max:70'],
            'credito_jefe' => ['required','integer','exists:users,id'],
            'areas' => ['required','array','min:1'],
            'vigente' => ['nullable','in:true,false'],
        ]);

        CreditoArea::where('credito_id','=',$id)->delete();
        //Ejecuta la modificacion
        $credito= Credito::find($id);
        $credito->nombre=$request->nombre;
        $credito->credito_jefe = $request->credito_jefe;
        $credito->vigente = $request->input('vigente', $credito->vigente);
        $credito->save();
        for($x=0; $x<count($request->areas); $x++){
            $credito_area = new CreditoArea();
            $credito_area->timestamps = false;
            $credito_area->credito_id=$id;
            $credito_area->credito_area=$request->areas[$x];
            $credito_area->save();
        }
        Alert::warning('Alerta','El credito '. $credito->nombre .' a sido editado de forma exitosa');//Envia mensaje
        return redirect()->route('creditos.index');
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
            Alert::error('Error','No se puede eliminar debido a que hay actividades registradas en este crédito');
            return redirect()->route('creditos.index');
        }
        $credito->delete();//Elimina el registro
        Alert::success('Correcto','El credito '. $credito->nombre .' a sido borrado de forma exitosa');
        return redirect()->route('creditos.index');
    }
}
