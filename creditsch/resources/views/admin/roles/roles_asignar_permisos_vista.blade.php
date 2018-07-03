@extends('template.molde')

@section('title','Roles|Permisos|Asignar')

@section('ruta')
	<a href="{{route('roles.index')}}"> Alumnos </a>
	/
    <label class="label label-success"> Roles</label>
@endsection

@section('contenido')
	@extends('template.molde')

	@section('title','Alumnos|Edit')

	@section('ruta')
		<a href="{{route('roles.index')}}"> roles </a>
		/
	    <label class="label label-success"> Roles Dashboard</label>
	@endsection

	@section('contenido')
		<a href="{{ route('roles.permisos_crear')}}" class="btn btn-info">Crear Permiso</a>
		<br>
		<label>Rol: {{ $role->name }}</label>
		{!! Form::open(['route' => 'roles.roles_asignar_permisos', 'method' => 'POST'])!!}
			<input type="hidden" name="role_id" value="{{ $role->id }}">
			<table class="table table-striped" id="tabla_evidencia">
			    <!-- instancia al archivo table, dentro de este mismo direcctorio -->
			   <thead>
			       <th>ID</th>
			       <th>Nombre</th>
			       <th>Asignar</th>
			   </thead>
			   <tbody>
			   	@foreach ($permisos as $per)
			   		<tr>
			   			<td>{{ $per->id }}</td>
			   			<td>{{ $per->name }}</td>
			   			<td><input type="checkbox" name="permisos_id[]" value="{{ $per->id}}"></td>
			   		</tr>
			   	@endforeach
			   </tbody>
			</table>
			{!! Form::submit('Aceptar',['class'=>'btn btn-primary']) !!}
		{!! Form::close() !!}
		<div style="margin-bottom: 50px;"></div>
	@endsection
@endsection