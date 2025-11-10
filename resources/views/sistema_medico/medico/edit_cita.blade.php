@extends('template.molde')

@section('title','Sistema Medico - Gestionar cita')

@section('ruta')
    <label class="label label-success"> <a href="{{ route('medico.index') }}">Sistema Medico</a> / Gestionar cita</label> 
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
                            <form action="{{ route('medico.update.cita', $cita->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="fecha">Fecha:</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha_cita" value="{{ $cita->fecha_cita }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="hora">Hora:</label>
                                    <input type="time" class="form-control" id="hora" name="hora_cita" value="{{ $cita->hora_cita }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="medico">Medico:</label>
                                    <input type="text" class="form-control" id="medico" name="medico_id" value="{{ $medico->name }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="motivo">Motivo de la Consulta:</label>
                                    <textarea class="form-control" id="motivo" name="motivo_consulta" rows="3" readonly>{{ $cita->motivo_consulta }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="estado">Estatus de la Cita:</label>
                                    <select name="estado_cita" id="estado" class="form-control" required>
                                        <option value="Pendiente" {{ $cita->estado_cita == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="Confirmada" {{ $cita->estado_cita == 'Confirmada' ? 'selected' : '' }}>Confirmada</option>
                                        <option value="Cancelada" {{ $cita->estado_cita == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>                                        
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="notas">Notas Adicionales:</label>
                                    <textarea class="form-control" id="notas" name="notas_adicionales" rows="3" required>{{ $cita->notas_adicionales }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Actualizar Cita</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection