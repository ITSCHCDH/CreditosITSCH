<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Paciente;
use App\User;
use RealRashid\SweetAlert\Facades\Alert;

class PacienteController extends Controller
{
    //Mostrar la vista para mis citas médicas
    public function index()
    {
        //Consultamos las citas ordenadas por fecha y los pasamos a la vista       
        $citas = Cita::where('paciente_id', auth()->user()->id)->orderBy('fecha_cita', 'asc')->get();
        //Consultamos si este usuario ya es paciente, si no, lo redirigimos a completar su perfil
        $usuario = auth()->user(); 
        $esPaciente = Paciente::where('user_id', $usuario->id)->first();
        if (!$esPaciente) {
            //Redirigimos a la vista para completar el perfil de paciente y enviamos los datos del usuario
            $paciente = Paciente::where('user_id', $usuario->id)->first(); 
            return view('sistema_medico.paciente.completar_perfil', compact('usuario', 'paciente'));
        }
        return view('sistema_medico.paciente.mis_citas', compact('citas'));
    }

    //Mostrar la vista para crear una nueva cita médica
    public function create()
    {
        //Consultamos los datos del usuario logueado y los pasamos a la vista
        $usuario = auth()->user();
        //Consultamos los médicos disponibles para asignar la cita, estos son los que tienen asignado el permiso de VIP_MEDICO o VIP_PSICOLOGO
        $medicos = User::whereHas('roles.permissions', function ($query) {
            $query->whereIn('name', ['VIP_MEDICO', 'VIP_PSICOLOGO']);
        })
        ->with(['roles.permissions' => function($query) {
            $query->whereIn('name', ['VIP_MEDICO', 'VIP_PSICOLOGO']);
        }])
        ->get()
        ->map(function($user) {
            // Determinar el tipo basado en los permisos
            $tipo = 'general';
            if ($user->hasPermissionTo('VIP_MEDICO')) {
                $tipo = 'Medico';
            } elseif ($user->hasPermissionTo('VIP_PSICOLOGO')) {
                $tipo = 'Psicologo';
            }
            
            $user->tipo_profesional = $tipo;
            return $user;
        });  
        return view('sistema_medico.paciente.create_cita', compact('usuario', 'medicos'));
    }

    //Guardar la nueva cita médica en la base de datos
    public function store(Request $request)
    {
        //Validar los datos del formulario
        $request->validate([
            'fecha_cita' => 'required|date',
            'hora_cita' => 'required',
            'motivo_consulta' => 'required|string',
        ]);       
        //Verificamos que el espacio para la cita no esté ya ocupado com mas menos 30 minutos
        $fechaCita = $request->input('fecha_cita');
        $horaCita = $request->input('hora_cita');
        $citaExistente = Cita::where('fecha_cita', $fechaCita)
            ->where('hora_cita', '>=', date('H:i:s', strtotime($horaCita . ' -30 minutes')))
            ->where('hora_cita', '<=', date('H:i:s', strtotime($horaCita . ' +30 minutes')))
            ->first();
        if ($citaExistente) {
            //Si ya existe una cita en ese horario, redirigir con un mensaje de error
            Alert::error('Error','Ya existe una cita programada en ese horario. Por favor, elija otro horario.');
            return redirect()->back()->withInput();
        }          
        //Si la validación es exitosa, se guarda la cita en la base de datos
        //Aquí va la lógica para guardar la cita            
        $cita = new Cita();
        $cita->fecha_cita = $request->input('fecha_cita');
        $cita->hora_cita = $request->input('hora_cita');
        $cita->medico_id = $request->input('medico_id');
        $cita->motivo_consulta = $request->input('motivo_consulta');
        $cita->paciente_id = $request->input('paciente_id');
        $cita->estado_cita = 'Pendiente';
        $cita->notas_adicionales = "Sin comentarios adicionales.";
        $cita->save();
        //Redirigir a la vista de citas médicas con un mensaje de éxito
        Alert::success('Correcto','La cita médica ha sido programada exitosamente!');
        return redirect()->route('paciente.index.citas');
    }

    //Guardar el perfil de paciente en la base de datos
    public function storePerfil(Request $request)
    {
        //Validar los datos del formulario
        $request->validate([
            'tipo' => 'required|string',
            'alergias' => 'nullable|string',
            'enfermedades_cronicas' => 'nullable|string',
            'medicamentos_actuales' => 'nullable|string',
            'contacto_emergencia' => 'nullable|string',
            'telefono_emergencia' => 'nullable|string',
        ]);
        //Agregamos el perfil del paciente si no existe de lo contrario lo actualizamos       
        $paciente = Paciente::updateOrCreate(
            ['user_id' =>$request->input('user_id')],
            [
                'tipo' => $request->input('tipo'),
                'edad' => $request->input('edad'),
                'alergias' => $request->input('alergias'),
                'enfermedades_cronicas' => $request->input('enfermedades_cronicas'),
                'medicamentos_actuales' => $request->input('medicamentos_actuales'),
                'contacto_emergencia' => $request->input('contacto_emergencia'),
                'telefono_emergencia' => $request->input('telefono_emergencia'),
            ]
        );
        //Redirigir a la vista de citas médicas con un mensaje de éxito
        Alert::success('Correcto','El perfil de paciente ha sido completado exitosamente!');
        return redirect()->route('paciente.index.citas');
    }

    //Mostrar la vista para editar el perfil de paciente
    public function editPerfil()
    {
        //Consultamos los datos del usuario logueado y su perfil de paciente
        $usuario = auth()->user();
        $paciente = Paciente::where('user_id', $usuario->id)->first(); 
        return view('sistema_medico.paciente.completar_perfil', compact('usuario', 'paciente'));
    }

    //Mostrar la vista para editar una cita médica
    public function edit($id)
    {
        //Consultamos la cita médica por su id
        $cita = Cita::findOrFail($id);
         //Consultamos los médicos disponibles para asignar la cita, estos son los que tienen asignado el permiso de VIP_MEDICO o VIP_PSICOLOGO
        $medicos = User::whereHas('roles.permissions', function ($query) {
            $query->whereIn('name', ['VIP_MEDICO', 'VIP_PSICOLOGO']);
        })
        ->with(['roles.permissions' => function($query) {
            $query->whereIn('name', ['VIP_MEDICO', 'VIP_PSICOLOGO']);
        }])
        ->get()
        ->map(function($user) {
            // Determinar el tipo basado en los permisos
            $tipo = 'general';
            if ($user->hasPermissionTo('VIP_MEDICO')) {
                $tipo = 'Medico';
            } elseif ($user->hasPermissionTo('VIP_PSICOLOGO')) {
                $tipo = 'Psicologo';
            }
            
            $user->tipo_profesional = $tipo;
            return $user;
        });  
        return view('sistema_medico.paciente.edit_cita', compact('cita', 'medicos'));
    }

    //Actualizar la cita médica en la base de datos
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
        $cita->notas_adicionales = "Sin comentarios adicionales.";
        $cita->save();
        //Redirigir a la vista de citas médicas con un mensaje de éxito
        Alert::success('Correcto','La cita médica ha sido actualizada exitosamente!');
        return redirect()->route('paciente.index.citas');
    }

    //Eliminar una cita médica
    public function destroy($id)
    {
        //Eliminar la cita médica de la base de datos
        $cita = Cita::findOrFail($id);
        $cita->delete();
        //Redirigir a la vista de citas médicas con un mensaje de éxito
        Alert::success('Correcto','La cita médica ha sido eliminada exitosamente!');
        return redirect()->route('paciente.index.citas');
    }
}