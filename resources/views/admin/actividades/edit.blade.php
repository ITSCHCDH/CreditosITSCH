@extends('template.molde')

@section('title','Actividades|Edit')

@section('ruta')
    <a href="{{route('actividades.index')}}"> Actividades </a>
    /
    <label class="label label-success"> Modificaciones</label>
@endsection

@section('contenido')

    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <form action="{{ route('actividades.update', $actividad->id) }}" method="post">
                @csrf
                <div class="form-outline mb-4">
                    <input value="{{ $actividad->nombre }}" type="text" id="nombre" class="form-control form-control-lg"  name="nombre" required/>
                    <label class="form-label" for="nombre" id="actividad">Nombre de la actividad</label>
                </div>
                
                <div class="form-outline mb-4">
                    <input value="{{ $actividad->por_cred_actividad }}" type="number" min="0" max="100" id="por_cred_actividad" class="form-control form-control-lg"  name="por_cred_actividad" required/>
                    <label class="form-label" for="por_cred_actividad" id="lPorcentage">Porcentaje de liberación Ej. 20</label>
                </div>

                <div class="mb-4">    
                    <Label class="form-label" >Credito al que pertenece la actividad</Label>                                            
                    <select id="select-category" name="id_actividad" class="form-control form-control-lg" required>                                                    
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

                @if (Auth::User()->hasAnyPermission(['VIP','CREAR_ACTIVIDAD_ALUMNOS','VIP_ACTIVIDAD']))
                    <div class="mb-4">    
                        <Label class="form-label" >Alumnos Responsables</Label>                                            
                        <select id="alumnos" name="alumnos" class="form-control form-control-lg" required>                                                    
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
              
                <div class="mb-4">    
                    <Label class="form-label" >Vigente</Label>                                            
                    <select id="alumnos" name="alumnos" class="form-control form-control-lg" required>                                                    
                        @if ($actividad->vigente=="true")
                            <option value="false">NO</option>
                            <option value="true" selected>SI</option>   
                        @else
                            <option value="false" selected>NO</option>
                            <option value="true" >SI</option>   
                        @endif      
                    </select>                                                
                </div>    
             
                <div class="form-outline mb-4">                   
                    <input value="{{ $actividad->fecCierre }}" type="date" class="form-control form-control-lg" name="fecCierre" id="fecCierre" required>
                    <label class="form-label">Fecha de cierre</label>
                </div>
            
                <hr>

               
                <div class="form-group">
                    <input type="submit" value="Guardar" class="btn btn-primary">            
                </div>
        
        
            </form>
        </div>
        <div class="col-sm-3"></div>
    </div>    

@endsection