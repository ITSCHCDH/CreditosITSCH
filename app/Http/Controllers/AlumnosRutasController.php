<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use App\Models\Credito;
use App\Models\Actividad;
use App\User;
use App\Models\Actividad_Evidencia;
use App\Models\Evidencia;
use App\Models\ALumno;
use App\Models\ConstanciaComplemento;
use App\Models\Folio;
use App\Models\Participante;
use App\Models\Avance;
use PDF;
use Alert;
use App\Http\Controllers\Utilities\HttpCode;
use Illuminate\Support\Facades\DB;

class AlumnosRutasController extends Controller
{

    public function avance(){
        $alumno_data=null;
        $avance = true;
            $liberado = false;
        //Traemos todos los creditos existentes
        $creditos = Credito::select('nombre')->orderBy('nombre')->get();

            //Consulta para obterner el avance del alumno
        $alumno_data = DB::table('alumnos as alu')
            ->join('participantes as p',function($join){
                $join->on('p.no_control','=','alu.no_control');
                $join->where('alu.no_control','=',Auth::User()->no_control);
            })
            ->join('actividad_evidencia as ae',function($join){
                $join->on('ae.id','=','p.id_evidencia');
                $join->where('ae.validado','=','true');
            })
            ->join('evidencia as e',function($join){
                $join->on('e.id_asig_actividades','=','ae.id');
            })
            ->join('actividad as a','a.id','=','ae.actividad_id')
            ->join('creditos as c','c.id','=','a.id_actividad')
            ->join('avance as av',function($join){
                $join->on('av.id_credito','=','c.id');
                $join->where('av.no_control','=',Auth::User()->no_control);
            })
            ->join('areas','areas.id','=','alu.carrera')
            ->where(function($query){
                $query->where('p.evidencia_validada','=','na')->orwhere('p.evidencia_validada','=','si');
            })
            ->where('ae.validado','=','true')
            ->select('alu.no_control','alu.foto as foto','alu.id as alumno_id','alu.nombre as nombre_alumno','areas.nombre as carrera','c.nombre as nombre_credito','a.nombre as nombre_actividad','a.por_cred_actividad','av.por_credito')
            ->orderBy('nombre_credito')
            ->groupBy('nombre_actividad')
            ->get();

            $liberado = $this->verificarProgreso();

            //Validamos que el alumnos tenga algun avance
        if($alumno_data->count()==0){
            //SI no tiene avance solo retornamos los datos del alumno los datos del alumno
            $avance = false; 
            $alumno_data = DB::table('alumnos')->join('areas', function($join){
                $join->on('areas.id','=','alumnos.carrera');
            })->where('alumnos.no_control','=',Auth::User()->no_control)->select('alumnos.id as alumno_id','alumnos.nombre as nombre_alumno','areas.nombre as carrera','alumnos.no_control','alumnos.foto')->get();
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
            Alert::error('Error','El número de control no existe.');
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
        })->join('users as u','u.id','=','c.jefe_division')->select('u.name','c.division_enunciado','c.profesion_jefe_division','c.plan_de_estudios')->get();
        if($jefe_depto->count()==0 || $certificador->count()==0 || $jefe_division->count()==0 || $datos_globales->count()==0){
            Alert::error('Error','Falta de integridad en los datos de la constancia');
            return redirect()->back();
        }
        $alumno = DB::table('alumnos')->join('areas','areas.id','=','alumnos.carrera')->where('alumnos.no_control','=',Auth::User()->no_control)->select('alumnos.nombre','alumnos.no_control','areas.nombre as carrera')->get();
        $alumno_data = DB::select('select c.nombre as credito_nombre, u.name as credito_jefe from creditos as c join avance on avance.id_credito=c.id and avance.no_control = "'.Auth::User()->no_control.'" and avance.por_credito >= 100 join users as u on u.id = c.credito_jefe order by c.id limit 5');
        if(count($alumno_data)<5){
            Alert::error('Error','Si ya tienes tus 5 créditos liberados y no se muestra tu constancia.<br>Probablemente falten datos de la misma.');
            return back();
        }
        sort($alumno_data);
        $obtener_folio = Folio::where('no_control','=',Auth::User()->no_control)->get();
        $folio = -1;
        if($obtener_folio->count() == 0){
            $datos_globales[0]->numero_oficio = $datos_globales[0]->numero_oficio+1;
            $datos_globales[0]->save();
            $folio_object = new Folio();
            $folio_object->no_control = Auth::User()->no_control;
            $folio_object->no_folio = $datos_globales[0]->numero_oficio;
            $folio_object->save();
            $folio = $folio_object->no_folio;
        }else{
            $folio = $obtener_folio[0]->no_folio;
        }
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
            'alumno_data' => $alumno_data,
            'no_oficio' => $folio,
            'plan_de_estudios' => $jefe_division[0]->plan_de_estudios
        ];
        $pdf = PDF::loadView('admin.constancias.constancia_alumno', compact('data'));
        //return view('admin.constancias.constancia');
        return $pdf->stream('constancia.pdf');
    }

    public function verificarProgreso() {
        $no_control = Auth::Guard('alumno')->user()->no_control;

        $avance_data = DB::table('participantes as p')
        ->join('actividad_evidencia as ae', 'ae.id', '=', 'p.id_evidencia')
        ->join('actividad as act', 'act.id', '=', 'ae.actividad_id')
        ->join('creditos as c', 'c.id', '=', 'act.id_actividad')
        ->where([
            ['ae.validado', '=', 'true'],
            ['p.no_control', '=', $no_control]
        ])
        ->whereIn('p.evidencia_validada', ['na', 'si'])
        ->select('act.nombre as act_nombre', 'act.por_cred_actividad as porcentaje',
            'act.id_actividad as act_cred_id')
        ->get();

        $creditos_cant = (int)Credito::max('id');
        $cred_porcen = array_fill(0, $creditos_cant + 1, 0);

        foreach ($avance_data as $avance) {
            $cred_porcen[$avance->act_cred_id] += $avance->porcentaje;
        }

        $avance_alu = Avance::where('no_control', $no_control)->get();
        $creditos_liberados = 0;
        foreach($avance_alu as $avance) {
            if ($cred_porcen[$avance->id_credito] !== (int)$avance->por_credito) {
                $avance->por_credito = $cred_porcen[$avance->id_credito];
                $avance->save();
            }

            if ($avance->por_credito >= 100)
                ++$creditos_liberados;
        }

        if ($creditos_liberados >= 5 && Auth::guard('alumno')->user()->status === 'pendiente') {
            $alumno = Alumno::find(Auth::guard('alumno')->user()->id);
            $alumno->status = 'Liberado';
            $alumno->save();
        } else if (Auth::guard('alumno')->user()->status === 'Liberado') {
            $alumno = Alumno::find(Auth::guard('alumno')->user()->id);
            $alumno->status = 'pendiente';
            $alumno->save();
        }

        return $creditos_liberados >= 5;
    }

    public function actividades(){
        $alumno_data = Alumno::where('no_control',Auth::User()->no_control)->select('id as alumno_id')->get();

        $actividades = DB::table('participantes as p')
            ->join('actividad_evidencia as ae', function($join){
                $join->on('ae.id','=','p.id_evidencia');
                $join->where('p.no_control','=',Auth::User()->no_control);
            })
            ->join('actividad as a','a.id','=','ae.actividad_id')
            ->join('creditos as c','a.id_actividad','=','c.id')
            ->select('a.nombre as actividad_nombre','a.id as actividad_id','a.por_cred_actividad as actividad_porcentaje','a.alumnos','ae.validado','ae.user_id','c.nombre as credito_nombre','p.momento_agregado','p.evidencia_validada')
            ->orderBy('a.created_at','DESC')
            ->get();
        return view('alumnos.actividades')
            ->with('actividades',$actividades)
            ->with('alumno_data',$alumno_data);
    }

    public function subirEvidencia(Request $request){
        $alumno_data = Alumno::where('no_control',Auth::User()->no_control)->select('id as alumno_id')->get();

        $actividad_evidencia = DB::table('actividad_evidencia')->where([
            ['user_id','=',$request->id_responsable],
            ['actividad_id','=',$request->id_actividad]
        ])->select('id','user_id','actividad_id','validado','validador_id')->get();
        $actividad = Actividad::find($request->id_actividad);
        if($actividad_evidencia->count() == 0){
            return redirect()->back();
        }else if($actividad_evidencia[0]->validado == "true"){
            $participante = Participante::where([
                ['id_evidencia','=',$actividad_evidencia[0]->id],
                ['no_control','=',Auth::User()->no_control]
                ])->get()[0];
            if($actividad->alumnos == "true" && ($participante->momento_agregado == "anteriormente" || $participante->evidencia_validada == "si")){
                Alert::error('Error','La actividad ya no acepta modificaciones, ya ha sido validada.');
                return redirect()->route('alumnos.actividades');
            }
        }
        $validador = User::find($actividad_evidencia[0]->validador_id);
            $responsable = User::find($request->id_responsable);
        if($actividad->count() == null || $responsable == null){
            Alert::error('Error','No actividad o responsable seleccionado');
            return redirect()->route('participantes.index');
        }
        return view('alumnos.subir_evidencia')
            ->with('responsable',$responsable)
            ->with('actividad',$actividad)
            ->with('validador',$validador)
            ->with('alumno_data',$alumno_data);
    }

    public function guardarEvidencia(Request $request){
      //dd(Storage::deleteDirectory('public/evidencias'));
      if(!Storage::has('public/evidencias')){
          Storage::makeDirectory('public/evidencias');
      }

      $actividad = Actividad::find($request->actividad_id);
      if (!isset($actividad) && $actividad->vigente == 'false') {
        Alert::error('Error','La actividad ya no acepta modificaciones');
        return redirect()->route('alumnos.actividades');
      }

      if($request->has('archivos')){
          // Creamos un arreglo con las extensiones validas
          $allowedfileExtension=['pdf','jpg','png','jpeg'];
          for ($i = 0; $i < count($request->archivos); $i++) {
             $file = $request->archivos[$i];
             // Obtenemos la exetensión original del archivo
             $extension = strtolower($file->getClientOriginalExtension());
             // Función para saber si la extensión se encuentra dentro de las extensiones permitidas
             $check=in_array($extension,$allowedfileExtension);
             if(!$check){
                 Alert::error('Error','La extensión '.$extension.' no es valida.');
                 return back()->withInput();
             }
          }
      }

      $actividad_evidencia = DB::table('actividad_evidencia')->where([
          ['actividad_id','=',$request->actividad_id],
          ['user_id','=',$request->responsables],
      ])->select('id', 'validado')->first();

      if ($actividad_evidencia->validado == 'true') {
          $participante = DB::table('participantes as p')
              ->join('actividad_evidencia as ae', 'ae.id', '=', 'p.id_evidencia')
              ->where('p.no_control', '=', Auth::User()->no_control)
              ->where('ae.actividad_id', '=', $actividad->id)
              ->first();

          if ($participante->momento_agregado == 'anteriormente' || $participante->evidencia_validada == 'si') {
            Alert::error('Error','La actividad se encuentra validada, motivo por el cual no acepta modificaciones');
            return redirect()->route('alumnos.actividades');
          }
      }

      //Manipulacion de imagenes
      if($request->has('archivos'))//Validamos si existe una imagen
      {
          //Generamos la ruta donde se guardaran las imagenes de los articulos
          $path=storage_path().'/app/public/evidencias/'.$actividad->nombre.'/';
          $path_to_verify = 'public/evidencias/'.$actividad->nombre;
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
              $evidencia->id_asig_actividades=$actividad_evidencia->id;
              $evidencia->nom_imagen=$name;//Obtiene el nombre de la imagen para guardarlo en la bd
              $evidencia->alumno_no_control = $request->no_control;
              $evidencia->save();//Guarda la evidencia en su tabla

          }
          $actividad_evidencia = Actividad_Evidencia::find($actividad_evidencia->id);
          $actividad_evidencia->save();
      }
      Alert::success('Correcto','La evidencia fue guardada correctamente');
      return redirect()->route('alumnos.actividades');
    }

    public function evidencia(Request $request){
        $alumno_data = Alumno::where('no_control',Auth::User()->no_control)->select('id as alumno_id')->get();

        if(!$request->has('user_id') && !$request->has('actividad_id')){
            return redirect()->route('alumnos.home_avance');
        }
        if(User::find($request->user_id) == null || Actividad::find($request->actividad_id) == null){
            return redirect()->route('alumnos.home_avance');
        }
      $evidencias = DB::table('actividad_evidencia as ae')->join('evidencia as e', function($join) use($request){
        $join->on('e.id_asig_actividades','=','ae.id');
        $join->where('ae.user_id','=',$request->user_id);
        $join->where('ae.actividad_id','=',$request->actividad_id);
        $join->where('e.alumno_no_control','=',Auth::User()->no_control);
      })->join('actividad as a','a.id','=','ae.actividad_id')->join('users as u','u.id','=','ae.user_id')->select('a.nombre as actividad_nombre','a.id as actividad_id','e.nom_imagen as evidencia_nombre','ae.user_id','e.created_at as fecha','e.id as evidencia_id','u.name as usuario_nombre')->get();
      $actividad = Actividad::find($request->actividad_id);
      $responsable = User::find($request->user_id);
      $actividad_evidencia = DB::table('actividad_evidencia as ae')->join('participantes as p','p.id_evidencia','=','ae.id')->where([
        ['p.no_control','=',Auth::User()->no_control],
        ['ae.user_id','=',$request->user_id],
        ['ae.actividad_id','=',$request->actividad_id]
      ])->select('ae.id')->get();
      if($actividad_evidencia->count()==0)$actividad=null;
        $validado = Actividad_Evidencia::where([
            ['user_id','=',$request->user_id],
            ['actividad_id','=',$request->actividad_id]
        ])->select('validado','id')->get();
        $participante_data = Participante::where([
            ['id_evidencia','=',$validado[0]->id],
            ['no_control','=',Auth::User()->no_control]
        ])->get();
        if($participante_data->count() == 0){
            return redirect()->route('alumnos.actividades');
        }
      return view('alumnos.evidencia')
        ->with('evidencias',$evidencias)
        ->with('responsable',$responsable)
        ->with('actividad',$actividad)
        ->with('validado',$validado)
        ->with('participante_data',$participante_data[0])
        ->with('alumno_data',$alumno_data);
    }

    public function peticionEvidencia(Request $request) {
        if (!$request->has('responsable_id') || !$request->has('actividad_id')) {
            return response()->json('Datos invalidos.', HttpCode::BAD_REQUEST);
        }

        $evidencias = DB::table('actividad_evidencia as ae')
            ->join('evidencia as e', 'e.id_asig_actividades', '=', 'ae.id')
            ->join('actividad as a','a.id','=','ae.actividad_id')
            ->join('participantes as p','p.id_evidencia','=','ae.id')
            ->where('ae.user_id','=',$request->responsable_id)
            ->where('ae.actividad_id','=',$request->actividad_id)
            ->where('e.alumno_no_control','=',Auth::User()->no_control)
            ->where('p.no_control','=',Auth::User()->no_control)
            ->select('e.nom_imagen',DB::raw('DATE_FORMAT(e.created_at, "%d-%m-%Y") as fecha_creacion'),
                'a.nombre as actividad_nombre','e.id as evidencia_id', 'p.evidencia_validada as participante_evidencia_validada',
                'ae.validado', 'e.nom_original', 'a.id as actividad_id', 'a.vigente', 'p.momento_agregado')
            ->get();

        return response()->json($evidencias);
    }

    public function peticionEliminar(Request $request) {
        if($request->has('actividad') && $request->has('archivo')){
            $evidencia_data = DB::table('evidencia as e')
                ->join('actividad_evidencia as ae', 'ae.id', '=', 'e.id_asig_actividades')
                ->join('actividad as a', 'a.id', '=', 'ae.actividad_id')
                ->where('e.id', '=', $request->get('archivo'))
                ->where('e.alumno_no_control', '=', Auth::User()->no_control)
                ->where('a.id', '=', $request->get('actividad'))
                ->select('a.nombre as actividad_nombre', 'e.nom_imagen as archivo_nombre', 'ae.validado',
                    'ae.user_id as responsable', 'ae.id as act_evidencia_id', 'a.id_user as owner_id', 'e.id as archivo', 'a.vigente')
                ->get();

            if ($evidencia_data->count() != 1) {
                return response()->json('No se encontraron registros', HttpCode::BAD_REQUEST);
            }

            $evidencia_data = $evidencia_data[0];
            $validado = (bool)json_decode($evidencia_data->validado);
            $actividad_vigente = (bool)json_decode($evidencia_data->vigente);

            try {
                if (!$validado && $actividad_vigente) {
                    $this->eliminarEvidencia($evidencia_data->actividad_nombre, $evidencia_data->archivo, $evidencia_data->archivo_nombre);
                    return response()->json('Evidencia eliminada con exito', HttpCode::OK);
                } else if($validado && $actividad_vigente) {
                    $participante_data = Participante::where(
                        [
                            ['id_evidencia','=',$evidencia_data->act_evidencia_id],
                            ['no_control','=',Auth::User()->no_control]
                        ])
                        ->first();

                    if($participante_data->momento_agregado == 'posteriormente'
                        && $participante_data->evidencia_validada == 'no')
                    {
                        $this->eliminarEvidencia($evidencia_data->actividad_nombre, $evidencia_data->archivo, $evidencia_data->archivo_nombre);
                        return response()->json('Evidencia eliminada con exito', HttpCode::OK);
                    } else {
                        return response()->json('La evidencia ya se encuentra validada. No esta permitida esta acción.', HttpCode::NOT_ACCEPTABLE);
                    }
                } else {
                    return response()->json('La actividad ya no acepta modificaciones.', HttpCode::UNAUTHORIZED);
                }
            } catch (\Exception $e) {
                return response()->json('Se proceso con el siguiente error: '.$e->getMessage(), HttpCode::BAD_REQUEST);
            }
        }
        return response()->json('Error al eliminar la evidencia', HttpCode::BAD_REQUEST);
    }

    private function eliminarEvidencia($actividad, $archivo_id, $archivo) {
        Evidencia::destroy($archivo_id);
        Storage::delete('public/evidencias/'.$actividad.'/'.$archivo);
    }

}
