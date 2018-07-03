@extends('template.molde')

@section('title','Verificar Evidencias')

@section('ruta')
    <label class="label label-success">Verificar Evidencias</label>
@endsection

@section('contenido')
	{!! Form::open(['route' => 'verifica_evidencia.store','method' => 'POST']) !!}
		<table class="table table-striped" id="tabla_evidencia">
		    <!-- instancia al archivo table, dentro de este mismo direcctorio -->
		   <thead>
		       <th>Actividad</th>
		       <th>Responsable</th>
		       <th>Credito</th>
		       <th>Evidencias</th>
		       <th>Descarga</th>
		       <th>Validar</th>
		   </thead>
		   <tbody>
		   	@foreach ($evidencias_data as $evi)
		   		<tr class="oculta_validados">
		   			<td>{{ $evi->nombre }}</td>
		   			<td>{{ $evi->name }}</td>
		   			<td>{{ $evi->nombre_credito }}</td>
		   			<td>
		   				<a href="{{ route('verifica_evidencia.ver_evidencia',$evi->actividad_evidencia_id)}}">Ver evidencias</a>
		   			</td>
		   			<td>
		   				<a href="verifica_evidencia/descargar/{{$evi->nom_imagen}}">Descargar</a>
		   			</td>
		   			<td>
		   				<label>
		   					<input type="hidden" name="id_creditos[]" value="{{ $evi->id_credito }}">
		   					<input type="hidden" name="array_de_ids[]" value="{{ $evi->actividad_evidencia_id }}">
		   					<input type="hidden" name="por_cred_actividades[]" value="{{ $evi->por_cred_actividad }}">
		   					@if($evi->status==0)
		   						<input type="checkbox" name="id_evidencias[]" value="{{ $evi->actividad_evidencia_id }}" class="validado">
		   					@else
		   						<input type="checkbox" name="id_evidencias[]" value="{{ $evi->actividad_evidencia_id }}" class="validado" checked>
		   					@endif
		   				</label>
		   			</td>
		   		</tr>
		   	@endforeach
		   </tbody>
		</table>
		{!! Form::submit('Guardar',['class' => 'btn btn-primary','style' =>'margin-bottom:50px;']) !!}
	{!! Form::close() !!}
	@section('js')
		<script type="text/javascript">
			
			$(document).ready(function() {
			    $('#tabla_evidencia').DataTable( {
			        "pagingType": "full_numbers"
			    } );
			} );
		</script>
	@endsection
@endsection