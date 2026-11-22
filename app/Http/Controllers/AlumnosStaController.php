<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Historial_clinico;
use App\Models\Datos_familiares;
use App\Models\Direccion;
use App\Models\Familiar;
use App\Models\Personales;
use App\Models\Padres;
use App\Models\Social;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use App\Models\Sit\Alumno as SitAlumno;
use App\Models\AlumnoCreditosPerfil;
use App\Services\Sta\FichaAlumnoService;

class AlumnosStaController extends Controller
{
   public function __construct(private FichaAlumnoService $fichaAlumno)
   {
   }

   private function perfil(string $nc): ?AlumnoCreditosPerfil
   {
      return AlumnoCreditosPerfil::where('no_control', $nc)->first();
   }
   /**
    * Datos equivalentes a los que antes se leían de la conexión anterior:
    * alumno, su carrera y los datos de dirección/salud, ahora desde SIT.
    */
   private function datosSitAlumno($nc): array
   {
      $alumno = SitAlumno::with(['user', 'carrera', 'alumnoComplemento', 'alumnoDatoMedico'])
         ->where('no_control', $nc)
         ->first();

      $complemento = $alumno?->alumnoComplemento;
      $datoMedico = $alumno?->alumnoDatoMedico;

      $alu1 = (object) [
         'alu_NumControl' => $alumno?->no_control ?? $nc,
         'car_Clave' => $alumno?->carrera_id,
      ];

      $car = (object) [
         'car_Clave' => $alumno?->carrera_id,
         'car_Nombre' => $alumno?->carrera?->nombre,
         'car_NombreCorto' => $alumno?->carrera?->nombre_corto,
      ];

      $alu2 = (object) [
         'alc_Direccion' => $complemento?->direccion,
         'alc_Colonia' => $complemento?->colonia,
         'alc_CodPostal' => $complemento?->cp,
         'alc_TipoSangre' => $datoMedico?->tipo_sangre,
      ];

      return [$alu1, $car, $alu2];
   }

