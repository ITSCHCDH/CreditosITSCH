<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\User;
use App\ConstanciaComplemento;
use App\Constancia;
use PDF;
class ConstanciasController extends Controller
{
	
    public function index(){
    	return view('admin.constancias.index');
    }
    public function visualizar(){
        $meses = [
            'enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'
        ];
        $datos_globales = ConstanciaComplemento::all();
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
    	$data = [
            'datos_globales' => $datos_globales[0],
            'dia' => $dia,
            'mes' => $meses[$mes-1],
            'year' => $year,
            'raiz' => $raiz
        ];
        $pdf = PDF::loadView('admin.constancias.constancia', compact('data'));
        //return view('admin.constancias.constancia');
        return $pdf->stream('constancia.pdf');
    }

    public function editarConstancia(){
        $datos_globales = ConstanciaComplemento::where('id','=',1)->get();
        $carreras = [
            ['carrera' => 'Ingeniería en Sistemas Computacionales','valor' => 'Sistemas'],
            ['carrera' => 'Ingeniería en Nanotecnología', 'valor' => 'Nanotecnología'],
            ['carrera' => 'Ingeniería en Mecatrónica','valor' => 'Mecatrónica'],
            ['carrera' => 'Ingeniería en Bioquímica','valor' => 'Bioquímica'],
            ['carrera' => 'Ingeniería en Tecnologías de la Información y Comunicaciones','valor' =>"TIC's"],
            ['carrera' => 'Ingeniería en Gestión Empresarial','valor' => 'Gestión Empresarial'],
            ['carrera' => 'Ingeniería Industrial', 'valor' => 'Industrial']
        ];
        $abreviaturas = $this->obternerAbreviaturas();
        $users = User::select('name','id')->get();
        return view('admin.constancias.editar')
        ->with('carreras',$carreras)
        ->with('abreviaturas',$abreviaturas)
        ->with('users',$users)
        ->with('datos_globales',$datos_globales);
    }

    public function guardarDatosGlobales(Request $request){
        $oficio = "DISC/117/2017";
        $enunciado_superior = "Año del Centenario de la Promulgación de la Constitución Política de los Estados Unidos Mexicanos";
        $plan_de_estudios = "ISIC-2010-224";
        $institucion_info = "Av. Ing. Carlos Rojas Gutiérrez 2120 Fracc. Valle de la Herradura Ciudad Hidalgo, Michoacán. C.P. 61100 Tel. 786 1549000";
        $datos_globales = ConstanciaComplemento::where('id','=',1)->get();
        if($datos_globales->count()>0){
            $datos_globales = ConstanciaComplemento::find(1);
            $datos_globales->fill($request->all());
            if($request->oficio==null)$datos_globales->oficio = $oficio;
            if($request->plan_de_estudios==null)$datos_globales->plan_de_estudios = $plan_de_estudios;
            if($request->enunciado_superior==null)$datos_globales->enunciado_superior = $enunciado_superior;
            if($request->institucion_info==null)$datos_globales->institucion_info = $institucion_info;
            $datos_globales->save();
            return response()->json(array('data'=>$datos_globales,'mensaje' => 'Datos globales guardados exitosamente', 'mensaje_tipo' => 'exito'));
        }else{
            $datos_globales = new ConstanciaComplemento($request->all());
            $datos_globales->id = 1;
            if($request->oficio==null)$datos_globales->oficio = $oficio;
            if($request->plan_de_estudios==null)$datos_globales->plan_de_estudios = $plan_de_estudios;
            if($request->enunciado_superior==null)$datos_globales->enunciado_superior = $enunciado_superior;
            if($request->institucion_info==null)$datos_globales->institucion_info = $institucion_info;
            $datos_globales->save();
        }
        
        return response()->json(array('data'=>$datos_globales,'mensaje' => 'Datos globales guardados exitosamente', 'mensaje_tipo' => 'exito'));
    }

    public function obtenerDatosEspecificos($carrera){
        $constancia_data = Constancia::where('carrera','=',$carrera)->get();
        return response()->json($constancia_data);
    }

    public function guardarDatosEspecificos($carrera,Request $request){
        $constancia_existe = Constancia::where('carrera','=',$carrera)->select('id')->get();
        $division_enunciado_lista=[
            ['enunciado' => 'DIV. DE ING. SIST. COMP.','valor' => 'Sistemas'],
            ['enunciado' => 'DIV. DE ING. NANOTECNOLOGÍA.', 'valor' => 'Nanotecnología'],
            ['enunciado' => 'DIV. DE ING. MECATRÓNICA.','valor' => 'Mecatrónica'],
            ['enunciado' => 'DIV. DE ING. BIOQUÍMICA.','valor' => 'Bioquímica'],
            ['enunciado' => "DIV. DE ING. TIC'S.",'valor' =>"TIC's"],
            ['enunciado' => 'DIV. DE ING. GEST. EMP.','valor' => 'Gestión Empresarial'],
            ['enunciado' => 'DIV. DE ING. INDUSTRIAL', 'valor' => 'Industrial']
        ];
        $division_enunciado = "";
        for ($i = 0; $i < count($division_enunciado_lista); $i++) {
            if($division_enunciado_lista[$i]['valor']==$carrera){
                $division_enunciado = $division_enunciado_lista[$i]['enunciado'];
                break;
            }
        }
        if(strlen($division_enunciado)>0){
            if($constancia_existe->count()>0){
                $constancia = Constancia::find($constancia_existe[0]->id);
                $constancia->fill($request->all());
                $constancia->save();
            }else{
                $constancia = new Constancia($request->all());
                $constancia->division_enunciado = $division_enunciado;
                $constancia->save();
            }
            return response()->json(array('data' => $constancia,'mensaje' => 'Datos guardados correctamente','mensaje_tipo' => 'exito'));
        }
        return response()->json(array('data' => $constancia,'mensaje' => 'Datos inconcistentes', 'mensaje_tipo' => 'error'));
        
    }

    public function constanciasFaltantes(){
        $constancias_existentes = Constancia::all();
        $constancias_faltantes = array();
        $lista=[
            ['valor' => 'Sistemas'],
            ['valor' => 'Nanotecnología'],
            ['valor' => 'Mecatrónica'],
            ['valor' => 'Bioquímica'],
            ['valor' =>"TIC's"],
            ['valor' => 'Gestión Empresarial'],
            ['valor' => 'Industrial']
        ];
        for ($x=0;$x < count($lista) && $constancias_existentes->count()!=7; $x++) {
            $existe = false;
            foreach ($constancias_existentes as $constancia) {
                if($constancia->carrera == $lista[$x]['valor']){
                    $existe = true;
                    break;
                }
            }
            if(!$existe){
                array_push($constancias_faltantes,$lista[$x]['valor']);
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
            ['abreviatura' => 'L.I', 'profesion' => 'Licenciado(a) en Informática'],
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