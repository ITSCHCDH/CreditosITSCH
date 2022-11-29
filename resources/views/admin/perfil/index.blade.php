@extends('template.molde')

@section('title','Perfil')

@section('ruta')
	<label class="label label-success">Perfil</label>
@section('contenido')
	<table class="table table-striped table-bordered" style="width: 700px; margin: 0 auto 0 auto;">
		<thead></thead>
		<tbody>
			<tr style="background-color: #2d3e50; color: white;">
				<th colspan="2">Datos Personales</th>
			</tr>
			<tr>
				<th>Nombre </th>
				<td>{{ Auth::User()->name }}</td>
			</tr>
			<tr>
				<th>Correo</th>
				<td>{{ Auth::User()->email }}</td>
			</tr>
			<tr>
				<th>Area:</th>
				<td>{{ $data_usuario->area_nombre }}</td>
			</tr>
			<tr>
				<th>Roles</th>
				<td>
					<ul style="list-style-type: none;">
						@for ($i = 0; $i < count($roles); $i++)
							<li>
								{{ $roles[$i] }}
							</li>
						@endfor
					</ul>
				</td>
			</tr>
			<tr>
				<th>Contraseña</th>
				<td><a href="{{ route('perfil.password_reset_view') }}" class="btn btn-primary">Cambiar contraseña</a></td>
			</tr>
		</tbody>
	</table>
	<div style="padding: 20px;"></div>
@endsection
@endsection