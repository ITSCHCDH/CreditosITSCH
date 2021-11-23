@extends('template.molde')

@section('title','Reportes')

@section('ruta')
    <label class="label label-success">Reportes</label>
@endsection

@section('contenido')
		

	{!! Form::open(['route' => 'verifica_evidencia.reportes','method' => 'GET']) !!}
		<div><h4>Filtros</h4></div>
		<hr>
			<div class="row">
				<div class="col-sm-3">
					{!! Form::label('generacion','Generacion') !!}
					<select name='generacion' class='form-control' required placeholder='Año-Generación' method='GET'>
						@php
							echo "<option value = 1>Todos</option>";
							$anio_actual = (int)explode("-",Carbon\Carbon::now())[0];
							for($anio = 2013; $anio <= $anio_actual; ++$anio){
								echo "<option value = $anio>$anio</option>";
							}
						@endphp
					</select>
				</div>
				<div class="col-sm-3">
				    {!! Form::label('carrera','Carrera') !!}
				    <select class="form-control" required name="carrera" id="carrera">
				    	@if (Auth::User()->hasAnyPermission(['VIP','VIP_REPORTES','VIP_SOLO_LECTURA']))
				    		<option value="">Seleccione una carrera</option>
				    	@endif
				    	@foreach($carreras as $carrera)
				    		@if($carrera_seleccionada == $carrera->id)
				    			<option value="{{ $carrera->id }}" selected>{{ $carrera->nombre }}</option>
				    		@else
				    			<option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
				    		@endif
				    	@endforeach
				    </select>
				</div>
				<div class="col-sm-3">
					{!! Form::label('busqueda','Busqueda') !!}			
					<input type="text" name="busqueda" id="Control" class="form-control" placeholder="Nombre - No Control" value="{{ $busqueda }}">
				</div>
				<div class="col-sm-3">
					<br>
					<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-filter"></span> Filtrar</button>
					
				</div>
			</div>	
			<hr>
	{!! Form::close() !!}

	<br>
	<br>
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
			@if ($reportes_data != null)
				@for ($alumno = 0, $alumno_index=0;  $alumno < count($suma_creditos); $alumno++)
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-10 bg-dark">
							<h5 style="color:#ffffff;"><strong>Alumno:</strong>  {{ $suma_creditos[$alumno]->nombre }}</h5>
						</div>
						<div class="col-sm-1">
							
						</div>
					</div>		
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
							<p class="alumno_nombre texto" style="text-align: left;"><strong>Numero de control:</strong> {{ $suma_creditos[$alumno]->no_control }}</p>
						</div>
						<div class="col-sm-1"></div>
					</div>
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-4">
							<p class="texto pull-left" style="margin-right: 10px;"><strong>Completado</strong></p>
							<div class="porcentaje pull-left">
								<p class="pull-left" style="width: 100%; max-width: 100%;">{{ ($suma_creditos[$alumno]->credito_suma*100)/500 }}%</p>
								<div style="width: {{ ($suma_creditos[$alumno]->credito_suma*100)/500 }}%">
								</div>
							</div>	
						</div>
						
						<div class="col-sm-2">
							<button class="btn btn-info btn-sm" id="{{ $suma_creditos[$alumno]->alumno_id }}" data-toggle="modal" data-target="#myModalDetalle{{ $suma_creditos[$alumno]->alumno_id }}"><i class='fas fa-eye'></i> Más</button>
						</div>
						<div class="col-sm-2">
							@if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_AVANCE_ALUMNO']))
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
									{!! Form::submit('Avance',['class' => 'btn btn-primary btn-sm'])!!}
								{!! Form::close() !!}
							@endif
						</div>
						<div class="col-sm-2">
							@if($suma_creditos[$alumno]->credito_suma=='500' && (Auth::User()->hasAnyPermission(['VIP','IMPRIMIR_CONSTANCIAS'])))
								<form action="{{ route('constancias.imprimir') }}"  method="post">
									{{ csrf_field() }}
									<input type="hidden" name="no_control" value="{{  $reportes_data[$alumno_index]->no_control }}">
									<input type="submit" name="" value="Constancia" class="btn btn-warning btn-sm">
								</form>
							@endif
						</div>
						<div class="col-sm-1"></div>
					</div>	
						<!-- The Modal -->
						<div class="modal" id="myModalDetalle{{ $suma_creditos[$alumno]->alumno_id }}">
						  <div class="modal-dialog">
						    <div class="modal-content">

						      <!-- Modal Header -->
						      <div class="modal-header">
						        <h4 class="modal-title">Detalle del alumno: {{$suma_creditos[$alumno]->nombre}}</h4>
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						      </div>

						        <!-- Modal body -->
						        <div class="modal-body" style="text-align: center;">				      		
							        <ul class="lista" id="a{{ $suma_creditos[$alumno]->alumno_id }}" style="padding:0;">
									@for ($alumno_data = 0; $alumno_data < $creditos; $alumno_data++,$alumno_index++)
										<li style="text-align: center;">
											<div >
												<h5><strong>{{ $reportes_data[$alumno_index]->nombre_credito }}</strong></h5>
											</div>
											<div class="porcentaje" style="margin:auto;">
												<p class="pull-left" style="width: 100%; max-width: 100%">{{ $reportes_data[$alumno_index]->por_credito }}%</p>
												<div style="width: {{ $reportes_data[$alumno_index]->por_credito }}%;">
												</div>
											</div>
										</li>
										<div class="resetear"></div>
									@endfor
									</ul>						
								</div>
						      
						      <!-- Modal footer -->
						      <div class="modal-footer">
						        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
						      </div>

						    </div>
						  </div>
						</div>				
				@endfor
			@else	
				@section('js')
					<script>
						if($("#Control").val().length > 0){  $("#alerta").modal("show");}
					</script>
				@endsection						

			@endif

			<!-- The Modal -->
				<div class="modal" id="alerta">
				  <div class="modal-dialog">
				    <div class="modal-content">

				      <!-- Modal Header -->
				      <div class="modal-header">
				        <h4 class="modal-title">Mensaje</h4>
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				      </div>

				      <!-- Modal body -->
				      <div class="modal-body">
				        <strong>Alumno no encontrado!.</strong>
				        <br>
				        Nota:
				        <br>
				        Te sugerimos modificar los criterios de busqueda.
				      </div>

				      <!-- Modal footer -->
				      <div class="modal-footer">
				        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				      </div>

				    </div>
				  </div>
				</div>
			  <!-- End Modal -->
		</div>
		<div class="col-sm-2"></div>
	</div>
	
	
@section('js')
	
@endsection
@endsection