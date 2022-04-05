@extends('template.molde')

@section('title','Actividades|Edit')

@section('ruta')
    <a href="{{route('actividades.index')}}"> Actividades </a>
    /
    <label class="label label-success"> Modificaciones</label>
@endsection

@section('contenido')

    <form action="{{ route('actividades.update', $actividad->id) }}" method="get">
    
        <div class="form-group">
            <label for="nombre">Nombre de la actividad</label>
            <input type="text" name="nombre" id="nombre" value="{{ $actividad->nombre }}" class="form-control" placeholder="Nombre de la actividad" required>            
        </div>

        <div class="form-group">
            <label for="avance">Porcentaje de liberación</label>
            <input type="text" name="por_cred_actividad" id="nombre" value="{{ $actividad->por_cred_actividad }}" class="form-control" placeholder="Porcentage del credito que se liberara con esta actividad, ej 20" required>             
        </div>

        <div class="form-group">
            <label for="id_actividad">Credito al que pertenece la actividad</label>
            <select name="id_actividad" id="id_actividad" class="form-control select-category" required>
                <option value="">Selecciona un tipo de credito</option>
                @foreach($creditos as $cred)
                    <option value="{{ $cred->id }}">{{ $cred->nombre }}</option>
                @endforeach              
            </select>            
        </div>
        @if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD','CREAR_ACTIVIDAD_ALUMNOS']))
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
            <div class="form-group">            
                <label for="vigente">Vigente</label>            
                <select class="form-control form-control-sm" id="vigente" required name="vigente">	
                    <option value="">¿Actividad dedicada para alumnos responsables?, Si no estas seguro selecciona NO</option>
                    <option value="false">NO</option>
                    <option value="true">SI</option>               
                </select>
            </div>           
        </div>
        <div class="form-group">
            <input type="submit" value="Guardar" class="btn btn-primary">            
        </div>


    </form>

@endsection