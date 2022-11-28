@extends('template.molde')

@section('title','Mensajes')
@section('ruta')
	<label class="label label-success">Mensajes</label>
@endsection
@section('contenido')
	<div class="row">
		<div class="col-sm-4">
			@if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VIP_EVIDENCIA','VERIFICAR_EVIDENCIA']))				
				<a  href="{{ route('verifica_evidencia.index') }}" class="btn btn-info btn-sm"  title="Verificar evidencias">
					<i class='fas fa-search-plus' style='font-size:14px; color:#000;'></i>
				</a>						
			@endif
		</div>		
		
		<div class="col-sm-8" style="text-align: right;">
			
				<a href="{{ route('mensajes.crear') }}" class="btn btn-primary btn-sm" title="Crear mensajes" >
					<i class="far fa-envelope" style="font-size:14px"></i>
				</a>				
			
				<a href="{{ route('mensajes.enviados') }}" class="btn btn-warning btn-sm" title="Mensajes enviados" >
					<i class="fas fa-share-square" style="font-size:14px"></i>
				</a>		
			
				<a href="{{ route('mensajes.vistos') }}" class="btn btn-success btn-sm" title="Mensajes leídos" >
					<i class="far fa-envelope-open" style="font-size:14px"></i>
				</a>
				
			
		</div>		
	</div>
	
	<br>
	<h3>Bandeja de entrada</h3>
	<div class="table-responsive">
		<table class="table">
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
								<a href="{{ route('mensajes.ver',['mensaje_id' => $msj->mensaje_id,'receptor_id' => $msj->receptor_id]) }}" class="btn btn-warning btn-sm"><i class="far fa-envelope" style="font-size:14px"></i></a>
							</td>
							<td>{{ $msj->usuario_nombre }}</td>
							<td>{{ $msj->notificacion }}</td>
							<td>{{ $msj->fecha }}</td>		    		
						</tr>
					@else
						<tr>
							<th>
								<a href="{{ route('mensajes.ver',['mensaje_id' => $msj->mensaje_id,'receptor_id' => $msj->receptor_id]) }}" class="btn btn-warning btn-sm"><i class="far fa-envelope" style="font-size:14px"></i></a>
							</th>
							<th>{{ $msj->usuario_nombre }}</th>
							<th>{{ $msj->notificacion }}</th>
							<th>{{ $msj->fecha }}</th>					
						</tr>
					@endif
				@endforeach
			</tbody>
		</table>
	</div>
	
@endsection