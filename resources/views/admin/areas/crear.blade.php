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
		<div class="form-group">
			<label for="tipo">Tipo</label>
			<select class="form-control" required name="tipo">
				<option value="">Tipo de area</option>
				<option value="carrera">Carrera</option>
				<option value="otro">Otro</option>
			</select>
		</div>
		<input type="submit" name="" value="Guardar" class="btn btn-primary">
	</form>
@endsection