@extends('template.molde')

@section('title','Alumnos|Edit')

@section('ruta')
	<a href="{{route('roles.index')}}"> roles </a>
	/
    <label class="label label-success"> Roles Dashboard</label>
@endsection

@section('contenido')
	<a href="{{ route('roles.roles_crear')}}" class="btn btn-info">Crear Rol</a>
	<table class="table table-striped" id="tabla_evidencia">
	    <!-- instancia al archivo table, dentro de este mismo direcctorio -->
	   <thead>
	       <th>ID</th>
	       <th>Nombre</th>
	       <th>Guard</th>
	       <th>Asignar Permisos</th>
	   </thead>
	   <tbody>
	   	@foreach ($roles as $rol)
	   		<tr class="oculta_validados">
	   			<td>{{ $rol->id }}</td>
	   			<td>{{ $rol->name }}</td>
	   			<td>{{ $rol->guard_name }}</td>
	   			<td><a href="{{route('roles.roles_asignar_permisos_vista',$rol->id)}}">Asignar</a></td>
	   		</tr>
	   	@endforeach
	   </tbody>
	</table>
@endsection