@extends('template.molde')

@section('title','Crear Actividad')

@section('ruta')
    <a href="{{route('actividades.index')}}"> Actividades </a>
    /
    <label class="label label-success"> Altas</label>
@endsection

@section('contenido')

    
    <form action="{{ route('actividades.store') }}" method="POST">
    {{csrf_field()}}
    <div class="form-group">      
        <label for="nombre">Nombre de la actividad</label>        
        <input type="text" name="nombre" class="form-control" placeholder="Nombre de la actividad" required>
    </div>

    <div class="form-group">        
        <label for="avance">Porcentaje de liberación</label>        
        <input type="text" name="por_cred_actividad" class="form-control" placeholder="Porcentage del crédito que se liberara con esta actividad, ej 20" required>
    </div>

    <div class="form-group">        
        <label for="select-category">Credito al que pertenece la actividad</label>
        
        <select class="form-control form-control-sm" id="select-category" required name="id_actividad">	
            <option value="">Selecciona un tipo de credito</option>
            @foreach($creditos as $cred)
                <option value="{{ $cred->id }}">{{ $cred->nombre }}</option>
            @endforeach
        </select>
    </div>
    @if (Auth::User()->hasAnyPermission(['VIP','CREAR_ACTIVIDAD_ALUMNOS','VIP_ACTIVIDAD']))
        <div class="form-group">            
            <label for="alumnos">Alumnos Responsables</label>            
            <select class="form-control form-control-sm" id="alumnos" required name="alumnos">	
                <option value="">¿Actividad dedicada para alumnos responsables?, Si no estas seguro selecciona NO</option>
                <option value="false">NO</option>
                <option value="true">SI</option>               
            </select>
        </div>
    @endif


    <div class="form-group">        
        <input type="submit" value="Registrar actividad" class="btn btn-primary btn-sm">
    </div>


</form>

@endsection