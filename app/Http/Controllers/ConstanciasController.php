<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\ConstanciaComplemento;
use App\Models\Constancia;
use App\Models\Area;
use App\Models\Alumno;
use App\Models\Folio;
use PDF;
use DB;
use Alert;

class ConstanciasController extends Controller
{
    public function __construct(){

        $this->middleware('permission:VIP|VIP_CONSTANCIAS')->only('guardarDatosGlobales');
        $this->middleware('permission:VIP|VIP_CONSTANCIAS|MODIFICAR_CONSTANCIAS_CARRERA')->only('guardarDatosEspecificos','visualizar','editarConstancia');
    }
    	
    public function index(){
    	if (Auth::User()->hasAnyPermission(['VIP','VIP_CONSTANCIAS'])) {
            //Cosuntamos si existen los datos globales
            $datos_globales = ConstanciaComplemento::where([
                ['id','=',1],
                ['imagen_encabezado','<>',null],
                ['imagen_encabezado','<>',null]
            ])->get();
            $carreras = Area::where('tipo','=','carrera')->get();
            $abreviaturas = $this->obternerAbreviaturas();
            $users = User::select('name','id')->where('email','<>','admin@itsch.com')->orderBy('name','ASC')->get();
            return view('admin.constancias.index')
            ->with('carreras',$carreras)
            ->with('abreviaturas',$abreviaturas)
            ->with('users',$users)
            ->with('datos_globales',$datos_globales);
        }else{
            //Cosuntamos si existen los datos globales
            $datos_globales = ConstanciaComplemento::where([
                ['id','=',1],
                ['imagen_encabezado','<>',null],
                ['imagen_encabezado','<>',null]
            ])->get();

            $carreras = Area::where([
                ['tipo','=','carrera'],
                ['id','=',Auth::User()->area]
            ])->get();
            $abreviaturas = $this->obternerAbreviaturas();
            $users = User::select('name','id')->where([
                ['email','<>','admin@itsch.com'],
                ['area','=',Auth::User()->area]
            ])->orderBy('name','ASC')->get();
            return view('admin.constancias.index')
            ->with('carreras',$carreras)
            ->with('abreviaturas',$abreviaturas)
            ->with('users',$users)
            ->with('datos_globales',$datos_globales);
        }
    }

    public function visualizar(Request $request){
        if(!$request->has('carrera')){
            Alert::error('Error','Error datos inconcistentes');           
            return redirect()->route('constancias.editar');
        }
        $datos_especificos_por_carrera = DB::table('constancia as c')->join('users as u','u.id','=','c.jefe_division')->where('c.carrera','=',$request->get('carrera'))->select('u.name','c.profesion_jefe_division','c.division_enunciado','c.plan_de_estudios')->get();
        if($datos_especificos_por_carrera->count() == 0){
            Alert::error('Error','Error datos inconcistentes');
            return redirect()->route('constancias.editar');
        }
        $meses = [
            'enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'
        ];
        //$datos_a_guardar = ConstanciaComplemento::find(1);
        //$datos_a_guardar->$datos_a_guardar->numero_oficio+1;
        //$datos_a_guardar->save();
        //$datos_globales = ConstanciaComplemento::all();
        $jefe_depto = DB::table('constancia_complemento  as cc')->join('users as u','u.id','=','cc.jefe_depto')->select('u.name','cc.jefe_depto_enunciado','cc.profesion_jefe_depto')->get();
        $certificador = DB::table('constancia_complemento as cc')->join('users as u','u.id','=','cc.certificador')->select('u.name','cc.profesion_certificador','cc.certificador_enunciado')->get();
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
    	$data = [
            'datos_globales' => $datos_globales[0],
            'dia' => $dia,
            'mes' => $meses[$mes-1],
            'year' => $year,
            'jefe_depto' => $jefe_depto[0],
            'raiz' => $raiz,
            'certificador' => $certificador[0],
            'jefe_division' => $datos_especificos_por_carrera[0],
            'plan_de_estudios' => $datos_especificos_por_carrera[0]->plan_de_estudios
        ];
        $pdf = PDF::loadView('admin.constancias.constancia', compact('data'));
        //return view('admin.constancias.constancia');
        return $pdf->stream('constancia.pdf');
    }

