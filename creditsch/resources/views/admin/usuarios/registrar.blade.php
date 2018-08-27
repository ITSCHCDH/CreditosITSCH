@extends('template.molde')

@section('title','Usuarios Crear')

@section('ruta')
	<a href="{{ route('usuarios.index') }}">Usuarios</a>
	/
	<label class="label label-success">Creación</label>
@endsection
@section('contenido')

	<form class="form-horizontal" method="POST" action="{{ route('usuarios.store') }}">
	    {{ csrf_field() }}

	    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	        <label for="name" class="col-md-4 control-label">Nombre</label>

	        <div class="col-md-6">
	            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"  autofocus>

	            @if ($errors->has('name'))
	                <span class="help-block">
	                    <strong>{{ $errors->first('name') }}</strong>
	                </span>
	            @endif
	        </div>
	    </div>

	    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
	        <label for="email" class="col-md-4 control-label">Dirección E-Mail</label>

	        <div class="col-md-6">
	            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" >

	            @if ($errors->has('email'))
	                <span class="help-block">
	                    <strong>{{ $errors->first('email') }}</strong>
	                </span>
	            @endif
	        </div>
	    </div>

	    <div class="form-group{{ $errors->has('area') ? ' has-error' : '' }}">
	        <label for="area" class="col-md-4 control-label">Area</label>

	        <div class="col-md-6">
	            <select id="area" type="text" class="form-control" name="area" value="{{ old('area') }}" >
	            	@if($areas->count()==1)
	            		<option value="{{ $areas[0]->id }}" selected>{{ $areas[0]->nombre }}</option>
	            	@else
	            		<option value="" disabled selected>Seleccione un Area</option>
	            		@foreach($areas as $area)
	            			<option value = "{{ $area->id }}">{{ $area->nombre }}</option>
	            		@endforeach
	            	@endif
	            	
	            </select>

	            @if ($errors->has('area'))
	                <span class="help-block">
	                    <strong>{{ $errors->first('area') }}</strong>
	                </span>
	            @endif
	        </div>
	    </div>

	    <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
	        <label for="active" class="col-md-4 control-label">Activo</label>

	        <div class="col-md-6">
	        	<select id="active" type="select" class="form-control" name="active" >
	        		<option value="" disabled selected>El usuario actualmente se encuentra es estado activo?</option>
	        		<option value="true">SI</option>
	        		<option value="false">NO</option>
	        	</select>
	        	@if ($errors->has('active'))
	        	    <span class="help-block">
	        	        <strong>{{ $errors->first('active') }}</strong>
	        	    </span>
	        	@endif
	        </div>
	    </div>

	    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
	        <label for="password" class="col-md-4 control-label">Password</label>

	        <div class="col-md-6">
	            <input id="password" type="password" class="form-control" name="password" >

	            @if ($errors->has('password'))
	                <span class="help-block">
	                    <strong>{{ $errors->first('password') }}</strong>
	                </span>
	            @endif
	        </div>
	    </div>

	    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
	        <label for="password_confirmation" class="col-md-4 control-label">Confirmar Password</label>

	        <div class="col-md-6">
	            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" >
	            @if ($errors->has('password_confirmation'))
	                <span class="help-block">
	                    <strong>{{ $errors->first('password_confirmation') }}</strong>
	                </span>
	            @endif
	        </div>
	    </div>
	    <div class="form-group">
	        <div class="col-md-6 col-md-offset-4">
	            <button type="submit" class="btn btn-primary">
	                Registrar
	            </button>
	        </div>
	    </div>
	</form>
	<div style = "margin-bottom: 50px;"></div>
@endsection