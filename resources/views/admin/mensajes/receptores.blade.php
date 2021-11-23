@extends('template.molde')

@section('title','Mensajes')
@section('ruta')
	<a href="{{ route('mensajes.index') }}">Mensajes</a>
	/
	<a href="{{  route('mensajes.enviados') }}">Mensajes Enviados</a>
	/
	<label class="label label-success">Destinatarios</label>
@endsection
@section('contenido')
	<h3>Destinatarios</h3>
	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<thead>
			<th>Usuario</th>
			<th>Visto</th>
			<th>Fecha visto</th>
			</thead>
			<tbody>
				@foreach ($receptores as $receptor)
					<tr>
						<td>{{ $receptor->usuario_nombre }}</td>
						<td>
							@if ($receptor->visto=="true")
								{{ "SI" }}
							@else
								{{ "NO" }}
							@endif
						</td>
						<td>
							@if ($receptor->visto=="true")
								{{ $receptor->fecha_visto }}
							@else
								{{ "--:--:--" }}
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection