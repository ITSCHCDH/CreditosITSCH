@extends('template.molde')

@section('title','Sistema Medico - Crear Cita')

@section('ruta')
    <label class="label label-success"> <a href="#">Sistema Medico</a> / Crear Cita</label> 
@endsection

@section('contenido')
    {{--Formulario para crear una nueva cita médica--}}
    <div class="container"> 
        <div class="row justify-content-center">
            <div class="col-md-6"> 
                <div class="card mb-4 ">
                    <div class="card-header">
                        <h3>Programar Nueva Cita</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('paciente.store.cita') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="paciente">Paciente:</label>
                                <input type="text" class="form-control" id="paciente" name="paciente" value="{{ $usuario->name }}" readonly>
                                <input type="hidden" name="paciente_id" value="{{ $usuario->id }}">                                   
                            </div>
                            <div class="form-group">
                                <label for="medico">Medico:</label>
                                <select class="form-control" id="medico" name="medico_id" required>
                                    <option value="">Seleccione una opción</option>
                                    @foreach($medicos as $medico)
                                        <option value="{{ $medico->id }}">{{ $medico->name }} | {{ $medico->tipo_profesional }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="fecha">Fecha:</label>
                                <input type="date" class="form-control" id="fecha" name="fecha_cita" required>
                            </div>
                            <div class="form-group">
                                <label for="hora">Hora:</label>
                                <input type="time" class="form-control" id="hora" name="hora_cita" required>
                            </div>
                            <div class="form-group">
                                <label for="motivo">Motivo de la Cita:</label>
                                <textarea class="form-control" id="motivo" name="motivo_consulta" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Programar Cita</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>    
@endsection

