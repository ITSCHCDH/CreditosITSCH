@extends('template.molde')

@section('title','Permisos Asignados')

@section('ruta')
	@if ($user_id!=null)
		<a href="{{ route('usuarios.index') }}">Usuarios</a>
		/
		<a href="{{ route('usuarios.asignar_roles',$user_id)}}">Asignación de roles</a>
		/
		<label class="label label-success"> Permisos Asignados a {{ $role->name}}</label>
	@else
		<a href="{{ route('roles.index') }}">Roles</a>
		/
	    <label class="label label-success"> Permisos Asignados a {{ $role->name}}</label>
	@endif
	
@endsection

@section('contenido')
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