   public function ficha()
   {    
      $sitUser = Auth::guard('alumno')->user();
      $sitAlumno = $sitUser
         ? SitAlumno::with(['user', 'carrera', 'alumnoComplemento', 'alumnoDatoMedico'])
            ->where('user_id', $sitUser->getAuthIdentifier())
            ->first()
         : null;

      if (!$sitAlumno) {
         Alert::error('Error', 'No se encontró el perfil académico del alumno.');
         return redirect()->route('login');
      }

      $fichaAlumno = $this->fichaAlumno->obtener($sitAlumno->no_control);
      $sitUrl = $fichaAlumno['url'] ?? null;

      $no_cont = $sitAlumno->no_control;
      $alu1 = (object) [
         'alu_NumControl' => $sitAlumno->no_control,
         'alu_Nombre' => $sitUser->nombre,
         'alu_ApePaterno' => $sitUser->apellido_paterno,
         'alu_ApeMaterno' => $sitUser->apellido_materno,
         'alu_Sexo' => $sitAlumno->genero,
         'car_Clave' => $sitAlumno->carrera_id,
      ];

      $complemento = $sitAlumno->alumnoComplemento;
      $datoMedico = $sitAlumno->alumnoDatoMedico;
      $alu2 = (object) [
         'alu_NumControl' => $sitAlumno->no_control,
         'alc_FechaNac' => optional($sitAlumno->fecha_nacimiento)->format('Y-m-d'),
         'alc_TipoSangre' => $datoMedico?->tipo_sangre,
         'alc_Direccion' => $complemento?->direccion,
         'alc_CodPostal' => $complemento?->cp,
         'alc_Colonia' => $complemento?->colonia,
      ];

      $alu = (object) [
         'id' => $sitAlumno->id,
         'no_control' => $sitAlumno->no_control,
         'grupo' => null,
         'lug_pro' => null,
         'est_civ' => null,
         'tel' => $sitUser->celular,
         'emailPer' => $complemento?->email_personal,
         'email' => $sitUser->email,
      ];

      $car = (object) [
         'car_Clave' => $sitAlumno->carrera_id,
         'car_NombreCorto' => $sitAlumno->carrera?->nombre_corto,
      ];

      $person = Personales::where('no_control', $no_cont)
         ->when(!Personales::where('no_control', $no_cont)->exists(), fn ($q) => $q->where('id_alu', $alu->id))
         ->first();
      if ($person == null) {
         $person = new Personales();
         $person->no_control = $no_cont;
         $person->id_alu = $alu->id;
      }
      $dPad = Padres::where('no_control', $no_cont)->where('parentesco', 'Padre')->first()
         ?? Padres::where('id_alu', $alu->id)->where('parentesco', 'Padre')->first();
      if ($dPad == null) {
         $dPad = new Padres();
         $dPad->no_control = $no_cont;
         $dPad->id_alu = $alu->id;
         $dPad->parentesco = 'Padre';
      }
      $dMad = Padres::where('no_control', $no_cont)->where('parentesco', 'Madre')->first()
         ?? Padres::where('id_alu', $alu->id)->where('parentesco', 'Madre')->first();
      if ($dMad == null) {
         $dMad = new Padres();
         $dMad->no_control = $no_cont;
         $dMad->id_alu = $alu->id;
         $dMad->parentesco = 'Madre';
      }
      $direccion = Direccion::where('id_alu', $alu->id)->first();
      if ($direccion == null) {
         $direccion = new Direccion();
         $direccion->id_alu = $alu->id;
         $direccion->direccion = $alu2->alc_Direccion;
         $direccion->cp = $alu2->alc_CodPostal;
         $direccion->colonia = $alu2->alc_Colonia;
      }
      $direccionP = Direccion::where('id_fam', $dPad->id)->first();
      if ($direccionP == null) {
         $direccionP = new Direccion();
         $direccionP->id_fam = $dPad->id;
      }
      $direccionM = Direccion::where('id_fam', $dMad->id)->first();
      if ($direccionM == null) {
         $direccionM = new Direccion();
         $direccionM->id_fam = $dMad->id;
      }
      $clinicos = Historial_clinico::where('no_control', $no_cont)->first()
         ?? Historial_clinico::where('id_alu', $alu->id)->first();
      if ($clinicos == null) {
         $clinicos = new Historial_clinico();
         $clinicos->no_control = $no_cont;
         $clinicos->id_alu = $alu->id;
         $clinicos->sangre = $alu2->alc_TipoSangre;
      }     
     
      $alumno_data = collect([(object) [
         'alumno_id' => $sitAlumno->id,
      ]]);
      return view('alumnos.sta.ficha',compact('alu2', 'alu1', 'dPad', 'dMad', 'direccion', 'direccionP', 'direccionM', 'alu', 'car', 'clinicos', 'person','alumno_data','sitUrl'));
            
   }

   public function guardarDatFam(Request $request, $nc)
   {
      return redirect()->away(config('services.sit.perfil_url'))
         ->with('info', 'Los datos personales, domicilio y salud se actualizan directamente en SIT.');
   }

   public function editDatSalud($nc)
   {
      return redirect()->away(config('services.sit.perfil_url'))
         ->with('info', 'Los datos médicos se actualizan directamente en el sistema SIT.');
      $sit = SitAlumno::with(['user','carrera','alumnoComplemento','alumnoDatoMedico'])->where('no_control',$nc)->firstOrFail();
      $alu = (object) ['id' => $sit->id, 'no_control' => $sit->no_control];
      $alu1 = $this->datosSitAlumno($nc)[0];
      $clinicos = Historial_clinico::where('no_control',$nc)->first()
         ?? Historial_clinico::where('id_alu',$sit->id)->first();
      $alumno_data = collect([(object) ['alumno_id' => $sit->id]]);
      return view('alumnos.sta.dsalud', compact('alu1', 'alu', 'clinicos','alumno_data'));
   }

