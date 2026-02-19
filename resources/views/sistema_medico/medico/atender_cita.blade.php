@extends('template.molde')

@section('title','Sistema Medico - Atender Cita')

@section('ruta')
    <label class="label label-success"> <a href="{{ route('medico.index') }}">Sistema Medico</a> / Atender Cita</label> 
@endsection

@section('contenido')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-6">
                               <h3>Atender Cita</h3> 
                            </div>
                            <div class="col-md-6" style="text-align: right;">
                                 <a class="btn btn-primary" href="{{ route('medico.generar.receta', $cita->id) }}"><i class="fas fa-prescription"></i> Receta</a>
                                 <a class="btn btn-secondary" href="{{ route('medico.actualizar.semaforo', $cita->id) }}"><i class="fas fa-user-md"></i> Semaforo</a>
                            </div>
                        </div>              
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Paciente:</strong> {{ $usuarioPaciente->name }}<br>
                                <strong>Tipo de Paciente:</strong> {{ $paciente->tipo }} <br>  
                                <strong>Email del Paciente:</strong> {{ $usuarioPaciente->email }} <br>
                                <strong>Contacto de emergencia:</strong> {{ $paciente->contacto_emergencia }} <br>
                                <strong>Fecha de la Cita:</strong> {{ $cita->fecha_cita }} <br>
                                <strong>Hora de la Cita:</strong> {{ $cita->hora_cita }} <br>
                            </div>
                            <div class="col-md-4">
                                <strong>Motivo de la Cita:</strong> {{ $cita->motivo_consulta }} <br>                              
                                <strong>Fecha de Creación de la Cita:</strong> {{ $cita->created_at }} <br>
                                <strong>Última Actualización de la Cita:</strong> {{ $cita->updated_at }} <br>
                            </div>
                            <div class="col-md-4" style="text-align: center;">
                                {{--Fotografia del paciente--}}                               
                                <img src="{{ asset('images/user.png') }}" alt="Foto del Paciente" class="img-fluid rounded" style="max-width: 150px; max-height: 150px;">                              
                            </div> 
                        </div>                    
                    </div>
                    <div class="card-body">                  
                        <div class="form-group">                              
                            <label>Historial Medico:</label>
                            <div class="form-control" style="height: 300px; overflow-y: auto; white-space: pre-wrap;">
                                    @if($historialMedico->isNotEmpty())
                                        @foreach($historialMedico as $historial)
                                            Fecha Cita: {{ $historial->created_at->format('d/m/Y H:i') }}
                                            <strong>Notas:</strong> {{ $historial->notas_adicionales ?? 'Sin notas' }}                                                                                       
                                            ----------------------------------------                                           
                                            <strong>Diagnostico:</strong> {{ $historial->diagnostico ?? 'Ninguno' }}                                           
                                            <strong>Tratamiento:</strong> {{ preg_replace('/\s+/', ' ', $historial->tratamiento ?? 'Ninguno') }}
                                            ========================================
                                        @endforeach
                                    @else
                                        No hay historial médico disponible para este paciente.
                                    @endif
                            </div>
                        </div>  
                        <div class="form-group">
                            <label>Detalles Clínicos:</label>    
                            <div class="card">
                                <div class="card-header py-2">
                                    <button class="btn btn-link p-0 text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#detallesClinicos">
                                        <i class="fas fa-medkit"></i> Historial Clínico 
                                        <i class="fas fa-chevron-down ms-2"></i>
                                    </button>
                                </div>
                                
                                <div class="collapse" id="detallesClinicos">
                                    <div class="card-body" style="max-height: 300px; overflow-y: auto; white-space: pre-wrap;">
                                        @if($historialClinico)
                                            Peso: {{ $historialClinico->peso ?? 'No registrado' }} kg
                                            Estatura: {{ $historialClinico->estatura ?? 'No registrado' }} m
                                            Tipo de Sangre: {{ $historialClinico->sangre ?? 'No registrado' }}
                                            ========================================
                                            Enfermedades Previas: {{ $historialClinico->enfermedad ?? 'Ninguna' }}
                                            Hipertensión: {{ $historialClinico->hipertension ?? 'No' }}
                                            Diabetes: {{ $historialClinico->diabetes ?? 'No' }}
                                            Epilepsia: {{ $historialClinico->epilepsia ?? 'No' }}
                                            Anorexia: {{ $historialClinico->anorexia ?? 'No' }}
                                            Bulimia: {{ $historialClinico->bulimia ?? 'No' }}
                                            Sexualidad: {{ $historialClinico->sexual ?? 'No' }}
                                            Depresión: {{ $historialClinico->depresion ?? 'No' }}
                                            Capacidad Diferente: {{ $historialClinico->cap_dif ?? 'No' }}
                                            Vista: {{ $historialClinico->vista ?? 'Normal' }}
                                            Audición: {{ $historialClinico->oido ?? 'Normal' }}
                                        @else
                                            <div class="text-center text-muted">
                                                <i class="fas fa-info-circle"></i> No hay historial clínico registrado.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>                                                 
                        </div>               
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection