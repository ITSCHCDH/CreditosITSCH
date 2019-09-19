@extends('template.molde')

@section('title','Mensajes')
@section('ruta')
    <a href="{{ route('mensajes.index') }}">Mensajes</a>
    /
	<label class="label label-success">Mensajes vistos</label>
@endsection
@section('contenido')
	<div class="pull-right">
		<div class="toltip">
			<a href="{{ route('mensajes.crear') }}" class="btn btn-primary" style="padding: 2px;">
				<img src="{{ asset('images/new_message.png') }}" alt="Nuevo mensaje" class="white-icon" style="width: 40px; heigth: 40px;">
			</a>
			<span class="toltiptext">Nuevo mensaje</span>
		</div>
		<div class="toltip">
			<a href="{{ route('mensajes.enviados') }}" class="btn btn-warning" style="padding: 2px;">
				<img src="{{ asset('images/paper-plane.png') }}" alt="Nuevo mensaje" class="white-icon" style="width: 40px; heigth: 40px;">
			</a>
			<span class="toltiptext">Mensajes enviados</span>
		</div>
	</div>
	<div style="clear: both;"></div>
	<br>
	<h3>Mensajes vistos</h3>
	<table class="table table-striped table-bordered">
	    <thead>
	    <th>Ver mensaje</th>
	    <th>Usuario</th>
	    <th>Asunto o Alerta</th>
	    <th>Fecha</th>
	    </thead>
	    <tbody>
	    	@foreach ($mensajes as $msj)
		    	@if ($msj->visto=="true")
		    		<tr>
		    			<td>
		    				<a href="{{ route('mensajes.ver',['mensaje_id' => $msj->mensaje_id,'receptor_id' => $msj->receptor_id]) }}" class="btn btn-warning"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a>
		    			</td>
		    			<td>{{ $msj->usuario_nombre }}</td>
		    			<td>{{ $msj->notificacion }}</td>
		    			<td>{{ $msj->fecha }}</td>
		    		</tr>
		    	@else
					<tr>
						<th>
							<a href="{{ route('mensajes.ver',['mensaje_id' => $msj->mensaje_id,'receptor_id' => $msj->receptor_id]) }}" class="btn btn-warning"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a>
						</th>
						<th>{{ $msj->usuario_nombre }}</th>
						<th>{{ $msj->notificacion }}</th>
						<th>{{ $msj->fecha }}</th>
					</tr>
		    	@endif
	    	@endforeach
	    </tbody>
	</table>
	{{ $mensajes->links() }}
@endsection