   public function updtDatSalud(Request $request, $nc)
   {
      return redirect()->away(config('services.sit.perfil_url'))
        ->with('info', 'La captura de salud pertenece al sistema institucional SIT.');
        try
        {
            $sit = SitAlumno::where('no_control',$nc)->firstOrFail();
            $alu = (object) ['id' => $sit->id, 'no_control' => $sit->no_control];
            $clinicos = Historial_clinico::where('no_control',$nc)->first()
               ?? Historial_clinico::where('id_alu',$sit->id)->first();
            if (! $clinicos) {
                $clinicos = new Historial_clinico();
                $clinicos->no_control = $nc;
                $clinicos->id_alu = $sit->id;
            }
            if ($request->alu_enf == 'No') {
                $clinicos->enfermedad = $request->alu_enf;
                $clinicos->diabetes = "";
                $clinicos->hipertension = "";
                $clinicos->epilepsia = "";
                $clinicos->anorexia = "";
                $clinicos->bulimia = "";
                $clinicos->sexual = "";
                $clinicos->depresion = "";
                $clinicos->tristeza = "";
                $clinicos->otra_enf = "";
            } else {
                $clinicos->enfermedad = $request->alu_enf;
                if ($request->fm_diabetes == 'Diabetes') {
                    $clinicos->diabetes = $request->fm_diabetes;
                }
                if ($request->fm_hipertencion == 'Hipertensión') {
                    $clinicos->hipertension = $request->fm_hipertencion;
                }
                if ($request->fm_epilepsia == 'Epilepsia') {
                    $clinicos->epilepsia = $request->fm_epilepsia;
                }
                if ($request->fm_anorexia == 'Anorexia') {
                    $clinicos->anorexia = $request->fm_anorexia;
                }
                if ($request->fm_bulimia == 'Bulimia') {
                    $clinicos->bulimia = $request->fm_bulimia;
                }
                if ($request->fm_trans_sexual == 'Enfermedad de Transmisión Sexual') {
                    $clinicos->sexual = $request->fm_trans_sexual;
                }
                if ($request->fm_depresion == 'Depresión') {
                    $clinicos->depresion = $request->fm_depresion;
                }
                if ($request->fm_tristesa == 'Tristeza Profunda') {
                    $clinicos->tristeza = $request->fm_tristesa;
                }
                if ($request->fm_otra != '') {
                    $clinicos->otra_enf = $request->fm_otra;
                }
            }
            if ($request->alu_disfi == 'No') {
                $clinicos->cap_dif = $request->alu_disfi;
                $clinicos->vista = "";
                $clinicos->oido = "";
                $clinicos->lenguaje = "";
                $clinicos->motora = "";
                $clinicos->otra_dis = "";
            } else {
                $clinicos->cap_dif = $request->alu_disfi;
                if ($request->fm_dis_vista == 'Vista') {
                    $clinicos->vista = $request->fm_dis_vista;
                }
                if ($request->fm_dis_oido == 'Oído') {
                    $clinicos->oido = $request->fm_dis_oido;
                }
                if ($request->fm_dis_lenguaje == 'Lenguaje') {
                    $clinicos->lenguaje = $request->fm_dis_lenguaje;
                }
                if ($request->fm_dis_motora == 'Motora') {
                    $clinicos->motora = $request->fm_dis_motora;
                }
                if ($request->fm_dis_otra != '') {
                    $clinicos->otra_dis = $request->fm_dis_otra;
                }
            }
            if ($request->dx_psicologico == 'No') {
                $clinicos->dia_psico = $request->dx_psicologico;
                $clinicos->cuanto_psico = '';
            } else {
                $clinicos->dia_psico = $request->dx_psicologico_c;
                $clinicos->cuanto_psico = $request->dx_psicologico_tm;
            }
            if ($request->medRadio == 'No') {
                $clinicos->dia_med = $request->medRadio;
                $clinicos->cuanto_med = '';
            } else {
                $clinicos->dia_med = $request->dx_medico;
                $clinicos->cuanto_med = $request->dx_medico_tm;
            }
            $clinicos->save();
            $alumno_data = collect([(object) ['alumno_id' => $sit->id]]);
            $alu1 = $this->datosSitAlumno($nc)[0];
            $fam = Datos_familiares::where('no_control',$nc)->first()
               ?? Datos_familiares::where('id_alu',$sit->id)->first();
            if ($fam == null) {
                $fam = new Datos_familiares();
                $fam->no_control = $nc;
                $fam->id_alu = $alu->id;
                $fam->save();
            }
            $familiares = Familiar::where('no_control',$nc)->get();
            if ($familiares->isEmpty()) $familiares = Familiar::where('id_alu',$sit->id)->get();
            return view('alumnos.sta.dfamiliares', compact('alu1', 'alu', 'fam', 'familiares','alumno_data'));
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            //Regresamos a la pagina anterior con un mensaje de error
            Alert::error('Error', 'No se pudo actualizar la información, revisa que todos los datos esten correctos');
            return redirect()->back();
        }      
   }

