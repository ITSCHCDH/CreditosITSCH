@extends('template.molde')

@section('title','Alumnos|Edit')

@section('ruta')
    <a href="{{route('alumnos.index')}}"> Alumnos </a>
    /
    <label class="label label-success"> Modificaciones</label>
@endsection

@section('contenido')

    @if ($alumno!=null)
        <form action="{{ route('alumnos.update',$alumno->id) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="no_control">Numero de Control</label>
                        <input type="text" name="no_control" id="no_control" value="{{ $alumno->no_control }}" class="form-control" placeholder="Numero de control" required readonly>                                
                    </div>
        
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" value="{{ $alumno->nombre }}" class="form-control" placeholder="Nombre Completo" required>                   
                    </div>
        
                    <div class="form-group">  
                        <label for="carrera">Carrera</label>  
                        <select name="carrera" id="carrera" class="form-control" required>
                            <option value="" selected>Selecciona una carrera</option>
                            @foreach ($areas as $ar )
                                <option value="{{ $ar->id }}" {{$alumno->carrera == $ar->id ? 'selected' : '' }}>{{ $ar->nombre }}</option>
                            @endforeach                   
                        </select>     
                    </div>
        
                    <div class="form-group">
                        <label for="password">Contraseña</label>               
                        <div >
                            <input id="password" type="password" class="form-control" name="password" value="{{ $alumno->password }}">                   
                        </div>         
                    </div>
        
                    <div class="form-group">
                        <label for="password2">Verificar Contraseña</label>                
                        <div>
                            <input id="passwordV" type="password" class="form-control" name="passwordV" value="{{ $alumno->password }}">                                
                        </div>    
                    </div>      
                    <hr>
                    <div class="form-group">
                        <input type="submit" value="Editar" class="btn btn-primary">               
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </form>
    @endif

@endsection