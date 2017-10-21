@extends('template.molde')

@section('title','Alumnos|Altas')

@section('ruta')
    <a href="{{route('alumnos.index')}}"> Alumnos </a>
    /
    <label class="label label-success"> Altas</label>
@endsection

@section('contenido')

    {!! Form::open(['route'=>'alumnos.store','method'=>'POST']) !!}

        <div class="form-group">
            {!! Form::label('no_control','Numero de Control') !!}
            {!! Form::text('no_control',null,['class'=>'form-control','placeholder'=>'Numero de control','required']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('nombre','Nombre') !!}
            {!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Nombre Completo','required']) !!}
        </div>

        <div class="form-group">
           {!! Form::label('carrera','Carrera') !!}
            {!! Form::select('carrera',[''=>'Seleccione un elemento','Sistemas'=>'Ingeniería es Sistemas Computacionales','Industrial'=>'Ingeniería Industrial','Mecatrónica'=>'Ingeniería Mecatrónica','TICS'=>'Ingeniería en Tecnologias de Información y Comunicaciones','Bioquimmica'=>'Ingeniería Bioquimica','Nanotecnologia'=>'Ingeniería en Nanotecnologia'],null,['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('password','Contraseña') !!}
            {!! Form::password('password',['class'=>'form-control','placeholder'=>'***********','required']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('status','Status') !!}
            {!! Form::select('status',[''=>'Seleccione un elemento','Pendiente'=>'Pendiente','Liberado'=>'Liberado'],null,['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Registrar',['class'=>'btn btn-primary']) !!}
        </div>

    {!! Form::close() !!}

@endsection