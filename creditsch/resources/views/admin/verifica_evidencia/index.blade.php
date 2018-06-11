@extends('template.molde')

@section('title','Verificar Evidencias')

@section('ruta')
    <label class="label label-success">Verificar Evidencias</label>
@endsection

@section('contenido')
	{!! Form::open(['route' => 'verifica_evidencia.store','method' => 'POST']) !!}
		<table class="table table-striped">
		    <!-- instancia al archivo table, dentro de este mismo direcctorio -->
		   <thead>
		       <th>Actividad</th>
		       <th>Responsable</th>
		       <th>Credito</th>
		       <th>Archivo</th>
		       <th>Descarga</th>
		       <th>Validar</th>
		   </thead>
		   <tbody>
		   	@foreach ($evidencias_data as $evi)
		   		<tr>
		   			<td>{{ $evi->nombre }}</td>
		   			<td>{{ $evi->name }}</td>
		   			<td>{{ $evi->nombre_credito }}</td>
		   			<td >
		   				<a href="verifica_evidencia/visualizar/{{$evi->nom_imagen}}">{{ $evi->nom_imagen }}</a>
		   			</td>
		   			<td>
		   				<a href="verifica_evidencia/descargar/{{$evi->nom_imagen}}">Descargar</a>
		   			</td>
		   			<td>
		   				<label>
		   					<input type="hidden" name="id_creditos[]" value="{{ $evi->id_credito }}">
		   					<input type="hidden" name="array_de_ids[]" value="{{ $evi->id }}">
		   					<input type="hidden" name="por_cred_actividades[]" value="{{ $evi->por_cred_actividad}} ">
		   					@if($evi->status==0)
		   						<input type="checkbox" name="id_evidencias[]" value="{{ $evi->id}}">
		   					@else
		   						<input type="checkbox" name="id_evidencias[]" value="{{ $evi->id }}" checked>
		   					@endif
		   				</label>
		   			</td>
		   		</tr>
		   	@endforeach
		   </tbody>
		</table>
		{!! Form::submit('Guardar',['class' => 'btn btn-primary','style' =>'margin-bottom:50px;']) !!}
	{!! Form::close() !!}
@endsection