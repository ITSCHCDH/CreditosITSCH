@extends('template.molde')

@section('title','Editar Roles')

@section('ruta')
    <label class="label label-success"> Editar Roles</label>
@endsection

@section('contenido')	
	<form action="{{ route('roles.role_actualizar',$role->id) }}" method="post">
		@csrf
		<div class="form-group">
			<label for="name">Nombre</label>
			<input type="text" name="name" id="name" class="form-control" required placeholder="Nombre del rol" value="{{ $role->name }}">			
		</div>
		<hr>
		<input type="submit" value="Guardar" class="btn btn-info">		
	</form>
@endsection
