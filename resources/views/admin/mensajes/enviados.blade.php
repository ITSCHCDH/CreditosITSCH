@extends('template.molde')

@section('title','Mensajes')
@section('ruta')
	<a href="{{ route('mensajes.index') }}">Mensajes</a>
	/
	<label class="label label-success">Mensajes Enviados</label>
@endsection
@section('contenido')
	<div class="pull-right">
		<div class="toltip">
			<a href="{{ route('mensajes.crear') }}" class="btn btn-primary" style="padding: 2px;">
				<img src="{{ asset('images/new_message.png') }}" alt="Nuevo mensaje" class="white-icon" style="width: 40px; heigth: 40px;">
			</a>
			<span class="toltiptext">Nuevo mensaje</span>
		</div>
	</div>
	<div style="clear: both;"></div>
	<br>
	<h3>Bandeja de entrada</h3>
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
	    				<a href="{{ route('mensajes.destinatarios',['mensaje_id' => $msj->id]) }}" class="btn btn-primary"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>
	    				<a href="{{ route('mensajes.ver',['mensaje_id' => $msj->id,'ruta' => 'true']) }}" class="btn btn-warning"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a>
	    			</td>
	    		</tr>
	    	@endforeach
	    </tbody>
	</table>
	{{ $mensajes->links() }}
@endsection