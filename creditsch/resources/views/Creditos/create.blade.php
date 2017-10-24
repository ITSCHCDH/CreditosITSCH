@extends('template.molde')

@section('title','Creditos|Altas')

@section('ruta')
    <a href="{{route('creditos.index')}}"> Creditos </a>
    /
    <label class="label label-success"> Altas</label>
@endsection

@section('contenido')

    {!! Form::open(['route'=>'creditos.store','method'=>'POST']) !!}

    <div class="form-group">
        {!! Form::label('nombre','Nombre del credito') !!}
        {!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Nombre del credito','required']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Registrar',['class'=>'btn btn-primary']) !!}
    </div>


    {!! Form::close() !!}

@endsection