@extends('template.molde')

@section('title','Actividades')

@section('ruta')
	<a href="{{ route('alumnos.avance') }}" class="label label-info">Avance</a>
	/
	<label class="label label-success">Actividades</label>
@endsection

@section('contenido')
	<table class="table table-striped">
	    <thead>
	        <th>Nombre</th>
	        <th>Crédito</th>
	        <th>Porcentaje</th>
	        <th>Validado</th>
	        <th>Acción</th>
	    </thead>
	    <tbody>
	            @foreach($actividades as $actividad)
	                <tr>
	                	<td>{{ $actividad->actividad_nombre }}</td>
	                	<td>{{ $actividad->credito_nombre }}</td>
	                	<td>{{ $actividad->actividad_porcentaje }}%</td>
	                	<td>
	                		@if ($actividad->validado=="true")
	                			{{ "SI" }}
	                		@else
	                			{{ "NO" }}
	                		@endif
	                	</td>
	                	<td>
	                		@if ($actividad->alumnos=="true")
	                			@if ($actividad->validado=="false")
	                				<a href="{{ route('alumnos.subir_evidencia',['id_responsable' => $actividad->user_id,'id_actividad' => $actividad->actividad_id]) }}" class="btn btn-primary"><span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span></a>
	                			@endif
	                			<a href="{{ route('alumnos.evidencia',['actividad_id' => $actividad->actividad_id,'user_id' => $actividad->user_id]) }}" class="btn btn-warning"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
	                		@else
								NINGUNA
	                		@endif
	                	</td>
	                </tr>
	            @endforeach
	    </tbody>
	</table>
@endsection