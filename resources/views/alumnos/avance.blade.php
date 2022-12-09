@extends('template.molde')

@section('title','Avance alumnos')

@section('ruta')
    <label class="label label-success">Avance alumno</label>
@endsection

@section('contenido')
	
	<a href="{{ route('alumnos.actividades') }}" class="btn btn-primary" title="Ver actividades asignadas"><i class="far fa-eye"></i> Actividades</a>
	<hr>
	<div class="card mb-3" style="max-width: 1550px;">
		<div class="row g-0">
			<div class="col-md-2">
				@if($alumno_data[0]->foto==null)
					<img
						src="{{ asset('images/user.png') }}"
						alt="Imagen del alumno"
						class="img-fluid rounded-start"
					/>
				@else
					<img
						src="{{ asset('storage/alumnos/img/'.$alumno_data[0]->foto) }}"
						alt="Imagen del alumno"
						class="img-fluid rounded-start"
					/>
				@endif
			</div>
			<div class="col-md-10">
				<div class="card-body">
					<h5 class="card-title">Información del alumno</h5>				
					<table class="table">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>No. Control</th>
								<th>Carrera</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									@if ($alumno_data!=null)
									{{ $alumno_data[0]->nombre_alumno }}
									@endif
								</td>
								<td>
									@if ($alumno_data!=null)
									{{ $alumno_data[0]->no_control }}
									@endif	
								</td>
								<td>
									@if ($alumno_data!=null)
									{{ $alumno_data[0]->carrera }}
									@endif	
								</td>
							</tr>
						</tbody>
					</table>			
				</div>
			</div>
		</div>
	</div>

	
	<div class="table-responsive">
		<table class="table">
			<!-- instancia al archivo table, dentro de este mismo direcctorio -->
			<thead>
				<th>Credito</th>
				<th>Actividades</th>
				<th>Porcentaje</th>
			</thead>
			<tbody>
				@if($alumno_data!=null)
					@php
						$temp_porcentaje = 0;
						$temp_suma = 0;
						$y=0;
					@endphp
					@for ($x = 0; $x < count($creditos); $x++)
						
						@if ( $y < count($alumno_data) && $avance)
							@if ($alumno_data[$y]->nombre_credito==$creditos[$x]->nombre)
								@php
									$temp_porcentaje = ($alumno_data[$y]->por_credito >100)?100:$alumno_data[$y]->por_credito;
									$temp_suma += (int)$temp_porcentaje;
								@endphp
								<tr>
									<td colspan="3" style="text-align:left; padding: 0;">
										<div style="position: relative;">
											<div style="background: #27ce1e; padding: 5; width: {{$temp_porcentaje}}%; height: 35px;max-width: 100%";>
												<div style="position: absolute;">
													<strong>{{ $alumno_data[$y]->nombre_credito }}</strong>
												</div>
												
											</div>
										</div>
									</td>
								</tr>
								@for (; $y < count($alumno_data) && $alumno_data[$y]->nombre_credito==$creditos[$x]->nombre; $y++)
									<tr>
										<td></td>
										<td>{{ $alumno_data[$y]->nombre_actividad }}</td>
										<td>{{ $alumno_data[$y]->por_cred_actividad.'%' }}</td>
									</tr>
								@endfor
								<tr>
									<td></td>
									<td></td>
									<td ><strong>Total</strong></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td>{{ $temp_porcentaje.'%' }}</td>
								</tr>
							@else
								<tr>
									<td colspan="3" style="text-align:left; padding: 0;">
										<div style="position: relative;">
											<div style="background: #27ce1e; padding: 5; width: 0%;height: 35px;max-width: 100%";>
												<div style="position: absolute;">
													<strong >{{ $creditos[$x]->nombre }}</strong>
												</div>
												
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td></td>
									<td>No actividades registradas</td>
									<td>0%</td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td ><strong>Total</strong></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td>0%</td>
								</tr>
							@endif
						@else
							<tr>
								<td colspan="3" style="text-align:left; padding: 0;">
									<div style="position: relative;">
										<div style="background: #27ce1e; padding: 5; width: 0%;height: 35px;max-width: 100%";>
											<div style="position: absolute;">
												<strong >{{ $creditos[$x]->nombre }}</strong>
											</div>
											
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>No actividades registradas</td>
								<td>0%</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td ><strong>Total</strong></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td>0%</td>
							</tr>
						@endif
					@endfor
					@php
						if($temp_suma>500)$temp_suma=500;
						$temp_suma/=100;
					@endphp
					<tr>
							<td></td>
							<td></td>
							<td><h5>Total de creditos</h5></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td><h5>{{ $temp_suma.' creditos' }}</h5></td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
	<hr>
	@if($liberado)
		<a href="{{ route('alumnos.constancias_imprimir') }}" class="btn btn-primary">Imprimir constancia</a>
	@endif	
@endsection