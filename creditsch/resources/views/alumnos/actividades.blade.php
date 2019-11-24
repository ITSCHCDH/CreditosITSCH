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
									@if ($actividad->alumnos == "true" && (($actividad->momento_agregado == "posteriormente" && $actividad->evidencia_validada == "si") || ($actividad->momento_agregado == "anteriormente")))
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
										<div class="toltip">
											<a href="{{ route('alumnos.subir_evidencia',['id_responsable' => $actividad->user_id,'id_actividad' => $actividad->actividad_id]) }}" class="btn btn-primary"><span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span></a>
											<span class="toltiptext">Subir evidencias</span>
										</div>
									@endif
									<div class="toltip">
										<a href="{{ route('alumnos.evidencia',['actividad_id' => $actividad->actividad_id,'user_id' => $actividad->user_id]) }}" class="btn btn-warning"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
										<span class="toltiptext">Ver evidencias subidas</span>
									</div>
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