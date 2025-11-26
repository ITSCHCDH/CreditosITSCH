<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Historial_Medico;
use RealRashid\SweetAlert\Facades\Alert;

class SistemaMedicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
          $user = auth()->user();     
    $esMedico = $user->hasPermissionTo('VIP_MEDICO') || $user->hasPermissionTo('VIP_PSICOLOGO');          
    
    // Determinar qué estados mostrar según el filtro
    $filtro = $request->get('filtro', 'Pendiente'); // Por defecto mostrar pendientes
    
    $estados = $this->obtenerEstadosPorFiltro($filtro);
    
    if ($esMedico) {
        $citas = Cita::where('medico_id', $user->id)
                ->when(!empty($estados), function($query) use ($estados) {
                    return $query->whereIn('estado_cita', $estados);
                })
                ->with([
                    'paciente.user:id,name,email',
                    'paciente:id,user_id,tipo,alergias'
                ])
                ->orderBy('fecha_cita', 'asc')
                ->orderBy('hora_cita', 'asc')
                ->get();
        } elseif ($user->hasPermissionTo('VIP')) {
            $citas = Cita::when(!empty($estados), function($query) use ($estados) {
                    return $query->whereIn('estado_cita', $estados);
                })
                ->with([
                    'paciente.user:id,name,email',
                    'paciente:id,user_id,tipo,alergias',
                    'medico:id,name'
                ])
                ->orderBy('fecha_cita', 'asc')
                ->orderBy('hora_cita', 'asc')
                ->get();
        } else {
            abort(403, 'Acceso denegado');
        }

        return view('sistema_medico.medico.index', compact('citas', 'filtro'));
    }

    // Método para obtener estados según el filtro
    private function obtenerEstadosPorFiltro($filtro)
    {
        switch ($filtro) {
            case 'activas':
                return ['Pendiente', 'Confirmada'];
            case 'canceladas':
                return ['Cancelada'];
            case 'atendidas':
                return ['Atendida'];
            case 'todas':
                return []; // Array vacío para mostrar todas
            default:
                return ['Pendiente', 'Confirmada'];
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function guardarReceta($cita_id, Request $request)
    {        
        //Guardamos el tratamiento como historial medico
        $historialMedico = new Historial_Medico();
        $historialMedico->paciente_id =  $user = auth()->user()->id;
        $historialMedico->cita_id = $cita_id;
        $historialMedico->diagnostico = $request->input('diagnostico');
        $historialMedico->tratamiento = $request->input('tratamiento');
        $historialMedico->notas_adicionales = $request->input('notas_adicionales');
        $historialMedico->semaforo = $request->input('semaforo');
        $historialMedico->save();  
        //Cambiamos el status de la cita a atendida
        $cita = Cita::findOrFail($cita_id);
        $cita->estado_cita = 'Atendida';
        $cita->save();
        //Redirigir a la vista de citas médicas con un mensaje de éxito
        Alert::success('Correcto','El historial médico ha sido guardado exitosamente!');
        return redirect()->route('medico.index'); 
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    { 
        //Llamar vista de editar
        $cita=Cita::find($id); 
        $medico=User::where('id',$cita->medico_id)->first(); 
        return view('sistema_medico.medico.edit_cita', compact('cita','medico'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //Validar los datos del formulario
        $request->validate([
            'fecha_cita' => 'required|date',
            'hora_cita' => 'required',
            'motivo_consulta' => 'required|string',
            'estado_cita' => 'required|string',
            'notas_adicionales' => 'nullable|string',
        ]);
        //Actualizar la cita médica en la base de datos
        $cita = Cita::findOrFail($id);
        $cita->fecha_cita = $request->input('fecha_cita');
        $cita->hora_cita = $request->input('hora_cita');
        $cita->motivo_consulta = $request->input('motivo_consulta');
        $cita->estado_cita = $request->input('estado_cita');
        $cita->notas_adicionales = $request->input('notas_adicionales');
        $cita->save(); 
        //Redirigir a la vista de citas médicas con un mensaje de éxito
        Alert::success('Correcto','La cita médica ha sido actualizada exitosamente!');
        return redirect()->route('medico.index');
    }

    public function generarReceta($id)
    {
        // Abrimos el formulario de receta medica para ser llenado por el medico
        $cita = Cita::find($id);
        $medico = User::where('id', $cita->medico_id)->first();
        $paciente= Paciente::where('id',$cita->paciente_id)->first();         
        $usuarioPaciente= User::where('id',$paciente->user_id)->first(); 
        return view('sistema_medico.medico.receta', compact('cita', 'medico', 'paciente', 'usuarioPaciente'));
    }

    public function atenderCita($id)
    {
        // Abrimos el formulario de historial medico para ser llenado por el medico
        $cita = Cita::find($id);
        $medico = User::where('id', $cita->medico_id)->first();
        $paciente= Paciente::where('id',$cita->paciente_id)->first();
        $usuarioPaciente= User::where('id',$paciente->user_id)->first(); 
        $historialMedico= Historial_Medico::where('paciente_id',$paciente->id)->get(); 
        //Si es alumno buscamos su historial clinico de lo contrario lo omitimos
        if($paciente->tipo=='Alumno'){
            $historialClinico= HistorialClinico::where('paciente_id',$paciente->id)->first();
        }else{
            $historialClinico=null;
        }
        return view('sistema_medico.medico.atender_cita', compact('cita', 'medico', 'paciente', 'historialMedico', 'historialClinico', 'usuarioPaciente'));
    }
}
