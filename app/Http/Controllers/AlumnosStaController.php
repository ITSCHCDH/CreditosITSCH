<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Historial_clinico;
use App\Models\Datos_familiares;
use App\Models\ALumno;
use App\Models\Direccion;
use App\Models\Familiar;
use App\Models\Personales;
use App\Models\Padres;
use App\Models\Social;
use PDF;

use Illuminate\Http\Request;

class AlumnosStaController extends Controller
{
   public function ficha()
   {    
      $no_cont=Auth::User()->no_control;      
      $alu = Alumno::where('no_control',$no_cont)->first();
      $alu1 = DB::connection('contEsc')->table('alumnos')->where('alu_NumControl', $no_cont)->first(); 
      $alu2 = DB::connection('contEsc')->table('alumcom')->where('alu_NumControl', $alu1->alu_NumControl)->first();
      $person = Personales::where('id_alu', $alu->id)->first();
      if ($person == null) {
         $person = new Personales();
         $person->id_alu = $alu->id;
         $person->save();
      }
      $car = DB::connection('contEsc')->table('carreras')->where('car_Clave', $alu1->car_Clave)->first();
      $dPad = Padres::where('id_alu', $alu->id)->where('parentesco', 'Padre')->first();
      if ($dPad == null) {
         $dPad = new Padres();
         $dPad->id_alu = $alu->id;
         $dPad->parentesco = 'Padre';
         $dPad->save();
      }
      $dMad = Padres::where('id_alu', $alu->id)->where('parentesco', 'Madre')->first();
      if ($dMad == null) {
         $dMad = new Padres();
         $dMad->id_alu = $alu->id;
         $dMad->parentesco = 'Madre';
         $dMad->save();
      }
      $direccion = Direccion::where('id_alu', $alu->id)->first();
      if ($direccion == null) {
         $direccion = new Direccion();
         $direccion->id_alu = $alu->id;
         $direccion->direccion = $alu2->alc_Direccion;
         $direccion->cp = $alu2->alc_CodPostal;
         $direccion->colonia = $alu2->alc_Colonia;
         $direccion->save();
      }
      $direccionP = Direccion::where('id_fam', $dPad->id)->first();
      if ($direccionP == null) {
         $direccionP = new Direccion();
         $direccionP->id_fam = $dPad->id;
         $direccionP->save();
      }
      $direccionM = Direccion::where('id_fam', $dMad->id)->first();
      if ($direccionM == null) {
         $direccionM = new Direccion();
         $direccionM->id_fam = $dMad->id;
         $direccionM->save();
      }
      $clinicos = Historial_clinico::where('id_alu', $alu->id)->first();
      if ($clinicos == null) {
         $clinicos = new Historial_clinico();
         $clinicos->id_alu = $alu->id;
         $clinicos->sangre = $alu2->alc_TipoSangre;
         $clinicos->save();
      }     
     
      $alumno_data = Alumno::where('no_control',Auth::User()->no_control)->select('id as alumno_id')->get();
      return view('alumnos.sta.ficha',compact('alu2', 'alu1', 'dPad', 'dMad', 'direccion', 'direccionP', 'direccionM', 'alu', 'car', 'clinicos', 'person','alumno_data'));
            
   }

   public function guardarDatFam(Request $request, $nc)
   {
      $alu = Alumno::where('no_control',$nc)->first();
      $clinicos = Historial_clinico::where('id_alu', $alu->id)->first();
      $person = Personales::where('id_alu', $alu->id)->first();
      $dPad = Padres::where('id_alu', $alu->id)->where('parentesco', 'Padre')->first();
      $dMad = Padres::where('id_alu', $alu->id)->where('parentesco', 'Madre')->first();
      $direccion = Direccion::where('id_alu', $alu->id)->first();
      $direccionP = Direccion::where('id_fam', $dPad->id)->first();
      $direccionM = Direccion::where('id_fam', $dMad->id)->first();
      $alu->email = $request->email;
      $alu->tel = $request->tel;
      $alu->est_civ = $request->est_civ;
      $alu->lug_pro = $request->lug;
      $alu->grupo = $request->grupo;     
      $alu->save();

      $dPad->nombre = $request->nomPa;
      $dPad->edad = $request->EdadPa;
      $dPad->tel = $request->TelPa;
      $dPad->profesion = $request->ProfPa;
      if ($request->trPad == 'No') {
          $dPad->ocupacion = $request->trPad;
      } else {
          $dPad->ocupacion = $request->trabPatext;
      }
      $dPad->save();

      $dMad->nombre = $request->nomMa;
      $dMad->edad = $request->EdadMa;
      $dMad->tel = $request->TelMa;
      $dMad->profesion = $request->ProfMa;
      if ($request->trMad == 'No') {
          $dMad->ocupacion = $request->trMad;
      } else {
          $dMad->ocupacion = $request->trabMtext;
      }
      $dMad->save();

      $direccion->direccion = $request->direccion;
      $direccion->cp = $request->cp;
      $direccion->colonia = $request->colonia;
      $direccion->estado = $request->estado;
      $direccion->municipio = $request->municipio;
      $direccion->save();

      $direccionP->direccion = $request->direccionP;
      $direccionP->cp = $request->cpP;
      $direccionP->colonia = $request->coloniaP;
      $direccionP->estado = $request->estadoP;
      $direccionP->municipio = $request->municipioP;
      $direccionP->save();

      $direccionM->direccion = $request->direccionM;
      $direccionM->cp = $request->cpM;
      $direccionM->colonia = $request->coloniaM;
      $direccionM->estado = $request->estadoM;
      $direccionM->municipio = $request->municipioM;
      $direccionM->save();

      $clinicos->sangre = $request->sangre;
      $clinicos->estatura = $request->estatura;
      $clinicos->peso = $request->peso;
      $clinicos->save();

      if ($request->trAlu == 'No') {
          $person->trab = $request->trAlu;
      } else {
          $person->trab = $request->trabajo;
      }
      if ($request->casa == 'Otro') {
          $person->casa = $request->casatipo;
      } else {
          $person->casa = $request->casa;
      }
      $person->num_person = $request->num_person;
      $person->parentesco = $request->parentesco;
      $person->save();
      
      return redirect()->route('alumnos.sta.editDatSalud', $alu->no_control);
   }

