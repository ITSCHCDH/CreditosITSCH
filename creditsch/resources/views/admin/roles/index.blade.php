@extends('template.molde')

@section('title','Roles')

@section('ruta')
    <label class="label label-success">Roles</label>
@endsection

@section('contenido')
	<a href="{{ route('roles.roles_crear')}}" class="btn btn-primary">Crear Rol</a>
	<a href="{{ route('roles.permisos_crear')}}" class="btn btn-primary">Crear Permiso</a>
	<table class="table table-striped" id="tabla_roles">
	   <thead>
	       <th>ID</th>
	       <th>Nombre</th>
	       <th>Ver permisos</th>
	       <th>Asignar/Revocar Permisos</th>
	       <th>Acción</th>
	   </thead>
	   <tbody>
	   	@foreach ($roles as $rol)
	   		<tr>
	   			<td>{{ $rol->id }}</td>
	   			<td>{{ $rol->name }}</td>
	   			<td>
	   				<a href="{{ route('roles.role_ver_permisos',$rol->id) }}">Ver</a>
	   			</td>
	   			<td>
	   				<a href="{{ route('roles.roles_asignar_permisos_vista',$rol->id) }}">Asignar/Revocar</a>
	   			</td>
	   			<td>
	   				<a href="{{ route('roles.usuarios',$rol->id) }}" class="btn btn-primary"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>
	   				<a href="{{ route('roles.role_editar',[$rol->id]) }}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>
	   				<a href="{{ route('roles.role_eliminar',$rol->id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>

	   			</td>
	   		</tr>
	   	@endforeach
	   </tbody>
	</table>
	<div style="margin-bottom: 50px;"></div>
	@section('js')
		<script type="text/javascript">

			$(document).ready(function(){
				$('#tabla_roles').DataTable({
					"pagingType":"full_numbers"
				});
			});
		</script>
	@endsection
@endsection