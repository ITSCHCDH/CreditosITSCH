@extends('template.molde')

@section('title','Permisos Asignados')

@section('ruta')
	@if ($user_id!=null)
		<a href="{{ route('usuarios.index') }}">Usuarios</a>
		/
		<a href="{{ route('usuarios.asignar_roles',$user_id)}}">Asignación de roles</a>
		/
		<label class="label label-success"> Permisos Asignados al role: {{ $role->name}}</label>
	@else
		<a href="{{ route('roles.index') }}">Roles</a>
		/
	    <label class="label label-success"> Permisos Asignados al role: {{ $role->name}}</label>
	@endif
	
@endsection

@section('contenido')
	<a href="{{ route('roles.index') }}" title="Regresar" class="btn btn-info"><i class="far fa-arrow-alt-circle-left"></i></a>
	<a href="{{ route('roles.roles_asignar_permisos_vista',$role->id) }}" class="btn btn-success" title="Agregar permisos"><i class="fas fa-key"></i></a>
	
	<table class="table table-striped">
	    <!-- instancia al archivo table, dentro de este mismo direcctorio -->
	   <thead>
	       <th>ID</th>
	       <th>Nombre</th>
	   </thead>
	   <tbody>
	   	@foreach ($permisos as $per)
	   		<tr>
	   			<td>{{ $per->id }}</td>
	   			<td>{{ $per->name }}</td>
	   		</tr>
	   	@endforeach
	   </tbody>
	</table>
@endsection