@extends('template.molde')

@section('title','Evidencias')

@section('ruta')
    <a href="{{route('evidencias.index')}}"> Evidencias </a>
    /
    <label class="label label-success"> Altas</label>
@endsection

@section('contenido')
    {!! Form::open(['route'=>'evidencias.store','method'=>'POST','files'=>true]) !!}

    <div class="form-group">
        {!! Form::label('status','Estatus') !!}
        {!! Form::select('status',[''=>'Seleccione un elemento',0=>'Pendiente',1=>'Liberado'],null,['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('responsable','Responsable de la actividad') !!}
        {!! Form::text('responsable',null,['class'=>'form-control','placeholder'=>'Responsable de la actividad','required']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('valida','Nombre del quien valida la evidencia') !!}
        {!! Form::select('valida',$usuarios,null,['class'=>'form-control select-category','placeholder'=>'Selecciona un validador','required']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('id_nom_actividad','Actividad a la que pertenece la evidencia') !!}
        {!! Form::select('id_nom_actividad',$actividad,null,['class'=>'form-control select-category','placeholder'=>'Selecciona una actividad','required']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('image','Imagen') !!}
        {!! Form::file('image') !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Registrar',['class'=>'btn btn-primary']) !!}
    </div>


    {!! Form::close() !!}


@endsection