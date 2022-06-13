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
                    @if($cred->id==$actividad->id_actividad)
                        <option value="{{ $cred->id }}" selected>{{ $cred->nombre }}</option>
                    @else
                        <option value="{{ $cred->id }}">{{ $cred->nombre }}</option>
                    @endif                    
                @endforeach              
            </select>            
        </div>
        @if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD','CREAR_ACTIVIDAD_ALUMNOS']))
            <div class="form-group">            
                <label for="alumnos">Alumnos Responsables</label>            
                <select class="form-control form-control-sm" id="alumnos" required name="alumnos">	
                    <option value="">¿Actividad dedicada para alumnos responsables?, Si no estas seguro selecciona NO</option>
                    @if($actividad->alumnos=="true")
                        <option value="true" selected>SI</option>  
                        <option value="false">NO</option>                      
                    @else
                        <option value="true">SI</option>  
                        <option value="false" selected>NO</option>
                    @endif           
                </select>
            </div>
        @endif
        <div class="form-group">
            <div class="form-group">            
                <label for="vigente">Vigente</label>            
                <select class="form-control form-control-sm" id="vigente" required name="vigente">	
                    <option value="">LA actividad aún esta vigente?</option>
                    @if ($actividad->vigente=="true")
                        <option value="false">NO</option>
                        <option value="true" selected>SI</option>   
                    @else
                        <option value="false" selected>NO</option>
                        <option value="true" >SI</option>   
                    @endif                               
                </select>
            </div>           
        </div>
        <div class="form-group">
            <input type="submit" value="Guardar" class="btn btn-primary">            
        </div>


    </form>

@endsection