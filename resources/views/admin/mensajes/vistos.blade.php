@extends('template.molde')

@section('title','Mensajes')
@section('ruta')
    <a href="{{ route('mensajes.index') }}">Mensajes</a>
    /
	<label class="label label-success">Mensajes vistos</label>
@endsection
@section('contenido')
	<div class="pull-right">	
		<a href="{{ route('mensajes.crear') }}" class="btn btn-primary btn-sm" title="Crear mensajes" >
			<i class="far fa-envelope" style="font-size:20px"></i>
		</a>	
		<a href="{{ route('mensajes.enviados') }}" class="btn btn-warning btn-sm" title="Mensajes enviados" >
			<i class="fas fa-share-square" style="font-size:20px"></i>
		</a>	
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
		    				<a href="{{ route('mensajes.ver',['mensaje_id' => $msj->mensaje_id,'receptor_id' => $msj->receptor_id]) }}" class="btn btn-warning btn-sm"><i class="far fa-envelope-open"></i></a>
		    			</td>
		    			<td>{{ $msj->usuario_nombre }}</td>
		    			<td>{{ $msj->notificacion }}</td>
		    			<td>{{ $msj->fecha }}</td>
		    		</tr>
		    	@else
					<tr>
						<th>
							<a href="{{ route('mensajes.ver',['mensaje_id' => $msj->mensaje_id,'receptor_id' => $msj->receptor_id]) }}" class="btn btn-warning btn-sm"><i class="far fa-envelope-open"></i></a>
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