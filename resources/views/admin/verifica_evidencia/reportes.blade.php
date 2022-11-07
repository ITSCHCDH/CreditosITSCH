@extends('template.molde')

@section('title','Reportes')

@section('ruta')
    <label class="label label-success">Reportes</label>
@endsection

@section('contenido')
		
	<form action="{{ route('verifica_evidencia.reportes') }}" method="get">	
		<div><h4>Filtros</h4></div>
		<hr>
		<div class="row ml-2">
			<div class="col-sm-3">					
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text bg-info">Generación</span>
					</div> 						
					<select name='generacion' class='form-control' required placeholder='Año-Generación' method='GET'>
						@php
							echo "<option value = 1>Todos</option>";
							$anio_actual = (int)explode("-",Carbon\Carbon::now())[0];
							for($anio = 2013; $anio <= $anio_actual; ++$anio){
								if($anio==$generacion)
								{
									echo "<option value = $anio selected='selected'>$anio</option>";
								}
								else 
								{
									echo "<option value = $anio>$anio</option>";
								}
								
							}
						@endphp
					</select>
				</div>
			</div>
			<div class="col-sm-3">					
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text bg-info">Carrera</span>
					</div> 			   
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
			</div>
			<div class="col-sm-2">
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text bg-info">Status</span>
					</div> 			   
					<select class="form-control" name="status" id="status">											
						<option value="todos" @if($status=='todos') selected='selected' @endif>Cualquier status</option>											
						<option value="liberado" @if($status=='liberado') selected='selected' @endif>Liberados</option>							
						<option value="pendiente" @if($status=='pendiente') selected='selected' @endif>Pendientes</option>	
						<option value="baja" @if($status=='baja') selected='selected' @endif>Baja</option>									
					</select>
				</div>
			</div>
			<div class="col-sm-3">					
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text bg-info">Control</span>
					</div>					
					<input type="text" name="busqueda" id="Control" class="form-control" placeholder="Nombre - No Control" value="{{ $busqueda }}">
				</div>
			</div>			
			<div class="col-sm-1">				
				<button type="submit" class="btn btn-secondary"><span class="glyphicon glyphicon-filter"></span> Filtrar</button>				
			</div>
		</div>	
		<hr>
	</form>
	<br>
	<br>
	<div class="row ml-2">		
		<div class="col-sm-12">
			@if ($reportes_data != null)
				@for ($alumno = 0, $alumno_index=0;  $alumno < count($suma_creditos); $alumno++)
					<div class="row">				
						<hr>
						<h5><strong>Alumno:</strong>  {{ $suma_creditos[$alumno]->nombre }}</h5>
						<p><strong>Numero de control:</strong> {{ $suma_creditos[$alumno]->no_control }}</p>
						<p><strong>Status:</strong> {{ $suma_creditos[$alumno]->status }}</p>					
						<p><strong>Completado</strong></p>
						<div>							
							<div style="width: {{ ($suma_creditos[$alumno]->credito_suma*100)/500 }}%; background-color:#27ce1e;"><p style="color: white">{{ ($suma_creditos[$alumno]->credito_suma*100)/500 }}%</p></div>
						</div>	
					</div>					
					<div class="row">					
						<div class="col-sm-4">
							<button class="btn btn-info" id="{{ $suma_creditos[$alumno]->alumno_id }}" data-mdb-toggle="modal" data-mdb-target="#myModalDetalle{{ $suma_creditos[$alumno]->alumno_id }}"><i class='fas fa-eye'></i> Más</button>
						</div>
						<div class="col-sm-2">
							@if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_AVANCE_ALUMNO']))
								<form action="{{ route('verifica_evidencia.avance_alumno') }}" method="get">							
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
									<input type="hidden" name="ruta_carrera" id="ruta_carrera" value="{{ $ruta_carrera }}">
									<input type="hidden" name="ruta_generacion" id="ruta_generacion" value="{{ $ruta_generacion }}">
									<input type="hidden" name="no_control" id="no_control" value="{{ $suma_creditos[$alumno]->no_control }}">
									<button type="submit" class="btn btn-primary">Avance</button>									
								</form>	
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
					<div style="margin-bottom: 200px"></div>

					<!-- Modal -->
					<div class="modal" id="myModalDetalle{{ $suma_creditos[$alumno]->alumno_id }}" tabindex="-1" aria-labelledby="Resumen del avance del alumno" aria-hidden="true">
						<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5><strong>Detalle del alumno:</strong>&nbsp{{$suma_creditos[$alumno]->nombre}}</h5>
								<button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<ul class="list-group list-group-light" id="a{{ $suma_creditos[$alumno]->alumno_id }}" style="padding:0;">
									@for ($alumno_data = 0; $alumno_data < $creditos; $alumno_data++,$alumno_index++)
										<li class="list-group-item">
											<div >
												<h6>{{ $reportes_data[$alumno_index]->nombre_credito }}</h6>
											</div>
											<div>												
												<div style="width: {{ $reportes_data[$alumno_index]->por_credito }}%; background-color:#27ce1e;"><p style="color: white;">{{ $reportes_data[$alumno_index]->por_credito }}%</p></div>
											</div>
										</li>
										<div class="resetear"></div>
									@endfor
								</ul>	
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cerrar</button>								
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
				        <strong>Alumno(s) no encontrado(s)!.</strong>
				        <br>
				        Nota:
				        <br>
				        Tus criterios de busqueda no generarón ningun resultado, te sugerimos modificarlos.
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
		
	</div>
@endsection