@extends('template.molde')

@section('title','Perfil')

@section('ruta')
	<a href="{{ route('perfil.index') }}">Mi Perfil</a>
	/
	<label class="label label-success">Password Reset</label>
@section('contenido')
	<form action="{{ route('perfil.password_update') }}" method="post">
		{{ csrf_field() }}
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				<div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
					<label for="old_password">Contraseña actual</label>
					<input type="password" name="old_password" class="form-control">
					@if ($errors->has('old_password'))
						<span class="help-block">
							<strong>{{ $errors->first() }}</strong>
						</span>
					@endif
				</div>
				<div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
					<label for="new_password">Contraseña nueva</label>
					<input type="password" name="new_password" class="form-control">
					@if ($errors->has('new_password'))
						<span class="help-block">
							<strong>{{ $errors->first("new_password") }}</strong>
						</span>
					@endif
				</div>
				<div class="form-group{{ $errors->has('confirm_password') ? ' has-error' : '' }}">
					<label for="confirm_password">Confirmar contraseña</label>
					<input type="password" name="confirm_password" class="form-control">
					@if ($errors->has('confirm_password'))
						<span class="help-block">
							<strong>{{ $errors->first("confirm_password") }}</strong>
						</span>
					@endif
				</div>
				<hr>
				<input type="submit" name="" value="Guardar" class="btn btn-primary">
			</div>
			<div class="col-sm-3"></div>
		</div>
		
		
	</form>
	<div style="padding: 100px;"></div>
@endsection
@endsection