   public function editDatSalud($nc)
   {
      $alu = Alumno::where('no_control',$nc)->first();
      $alu1 = DB::connection('contEsc')->table('alumnos')->where('alu_NumControl', $nc)->first(); 
      $clinicos = Historial_clinico::where('id_alu', $alu->id)->first();
      $alumno_data = Alumno::where('no_control',Auth::User()->no_control)->select('id as alumno_id')->get();
      return view('alumnos.sta.dsalud', compact('alu1', 'alu', 'clinicos','alumno_data'));
   }

   public function updtDatSalud(Request $request, $nc)
   {
      $alu = Alumno::where('no_control',$nc)->first();
      $clinicos = Historial_clinico::where('id_alu', $alu->id)->first();
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
      $alumno_data = Alumno::where('no_control',Auth::User()->no_control)->select('id as alumno_id')->get();     
      $alu1 = DB::connection('contEsc')->table('alumnos')->where('alu_NumControl', $nc)->first(); 
      $fam = Datos_familiares::where('id_alu', $alu->id)->first();
      if ($fam == null) {
          $fam = new Datos_familiares();
          $fam->id_alu = $alu->id;
          $fam->save();
      }
      $familiares = Familiar::where('id_alu', $alu->id)->get();     
      return view('alumnos.sta.dfamiliares', compact('alu1', 'alu', 'fam', 'familiares','alumno_data'));
   }

   public function updtDatFam(Request $request, $nc)
   {
        $alu = Alumno::where('no_control',$nc)->first();
        $familiares = Familiar::where('id_alu', $alu->id)->get();
        foreach ($familiares as &$famil) {
            $famil->delete();
        }


        for ($i = 0; $i < count($request->edad); $i++) {
            $familiar = new Familiar();
            $familiar->id_alu = $alu->id;
            $familiar->nombre = $request->nombre[$i];
            $familiar->edad = $request->edad[$i];
            $familiar->escolaridad = $request->escolaridad[$i];
            $familiar->parentesco = $request->parentesco[$i];
            $familiar->relacion = $request->actitud[$i];
            $familiar->save();
        }

        $fam = Datos_familiares::where('id_alu', $alu->id)->first();
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
        
        
        $alu1 = DB::connection('contEsc')->table('alumnos')->where('alu_NumControl', $nc)->first(); 
        $soc = Social::where('id_alu', $alu->id)->first();
        if ($soc == null) {
            $soc = new Social();
            $soc->id_alu = $alu->id;
            $soc->save();
        }
        $alumno_data = Alumno::where('no_control',Auth::User()->no_control)->select('id as alumno_id')->get();
        return view('alumnos.sta.dsocial', compact('alu1', 'alu', 'soc','alumno_data'));
   }

   public function updtDatSoc(Request $request, $nc)
   {
        $alu = Alumno::where('no_control',$nc)->first();
        $soc = Social::where('id_alu', $alu->id)->first();
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

        $alu1 = DB::connection('contEsc')->table('alumnos')->where('alu_NumControl', $nc)->first(); 
        $alumno_data = Alumno::where('no_control',Auth::User()->no_control)->select('id as alumno_id')->get();
        return view('alumnos.sta.autorizar', compact('alu1', 'alu','alumno_data'));
   }

   public function autorizar($nc)
   {        
        return redirect()->route('alumnos.sta.pdf', $nc);
   }

   public function pdf($nc)
    {
        $alu = Alumno::where('no_control',$nc)->first();
        $alu1 = DB::connection('contEsc')->table('alumnos')->where('alu_NumControl', $nc)->first(); 
        $car = DB::connection('contEsc')->table('carreras')->where('car_Clave', $alu1->car_Clave)->first();
        $alu2 = DB::connection('contEsc')->table('alumcom')->where('alu_NumControl', $alu1->alu_NumControl)->first();

        $clinicos = Historial_clinico::where('id_alu', $alu->id)->first();

        $dPad = Padres::where('id_alu', $alu->id)->where('parentesco', 'Padre')->first();
        $dMad = Padres::where('id_alu', $alu->id)->where('parentesco', 'Madre')->first();
        $direccion = Direccion::where('id_alu', $alu->id)->first();
        $direccionP = Direccion::where('id_fam', $dPad->id)->first();
        $direccionM = Direccion::where('id_fam', $dMad->id)->first();

        $familiares = Familiar::where('id_alu', $alu->id)->get();

        $person = Personales::where('id_alu', $alu->id)->first();
        $fam = Datos_familiares::where('id_alu', $alu->id)->first();
        $soc = Social::where('id_alu', $alu->id)->first();
       
        $pdf = PDF::setOptions(['defaultFont' => 'sans-serif'])->loadView('alumnos.sta.pdf', compact('familiares', 'alu1', 'alu2', 'car', 'dPad', 'dMad', 'direccion', 'direccionP', 'direccionM', 'soc', 'alu',  'clinicos', 'person', 'fam'));       
        return $pdf->stream($alu->no_cont . ".pdf");        
    }
   
}
