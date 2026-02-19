@extends('template.molde')

@section('title','Sistema Medico - Semaforo')

@section('ruta')
    <label class="label label-success"> <a href="{{ route('medico.index') }}">Sistema Medico</a> / Semaforo</label> 
@endsection

@section('contenido')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-6">
                               <h3>Actualizar Semaforo Médico</h3> 
                            </div>
                            <div class="col-md-6" style="text-align: right;">                                 
                            </div>
                        </div>              
                        <hr>                    
                    </div>
                    <div class="card-body">                  
                        <div class="form-group">
                                <label for="paciente"><strong>Paciente:</strong> {{ $paciente->nombre }}</label><br>
                            <label for="medico"><strong>Médico:</strong> Dr. {{ $medico->name }}</label><br>
                            <label for="fecha"><strong>Fecha:</strong> {{ date('d/m/Y') }}</label><br>
                            <label for="notas"><strong>observaciones historicas:</strong></label>
                            <textarea class="form-control" name="observaciones_med" cols="30" rows="2" readonly>{{ $dat_medicos->observaciones_med }}</textarea>
                            <hr>                            
                            <form action="{{ route('medico.guardar.semaforo', $cita->id) }}" method="post">
                                @csrf
                                <label for="semaforo"><strong>Semaforo:</strong></label>
                                <select name="semaforo" id="semaforo" class="form-control" required>                                    
                                    <option value="1" {{ $dat_medicos->sem_med == 1 ? 'selected' : '' }}>🟢 Verde</option>
                                    <option value="2" {{ $dat_medicos->sem_med == 2 ? 'selected' : '' }}>🟡 Amarillo</option>
                                    <option value="3" {{ $dat_medicos->sem_med == 3 ? 'selected' : '' }}>🟠 Naranja</option>
                                    <option value="4" {{ $dat_medicos->sem_med == 4 ? 'selected' : '' }}>🔴 Rojo</option>
                                </select>
                                <label for="notas"><strong>Notas Adicionales:</strong></label>
                                <textarea class="form-control" name="observaciones_med" cols="30" rows="2" placeholder="Ingrese notas adicionales..."></textarea>
                                <hr>
                                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection