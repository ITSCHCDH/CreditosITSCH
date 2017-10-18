@extends('template.molde')

@section('contenido')

    <div class="form-group">
        {!! Form::label('name','Nombre') !!}
        {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Nombre Completo','required']) !!}
    </div>



@endsection