   public function updtDatFam(Request $request, $nc)
   {
        try
        {
            //Buscamos al alumno
            $sit = SitAlumno::where('no_control',$nc)->firstOrFail();
            $alu = (object) ['id' => $sit->id, 'no_control' => $sit->no_control];
            $familiares = Familiar::where('no_control',$nc)->get();
            if ($familiares->isEmpty()) $familiares = Familiar::where('id_alu',$sit->id)->get();
            foreach ($familiares as &$famil) {
                $famil->delete();
            }

            //Verificamos que venga algun familiar antes de guardar
            if (isset($request->nombre[0])  ) {
                for ($i = 0; $i < count($request->edad); $i++) {
                    $familiar = new Familiar();
                    $familiar->no_control = $nc;
                    $familiar->id_alu = $alu->id;
                    $familiar->nombre = $request->nombre[$i];
                    $familiar->edad = $request->edad[$i];
                    $familiar->escolaridad = $request->escolaridad[$i];
                    $familiar->parentesco = $request->parentesco[$i];
                    $familiar->relacion = $request->actitud[$i];
                    $familiar->save();
                }
            }
        

            $fam = Datos_familiares::where('no_control',$nc)->first()
               ?? Datos_familiares::where('id_alu',$sit->id)->first();
            if (! $fam) {
                $fam = new Datos_familiares();
                $fam->no_control = $nc;
                $fam->id_alu = $sit->id;
            }
            if ($request->dif == 'No') {
                $fam->dificultades = $request->dif;
            } else {
                $fam->dificultades = $request->fiden_dificultades;
            }
            $fam->ligado = $request->fiden_ligue;
            $fam->ligado_por = $request->fiden_ligue_T;
            $fam->edu = $request->fiden_edu;
            $fam->carrera = $request->fiden_influ;
            $fam->otro_dato = $request->fiden_otro_dato;
            $fam->save();
            
            
            $alu1 = $this->datosSitAlumno($nc)[0];
            $soc = Social::where('no_control',$nc)->first()
               ?? Social::where('id_alu',$sit->id)->first();
            if ($soc == null) {
                $soc = new Social();
                $soc->no_control = $nc;
                $soc->id_alu = $alu->id;
                $soc->save();
            }
            $alumno_data = collect([(object) ['alumno_id' => $sit->id]]);
            return view('alumnos.sta.dsocial', compact('alu1', 'alu', 'soc','alumno_data'));
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            //Regresamos a la pagina anterior con un mensaje de error
            Alert::error('Error', 'No se pudo actualizar la información, revisa que todos los datos esten correctos');
            return redirect()->back();
        }
   }