    public function imprimir(Request $request){
        if(!$request->has('no_control')){
            Alert::error('Error','Estas intentando acceder de forma ilegal');
            return redirect('/home');
        }
        $existe_alumno = Alumno::where('no_control','=',$request->no_control)->get()->count()>0? true: false;
        if(!$existe_alumno){
            Alert::error('Error','El número de control no existe');
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
        $jefe_division = DB::table('alumnos as alu')->join('constancia as c', function($join) use($request){
            $join->on('alu.carrera','=','c.carrera');
            $join->where('alu.no_control','=',$request->no_control);
        })->join('users as u','u.id','=','c.jefe_division')->select('u.name','c.division_enunciado','c.profesion_jefe_division','c.plan_de_estudios')->get();
        if($jefe_depto->count()==0 || $certificador->count()==0 || $jefe_division->count()==0 || $datos_globales->count()==0){
            Alert::error('Error','Falta de integridad en los datos de la constancia');
            return redirect()->back();
        }
        $alumno = DB::table('alumnos')->join('areas','areas.id','=','alumnos.carrera')->where('alumnos.no_control','=',$request->no_control)->select('alumnos.nombre','alumnos.no_control','areas.nombre as carrera')->get();
        $alumno_data = DB::select('select c.nombre as credito_nombre, u.name as credito_jefe from creditos as c join avance on avance.id_credito=c.id and avance.no_control = "'.$request->no_control.'" and avance.por_credito >= 100 join users as u on u.id = c.credito_jefe order by c.id limit 5');
        if(count($alumno_data)!=5){
            Alert::error('Error','El alumno aun no liberado todos sus credito complementarios');
            return redirect('/home');
        }
        $obtener_folio = Folio::where('no_control','=',$request->no_control)->get();
        $folio = -1;
        if($obtener_folio->count() == 0){
            $datos_globales[0]->numero_oficio = $datos_globales[0]->numero_oficio+1;
            $datos_globales[0]->save();
            $folio_object = new Folio();
            $folio_object->no_control = $request->no_control;
            $folio_object->no_folio = $datos_globales[0]->numero_oficio;
            $folio_object->save();
            $folio = $folio_object->no_folio;
        }else{
            $folio = $obtener_folio[0]->no_folio;
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
            'alumno_data' => $alumno_data,
            'no_oficio' => $folio,
            'plan_de_estudios' => $jefe_division[0]->plan_de_estudios

        ];
        $pdf = PDF::loadView('admin.constancias.constancia_alumno', compact('data'));
        //return view('admin.constancias.constancia');
        return $pdf->stream('constancia.pdf');
    }

    public function guardarDatosGlobales(Request $request){
        $datos_globales = ConstanciaComplemento::where('id','=',1)->get();

        if($datos_globales->count()>0){
            $datos_globales = ConstanciaComplemento::find(1);
            $datos_globales->fill($request->all());
            if($request->hasFile('imagen_encabezado')){
                $check = $this->extensionEsValida('imagen_encabezado',$request);
                if(!$check){
                    Alert::error('Error','La extensión '.$request->file('imagen_encabezado')->getClientOriginalExtension().' no es valida.');
                    return redirect()->route('constancias.index');
                }
                $datos_globales->imagen_encabezado = $this->guardarImagen('encabezado','imagen_encabezado','encabezado',$request);
                $datos_globales->save();
            }

            if($request->hasFile('imagen_pie')){
                $check = $this->extensionEsValida('imagen_pie',$request);
                if(!$check){
                    Alert::error('Error','La extensión '.$request->file('imagen_pie')->getClientOriginalExtension().' no es valida.');
                    return redirect()->route('constancias.index');
                }
                $datos_globales->imagen_pie = $this->guardarImagen('pie_de_pagina','imagen_pie','pie_de_pagina',$request);
                $datos_globales->save();
            }

            $datos_globales->save();

        }else{
            if($request->hasFile('imagen_encabezado')){
                $check = $this->extensionEsValida('imagen_encabezado',$request);
                if(!$check){
                    Alert::error('Error','La extensión '.$request->file('imagen_encabezado')->getClientOriginalExtension().' no es valida.');
                    return redirect()->route('constancias.index');
                }
            }else{
                Alert::error('Error','No se encontro la imagen para el encabezado');
                return redirect()->route('constancias.index');
            }
            if($request->hasFile('imagen_pie')){
                $check = $this->extensionEsValida('imagen_pie',$request);
                if(!$check){
                    Alert::error('Error','La extensión '.$request->file('imagen_pie')->getClientOriginalExtension().' no es valida.');
                    return redirect()->route('constancias.index');
                }
            }else{
                Alert::error('Error','No se encontro la imagen para el pie de página');
                return redirect()->route('constancias.index');
            }

            $datos_globales = new ConstanciaComplemento($request->all());
            $datos_globales->id = 1;
            $datos_globales->imagen_encabezado = $this->guardarImagen('encabezado','imagen_encabezado','encabezado',$request);
            $datos_globales->imagen_pie = $this->guardarImagen('pie_de_pagina','imagen_pie','pie_de_pagina',$request);
            $datos_globales->numero_oficio = 0;
            $datos_globales->save();
        }
        
        Alert::success('Correcto',"Datos guardados correctamente");
        return redirect()->route('constancias.index');
    }
    public function extensionEsValida($nombre_request, $request){
        $allowedfileExtension=['jpg','png','jpeg'];
        $file = $request->file($nombre_request);
        $extension = strtolower($file->getClientOriginalExtension());
        $check=in_array($extension,$allowedfileExtension);
        return $check;
    }
    public function guardarImagen($nombre_archivo,$nombre_request,$carpeta,$request){
        //Generamos la ruta donde se guardaran las imagenes de los articulos
        Storage::deleteDirectory('public/constancia_imagenes/'.$carpeta);
        $path=storage_path().'/app/public/constancia_imagenes/'.$carpeta.'/';
        $path_to_verify = 'public/constancia_imagenes';
        if(!Storage::has($path_to_verify)){
            Storage::makeDirectory($path_to_verify);
        }
        $path_to_verify = 'public/constancia_imagenes/'.$carpeta;
        if(!Storage::has($path_to_verify)){
            Storage::makeDirectory($path_to_verify);
        }
        $file = $request->file($nombre_request);
        $name=$nombre_archivo.'_'.time().'.'.strtolower($file->getClientOriginalExtension());
        //Guardamos la imagen en la carpeta creada en la ruta que marcamos anteriormente
        $file->move($path,$name);
        return (string)$name;
    }
    public function obtenerDatosEspecificos($carrera){
        $constancia_data = Constancia::where('carrera','=',$carrera)->get();
        return response()->json($constancia_data);
    }

    public function guardarDatosEspecificos($carrera,Request $request){
        $area = Area::find($carrera);
        if($area==null){
            return response()->json(array('data' => [],'mensaje' => 'La carrera no existe','mensaje_tipo' => 'error'));
        }
        if($area->tipo!="carrera"){
            return response()->json(array('data' => [],'mensaje' => 'No es una carrera','mensaje_tipo' => 'error'));
        }
        $constancia_existe = Constancia::where('carrera','=',$carrera)->select('id')->get();
        if($constancia_existe->count()>0){
            $constancia = Constancia::find($constancia_existe[0]->id);
            $constancia->fill($request->all());
            $constancia->save();
        }else{
            $constancia = new Constancia($request->all());
            $constancia->save();
        }
        return response()->json(array('data' => $constancia,'mensaje' => 'Datos guardados correctamente','mensaje_tipo' => 'exito'));
    }

    public function constanciasFaltantes(){
        $constancias_existentes = Constancia::all();
        $constancias_faltantes = array();
        $carreras_lista= Area::where('tipo','=','carrera')->get();
        foreach ($carreras_lista as $carrera) {
            $existe = false;
            foreach ($constancias_existentes as $constancia) {
                if($constancia->carrera==$carrera->id){
                    $existe = true;
                    break;
                }
            }
            if(!$existe){
                array_push($constancias_faltantes, $carrera->nombre);
            }
        }
        return response()->json($constancias_faltantes);
    }

    public function obternerAbreviaturas(){
        $abreviaturas = [
            ['abreviatura' => 'Abgdo', 'profesion' => 'Abogado'],
            ['abreviatura' => 'Adm', 'profesion' => 'Administrador'],
            ['abreviatura' => 'Alcde', 'profesion' => 'Alcalde'],
            ['abreviatura' => 'Almte', 'profesion' => 'Almirante'],
            ['abreviatura' => 'Anl', 'profesion' => 'Analista'],
            ['abreviatura' => 'Anl Sist', 'profesion' => 'Analista de Sistemas'],
            ['abreviatura' => 'CSA', 'profesion' => 'Analista de Sistemas de Computadoras'],
            ['abreviatura' => 'Arq', 'profesion' => 'Arquitecto'],
            ['abreviatura' => 'BA', 'profesion' => 'Arquitecto Modalidad Internacional'],
            ['abreviatura' => 'Bach', 'profesion' => 'Bachiller'],
            ['abreviatura' => 'Cap', 'profesion' => 'Capitán'],
            ['abreviatura' => 'Comte', 'profesion' => 'Comandante'],
            ['abreviatura' => 'Cdor', 'profesion' => 'Contador'],
            ['abreviatura' => 'CP', 'profesion' => 'Contador Público'],
            ['abreviatura' => 'Coord', 'profesion' => 'Coordinador'],
            ['abreviatura' => 'Cnel', 'profesion' => 'Coronel'],
            ['abreviatura' => 'Dir', 'profesion' => 'Director'],
            ['abreviatura' => 'Dr', 'profesion' => 'Doctor'],
            ['abreviatura' => 'Dra', 'profesion' => 'Doctora'],
            ['abreviatura' => 'DA', 'profesion' => 'Doctorado en Administración'],
            ['abreviatura' => 'DIN', 'profesion' => 'Doctorado en Informática'],
            ['abreviatura' => 'DII', 'profesion' => 'Doctorado en Ingeniería Industrial'],
            ['abreviatura' => 'DEE', 'profesion' => 'Doctorado en Innovación y Tecnología Educativa'],
            ['abreviatura' => 'DIT', 'profesion' => 'Doctorado en Inteligencia Artificial'],
            ['abreviatura' => 'DPA', 'profesion' => 'Doctorado en Parasitología Agrícola'],
            ['abreviatura' => 'DQ', 'profesion' => 'Doctorado en Química'],
            ['abreviatura' => 'Econ', 'profesion' => 'Economista'],
            ['abreviatura' => 'Enf', 'profesion' => 'Enfermero(a)'],
            ['abreviatura' => 'ECT', 'profesion' => 'Especialidad en Conversión de Tecnología a Capital'],
            ['abreviatura' => 'Gral', 'profesion' => 'General'],
            ['abreviatura' => 'Gte', 'profesion' => 'Gerente'],
            ['abreviatura' => 'Gdor', 'profesion' => 'Gobernador'],
            ['abreviatura' => 'Gdora', 'profesion' => 'Gobernadora'],
            ['abreviatura' => 'ESM', 'profesion' => 'Ingeniería de Sistemas de Manufactura'],
            ['abreviatura' => 'IAA', 'profesion' => 'Ingeniero Agrónomo Administrador'],
            ['abreviatura' => 'IAP', 'profesion' => 'Ingeniero Agrónomo en Producción'],
            ['abreviatura' => 'IB', 'profesion' => 'Ingeniero Bioquímico'],
            ['abreviatura' => 'IBR', 'profesion' => 'Ingeniero Bioquímico Administrador de Recursos Acuáticos'],
            ['abreviatura' => 'IBA', 'profesion' => 'Ingeniero Bioquímico en Aprovechamiento de Recursos Acuáticos'],
            ['abreviatura' => 'IBP', 'profesion' => 'Ingeniero Bioquímico en Proceso de Alimentos'],
            ['abreviatura' => 'IC', 'profesion' => 'Ingeniero Civil'],
            ['abreviatura' => 'BC', 'profesion' => 'Ingeniero Civil Modalidad Internacional'],
            ['abreviatura' => 'IEA', 'profesion' => 'Ingeniero Electricista Administrador'],
            ['abreviatura' => 'IFI', 'profesion' => 'Ingeniero Físico Industrial'],
            ['abreviatura' => 'Ing. Ind', 'profesion' => 'Ingeniero Industrial'],
            ['abreviatura' => 'IIS', 'profesion' => 'Ingeniero Industrial y de Sistemas'],
            ['abreviatura' => 'BIE', 'profesion' => 'Ingeniero Industrial y de Sistemas Modalidad Internacional'],
            ['abreviatura' => 'IMA', 'profesion' => 'Ingeniero Mecánico Administrador'],
            ['abreviatura' => 'BMI', 'profesion' => 'Ingeniero Mecánico Administrador Modalidad Internacional'],
            ['abreviatura' => 'IME', 'profesion' => 'Ingeniero Mecánico Electricista'],
            ['abreviatura' => 'IQA', 'profesion' => 'Ingeniero Químico Administrador'],
            ['abreviatura' => 'BCI', 'profesion' => 'Ingeniero Químico Administrador Modalidad Internacional'],
            ['abreviatura' => 'IQS', 'profesion' => 'Ingeniero Químico y de Sistemas'],
            ['abreviatura' => 'BCE', 'profesion' => 'Ingeniero Químico y de Sistemas Modalidad Internacional'],
            ['abreviatura' => 'Ing Sist', 'profesion' => 'Ingeniero de Sistemas'],
            ['abreviatura' => 'ICAP', 'profesion' => 'Ingeniero en Computación Administrativo y Producción'],
            ['abreviatura' => 'IEC', 'profesion' => 'Ingeniero en Electrónica y Comunicaciones'],
            ['abreviatura' => 'Ing.G.E', 'profesion' => 'Ingeniero en Gestión Empresarial'],
            ['abreviatura' => 'IIA', 'profesion' => 'Ingeniero en Industrias Alimentarias'],
            ['abreviatura' => 'BME', 'profesion' => 'Ingeniero en Mecatrónica Modalidad Internacional'],
            ['abreviatura' => 'ISC', 'profesion' => 'Ingeniero en Sistemas Computacionales'],
            ['abreviatura' => 'ISE', 'profesion' => 'Ingeniero en Sistemas Electrónicos'],
            ['abreviatura' => 'ISI', 'profesion' => 'Ingeniero en Sistemas de Información'],
            ['abreviatura' => 'Ing. TIC', 'profesion' => 'Ingeniero en Tecnologías de la Información y Comunicación'],
            ['abreviatura' => 'Ing', 'profesion' => 'Ingeniero(a)'],
            ['abreviatura' => 'Jz', 'profesion' => 'Juez'],
            ['abreviatura' => 'Jr', 'profesion' => 'Junior'],
            ['abreviatura' => 'Lcda', 'profesion' => 'Licenciada'],
            ['abreviatura' => 'Lcdo', 'profesion' => 'Licenciado'],
            ['abreviatura' => 'BFI', 'profesion' => 'Licenciado en Administración Financiera Modalidad Internacional'],
            ['abreviatura' => 'LAE', 'profesion' => 'Licenciado en Administración de Empresas'],
            ['abreviatura' => 'BBA', 'profesion' => 'Licenciado en Administración de Empresas Modalidad Internacional'],
            ['abreviatura' => 'LRH', 'profesion' => 'Licenciado en Administrador de Recursos Humanos'],
            ['abreviatura' => 'LPL', 'profesion' => 'Licenciado en Ciencia Política'],
            ['abreviatura' => 'BPS', 'profesion' => 'Licenciado en Ciencia Política Modalidad Internacional'],
            ['abreviatura' => 'LCQ', 'profesion' => 'Licenciado en Ciencias Químicas'],
            ['abreviatura' => 'LCC', 'profesion' => 'Licenciado en Ciencias de la Comunicación'],
            ['abreviatura' => 'BCS', 'profesion' => 'Licenciado en Ciencias de la Comunicación Modalidad Internacional'],
            ['abreviatura' => 'LCO', 'profesion' => 'Licenciado en Ciencias de la Comunidad'],
            ['abreviatura' => 'LCI', 'profesion' => 'Licenciado en Ciencias de la Información'],
            ['abreviatura' => 'LCIC', 'profesion' => 'Licenciado en Ciencias de la Información y Comunicación'],
            ['abreviatura' => 'LIN', 'profesion' => 'Licenciado en Comercio Internacional'],
            ['abreviatura' => 'BAI', 'profesion' => 'Licenciado en Comercio Internacional Modalidad Internacional'],
            ['abreviatura' => 'BIB', 'profesion' => 'Licenciado en Comercio Internacional Modalidad Internacional'],
            ['abreviatura' => 'LAN', 'profesion' => 'Licenciado en Comercio Internacional con esp. en Agronegocios'],
            ['abreviatura' => 'CPF', 'profesion' => 'Licenciado en Contaduría Pública y Finanzas'],
            ['abreviatura' => 'BFA', 'profesion' => 'Licenciado en Contaduría Pública y Finanzas Modalidad Internacional'],
            ['abreviatura' => 'LED', 'profesion' => 'Licenciado en Derecho'],
            ['abreviatura' => 'LDG', 'profesion' => 'Licenciado en Diseño Gráfico'],
            ['abreviatura' => 'LEC', 'profesion' => 'Licenciado en Economía'],
            ['abreviatura' => 'L.I', 'profesion' => 'Licenciado en Informática'],
            ['abreviatura' => 'LIA', 'profesion' => 'Licenciado en Informática Aplicada'],
            ['abreviatura' => 'LLI', 'profesion' => 'Licenciado en Lengua Inglesa'],
            ['abreviatura' => 'LLE', 'profesion' => 'Licenciado en Letras Españolas'],
            ['abreviatura' => 'LMI', 'profesion' => 'Licenciado en Medios de Información'],
            ['abreviatura' => 'BJM', 'profesion' => 'Licenciado en Medios de Información Modalidad Internacional'],
            ['abreviatura' => 'LEM', 'profesion' => 'Licenciado en Mercadotecnia'],
            ['abreviatura' => 'BM', 'profesion' => 'Licenciado en Mercadotecnia Modalidad Internacional'],
            ['abreviatura' => 'LRI', 'profesion' => 'Licenciado en Relaciones Internacionales'],
            ['abreviatura' => 'BIA', 'profesion' => 'Licenciado en Relaciones Internacionales Modalidad Internacional'],
            ['abreviatura' => 'LSC', 'profesion' => 'Licenciado en Sistemas Computacionales'],
            ['abreviatura' => 'LSCA', 'profesion' => 'Licenciado en Sistemas de Computación Administrativa'],
            ['abreviatura' => 'LTI', 'profesion' => 'Licenciado en Tecnología de Información'],
            ['abreviatura' => 'MC', 'profesion' => 'Médico Cirujano'],
            ['abreviatura' => 'MA', 'profesion' => 'Maestría en Administración'],
            ['abreviatura' => 'MAD', 'profesion' => 'Maestría en Administración de Instituciones Educativas'],
            ['abreviatura' => 'MTI', 'profesion' => 'Maestría en Administración de Tecnologías de Información'],
            ['abreviatura' => 'MTL', 'profesion' => 'Maestría en Administración de las Telecomunicaciones'],
            ['abreviatura' => 'MAR', 'profesion' => 'Maestría en Arquitectura'],
            ['abreviatura' => 'MBT', 'profesion' => 'Maestría en Bibliotecología Y Ciencias de la Información'],
            ['abreviatura' => 'MBI', 'profesion' => 'Maestría en Ciencias con especialidad en Biotecnología'],
            ['abreviatura' => 'MAI', 'profesion' => 'Maestría en Ciencias, Esp. en Administración de Sistemas de Información'],
            ['abreviatura' => 'MAT-I', 'profesion' => 'Maestría en Ciencias, Especialidad en Automatización (Sistemas Inteligentes)'],
            ['abreviatura' => 'MCP', 'profesion' => 'Maestría en Ciencias, Especialidad en Sistemas de Calidad y Productividad'],
            ['abreviatura' => 'MCT', 'profesion' => 'Maestría en Ciencias, Especialidad en Tecnología Informática'],
            ['abreviatura' => 'MAT-C', 'profesion' => 'Maestría en Ciencias, especialidad en Automatización (Ingeniería de Control)'],
            ['abreviatura' => 'MCC', 'profesion' => 'Maestría en Ciencias, especialidad en Ciencias de las Computación'],
            ['abreviatura' => 'MCO', 'profesion' => 'Maestría en Ciencias, especialidad en Comunicación'],
            ['abreviatura' => 'MFQ', 'profesion' => 'Maestría en Ciencias, especialidad en Fisicoquímica'],
            ['abreviatura' => 'MIA', 'profesion' => 'Maestría en Ciencias, especialidad en Ingeniería Ambiental'],
            ['abreviatura' => 'MIA-P', 'profesion' => 'Maestría en Ciencias, especialidad en Ingeniería Ambiental (Prevención y Control)'],
            ['abreviatura' => 'MIA-E', 'profesion' => 'Maestría en Ciencias, especialidad en Ingeniería Ambiental(Evaluación e Impacto)'],
            ['abreviatura' => 'MCV-A', 'profesion' => 'Maestría en Ciencias, especialidad en Ingeniería Civil (Admón. de la Construcción)'],
            ['abreviatura' => 'MCV-E', 'profesion' => 'Maestría en Ciencias, especialidad en Ingeniería Civil (Ing. Estructural)'],
            ['abreviatura' => 'MIE', 'profesion' => 'Maestría en Ciencias, especialidad en Ingeniería Eléctrica'],
            ['abreviatura' => 'MSE', 'profesion' => 'Maestría en Ciencias, especialidad en Ingeniería Electrónica'],
            ['abreviatura' => 'MSE-E', 'profesion' => 'Maestría en Ciencias, especialidad en Ingeniería Electrónica (Sist. Electrónicos)'],
            ['abreviatura' => 'MSE-T', 'profesion' => 'Maestría en Ciencias, especialidad en Ingeniería Electrónica (Telecomunicaciones)'],
            ['abreviatura' => 'MII', 'profesion' => 'Maestría en Ciencias, especialidad en Ingeniería Industrial'],
            ['abreviatura' => 'MIM', 'profesion' => 'Maestría en Ciencias, especialidad en Ingeniería Mecánica'],
            ['abreviatura' => 'MIQ', 'profesion' => 'Maestría en Ciencias, especialidad en Ingeniería Química'],
            ['abreviatura' => 'MIL', 'profesion' => 'Maestría en Ciencias, especialidad en Ingeniería de Alimentos'],
            ['abreviatura' => 'MIC', 'profesion' => 'Maestría en Ciencias, especialidad en Ingeniería de Control'],
            ['abreviatura' => 'MSC', 'profesion' => 'Maestría en Ciencias, especialidad en Ingeniería de Sistemas Computacionales'],
            ['abreviatura' => 'MAC', 'profesion' => 'Maestría en Ciencias, especialidad en Ingeniería y Admón. De la Construcción'],
            ['abreviatura' => 'MQ-A', 'profesion' => 'Maestría en Ciencias, especialidad en Química Analítica'],
            ['abreviatura' => 'MQ-O', 'profesion' => 'Maestría en Ciencias, especialidad en Química Orgánica'],
            ['abreviatura' => 'MSV', 'profesion' => 'Maestría en Ciencias, especialidad en Sanidad Vegetal'],
            ['abreviatura' => 'MSA', 'profesion' => 'Maestría en Ciencias, especialidad en Sistemas Ambientales'],
            ['abreviatura' => 'MIS', 'profesion' => 'Maestría en Ciencias, especialidad en Sistemas de Calidad'],
            ['abreviatura' => 'MPI', 'profesion' => 'Maestría en Ciencias, especialidad en Sistemas de Producción Agroindustrial'],
            ['abreviatura' => 'MTC', 'profesion' => 'Maestría en Ciencias, especialidad en Tecnología y Calidad de Alimentos'],
            ['abreviatura' => 'MCE', 'profesion' => 'Maestría en Comercio Electrónico'],
            ['abreviatura' => 'MDC', 'profesion' => 'Maestría en Derecho Comercial e Internacional'],
            ['abreviatura' => 'MDM', 'profesion' => 'Maestría en Dirección para la Manufactura'],
            ['abreviatura' => 'MED', 'profesion' => 'Maestría en Educación'],
            ['abreviatura' => 'MET', 'profesion' => 'Maestría en Estadística Aplicada'],
            ['abreviatura' => 'MEH', 'profesion' => 'Maestría en Estudios Humanísticos'],
            ['abreviatura' => 'MAF', 'profesion' => 'Maestría en Finanzas'],
            ['abreviatura' => 'MIIS', 'profesion' => 'Maestría en Ingeniería Industrial y de sistemas'],
            ['abreviatura' => 'MSM', 'profesion' => 'Maestría en Ingeniería, especialidad en Sistemas de Manufactura'],
            ['abreviatura' => 'MMT', 'profesion' => 'Maestría en Mercadotecnia'],
            ['abreviatura' => 'MNL', 'profesion' => 'Maestría en Negocios Internacionales'],
            ['abreviatura' => 'MQ', 'profesion' => 'Maestría en Química'],
            ['abreviatura' => 'MTE', 'profesion' => 'Maestría en Tecnología Educativa'],
            ['abreviatura' => 'May', 'profesion' => 'Mayor'],
            ['abreviatura' => 'May. Brig', 'profesion' => 'Mayor de brigada'],
            ['abreviatura' => 'Not', 'profesion' => 'Notario'],
            ['abreviatura' => 'Nut', 'profesion' => 'Nutrisionista'],
            ['abreviatura' => 'Odont', 'profesion' => 'Odontologo'],
            ['abreviatura' => 'PM', 'profesion' => 'Policia Militar'],
            ['abreviatura' => 'Pdta', 'profesion' => 'Presidenta'],
            ['abreviatura' => 'Pdte', 'profesion' => 'Presidente'],
            ['abreviatura' => 'prof', 'profesion' => 'Profesor'],
            ['abreviatura' => 'Profa', 'profesion' => 'Profesora'],
            ['abreviatura' => 'Prog Sist', 'profesion' => 'Programador de Sistemas'],
            ['abreviatura' => 'Psic', 'profesion' => 'Psicólogo'],
            ['abreviatura' => 'Psiq', 'profesion' => 'Psiquiatra'],
            ['abreviatura' => 'Quim', 'profesion' => 'Químico'],
            ['abreviatura' => 'QF', 'profesion' => 'Químico farmaceutico'],
            ['abreviatura' => 'RE', 'profesion' => 'Residencia de Especialidad'],
            ['abreviatura' => 'Soc', 'profesion' => 'Sociólogo'],
            ['abreviatura' => 'Superv', 'profesion' => 'Supervisor'],
            ['abreviatura' => 'Tnco', 'profesion' => 'Tecnico'],
            ['abreviatura' => 'TM', 'profesion' => 'Tecnico Medico'],
            ['abreviatura' => 'Tnlgo', 'profesion' => 'Tecnologo'],
            ['abreviatura' => 'Tec Sist', 'profesion' => 'Tecnologo de Sistemas'],
            ['abreviatura' => 'Tte', 'profesion' => 'Tenente'],
            ['abreviatura' => 'TS', 'profesion' => 'Trabajadora Social'],
            ['abreviatura' => 'Vet', 'profesion' => 'Veterinario']
        ];
        return $abreviaturas;
    }
}
