@extends('template.molde')

@section('title','Usuarios Editar')
@section('ruta')
	<a href="{{ route('usuarios.index') }}">Usuarios</a>
	/
	<label class="label label-success">Modificación</label>
@endsection
@section('contenido')

	<form method="POST" action="{{ route('usuarios.update',$user->id) }}">		
	    {{ csrf_field() }}

		<div class="form-outline">
			<input type="text" id="nombre" name="name" class="form-control form-control-lg" value="{{ $user->name }}" autofocus required />
			<label class="form-label" for="nombre">Nombre</label>
		</div>	
		<br>

		<div class="form-outline">
			<input type="email" id="email" name="email" class="form-control form-control-lg" value="{{ $user->email }}" required />
			<label class="form-label" for="email">Dirección E-Mail</label>
		</div>	   

		<div class="form-group">
	        <label for="area" class="control-label">Area</label>
	        <div>
	            <select id="area" type="text" class="form-control" name="area">
	            	@if($areas->count()==1)
	            		<option value="{{ $areas[0]->id }}" selected>{{ $areas[0]->nombre }}</option>
	            	@else
		            	@foreach($areas as $area)
		            		@if($user->area==$area->id)
		            			<option value="{{ $area->id }}" selected style="background-color: blue; color: white;">{{ $area->nombre }}</option>
		            		@else
		            			<option value="{{ $area->id }}">{{ $area->nombre }}</option>
		            		@endif
		            	@endforeach
		            @endif
	            </select>	          
	        </div>
	    </div>

		<div class="form-group">
	        <label for="active" class=" control-label">Activo</label>
	        <div>
	        	<select id="active" type="select" class="form-control" name="active">
	        		<option value="true" @if ($user->active=="true")
	        			{{ "selected" }}
	        			style="{{ 'background-color: blue; color: white;' }}"
	        		@endif>SI</option>
	        		<option value="false" @if ($user->active=="false")
	        			{{ "selected" }}
	        			style="{{ 'background-color: blue; color: white;' }}"
	        		@endif>NO</option>
	        	</select>	        	
	        </div>
	    </div>		

		<div class="form-outline">
			<input type="password" id="password" name="password" class="form-control form-control-lg" value="{{ $user->password }}" required />
			<label class="form-label" for="password">Password</label>
		</div>	
		<br>	
		
		<div class="form-outline">
			<input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-lg" value="{{ $user->password }}" required />
			<label class="form-label" for="password_confirmation">Confirmar Password</label>
		</div>
		<br>   

	    <div class="form-group">
	        <div class="col-md-offset-4">
	            <button type="submit" class="btn btn-primary">
	                Guardar
	            </button>
	        </div>
	    </div>
	</form>
@endsection