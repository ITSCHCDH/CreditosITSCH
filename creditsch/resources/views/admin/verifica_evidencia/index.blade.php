@extends('template.molde')

@section('title','Verificar Evidencias')

@section('links')
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/checkboxcss/checkbox.css') }}">
	<link rel="stylesheet" href="{{ asset('css/checkbox.css')}}">
@endsection
@section('ruta')
	@if ($actividades_link == 'true')
		<a href="{{ route('actividades.index')}} ">Actividades</a>
		/
	@endif
	<label class="label label-success">Verificar Evidencias</label>
@endsection

@section('contenido')
	<!-- Boton de busqueda en la pagina -->
	{!! Form::open(['route'=>'verifica_evidencia.index','method'=>'GET','class'=>'form-inline my-2 my-lg-0 mr-lg-2 navbar-form pull-right','id' => 'actividades-submit']) !!}
		@if ($validadas == "false")
			<input  type="checkbox" id="checkbox5" class="css-checkbox" checked="checked" name="validadas"/>
		@else
			<input type="checkbox" id="checkbox5" class="css-checkbox" name="validadas"/>
		@endif
		<label for="checkbox5" name="checkbox2_lbl" class="css-label lite-blue-check">Actividades sin validar </label>
		<input type="hidden" name="actividades_link" value="{{ $actividades_link }}">
		<div class="input-group">
			{!! Form::text('busqueda',null,['class'=>'form-control','placeholder'=>'Buscar.....','aria-describedby'=>'search']) !!}
			<div class="input-group-btn">
				<button type="submit" class="btn btn-primary">
					<span class="badge  label label-primary glyphicon glyphicon-search">
					</span>
				</button>
			</div>
		</div>
	{!! Form::close() !!}
	
	{!! Form::open(['route' => 'verifica_evidencia.store','method' => 'POST']) !!}
		<input type="hidden" name="actividades_link" value="{{ $actividades_link }}">
		<br>
		<br>
		<div class="table-responsive">
			<table class="table" id="tabla_evidencia">
			   <thead class="thead-dark">
			       <th>Actividad</th>
			       <th>Validador</th>
			       <th>Responsable</th>
			       <th>Crédito</th>
			       <th>Evidencias</th>
			       <th>Validar</th>
			   </thead>
			   <tbody id="data-parent">
			   	@foreach ($evidencias_data as $evi)
			   		<tr class="oculta_validados">
			   			<td>{{ $evi->nombre }}</td>
			   			<td>{{ $evi->validador_nombre }}</td>
			   			<td>{{ $evi->name }}</td>
			   			<td>{{ $evi->nombre_credito }}</td>
			   			<td>
			   				<a href="{{ route('verifica_evidencia.ver_evidencia',$evi->actividad_evidencia_id)}}" class="btn btn-primary"><span class="glyphicon glyphicon-camera" aria-hidden="true"></span></a>
			   			</td>
			   			<td>
			   				<label>
			   					@if($evi->vigente=="false")
			   						Credito no Vigente
			   					@else
				   					@if (Auth::User()->hasAnyPermission(['VIP','VIP_EVIDENCIA']))
					   					@if($evi->validado=='false')
				   							<label class="control control--checkbox">
				   								<input type="checkbox" name="id_evidencias[]" value="{{ $evi->actividad_evidencia_id }}" class="validado">
				   								<div class="control__indicator"></div>
				   							</label>
					   					@else
					   						<label class="control control--checkbox">
					   							<input type="checkbox" name="id_evidencias[]" value="{{ $evi->actividad_evidencia_id }}" class="validado" checked disabled>
					   							<div class="control__indicator"></div>
					   						</label>
					   					@endif
					   				@elseif(Auth::User()->hasAnyPermission(['VIP_SOLO_LECTURA','VERIFICAR_EVIDENCIA']))
					   					@if (Auth::User()->can('VERIFICAR_EVIDENCIA') && $evi->validador_id==Auth::User()->id)
						   					@if($evi->validado=='false')
					   							<label class="control control--checkbox">
					   								<input type="checkbox" name="id_evidencias[]" value="{{ $evi->actividad_evidencia_id }}" class="validado">
					   								<div class="control__indicator"></div>
					   							</label>
						   					@else
						   						<label class="control control--checkbox">
						   							<input type="checkbox" name="id_evidencias[]" value="{{ $evi->actividad_evidencia_id }}" class="validado" checked disabled>
						   							<div class="control__indicator"></div>
						   						</label>
						   					@endif
						   				@else
						   					@if($evi->validado=='false')
					   							<label class="control control--checkbox">
					   								<input type="checkbox" name="id_evidencias[]" value="{{ $evi->actividad_evidencia_id }}" class="validado" disabled>
					   								<div class="control__indicator"></div>
					   							</label>
						   					@else
						   						<label class="control control--checkbox">
						   							<input type="checkbox" name="id_evidencias[]" value="{{ $evi->actividad_evidencia_id }}" class="validado" checked disabled>
						   							<div class="control__indicator"></div>
						   						</label>
						   					@endif
					   					@endif
				   					@endif
			   					@endif
			   				</label>
			   			</td>
			   		</tr>
			   	@endforeach
			   </tbody>
			</table>
		</div>
		@if (Auth::User()->hasAnyPermission(['VIP','VIP_EVIDENCIA','VERIFICAR_EVIDENCIA']))
			{!! Form::submit('Guardar',['class' => 'btn btn-primary','style' =>'margin-bottom:50px;']) !!}
		@endif
		
	{!! Form::close() !!}
	<div style="margin-bottom: 50px;"></div>
	{{ $evidencias_data->appends(['busqueda' => $busqueda,'validadas' => $validadas])->links() }}
	@section('js')
		<script>
			$('#checkbox5').click(function(){
				$('#actividades-submit').submit();
			});
		</script>
	@endsection
@endsection