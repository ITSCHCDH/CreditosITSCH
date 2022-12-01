@extends('template.molde')

@section('title','Areas')
@section('ruta')
	<h5>Areas</h5> 
@endsection

@section('contenido')
	@if(Auth::User()->hasAnyPermission(['VIP','CREAR_AREAS']))
	<div class="row">
		<div class="col"></div>
		<div class="col"></div>
		<div class="col text-right">
			<a href="{{ route('areas.crear') }}"  title="Nueva área">
				<i class="fas fa-plus fa-3x"></i>			
			</a>
		</div>
	</div>
		
	@endif
	<br>
	<table class="table" id="tabAreas">
	    <thead>
	    <th>ID</th>
	    <th>Nombre</th>
	    <th>Tipo</th>
	    <th>Acción</th>
	    </thead>
	    <tbody>
	    	@foreach($areas as $area)
	    		<tr>
	    			<td>{{ $area->id }}</td>
	    			<td>{{ $area->nombre }}</td>
	    			<td>{{ $area->tipo }}</td>
	    			<td>
	    				<a href="{{ route('areas.usuarios',$area->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-user-plus"></i></a>
	    				@if(Auth::User()->hasAnyPermission(['VIP','MODIFICAR_AREAS']))
	    					<a href="{{ route('areas.editar',$area->id) }}" class="btn btn-warning btn-sm"><i class="far fa-edit"></i></a>
	    				@endif
	    				@if(Auth::User()->hasAnyPermission(['VIP','ELIMINAR_AREAS']))
	    					<a type="button" data-toggle="modal" data-target="#modalBaja" onclick="ruta({{ $area->id }})" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
	    				@endif
	    			</td>
	    		</tr>
	    	@endforeach
	    </tbody>
	</table>
	 

	<!-- The Modal -->
	<div class="modal" id="modalBaja">
		<div class="modal-dialog">
		<div class="modal-content">
	
			<!-- Modal Header -->
			<div class="modal-header">
			<h4 class="modal-title">Eliminación de área</h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
	
			<!-- Modal body -->
			<div class="modal-body">
				Estas seguro de eliminar esta área
			</div>
	
			<!-- Modal footer -->
			<div class="modal-footer">
				<a type="button" class="btn btn-success" id="eliminar">Eliminar</a>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
			</div>
	
		</div>
		</div>
	</div>


	@section('js')
		<script type="text/javascript">
			function ruta(id)
			{
				$('#eliminar').attr('href','{{ url('') }}/admin/areas/'+id+'/eliminar');
			}
			
			//Codigo para adornar las tablas con datatables
			$(document).ready(function() {
				$('#tabAreas').DataTable({

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
