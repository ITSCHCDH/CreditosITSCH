@extends('template.molde');

@section('title','Avance alumnos')

@section('ruta')
    <label class="label label-success">Avance alumno</label>
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
					<td>Jehu Jair Ruiz Villegas</td>
				</tr>
				<tr>
					<th>Numero de control</th>
					<td>15030205</td>
				</tr>
				<tr>
					<th>Carrera</th>
					<td>Ing. en Sistemas Computacionales</td>
				</tr>
			</tbody>
		</table>
	</div>

	<table class="table table-striped" id="mitabla" style="margin: 30px auto 50px auto; width:60%;">
	    <!-- instancia al archivo table, dentro de este mismo direcctorio -->
	<thead>
		<th>Credito</th>
		<th>Actividades</th>
		<th>Porcentaje</th>
	</thead>
	<tbody>
		@if($alumno_data!=null)
			@php
				$temp_credito = $alumno_data[0]->nombre_credito;
				$temp_porcentaje = $alumno_data[0]->por_credito;
				$temp_suma = (int)$temp_porcentaje;
				$temp_nombre_credito = "Hola mundo";
			@endphp
			@foreach($alumno_data as $alumno)
				@if($temp_credito!=$alumno->nombre_credito)
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
					@php
						$temp_credito = $alumno->nombre_credito;
						$temp_porcentaje = $alumno->por_credito;
						$temp_suma += (int)$temp_porcentaje;
					@endphp
				@endif
				@if ($temp_nombre_credito!=$alumno->nombre_credito)
					@php
						$temp_nombre_credito=$alumno->nombre_credito;
					@endphp
					<tr>
						<td>{{ $alumno->nombre_credito }}</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td>{{ $alumno->nombre_actividad }}</td>
						<td>{{ $alumno->por_cred_actividad }}</td>
					</tr>
				@else
					<tr>
						<td></td>
						<td>{{ $alumno->nombre_actividad }}</td>
						<td>{{ $alumno->por_cred_actividad }}</td>
					</tr>
				@endif
			@endforeach
				@php
					$temp_suma/=100;
				@endphp
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
				<tr>
					<td></td>
					<td></td>
					<td><strong>Creditos Total</strong></td>
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