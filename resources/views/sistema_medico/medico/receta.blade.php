@extends('template.molde')

@section('title','Sistema Medico - Receta')

@section('ruta')
    <label class="label label-success"> <a href="{{ route('medico.index') }}">Sistema Medico</a> / Receta</label> 
@endsection

@section('contenido')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-6">
                               <h3>Receta Médica</h3> 
                            </div>
                            <div class="col-md-6" style="text-align: right;">                                 
                            </div>
                        </div>              
                        <hr>                    
                    </div>
                    <div class="card-body">                  
                        <div class="form-group">                            
                            <label for="paciente"><strong>Paciente:</strong> {{ $usuarioPaciente->name }}</label><br>
                            <label for="medico"><strong>Médico:</strong> Dr. {{ $medico->name }}</label><br>
                            <label for="fecha"><strong>Fecha:</strong> {{ date('d/m/Y') }}</label><br>
                            <hr>
                            <form action="{{ route('medico.guardar.receta', $cita->id) }}" method="post">
                                @csrf
                                <label for="diagnostico"><strong>Diagnóstico:</strong></label>
                                <textarea class="form-control" name="diagnostico" id="" cols="30" rows="2" required></textarea>
                                <label for="medicamentos"><strong>Medicamentos Recetados:</strong></label>
                                <textarea class="form-control" name="tratamiento" id="" cols="30" rows="10" placeholder="Lista de medicamentos recetados y/o tratamiento a seguir" required></textarea>                                
                                <hr>
                                <button type="submit" class="btn btn-success"><i class="fas fa-print"></i> Guardar e Imprimir</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
@endsection