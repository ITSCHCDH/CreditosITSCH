@extends('template.molde')

@section('title','Mensajes Ver')
@section('links')
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/chosen/chosen.css') }}">
@endsection
@section('ruta')
	@if ($ruta)
		<a href="{{ route('mensajes.index') }}">Mensajes</a>
		/
		<a href="{{  route('mensajes.enviados') }}">Mensajes Enviados</a>
		/
		<label class="label label-success">Ver Mensaje</label>
	@else
		<a href="{{ route('mensajes.index') }}">Mensajes</a>
		/
		<label class="label label-success">Ver Mensaje</label>
	@endif
	
@endsection
@section('contenido')
	<div>
		{{ $mensaje->mensaje }}
	</div>
@endsection