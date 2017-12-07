@extends('template.molde')

@section('title','Participantes')

@section('ruta')
    <label class="label label-success"> Participantes</label>
@endsection

@section('contenido')

    <a href="{{route('participantes.create')}}" class="btn btn-info">Agregar participantes</a>

@endsection