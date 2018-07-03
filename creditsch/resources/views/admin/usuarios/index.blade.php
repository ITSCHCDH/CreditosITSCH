@extends('template.molde')

@section('ruta')
	<label class="label label-success">Usuarios</label>
@endsection
@section('contenido')
	<a href="{{ route('usuarios.create')}}" class="btn btn-info">Nuevo Usuario</a>
	<table class="table table-striped" id="tabla-usuarios">
	    <!-- instancia al archivo table, dentro de este mismo direcctorio -->
	   <thead>
	       <th>ID</th>
	       <th>Nombre</th>
	       <th>Area</th>
	       <th>Correo</th>
	       <th>Activo</th>
	       <th>Action</th>
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
	   			<td>Hola</td>
	   		</tr>
	   	@endforeach
	   </tbody>
	</table>
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