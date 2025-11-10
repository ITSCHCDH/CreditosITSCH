@extends('template.molde')

@section('title','Sistema Medico - Completar Perfil')

@section('ruta')
    <label class="label label-success"> <a href="{{ route('paciente.index.citas') }}">Sistema Medico</a> / Completar Perfil</label> 
@endsection

@section('contenido')
    {{--Formulario para completar el perfil de paciente --}}
    <div class="container"> 
        <div class="row justify-content-center">
            <div class="col-md-6">  
                <div class="card mb-4 ">
                    <div class="card-header">
                        <h3>Completar Perfil de Paciente</h3>
                        <a href="{{ route('paciente.index.citas') }}" class="btn btn-secondary float-right" title="Regresar"><i class="fas fa-arrow-left"></i></a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('paciente.store.perfil') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $usuario->id }}">
                            <div class="form-group">
                                <label for="nombre">Nombre Completo:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre_completo" value="{{ $usuario->name }}" readonly>   
                            </div>
                            <div class="form-group">
                                <label for="edad">Edad:</label>
                                <input type="number" class="form-control" id="edad" name="edad" value="{{ $paciente->edad }}" required>
                            </div>  
                            <div class="form-group">
                                <label for="tipo">Tipo de Paciente:</label>
                                <select class="form-control" id="tipo" name="tipo"  required>
                                    <option value="">Seleccione una opción</option>
                                    <option value="Alumno" {{ $paciente->tipo === 'Alumno' ? 'selected' : '' }}>Alumno</option>
                                    <option value="Trabajador" {{ $paciente->tipo === 'Trabajador' ? 'selected' : '' }}>Trabajador</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="alergias">Alergias:</label>
                                <textarea class="form-control" id="alergias" name="alergias" rows="3" placeholder="Explica si tienes alguna alergia o si eres alérgico a algún medicamento">{{ $paciente->alergias }}</textarea>   
                            </div>
                            <div class="form-group">
                                <label for="enfermedades">Enfermedades Crónicas:</label>
                                <textarea class="form-control" id="enfermedades" name="enfermedades_cronicas" rows="3" placeholder="Enumera las enfermedades crónicas que padeces">{{ $paciente->enfermedades_cronicas }}</textarea>  
                            </div>
                            <div class="form-group">
                                <label for="medicamentos">Medicamentos Actuales:</label>
                                <textarea class="form-control" id="medicamentos" name="medicamentos_actuales" rows="3" placeholder="Enumera los medicamentos que estás tomando actualmente">{{ $paciente->medicamentos_actuales }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="contacto_emergencia">Contacto de Emergencia:</label>
                                <input type="text" class="form-control" id="contacto_emergencia" name="contacto_emergencia" placeholder="Nombre del contacto de emergencia" value="{{ $paciente->contacto_emergencia }}" required>
                            </div>
                            <div class="form-group">
                                <label for="telefono_emergencia">Teléfono de Emergencia:</label>
                                <input type="text" class="form-control" id="telefono_emergencia" name="telefono_emergencia" placeholder="Teléfono del contacto de emergencia" value="{{ $paciente->telefono_emergencia }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>    
@endsection