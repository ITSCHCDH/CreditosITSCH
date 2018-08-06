@extends('template.molde');

@section('title','Avance alumnos')

@section('ruta')
    
    @if (count($ruta_data)>0)
    	<div style="width: 200px; height: 30px; float:right;">

    		{!! Form::open(['route' => 'verifica_evidencia.reportes','method' => 'GET','id' => 'ruta_input','style' => 'float: left; margin-right: 5px;']) !!}
    			{!! Form::hidden('carrera',$ruta_data[0]) !!}
    			{!! Form::hidden('generacion',$ruta_data[1]) !!}
    			<a href="#" onclick="document.getElementById('ruta_input').submit()"> Reportes </a>
    		{!! Form::close() !!}
    		/
    		<label class="label label-success">Avance alumno</label>
    	</div>

    @else
    	<label class="label label-success">Avance alumno</label>
    @endif
@endsection

@section('contenido')
	{!! Form::open(['route' => 'verifica_evidencia.avance_alumno', 'method' => 'GET','class' => 'form-inline my-2 my-lg-0 mr-lg-2 navbar-form pull-right']) !!}
		<div class="input-group">
		    {!! Form::text('no_control',null,['class'=>'form-control','placeholder'=>'Numero de control','aria-describedby'=>'search','required']) !!}
		    <div class="input-group-btn">
		        <button type="submit" class="btn btn-primary"> Buscar
		            <span class="badge  label label-primary glyphicon glyphicon-search">
		                  </span>
		        </button>
		    </div>
		</div>
	{!! Form::close() !!}

	<div style="width:500px; margin-top:50px;">
		<table class="table table-striped">
			<thead>
				<th colspan="2">Información del alumno</th>
			</thead>
			<tbody>
				<tr>
					<th>Nombre</th>
					<td>
						@if ($alumno_data!=null)
							{{ $alumno_data[0]->nombre_alumno }}
						@endif
					</td>
				</tr>
				<tr>
					<th>Numero de control</th>
					<td>
						@if ($alumno_data!=null)
							{{ $alumno_data[0]->no_control }}
						@endif
					</td>
				</tr>
				<tr>
					<th>Carrera</th>
					<td>
						@if ($alumno_data)
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
@endsection