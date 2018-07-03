@extends('template.molde')

@section('title','Reportes')

@section('ruta')
    <label class="label label-success">Reportes</label>
@endsection

@section('contenido')
	{!! Form::open(['route' => 'verifica_evidencia.reportes','method' => 'GET']) !!}
		<div class="input-group form-inline my-2 my-lg-0 mr-lg-2 mt-lg-10 pull-left">
		    {!! Form::label('generacion','Generacion') !!}
		    {!! Form::select('generacion',['2015' => '2015','2016' => '2016','2014' => '2014'],null,['class'=>'form-control','required','placeholder'=>'Año-Generacion','method'=>'GET','required']) !!}
		</div>
		<div class="input-group form-inline my-2 my-lg-0 mr-lg-2 pull-left">
		    {!! Form::label('carrera','Carrera') !!}
            {!! Form::select('carrera',['Sistemas'=>'Ingeniería es Sistemas Computacionales','Industrial'=>'Ingeniería Industrial','Mecatrónica'=>'Ingeniería Mecatrónica','TICS'=>'Ingeniería en Tecnologias de Información y Comunicaciones','Bioquimica'=>'Ingeniería Bioquimica','Nanotecnologia'=>'Ingeniería en Nanotecnologia'],null,['class'=>'form-control','placeholder' => 'Seleccione una carrera','required']) !!}
		</div>
		<div>
			{!! Form::submit('Agregar',['class' => 'btn btn-primary']) !!}
		</div>
		
	{!! Form::close() !!}
	<div class="resetear"></div>
	<div style="margin-top: 30px;">
	@if ($reportes_data != null)
		@for ($alumno = 0, $alumno_index=0; $alumno < count($reportes_data)/$creditos; $alumno++)
			<div class="informe_alumno">
				<p class="alumno_nombre texto" style="text-align: left;"><strong>Alumno:</strong> {{ $suma_creditos[$alumno]->nombre }}</p>
				<div class="resetear"></div>
				<p class="alumno_nombre texto" style="text-align: left;"><strong>Numero de control:</strong> {{ $suma_creditos[$alumno]->no_control }}</p>
				<div class="resetear"></div>
				<p class="texto pull-left" style="margin-right: 10px;"><strong>Completado</strong></p>
				<div class="porcentaje pull-left">
					<p class="pull-left" style="width: 100%; max-width: 100%;">{{ ($suma_creditos[$alumno]->credito_suma*100)/500 }}%</p>
					<div style="width: {{ ($suma_creditos[$alumno]->credito_suma*100)/500 }}%">
					</div>
				</div>
				<p class="btn btn-primary boton-desplegar pull-left" id="{{ $suma_creditos[$alumno]->alumno_id }}">Ver más</p>

				{!! Form::open(['route' => 'verifica_evidencia.avance_alumno', 'method' => 'get','style' => 'width: 100px;','class' =>'pull-left']) !!}
					@php
						$ruta_carrera = "desconocida";
						if(isset($_GET['carrera'])){
							$ruta_carrera=$_GET['carrera'];
						}
						$ruta_generacion = "desconocida";
						if(isset($_GET['generacion'])){
							$ruta_generacion = $_GET['generacion'];
						}
					@endphp
					{!! Form::hidden('ruta_carrera',$ruta_carrera) !!}
					{!! Form::hidden('ruta_generacion',$ruta_generacion) !!}
					{!! Form::hidden('no_control', $suma_creditos[$alumno]->no_control) !!}
					{!! Form::submit('Ver avance del alumno',['class' => 'btn btn-primary pull-left alumno-avance'])!!}
				{!! Form::close() !!}
				
				<div class="resetear" ></div>
				<ul class="pull-left lista" id="a{{ $suma_creditos[$alumno]->alumno_id }}" style="display:none;">
				@for ($alumno_data = 0; $alumno_data < $creditos; $alumno_data++,$alumno_index++)
					<li>
						<div class="pull-left credito">
							<p>{{ $reportes_data[$alumno_index]->nombre_credito }}</p>
						</div>
						<div class="porcentaje pull-left">
							<p class="pull-left" style="width: 100%; max-width: 100%">{{ $reportes_data[$alumno_index]->por_credito }}%</p>
							<div style="width: {{ $reportes_data[$alumno_index]->por_credito }}%;">
							</div>
						</div>
					</li>
					<div class="resetear"></div>
				@endfor
				</ul>
			</div>
			<div class="resetear"></div>
		@endfor
	@endif
	<div class="margen"></div>
@section('js')
	<script>
		function subAvance(){
			$(document).on('click','.boton-desplegar',function(event){
				event.preventDefault();
				var id = $(this).attr('id');
				$('#a'+id).toggle();
			});
		}
		$(document).ready(function(){
			subAvance();
		});
	</script>
@endsection
@endsection