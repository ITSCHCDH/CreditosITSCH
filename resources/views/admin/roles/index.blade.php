@extends('template.molde')

@section('title','Roles')

@section('ruta')
    <label class="label label-success">Roles</label>
@endsection

@section('contenido')
	@if (Auth::User()->hasAnyPermission(['VIP','CREAR_ROLES']))
	<div class="row">
		<div class="col"></div>
		<div class="col"></div>
		<div class="col text-right">
			<a href="{{ route('roles.roles_crear')}}" class="btn btn-success btn-sm" title="Crear rol"><i class="far fa-address-card"></i></a>
		</div>
	</div>
		
	@endif
	<br>
	<div class="table-resposive">
		<table class="table" id="tabla_roles">
			<thead class="thead-dark">
				<th>ID</th>
				<th>Nombre</th>
				<th>Ver permisos</th>
				@if (Auth::User()->hasAnyPermission(['VIP','ASIGNAR_REMOVER_PERMISOS_A_ROLES']))
						<th>Asignar/Revocar Permisos</th>
				@endif
				<th>Acción</th>
			</thead>
			<tbody>
				@foreach ($roles as $rol)
					<tr>
						<td>{{ $rol->id }}</td>
						<td>{{ $rol->name }}</td>
						<td>
							<a href="{{ route('roles.role_ver_permisos',$rol->id) }}">Ver</a>
						</td>
						@if (Auth::User()->hasAnyPermission(['VIP','ASIGNAR_REMOVER_PERMISOS_A_ROLES']))
							<td>
								<a href="{{ route('roles.roles_asignar_permisos_vista',$rol->id) }}">Asignar/Revocar</a>
							</td>
						@endif
						<td>
							@if (Auth::User()->hasAnyPermission(['VIP','VER_ROLES_USUARIOS']))
								<a href="{{ route('roles.usuarios',$rol->id) }}" class="btn btn-primary"><i class="fas fa-user-tie"></i></a>
							@endif
							@if (Auth::User()->hasAnyPermission(['VIP','MODIFICAR_ROLES']))
								<a href="{{ route('roles.role_editar',[$rol->id]) }}" class="btn btn-warning"><i class="far fa-edit"></i></a>	
							@endif
							@if (Auth::User()->hasAnyPermission(['VIP','ELIMINAR_ROLES']))
								<a href="{{ route('roles.role_eliminar',$rol->id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		 </table>
	</div>
	
	<div style="margin-bottom: 200px;"></div>
	@section('js')
		<script>
			 //Codigo para adornar las tablas con datatables
             $(document).ready(function() {
                $('#tabla_roles').DataTable({

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