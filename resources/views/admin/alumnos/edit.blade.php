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
            {{--  {!! Form::model($alumno, array('route' => array('alumnos.update', $alumno->id), 'method' => 'PUT')) !!} --}}

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
                        <option value="{{ $ar->id }}">{{ $ar->nombre }}</option>
                    @endforeach
                </select>     
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password">Contraseña</label>               
                <div >
                    <input id="password" type="password" class="form-control" name="password" value="{{ $alumno->password }}"> 
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif 
                </div>         
            </div>

            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label for="password2">Verificar Contraseña</label>                
                <div>
                    <input id="passwordV" type="password" class="form-control" name="passwordV" value="{{ $alumno->password }}">   
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif                    
                </div>    
            </div>      

            <div class="form-group">
                <input type="submit" value="Editar" class="btn btn-primary">               
            </div>

        </form>
    @endif

@endsection