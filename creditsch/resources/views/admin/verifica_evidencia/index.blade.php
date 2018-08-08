@extends('template.molde')

@section('title','Verificar Evidencias')

@section('links')
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/checkboxcss/checkbox.css') }}">
@endsection
@section('ruta')
    <label class="label label-success">Verificar Evidencias</label>
@endsection

@section('contenido')
	{!! Form::open(['route' => 'verifica_evidencia.store','method' => 'POST']) !!}
		<table class="table table-striped" id="tabla_evidencia">
		   <thead>
		       <th>Actividad</th>
		       <th>Validador</th>
		       <th>Responsable</th>
		       <th>Credito</th>
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
		   					@if (Auth::User()->hasAnyPermission(['VIP','VIP_EVIDENCIA']))
			   					@if($evi->validado=='false')
		   							<label class="control control--checkbox">
		   								<input type="checkbox"type="checkbox" name="id_evidencias[]" value="{{ $evi->actividad_evidencia_id }}" class="validado">
		   								<div class="control__indicator"></div>
		   							</label>
			   					@else
			   						<label class="control control--checkbox">
			   							<input type="checkbox"type="checkbox" name="id_evidencias[]" value="{{ $evi->actividad_evidencia_id }}" class="validado" checked disabled>
			   							<div class="control__indicator"></div>
			   						</label>
			   					@endif
			   				@elseif(Auth::User()->hasAnyPermission(['VIP_SOLO_LECTURA','VERIFICAR_EVIDENCIA']))
			   					@if (Auth::User()->can('VERIFICAR_EVIDENCIA') && $evi->validador_id==Auth::User()->id)
				   					@if($evi->validado=='false')
			   							<label class="control control--checkbox">
			   								<input type="checkbox"type="checkbox" name="id_evidencias[]" value="{{ $evi->actividad_evidencia_id }}" class="validado">
			   								<div class="control__indicator"></div>
			   							</label>
				   					@else
				   						<label class="control control--checkbox">
				   							<input type="checkbox"type="checkbox" name="id_evidencias[]" value="{{ $evi->actividad_evidencia_id }}" class="validado" checked disabled>
				   							<div class="control__indicator"></div>
				   						</label>
				   					@endif
				   				@else
				   					@if($evi->validado=='false')
			   							<label class="control control--checkbox">
			   								<input type="checkbox"type="checkbox" name="id_evidencias[]" value="{{ $evi->actividad_evidencia_id }}" class="validado" disabled>
			   								<div class="control__indicator"></div>
			   							</label>
				   					@else
				   						<label class="control control--checkbox">
				   							<input type="checkbox"type="checkbox" name="id_evidencias[]" value="{{ $evi->actividad_evidencia_id }}" class="validado" checked disabled>
				   							<div class="control__indicator"></div>
				   						</label>
				   					@endif
			   					@endif
		   					@endif
		   				</label>
		   			</td>
		   		</tr>
		   	@endforeach
		   	
		   </tbody>
		</table>
		@if (Auth::User()->hasAnyPermission(['VIP','VIP_EVIDENCIA','VERIFICAR_EVIDENCIA']))
			{!! Form::submit('Guardar',['class' => 'btn btn-primary','style' =>'margin-bottom:50px;']) !!}
		@endif
		
	{!! Form::close() !!}
	<div style="margin-bottom: 50px;"></div>
	@section('js')
		<script type="text/javascript">
			$(document).ready(function() {
			    $('#tabla_evidencia').DataTable({
			        "pagingType": "full_numbers"
			    });
			} );
		</script>
	@endsection
@endsection