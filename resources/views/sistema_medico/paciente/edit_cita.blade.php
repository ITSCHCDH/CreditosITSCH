@extends('template.molde')

@section('title','Sistema Medico - Editar cita')

@section('ruta')
    <label class="label label-success"> <a href="{{ route('paciente.index.citas') }}">Sistema Medico</a> / Mis Citas / Editar Cita</label> 
@endsection

@section('contenido')
    {{--Formulario para editar una cita médica--}}
    <div class="container"> 
        <div class="row justify-content-center">
            <div class="col-md-6"> 
                <div class="card mb-4 ">
                    <div class="card-header">
                        <h3>Editar Cita Médica</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('paciente.update.cita', $cita->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="fecha">Fecha:</label>
                                <input type="date" class="form-control" id="fecha" name="fecha_cita" value="{{ $cita->fecha_cita }}" required>
                            </div>
                            <div class="form-group">
                                <label for="hora">Hora:</label>
                                <input type="time" class="form-control" id="hora" name="hora_cita" value="{{ $cita->hora_cita }}" required>
                            </div>
                            <div class="form-group">
                                <label for="medico">Medico:</label>
                                <select class="form-control" id="medico" name="medico_id" required>
                                    <option value="">Seleccione una opción</option>
                                    @foreach($medicos as $medico)
                                        <option value="{{ $medico->id }}" {{ $cita->medico_id == $medico->id ? 'selected' : '' }}>{{ $medico->name }} | {{ $medico->tipo_profesional }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="motivo">Motivo de la Consulta:</label>
                                <textarea class="form-control" id="motivo" name="motivo_consulta" rows="3" required>{{ $cita->motivo_consulta }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="estado">Estatus de la Cita:</label>
                                <input type="text" class="form-control" id="estado" name="estado_cita" value="{{ $cita->estado_cita }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="notas">Notas Adicionales:</label>
                                <textarea class="form-control" id="notas" name="notas_adicionales" rows="3" readonly>{{ $cita->notas_adicionales }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar Cita</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection