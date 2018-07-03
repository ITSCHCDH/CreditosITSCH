@extends('template.molde')

@section('title','Actividades|Edit')

@section('ruta')
    <a href="{{route('actividades.index')}}"> Actividades </a>
    /
    <label class="label label-success"> Modificaciones</label>
@endsection

@section('contenido')

    {!! Form::model($actividad, array('route' => array('actividades.update', $actividad->id), 'method' => 'PUT')) !!}

    <div class="form-group">
        {!! Form::label('nombre','Nombre de la actividad') !!}
        {!! Form::text('nombre',$actividad->nombre,['class'=>'form-control','placeholder'=>'Nombre de la actividad','required']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('avance','Porcentaje de liberación') !!}
        {!! Form::text('por_cred_actividad',$actividad->por_cred_actividad,['class'=>'form-control','placeholder'=>'Porcentage del credito que se liberara con esta actividad, ej 20','required']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('id_actividad','Credito al que pertenece la actividad') !!}
        {!! Form::select('id_actividad',$creditos,null,['class'=>'form-control select-category','placeholder'=>'Selecciona un credito','required']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('alumnos','Alumnos Responsables')!!}
        {!! Form::select('alumnos',['false' => 'NO','true' => 'SI'],null,['class'=>'form-control', 'required','placeholder' => 'Actividad dedicada para alumnos responsables?, Si no estas seguro selecciona "NO"'])!!}
    </div>
    <div class="form-group">
        {!! Form::submit('Editar actividad',['class'=>'btn btn-primary']) !!}
    </div>


    {!! Form::close() !!}

@endsection