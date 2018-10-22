@extends('template.molde')

@section('title','Roles')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/checkboxcss/checkbox.css') }}">
@endsection
@section('ruta')
	<a href="{{ route('usuarios.index') }}">Usuarios</a>
	/
    <label class="label label-success"> Asignación de roles</label>
@endsection

@section('contenido')
	@if (Auth::User()->hasAnyPermission(['VIP','CREAR_ROLES','VER_ROLES']))
		<a href="{{ route('roles.index') }}" class="btn btn-primary" style="margin: 10px;">Administración de Roles</a>
	@endif
	<div style="width: 500px;">
		<table class="table table-striped table-bordered">
		   <thead>
		   	<th colspan="2">
		   		Información
		   	</th>
		   </thead>
		   <tbody>
		   	<tr>
		   		<td>Nombre</td>
		   		<td>
		   			@if ($user!=null)
		   				{{ $user->name }}
		   			@else
		   				{{ "?????????????????????"}}
		   			@endif
		   		</td>
		   	</tr>
		   	<tr>
		   		<td>Correo</td>
		   		<td>
		   			@if ($user!=null)
		   				{{ $user->email }}
		   			@else
		   				{{ "?????????????????????"}}
		   			@endif
		   		</td>
		   	</tr>
		   	<tr>
		   		<td>Area</td>
		   		<td>
		   			@if ($area!=null)
		   				{{ $area->nombre }}
		   			@else
		   				{{ "?????????????????????"}}
		   			@endif
		   		</td>
		   	</tr>
		   	<tr>
		   		<td>Activo</td>
		   		<td>
		   			@if ($user!=null)
		   				@if ($user->active=="true")
		   					{{ "SI"}}
		   				@else
		   					{{ "NO" }}
		   				@endif
		   			@else
		   				{{ "?????????????????????"}}
		   			@endif
		   		</td>
		   	</tr>
		   </tbody>
		</table>
	</div>
	@if ($user!=null)
		<form action="{{ route('usuarios.guardar_roles') }}" method="post" style="margin-bottom: 50px;">
			{{ csrf_field() }}
			<table class="table table-striped">
			   <thead>
			       <th>ID</th>
			       <th>Nombre</th>
			       <th>Ver permisos</th>
			       <th>Asignar</th>
			   </thead>
			   <tbody>
			   	@foreach ($roles as $rol)
			   		<tr>
			   			<td>{{ $rol->id }}</td>
			   			<td>{{ $rol->name }}</td>
			   			<td class="formulario">
			   				<a href="{{ route('roles.role_ver_permisos',['id'=>$rol->id,'user_id' => $user->id]) }}">
			   					<input type="hidden" name="user_id" value="{{ $user->id }}">
			   					<span>
			   						<img src="{{ asset('images/role_permissions.png') }}" style="width: 26px; height: 28px;">
			   					</span>
			   				</a>
			   				
			   			</td>
			   			<td>
			   				@if ($rol->user_name!=null)
			   					<label class="control control--checkbox">
			   						<input type="checkbox" name="roles_id[]" value="{{ $rol->id }}" checked>
			   						<div class="control__indicator"></div>
			   					</label>			   					
			   				@else
			   					<label class="control control--checkbox">
			   						<input type="checkbox" name="roles_id[]" value="{{ $rol->id }}">
			   						<div class="control__indicator"></div>
			   					</label>			   					
			   				@endif
			   				
			   			</td>
			   		</tr>
			   	@endforeach
			   	@if (count($roles)==0)
			   		<tr>
			   			<td colspan="4">
			   				No se encontraron roles
			   			</td>
			   		</tr>
			   	@endif
			   </tbody>
			</table>
			<input type="submit" name="" value="Asignar" class="btn btn-primary">
		</form>
	@endif
@endsection