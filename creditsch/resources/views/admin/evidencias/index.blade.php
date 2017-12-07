@extends('template.molde')

@section('title','Evidencias')

@section('ruta')
    <label class="label label-success"> Evidencias</label>
@endsection

@section('contenido')

    <a href="{{route('evidencias.create')}}" class="btn btn-info">Agregar evidencias</a>

@endsection