   public function updtDatSoc(Request $request, $nc)
   { 
        try
        {   
            $sit = SitAlumno::where('no_control',$nc)->firstOrFail();
            $alu = (object) ['id' => $sit->id, 'no_control' => $sit->no_control];
            $soc = Social::where('no_control',$nc)->first()
               ?? Social::where('id_alu',$sit->id)->first();
            if (! $soc) {
                $soc = new Social();
                $soc->no_control = $nc;
                $soc->id_alu = $sit->id;
            }
            $soc->rel_comp = $request->rel_comp;
            $soc->comp_por = $request->rel_comp_t;
            $soc->rel_amig = $request->rel_ami;
            $soc->amig_por = $request->rel_ami_t;
            if ($request->alu_par == 'No') {
                $soc->pareja = $request->alu_par;
            } else {
                $soc->pareja = $request->rel_alu_par;
            }
            $soc->rel_prof = $request->rel_pro;
            $soc->prof_por = $request->rel_pro_t;
            $soc->rel_auto_ac = $request->rel_aut_aca;
            $soc->auto_ac_por = $request->rel_aut_aca_t;
            $soc->tiempo_lib = $request->alu_tlibre;
            $soc->recreativa = $request->alu_act_rec;
            $soc->planes_in = $request->alu_pl_inme;
            $soc->metas_vida = $request->alu_metas;
            $soc->yo_soy = $request->alu_soy;
            $soc->caracter = $request->alu_caracter;
            $soc->me_gusta = $request->alu_gusto;
            $soc->aspiraciones = $request->alu_aspira;
            $soc->miedo = $request->alu_miedo;
            $soc->save();

            $alu1 = $this->datosSitAlumno($nc)[0];
            $alumno_data = collect([(object) ['alumno_id' => $sit->id]]);
            return view('alumnos.sta.autorizar', compact('alu1', 'alu','alumno_data'));
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            //Regresamos a la pagina anterior con un mensaje de error
            Alert::error('Error', 'No se pudo actualizar la información, revisa que todos los datos esten correctos');
            return redirect()->back();
        }    
   }

   public function autorizar($nc)
   {     
        $sit = SitAlumno::where('no_control',$nc)->firstOrFail();
        $perfil = AlumnoCreditosPerfil::obtenerOCrear($sit->no_control);
        $perfil->ficha_completada = true;
        $perfil->save();
        return redirect()->route('alumnos.sta.pdf', $nc);
   }

   public function pdf($nc)
    {
        try
        {
            $ficha = $this->fichaAlumno->obtener($nc);
            abort_if(! $ficha, 404);
            $sit = $ficha['sit']['alumno'];
            $alu = (object) [
               'id' => $sit->id,
               'no_control' => $sit->no_control,
               'no_cont' => $sit->no_control,
            ];
            [$alu1, $car, $alu2] = $this->datosSitAlumno($nc);
    
            $historico = $ficha['historico_legacy'];
            $clinicos = $historico['clinicos'];
    
            $dPad = $historico['padre'];
            $dMad = $historico['madre'];
            $direccion = $historico['direccion'];
            $direccionP = $historico['direccion_padre'];
            $direccionM = $historico['direccion_madre'];
    
            $familiares = $historico['familiares'];
    
            $person = $historico['personales'];
            $fam = $historico['datos_familiares'];
            $soc = $historico['social'];
           
            $sitUrl = $ficha['url'];
            $pdf = PDF::setOptions(['defaultFont' => 'sans-serif'])->loadView('alumnos.sta.pdf', compact('familiares', 'alu1', 'alu2', 'car', 'dPad', 'dMad', 'direccion', 'direccionP', 'direccionM', 'soc', 'alu',  'clinicos', 'person', 'fam', 'sitUrl'));
            return $pdf->stream($alu->no_cont . ".pdf");    
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            //Regresamos a la pagina anterior con un mensaje de error
            Alert::error('Error', 'Ocurrio un error al generar el PDF, intentalo de nuevo');
            return redirect()->back();
        }           
    }
   
}
