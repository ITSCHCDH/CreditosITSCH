@extends('template.molde')

@section('title','Editar')

@section('ruta')
	<a href="{{ route('areas.inicio') }}">Areas</a>
	/
	<label class="label label-success">Editar area {{ $area->nombre }}</label>
@endsection

@section('contenido')
	<form action="{{ route('areas.actualizar',$area->id) }}" method="post">
		{{ csrf_field() }}
		<div class="form-group">
			<label for = "nombre">Nombre</label>
			<input type="text" name="nombre" id="nombre" class="form-control" value="{{ $area->nombre }}" required>
		</div>
		<input type="submit" name="" value="Guardar" class="btn btn-primary">
	</form>
@endsection