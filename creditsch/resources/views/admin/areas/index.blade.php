@extends('template.molde')

@section('title','Areas')
@section('ruta')
	<label class="label label-success">Areas</label>
@endsection

@section('contenido')
	@if(Auth::User()->hasAnyPermission(['VIP','CREAR_AREAS']))
		<a href="{{ route('areas.crear') }}" class="btn btn-primary">Nueva area</a>
	@endif
	<table class="table table-striped" id="tabla-areas">
	    <thead>
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
	    				<a href="{{ route('areas.usuarios',$area->id) }}" class="btn btn-primary"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>
	    				@if(Auth::User()->hasAnyPermission(['VIP','MODIFICAR_AREAS']))
	    					<a href="{{ route('areas.editar',$area->id) }}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>
	    				@endif
	    				@if(Auth::User()->hasAnyPermission(['VIP','ELIMINAR_AREAS']))
	    					<a href="{{ route('areas.eliminar',$area->id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
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
