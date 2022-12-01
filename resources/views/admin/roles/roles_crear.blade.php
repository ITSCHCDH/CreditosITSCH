@extends('template.molde')

@section('title','Roles|Crear')

@section('ruta')
	<a href="{{ route('roles.index') }}">Roles</a>
	/
    <label class="label label-success"> Crear Roles</label>
@endsection

@section('contenido')
	<form action="{{ route('roles.roles_guardar') }}" method="post">	
		@csrf
		<div class="form-outline">
			<input type="text" id="name" name="name" class="form-control form-control-lg" required />
			<label class="form-label" for="password">Nombre</label>
		</div>
		<br>
		<button type="submit" class="btn btn-primary">Agregar</button>		
	</form>
@endsection