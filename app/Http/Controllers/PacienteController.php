<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Paciente;
use App\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use App\Models\Sit\Alumno as SitAlumno;

class PacienteController extends Controller
{
    //Mostrar la vista para mis citas médicas
    public function index()
    {
        $usuario = Auth::guard('alumno')->check()
            ? Auth::guard('alumno')->user()
            : Auth::guard('web')->user();

        $paciente = $usuario
            ? Paciente::where('user_id', $usuario->getAuthIdentifier())->first()
            : null;

        $citas = $paciente
            ? Cita::where('paciente_id', $paciente->id)
            ->orderBy('fecha_cita')
            ->orderBy('hora_cita')
            ->get()
            : collect();

        return view('sistema_medico.paciente.mis_citas', compact('citas', 'paciente'));
    }

    //Mostrar la vista para crear una nueva cita médica
    public function create()
    {
        $usuario = Auth::guard('alumno')->check()
            ? Auth::guard('alumno')->user()
            : Auth::guard('web')->user();
        $paciente = $usuario
            ? Paciente::where('user_id', $usuario->getAuthIdentifier())->first()
            : null;
        if (!$paciente) {
            return redirect()->route('paciente.index.citas');
        }
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
        return view('sistema_medico.paciente.create_cita', compact('usuario', 'medicos', 'paciente'));
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
        $usuario = Auth::guard('alumno')->check()
            ? Auth::guard('alumno')->user()
            : Auth::guard('web')->user();
        $paciente = $usuario
            ? Paciente::where('user_id', $usuario->getAuthIdentifier())->first()
            : null;
        if (!$paciente) {
            Alert::error('Error', 'Primero debes completar tu perfil médico.');
            return redirect()->route('paciente.index.citas');
        }
        $cita->paciente_id = $paciente->id;
        $cita->estado_cita = 'Pendiente';
        $cita->notas_adicionales = "Sin comentarios adicionales.";
        $cita->save();
        //Redirigir a la vista de citas médicas con un mensaje de éxito
        Alert::success('Correcto','La cita médica ha sido programada exitosamente!');
        return redirect()->route(Auth::guard('alumno')->check()
            ? 'paciente.alumno.index.citas'
            : 'paciente.index.citas');
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
        $noControl = null;
        if (Auth::guard('alumno')->check()) {
            $sitAlumno = SitAlumno::where('user_id', Auth::guard('alumno')->id())->first();
            $noControl = $sitAlumno?->no_control;
        }
        //Agregamos el perfil del paciente si no existe de lo contrario lo actualizamos       
        $paciente = Paciente::updateOrCreate(
            ['user_id' =>$request->input('user_id')],
            [
                'no_control' => $noControl,
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
        return redirect()->route(Auth::guard('alumno')->check()
            ? 'paciente.alumno.index.citas'
            : 'paciente.index.citas');
    }

    //Mostrar la vista para editar el perfil de paciente
    public function editPerfil()
    {
        $usuario = Auth::guard('alumno')->check()
            ? Auth::guard('alumno')->user()
            : Auth::guard('web')->user();
        $paciente = $usuario
            ? Paciente::where('user_id', $usuario->getAuthIdentifier())->first()
            : null;
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