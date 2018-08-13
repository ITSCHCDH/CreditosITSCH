@extends('template.molde')

@section('title','Mensajes')
@section('ruta')
	<a href="{{ route('mensajes.index') }}">Mensajes</a>
	/
	<label class="label label-success">Mensajes Enviados</label>
@endsection
@section('contenido')
	<a href="{{ route('mensajes.crear') }}" class="btn btn-primary">Nuevo mensaje</a>
	<br>
	<h3>Bandeja de entrada</h3>
	<table class="table table-striped table-bordered">
	    <thead>
	    <th>Asunto o Alerta</th>
	    <th>fecha</th>
	    <th>Acción</th>
	    </thead>
	    <tbody>
	    	@foreach ($mesajes as $msj)
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
@endsection