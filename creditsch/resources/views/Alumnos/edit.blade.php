@extends('template.molde')

@section('ruta')
    <label for="">Alumnos / Modificaciones</label>
@endsection

@section('contenido')

    {!! Form::model($alumno, array('route' => array('alumnos.update', $alumno->id), 'method' => 'PUT')) !!}

    <div class="form-group">
        {!! Form::label('no_control','Numero de Control') !!}
        {!! Form::text('no_control',$alumno->no_control,['class'=>'form-control','placeholder'=>'Numero de control','required']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('nombre','Nombre') !!}
        {!! Form::text('nombre',$alumno->Nombre,['class'=>'form-control','placeholder'=>'Nombre Completo','required']) !!}
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
        {!! Form::submit('Editar',['class'=>'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

@endsection