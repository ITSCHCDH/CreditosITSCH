@extends('template.molde')
@section('title','Usuarios')
@section('ruta')
	<label class="label label-success">Usuarios</label>
@endsection
@section('contenido')
	<a href="{{ route('usuarios.create')}}" class="btn btn-primary">Nuevo Usuario</a>
	<table class="table table-striped" id="tabla-usuarios">
	   <thead>
	       <th>ID</th>
	       <th>Nombre</th>
	       <th>Area</th>
	       <th>Correo</th>
	       <th>Activo</th>
	       <th>Acción</th>
	   </thead>
	   <tbody>
	   	@foreach ($users as $user)
	   		<tr>
	   			<td>{{ $user->id }}</td>
	   			<td>{{ $user->name }}</td>
	   			<td>{{ $user->area }}</td>
	   			<td>{{ $user->email }}</td>
	   			@if ($user->active=='true')
	   				<td>SI</td>
	   			@else
	   				<td>NO</td>
	   			@endif
	   			<td>
	   				<a href="{{ route('usuarios.edit',$user->id) }}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>
	   				<a href="{{ route('admin.usuarios.destroy',$user->id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
	   				<a href="{{ route('usuarios.asignar_roles',$user->id) }}" class="btn btn-info" style="width: 40px; height: 34px;">
	   					<img src="{{ asset('images/permissions_icon.png') }}" style="width: 20px; height: 22px;">
	   				</a>
	   			</td>
	   		</tr>
	   	@endforeach
	   </tbody>
	</table>
	<div style="margin-bottom: 50px;"></div>
	@section('js')
		<script type="text/javascript">
			$(document).ready(function() {
			    $('#tabla-usuarios').DataTable( {
			        "pagingType": "full_numbers"
			    } );
			});
		</script>
	@endsection
@endsection