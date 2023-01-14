@extends('template.molde')

@section('title','Actividades')

@section('ruta')
	<a href="{{ route('alumnos.avance') }}" class="label label-info">Créditos</a>
	/
	<label class="label label-success">Actividades</label>
@endsection

@section('contenido')
	<div class="table-responsive">
		<table class="table table-striped" id="tabActividadesAlu">
			<thead>
				<th>Nombre</th>
				<th>Crédito</th>
				<th>Porcentaje</th>
				<th>Validado</th>
				<th>Acción</th>
			</thead>
			<tbody>
					@foreach($actividades as $actividad)
						@php
							$falta_evidencia = false;
						@endphp
						<tr>
							<td>{{ $actividad->actividad_nombre }}</td>
							<td>{{ $actividad->credito_nombre }}</td>
							<td>{{ $actividad->actividad_porcentaje }}%</td>
							<td>
								@if ($actividad->validado == "true")
									@if (( $actividad->alumnos == "true" && $actividad->momento_agregado == "posteriormente" && $actividad->evidencia_validada == "si") || ($actividad->momento_agregado == "anteriormente"))
										{{ "SI" }}
									@else
										@php
											$falta_evidencia = true;
										@endphp
										{{ "NO" }}
									@endif
								@else
									{{ "NO" }}
								@endif
							</td>
							<td>
								@if ($actividad->alumnos == "true")
									@if ($actividad->validado == "false" || $falta_evidencia)										
										<a href="{{ route('alumnos.subir_evidencia',['id_responsable' => $actividad->user_id,'id_actividad' => $actividad->actividad_id]) }}" class="btn btn-primary" title="Subir evidencias"><i class="fas fa-cloud-upload-alt"></i></a>																					
									@endif									
										<a href="{{ route('alumnos.evidencia',['actividad_id' => $actividad->actividad_id,'user_id' => $actividad->user_id]) }}" class="btn btn-warning" title="Ver evidencias subidas"><i class="far fa-eye"></i></a>																			
								@else
									NINGUNA
								@endif
							</td>
						</tr>
					@endforeach
			</tbody>
		</table>
	</div>
	@section('js')
		<script>
			 //Codigo para adornar las tablas con datatables
			 $(document).ready(function() {
                $('#tabActividadesAlu').DataTable({

                    dom: 'Bfrtip',

                    responsive: {
                        breakpoints: [
                        {name: 'bigdesktop', width: Infinity},
                        {name: 'meddesktop', width: 1366},
                        {name: 'smalldesktop', width: 1280},
                        {name: 'medium', width: 1188},
                        {name: 'tabletl', width: 1024},
                        {name: 'btwtabllandp', width: 848},
                        {name: 'tabletp', width: 768},
                        {name: 'mobilel', width: 600},
                        {name: 'mobilep', width: 320}
                        ]
                    },

                    lengthMenu: [
                        [ 5, 10, 25, 50, -1 ],
                        [ '5 reg', '10 reg', '25 reg', '50 reg', 'Ver todo' ]
                    ],

                    buttons: [
                        {extend: 'collection', text: 'Exportar',
                            buttons: [
                                { extend: 'copyHtml5', text: 'Copiar' },
                                'excelHtml5',
                                'pdfHtml5',
                                { extend: 'print', text: 'Imprimir' },
                            ]},
                        { extend: 'colvis', text: 'Columnas visibles' },
                        { extend:'pageLength',text:'Ver registros'},
                    ],
                    language: {
                        url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                    },
                   
                });
            });
		</script>
	@endsection
@endsection