@extends('template.molde')

@section('title','Actividades')

@section('ruta')
	<a href="{{ route('alumnos.avance') }}" class="label label-info">Avance</a>
	/
	<label class="label label-success">Actividades</label>
@endsection

@section('contenido')
	<div class="table-responsive">
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
						@php
							$falta_evidencia = false;
						@endphp
						<tr>
							<td>{{ $actividad->actividad_nombre }}</td>
							<td>{{ $actividad->credito_nombre }}</td>
							<td>{{ $actividad->actividad_porcentaje }}%</td>
							<td>
								@if ($actividad->validado == "true")
									@if (( $actividad->alumnos == "true" && $actividad->momento_agregado == "posteriormente" && $actividad->evidencia_validada == "si") || ($actividad->momento_agregado == "anteriormente"))
										{{ "SI" }}
									@else
										@php
											$falta_evidencia = true;
										@endphp
										{{ "NO" }}
									@endif
								@else
									{{ "NO" }}
								@endif
							</td>
							<td>
								@if ($actividad->alumnos == "true")
									@if ($actividad->validado == "false" || $falta_evidencia)										
										<a href="{{ route('alumnos.subir_evidencia',['id_responsable' => $actividad->user_id,'id_actividad' => $actividad->actividad_id]) }}" class="btn btn-primary" title="Subir evidencias"><i class="fas fa-cloud-upload-alt"></i></a>																					
									@endif									
										<a href="{{ route('alumnos.evidencia',['actividad_id' => $actividad->actividad_id,'user_id' => $actividad->user_id]) }}" class="btn btn-warning" title="Ver evidencias subidas"><i class="far fa-eye"></i></a>																			
								@else
									NINGUNA
								@endif
							</td>
						</tr>
					@endforeach
			</tbody>
		</table>
	</div>
@endsection