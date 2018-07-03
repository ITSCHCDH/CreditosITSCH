@extends('template.molde')

@section('title','Evidencias')

@section('ruta')
    <a href="{{route('participantes.index')}}"> Participantes </a>
    /
    <label class="label label-success"> Altas</label>
@endsection

@section('contenido')
    {!! Form::open(['route'=>'evidencias.store','method'=>'POST','files'=>true]) !!}

    <div class="form-group">
        {!! Form::label('status','Estatus') !!}
        {!! Form::select('status',[''=>'Seleccione un estatus',0=>'Pendiente',1=>'Liberado'],null,['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('actividad_id','Actividad a la que pertenece la evidencia') !!}
        {!! Form::hidden('actividad_id',$actividad->id) !!}
        {!! Form::text('id_asig_activi',$actividad->nombre,['class' => 'form-control','required','readonly']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('responsables','Responsable de la actividad') !!}
        {!! Form::hidden('responsables',$responsable->id) !!}
        {!! Form::text('resp',$responsable->name,['class' => 'form-control', 'required','readonly']) !!}

    </div>

    <div class="form-group">
        {!! Form::label('valida','Nombre del quien valida la evidencia') !!}
        {!! Form::select('valida',$usuarios,null,['class'=>'form-control select-category','placeholder'=>'Selecciona un validador','required']) !!}
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
