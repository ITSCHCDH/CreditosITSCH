@extends('template.molde')

@section('title','Alumnos|Edit')

@section('ruta')
    <a href="{{route('alumnos.index')}}"> Alumnos </a>
    /
    <label class="label label-success"> Modificaciones</label>
@endsection

@section('contenido')

    @if ($alumno!=null)
        {!! Form::model($alumno, array('route' => array('alumnos.update', $alumno->id), 'method' => 'PUT')) !!}

        <div class="form-group">
            {!! Form::label('no_control','Numero de Control') !!}
            {!! Form::text('no_control',$alumno->no_control,['class'=>'form-control','placeholder'=>'Numero de control','required','readonly']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('nombre','Nombre') !!}
            {!! Form::text('nombre',$alumno->nombre,['class'=>'form-control','placeholder'=>'Nombre Completo','required']) !!}
        </div>

        <div class="form-group">            
            {!! Form::label('carrera','Carrera') !!}           
            {!! Form::select('carrera', $areas,null, ['class' => 'form-control m-bot15']) !!}

        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            {!! Form::label('password','Contraseña') !!}
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
            {!! Form::label('password2','Verificar Contraseña') !!}
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
            {!! Form::submit('Editar',['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
    @endif

@endsection