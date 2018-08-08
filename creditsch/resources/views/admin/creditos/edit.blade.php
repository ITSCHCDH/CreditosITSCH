@extends('template.molde')

@section('title','Creditos|Edit')

@section('ruta')
    <a href="{{route('creditos.index')}}"> Creditos </a>
    /
    <label class="label label-success"> Altas</label>
@endsection

@section('contenido')

    {!! Form::model($credito, array('route' => array('creditos.update', $credito->id), 'method' => 'PUT')) !!}

    <div class="form-group">
        {!! Form::label('nombre','Nombre del credito') !!}
        {!! Form::text('nombre',$credito->nombre,['class'=>'form-control','placeholder'=>'Nombre del credito','required']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Registrar',['class'=>'btn btn-primary']) !!}
    </div>


    {!! Form::close() !!}

@endsection