<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Laracasts\Flash\Flash;
use App\Credito;
use App\Actividad;
use App\User;
use App\Actividad_Evidencia;
use App\Evidencia;
use App\ALumno;
use App\ConstanciaComplemento;
use DB;
use PDF;
class AlumnosRutasController extends Controller
{
    public function home(){
    	return view('home');
    }

    public function avance(){
		$alumno_data=null;
	    $avance = true;
        $liberado = false;
	    //Traemos todos los creditos existentes
	    $creditos = Credito::select('nombre')->orderBy('nombre')->get();

        //Consulta para obterner el avance del alumno
		$alumno_data = DB::table('alumnos as alu')->join('participantes as p', function($join){
			$join->on('p.no_control','=','alu.no_control');
			$join->where('alu.no_control','=',Auth::User()->no_control);
		})->join('actividad_evidencia as ae',function($join){
            $join->on('ae.id','=','p.id_evidencia');
            $join->where('ae.validado','=','true');
        })->join('evidencia as e',function($join){
            $join->on('e.id_asig_actividades','=','ae.id');
        })->join('actividad as a','a.id','=','ae.actividad_id')->join('creditos as c','c.id','=','a.id_actividad')->join('avance as av',function($join){
			$join->on('av.id_credito','=','c.id');
			$join->where('av.no_control','=',Auth::User()->no_control);
		})->join('areas','areas.id','=','alu.carrera')->select('alu.no_control','alu.nombre as nombre_alumno','areas.nombre as carrera','c.nombre as nombre_credito','a.nombre as nombre_actividad','a.por_cred_actividad','av.por_credito')->orderBy('nombre_credito')->groupBy('nombre_actividad')->get();
        $liberado = $this->alumnoLiberado();
        //Validamos que el alumnos tenga algun avance
		if($alumno_data->count()==0){
            //SI no tiene avance solo retornamos los datos del alumno los datos del alumno
            $avance = false;
            $alumno_data= DB::table('alumnos')->select('nombre as nombre_alumno','carrera','no_control')->where('no_control','=',Auth::User()->no_control)->get();
        }
    	return view('alumnos.avance')
    	->with('alumno_data',$alumno_data)
    	->with('creditos',$creditos)
    	->with('avance',$avance)
        ->with('liberado',$liberado);
    }

    public function imprimir(){
        $existe_alumno = Alumno::where('no_control','=',Auth::User()->no_control)->get()->count()>0? true: false;
        if(!$existe_alumno){
            Flash::error('El numero de control no existe');
            return redirect()->back();
        }
        $meses = [
            'enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'
        ];
        $fecha_actual = Carbon::now()->setTimezone('CDT')->format('d m Y');
        $tokenizer = strtok($fecha_actual," ");
        $dia = $tokenizer;
        $tokenizer = strtok(" ");
        $mes = (int)$tokenizer;
        $tokenizer = strtok(" ");
        $year = $tokenizer;
        $raiz = (string)public_path();
        if($raiz[0]!="/"){
            $raiz="";
        }else{
            $raiz = $raiz[0];
        }
        $datos_globales = ConstanciaComplemento::all();
        $jefe_depto = DB::table('constancia_complemento  as cc')->join('users as u','u.id','=','cc.jefe_depto')->select('u.name','cc.jefe_depto_enunciado','cc.profesion_jefe_depto')->get();
        $certificador = DB::table('constancia_complemento as cc')->join('users as u','u.id','=','cc.certificador')->select('u.name','cc.profesion_certificador','cc.certificador_enunciado')->get();
        $jefe_division = DB::table('alumnos as alu')->join('constancia as c', function($join){
            $join->on('alu.carrera','=','c.carrera');
            $join->where('alu.no_control','=',Auth::User()->no_control);
        })->join('users as u','u.id','=','c.jefe_division')->select('u.name','c.division_enunciado','c.profesion_jefe_division')->get();
        $alumno = DB::table('alumnos')->join('areas','areas.id','=','alumnos.carrera')->where('alumnos.no_control','=',Auth::User()->no_control)->select('alumnos.nombre','alumnos.no_control','areas.nombre as carrera')->get();
        $alumno_data = DB::select('select c.nombre as credito_nombre, u.name as credito_jefe from creditos as c join avance on avance.id_credito=c.id and avance.no_control = "'.Auth::User()->no_control.'" and avance.por_credito >= 100 join users as u on u.id = c.credito_jefe order by c.id limit 5');
        if(count($alumno_data)!=5){
            Flash::error('El alumno aun no liberado todos sus credito complementarios');
            return redirect('/home');
        }
        sort($alumno_data);
        $data = [
            'datos_globales' => $datos_globales[0],
            'dia' => $dia,
            'mes' => $meses[$mes-1],
            'year' => $year,
            'jefe_depto' => $jefe_depto[0],
            'raiz' => $raiz,
            'certificador' => $certificador[0],
            'jefe_division' => $jefe_division[0],
            'alumno' => $alumno[0],
            'alumno_data' => $alumno_data
        ];
        $pdf = PDF::loadView('admin.constancias.constancia_alumno', compact('data'));
        //return view('admin.constancias.constancia');
        return $pdf->stream('constancia.pdf');
    }

