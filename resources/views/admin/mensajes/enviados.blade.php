@extends('template.molde')

@section('title','Mensajes')
@section('ruta')
	<a href="{{ route('mensajes.index') }}">Mensajes</a>
	/
	<label class="label label-success">Mensajes Enviados</label>
@endsection
@section('contenido')
	<div class="pull-right">		
		<a href="{{ route('mensajes.crear') }}" class="btn btn-primary btn-sm" title="Crear mensaje" >
			<i class="far fa-envelope" style="font-size:20px"></i>
		</a>				
	</div>
	<div style="clear: both;"></div>
	<br>
	<h3>Bandeja de entrada</h3>
	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<thead>
			<th>Asunto o Alerta</th>
			<th>fecha</th>
			<th>Acción</th>
			</thead>
			<tbody>
				@foreach ($mensajes as $msj)
					<tr>
						<td>{{ $msj->notificacion }}</td>
						<td>{{ $msj->created_at }}</td>
						<td>
							<a href="{{ route('mensajes.destinatarios',['mensaje_id' => $msj->id]) }}" class="btn btn-primary" title="Ver destinatarios"><i class="fas fa-users"></i></a>
							<a href="{{ route('mensajes.ver',['mensaje_id' => $msj->id,'ruta' => 'true']) }}" class="btn btn-warning" title="Ver mensaje"><i class="far fa-eye"></i></a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	{{ $mensajes->links() }}
@endsection