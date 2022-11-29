@extends('template.molde')

@section('title','Usuarios')
@section('ruta')
	<a href="{{ route('areas.inicio') }}">Areas</a>
	/
	<label class="label label-success">Usuarios del area de {{ $area->nombre }}</label>
@endsection

@section('contenido')
	<table class="table table-striped" id="tabla-usuarios">
	    <thead>
	    <th>Nombre</th>
	    <th>Area</th>
	    </thead>
	    <tbody>
	    	@foreach($usuarios as $usuario)
	    		<tr>
	    			<td>{{ $usuario->name }}</td>
	    			<td>{{ $area->nombre }}</td>
	    		</tr>
	    	@endforeach
	    </tbody>
	</table>
	<div style="padding: 25px;"></div>
	@section('js')
		<script type="text/javascript">
			$(document).ready(function() {
			    $('#tabla-usuarios').DataTable( {
			        "pagingType": "full_numbers"
			    } );
			});
		</script>
	@endsection
@endsection
