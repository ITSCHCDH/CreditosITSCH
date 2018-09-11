@extends('template.molde');

@section('title','Avance alumnos')

@section('ruta')
    <label class="label label-success">Avance alumno</label>
@endsection

@section('contenido')
	
	<a href="{{ route('alumnos.actividades') }}" class="btn btn-primary">Actividades</a>
	<div style="width:500px; margin-top:10px;">
		<table class="table table-striped">
			<thead>
				<th colspan="2">Información del alumno</th>
			</thead>
			<tbody>
				<tr>
					<th>Nombre</th>
					<td>
						{{ Auth::User()->nombre }}
					</td>
				</tr>
				<tr>
					<th>Numero de control</th>
					<td>
						{{ Auth::User()->no_control }}
					</td>
				</tr>
				<tr>
					<th>Carrera</th>
					<td>
						@if ($alumno_data!=null)
							{{ $alumno_data[0]->carrera }}
						@endif
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<table class="table table-striped" style="margin: 30px auto 50px auto; width:60%;">
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
					<td><strong>Total de creditos</strong></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>{{ $temp_suma.' creditos' }}</td>
			</tr>
		@endif
	</tbody>
	</table>
	@if($liberado)
		<a href="{{ route('alumnos.constancias_imprimir') }}" class="btn btn-primary">Imprimir constancia</a>
	@endif
	<div style="padding: 5px 0 50px 0;"></div>
@endsection