@extends('template.molde')

@section('title','Perfil')

@section('ruta')
	<label class="label label-success">Perfil</label>
@section('contenido')

	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
			<div class="card" style="width: 30rem;">
				<img src="{{ asset('images/user.png') }}" class="card-img-top" alt="User"/>
				<div class="card-body">
				<h5 class="card-title">Datos Personales</h5>
				<p class="card-text">En esta sección podras ver los datos personales del usuario seleccionado</p>
				</div>
				<ul class="list-group list-group-light list-group-small">
					<li class="list-group-item px-4">Nombre: {{ Auth::User()->name }}</li>
					<li class="list-group-item px-4">Correo: {{ Auth::User()->email }}</li>
					<li class="list-group-item px-4">Area: {{ $data_usuario->area_nombre }}</li>
					<li class="list-group-item px-4">Roles: </li>
					<ul class="list-group list-group-light list-group-small">
						@for ($i = 0; $i < count($roles); $i++)
							<li class="list-group-item px-5">
								{{ $roles[$i] }}
							</li>
						@endfor
					</ul>
				</ul>
				<div class="card-body">
					<a href="{{ route('perfil.password_reset_view') }}" >Cambiar contraseña</a>	
				</div>
			</div>
		</div>
		<div class="col-sm-4"></div>
	</div>
	

	
	<div style="padding: 20px;"></div>
@endsection
@endsection