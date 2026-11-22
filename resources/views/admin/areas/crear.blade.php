@extends('template.molde')

@section('title','Crear')

@section('ruta')
	<a href="{{ route('areas.inicio') }}">Areas</a>
	/
	<label class="label label-success">Crear</label>
@endsection

@section('contenido')
	<form action="{{ route('areas.guardar') }}" method="post">
		{{ csrf_field() }}
		<div class="form-group">
			<label for="nombre">Nombre</label>
			<input type="text" name="nombre" id="nombre" placeholder="Nombre de el area" class="form-control" required>
		</div>
		<input type="hidden" name="tipo" value="otro">
		<input type="submit" name="" value="Guardar" class="btn btn-primary">
	</form>
@endsection