    public function alumnoLiberado(){
        $alumno_data = DB::select('select c.nombre as credito_nombre, u.name as credito_jefe from creditos as c join avance on avance.id_credito=c.id and avance.no_control = "'.Auth::User()->no_control.'" and avance.por_credito >= 100 join users as u on u.id = c.credito_jefe order by c.id limit 5');
        if(count($alumno_data)!=5) return false;
        return true;
    }
    public function actividades(){
    	$actividades = DB::table('participantes as p')->join('actividad_evidencia as ae', function($join){
    		$join->on('ae.id','=','p.id_evidencia');
    		$join->where('p.no_control','=',Auth::User()->no_control);
    	})->join('actividad as a','a.id','=','ae.actividad_id')->select('a.nombre as actividad_nombre','a.id as actividad_id','a.por_cred_actividad as actividad_porcentaje','a.alumnos','ae.validado','ae.user_id')->orderBy('actividad_nombre','ASC')->get();
    	return view('alumnos.actividades')
    	->with('actividades',$actividades);
    }
    public function subirEvidencia(Request $request){
        $existe_actividad = Actividad_Evidencia::where([
            ['user_id','=',$request->id_responsable],
            ['actividad_id','=',$request->id_actividad]
        ])->get();
        if($existe_actividad->count()==0){
            return redirect()->back();
        }else if($existe_actividad[0]->validado=="true"){
            return redirect()->route('alumnos.actividades');
        }
    	$usuarios = User::select('name','id')->orderBy('name','ASC')->get()->pluck('name','id');
    	$usuarios_sin_pluck = User::select('name','id')->orderBy('name','ASC')->get();
    	$validador = Actividad_Evidencia::where([
    	    ['user_id','=',$request->id_responsable],
    	    ['actividad_id','=',$request->id_actividad]
    	])->select('validador_id')->get();
    	$responsable = User::select('id','name')->where('id','=',$request->id_responsable)->get();
    	$actividad = Actividad::select('id','nombre')->where('id','=',$request->id_actividad)->get();
    	if($actividad->count()==0 || $responsable->count()==0){
    	    Flash::error('No actividad o responsable seleccinado');
    	    return redirect()->route('participantes.index');
    	}
    	return view('alumnos.subir_evidencia')
    	->with('responsable',$responsable[0])
    	->with('actividad',$actividad[0])
    	->with('usuarios',$usuarios)
    	->with('validador_id',$validador)
    	->with('usuarios_sin_pluck',$usuarios_sin_pluck);
    }

    public function guardarEvidencia(Request $request){
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
    	        $evidencia->alumno_no_control = $request->no_control;
    	        $evidencia->save();//Guarda la evidencia en su tabla
    	        
    	    }
    	    $actividad_evidencia = Actividad_Evidencia::find($id_actividad_evidencia[0]->id);
    	    $actividad_evidencia->validador_id = $request->valida;
    	    $actividad_evidencia->save();
    	}
    	Flash::success('La evidencia fue guardada correctamente');
    	return redirect()->route('alumnos.actividades');
    }

    public function evidencia(Request $request){
    	$evidencias = DB::table('actividad_evidencia as ae')->join('evidencia as e', function($join) use($request){
    		$join->on('e.id_asig_actividades','=','ae.id');
    		$join->where('ae.user_id','=',$request->user_id);
    		$join->where('ae.actividad_id','=',$request->actividad_id);
    		$join->where('e.alumno_no_control','=',Auth::User()->no_control);
    	})->join('actividad as a','a.id','=','ae.actividad_id')->join('users as u','u.id','=','ae.user_id')->select('a.nombre as actividad_nombre','a.id as actividad_id','e.nom_imagen as evidencia_nombre','ae.user_id','e.created_at as fecha','e.id as evidencia_id','u.name as usuario_nombre')->get();
    	$actividad = Actividad::find($request->actividad_id);
    	$actividad_evidencia = DB::table('actividad_evidencia as ae')->join('participantes as p','p.id_evidencia','=','ae.id')->where([
    		['p.no_control','=',Auth::User()->no_control],
    		['ae.user_id','=',$request->user_id],
    		['ae.actividad_id','=',$request->actividad_id]
    	])->select('ae.id')->get();
    	if($actividad_evidencia->count()==0)$actividad=null;
        $validado = Actividad_Evidencia::where([
            ['user_id','=',$request->user_id],
            ['actividad_id','=',$request->actividad_id]
        ])->select('validado')->get();
    	return view('alumnos.evidencia')
    	->with('evidencias',$evidencias)
    	->with('actividad',$actividad)
        ->with('validado',$validado);
    }

    public function eliminarEvidencia(Request $request){
    	if($request->has('actividad') && $request->has('archivo') && $request->has('archivo_nombre')){
    	    Evidencia::destroy($request->get('archivo'));
    	    Storage::delete('public/evidencias/'.$request->get('actividad').'/'.$request->get('archivo_nombre'));
    	    return response()->json(array('mensaje' => 'Evidencia eliminada con exito','tipo' => 'exito'));
    	}
    	return response()->json(array('mensaje' => 'Error al eliminar la evidencia', 'tipo' => 'error'));
    }
}
