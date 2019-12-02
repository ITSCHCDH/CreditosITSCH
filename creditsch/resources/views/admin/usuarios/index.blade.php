@extends('template.molde')
@section('title','Usuarios')
@section('ruta')
	<label class="label label-success">Usuarios</label>
@endsection
@section('contenido')
	@if (Auth::User()->hasAnyPermission(['VIP','CREAR_USUARIOS']))
		<div style="text-align: right;"> 
			<div class="toltip">
				<a  href="{{ route('usuarios.create')}}" class="btn btn-info btn-sm" >
					<span class="glyphicon glyphicon-plus"></span>
	          		<span class="glyphicon glyphicon-user"></span>          	
	        	</a> 
        	 	<span class="toltiptext">Agregar nuevo usuario</span>     
        	</div>  	
        	<!--<a href="{{ route('usuarios.create')}}" class="btn btn-primary">Nuevo Usuario</a>-->        	
		</div>			
	@endif
	<br>
	<table class="table" id="tabla-usuarios">
		<thead class="thead-dark">
			<th>ID</th>
			<th>Nombre</th>
			<th>Area</th>
			<th>Correo</th>
			<th>Activo</th>
			@if (Auth::User()->hasAnyPermission(['VIP','ASIGNAR_REMOVER_ROLES_USUARIOS','MODIFICAR_USUARIOS','ELIMINAR_USUARIOS']))
			<th>Acción</th>
			@endif
		</thead>
		<tbody>
		@foreach ($users as $user)
			<tr>
				<td>{{ $user->id }}</td>
				<td>{{ $user->name }}</td>
				<td style="overflow:hidden;">{{ $user->area }}</td>
				<td>{{ $user->email }}</td>
				@if ($user->active=='true')
					<td>SI</td>
				@else
					<td>NO</td>
				@endif
				<td>
					@if (Auth::User()->hasAnyPermission(['VIP','MODIFICAR_USUARIOS']))
						<div class="toltip">
							<a href="{{ route('usuarios.edit',$user->id) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>
							<span class="toltiptext">Modificar usuario</span>     
						</div>  
					@endif
					@if (Auth::User()->hasAnyPermission(['VIP','ELIMINAR_USUARIOS']))
						<div class="toltip">
							<a href="{{ route('admin.usuarios.destroy',$user->id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
							<span class="toltiptext">Elimar usuario</span>     
						</div>  
					@endif
					@if (Auth::User()->hasAnyPermission(['VIP','ASIGNAR_REMOVER_ROLES_USUARIOS']))
						<div class="toltip">
							<a href="{{ route('usuarios.asignar_roles',$user->id) }}" class="btn btn-info btn-sm" >
								<i class='fas fa-users-cog' ></i>	   							
							</a>
							<span class="toltiptext">Asignar rol</span>     
						</div>  
					@endif
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