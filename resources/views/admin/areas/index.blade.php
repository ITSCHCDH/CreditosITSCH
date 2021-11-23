@extends('template.molde')

@section('title','Areas')
@section('ruta')
	<label class="label label-success">Areas</label>   
	<h5>Hola Mundo</h5>
@endsection

@section('contenido')
	@if(Auth::User()->hasAnyPermission(['VIP','CREAR_AREAS']))
	<div class="row">
		<div class="col"></div>
		<div class="col"></div>
		<div class="col text-right">
			<a href="{{ route('areas.crear') }}" class="btn btn-success btn-sm">
				<i class='fab fa-buysellads'></i>	
				Nueva area
			</a>
		</div>
	</div>
		
	@endif
	<br>
	<table class="table" id="tabla-areas">
	    <thead class="thead-dark">
	    <th>ID</th>
	    <th>Nombre</th>
	    <th>Tipo</th>
	    <th>Acción</th>
	    </thead>
	    <tbody>
	    	@foreach($areas as $area)
	    		<tr>
	    			<td>{{ $area->id }}</td>
	    			<td>{{ $area->nombre }}</td>
	    			<td>{{ $area->tipo }}</td>
	    			<td>
	    				<a href="{{ route('areas.usuarios',$area->id) }}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>
	    				@if(Auth::User()->hasAnyPermission(['VIP','MODIFICAR_AREAS']))
	    					<a href="{{ route('areas.editar',$area->id) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>
	    				@endif
	    				@if(Auth::User()->hasAnyPermission(['VIP','ELIMINAR_AREAS']))
	    					<a href="{{ route('areas.eliminar',$area->id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
	    				@endif
	    			</td>
	    		</tr>
	    	@endforeach
	    </tbody>
	</table>
	<div style="padding: 25px;"></div>
	@section('js')
		<script type="text/javascript">
			$(document).ready(function() {
			    $('#tabla-areas').DataTable( {
			        "pagingType": "full_numbers"
			    } );
			});
		</script>
	@endsection
@endsection
