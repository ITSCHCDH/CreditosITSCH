@extends('template.molde')

@section('title','Usuarios Crear')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/chosen/chosen.css') }}">
@endsection
@section('ruta')
	<a href="{{ route('usuarios.index') }}">Usuarios</a>
	/
	<label class="label label-success">Creación</label>
@endsection
@section('contenido')
	<form method="POST" action="{{ route('usuarios.store') }}">
	    {{ csrf_field() }}

		<div class="form-outline">
			<input type="text" id="nombre" name="name" class="form-control form-control-lg" autofocus required />
			<label class="form-label" for="nombre">Nombre</label>
		</div>	
		<br>
		<div class="form-outline">
			<input type="email" id="email" name="email" class="form-control form-control-lg" required />
			<label class="form-label" for="email">Dirección E-Mail</label>
		</div>	   

	    <div class="form-group">
	        <label for="area" class="control-label">Area</label>

	        <div>
	            <select id="area" type="text" class="form-control" name="area" >
	            	@if($areas->count()==1)
	            		<option value="{{ $areas[0]->id }}" selected>{{ $areas[0]->nombre }}</option>
	            	@else
	            		<option value="" disabled selected>Seleccione un Area</option>
	            		@foreach($areas as $area)
	            			<option value = "{{ $area->id }}">{{ $area->nombre }}</option>
	            		@endforeach
	            	@endif
	            	
	            </select>	         
	        </div>
	    </div>

	    <div class="form-group">
	        <label for="active" class="control-label">Activo</label>

	        <div>
	        	<select id="active" type="select" class="form-control" name="active" >
	        		<option value="" disabled selected>El usuario actualmente se encuentra en estado activo?</option>
	        		<option value="true">SI</option>
	        		<option value="false">NO</option>
	        	</select>	        
	        </div>
		</div>

		<div class="form-group">
	        <label for="active" class="control-label">Podra ser tutor?</label>

	        <div>
	        	<select id="tutor" type="select" class="form-control" name="tutor" required>
	        		<option value="" disabled selected>Este usuario podra ser nombrado como tutor?</option>
	        		<option value="1">SI</option>
	        		<option value="0">NO</option>
	        	</select>	        
	        </div>
		</div>

		@if (Auth::User()->hasAnyPermission(['VIP','ASIGNAR_REMOVER_ROLES_USUARIOS']))
			<div class="form-group">
				<label for="area" class="control-label">Roles</label>
				<div>
					<select id="roles_id" type="text" class="form-control" multiple data-placeholder="Seleccionar roles (opcional)" name="roles_id[]" >
						@foreach ($roles as $rol)
							<option value="{{ $rol->id }}">{{ $rol->name }}</option>	
						@endforeach
					</select>
				</div>
			</div>
		@endif

		<br>

		<div class="form-outline">
			<input type="password" id="password" name="password" class="form-control form-control-lg" required />
			<label class="form-label" for="password">Password</label>
		</div>	
		<br>	
		
		<div class="form-outline">
			<input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-lg" required />
			<label class="form-label" for="password_confirmation">Confirmar Password</label>
		</div>
		<br> 
		
	    <div class="form-group">
	        <div class="col-md-offset-4">
	            <button type="submit" class="btn btn-primary">
	                Registrar
	            </button>
	        </div>
	    </div>
	</form>
	<div style = "margin-bottom: 200px;"></div>
	
@endsection