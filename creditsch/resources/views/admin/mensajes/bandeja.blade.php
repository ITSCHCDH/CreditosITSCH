@extends('template.molde')

@section('title','Mensajes')
@section('ruta')
	<label class="label label-success">Mensajes</label>
@endsection
@section('contenido')
	<div class="row">
		<div class="col-sm-4">
			@if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VIP_EVIDENCIA','VERIFICAR_EVIDENCIA']))
				<div class="toltip">
					<a  href="{{ route('verifica_evidencia.index') }}" class="btn btn-info btn-sm" style="padding: 2px;">
						<i class='fas fa-search-plus' style='font-size:24px; color:#000;'></i>
					</a>
					<span class="toltiptext">Verificar evidencias</span>
				</div> 
			@endif
		</div>
		<div class="col-sm-4"></div>
		<div class="col-sm-4" style="text-align: right;">
			<div class="toltip">
				<a href="{{ route('mensajes.crear') }}" class="btn btn-primary btn-sm" style="padding: 2px;">
					<i class='fas fa-envelope' style="font-size:24px"></i>
				</a>
				<span class="toltiptext">Nuevo mensaje</span>
			</div>
			<div class="toltip">
				<a href="{{ route('mensajes.enviados') }}" class="btn btn-warning" style="padding: 2px;">
					<i class="fa fa-send" style="font-size:24px"></i>
				</a>
				<span class="toltiptext">Mensajes enviados</span>
			</div>
			<div class="toltip">
				<a href="{{ route('mensajes.vistos') }}" class="btn btn-success" style="padding: 2px;">
					<i class='fas fa-envelope-open-text' style="font-size:24px"></i>
				</a>
				<span class="toltiptext">Mensajes vistos</span>
			</div>
		</div>		
	</div>
	<div style="clear: both;"></div>
	<br>
	<h3>Bandeja de entrada</h3>
	<table class="table">
	    <thead class="thead-dark">
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