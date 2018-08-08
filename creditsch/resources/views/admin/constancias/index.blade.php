@extends('template.molde')

@section('title','Constancias')

@section('ruta')
    <label class="label label-success"> Constancias</label>
@endsection

@section('contenido')
	<a href="{{ route('constancias.editar') }}" class="btn btn-primary">Editar/Agregar campos de constancia</a>
	<hr>
	<a href="{{ route('constancias.visualizar') }}">Stream</a>
@endsection