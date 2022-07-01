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
		<div class="form-group">
			<label for="name">Nombre</label>
			<input type="text" name="name" id="name" placeholder="Nombre del rol" required class="form-control">		
		</div>
		<button type="submit" class="btn btn-primary">Agregar</button>		
	</form>
@endsection