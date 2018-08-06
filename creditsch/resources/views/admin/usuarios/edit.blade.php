@extends('template.molde')

@section('title','Usuarios Editar')
@section('ruta')
	<a href="{{ route('usuarios.index') }}">Usuarios Dashboard</a>
	/
	<label class="label label-success">Modificación</label>
@endsection
@section('contenido')

	<form class="form-horizontal" method="POST" action="{{ route('usuarios.update',$user->id) }}">
		{{ method_field('PUT') }}
	    {{ csrf_field() }}

	    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	        <label for="name" class="col-md-4 control-label">Nombre</label>

	        <div class="col-md-6">
	            <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}"  autofocus>

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
	            <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" >

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
	            <select id="area" type="text" class="form-control" name="area">
	            	
	            	@foreach ($carreras as $carrera)
	            		@if ($user->area==$carrera['valor'])
	            			<option value="{{ $carrera['valor'] }}" selected style="background-color: blue; color: white;">{{ $carrera['carrera'] }}</option>
	            		@else
	            			<option value="{{ $carrera['valor'] }}">{{ $carrera['carrera'] }}</option>
	            		@endif
	            		
	            	@endforeach
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
	            <input id="password" type="password" class="form-control" name="password" value="{{ $user->password }}">

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
	            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" value="{{ $user->password }}">
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
	                Guardar
	            </button>
	        </div>
	    </div>
	</form>
@endsection