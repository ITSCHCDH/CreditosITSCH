@extends('template.molde')
@section('title','Usuarios')
@section('ruta')
	<label class="label label-success">Usuarios</label>
@endsection
@section('contenido')
	@if (Auth::User()->hasAnyPermission(['VIP','CREAR_USUARIOS']))
		<div style="text-align: right;"> 			
			<a title="Agregar usuario" href="{{ route('usuarios.create')}}" class="btn btn-info btn-sm" ><i class="fas fa-user-plus"></i></a>        	       	
		</div>			
	@endif
	<br>
	<div class="table-responsive">
		<table class="table" id="tabUsuarios">
			<thead>
				<th>Numero</th>
				<th>Nombre</th>
				<th>Area</th>
				<th>Correo</th>
				<th>Activo</th>
				@if (Auth::User()->hasAnyPermission(['VIP','ASIGNAR_REMOVER_ROLES_USUARIOS','MODIFICAR_USUARIOS','ELIMINAR_USUARIOS']))
				<th>Acción</th>
				@endif
			</thead>
			<tbody>
			@foreach ($users as $user)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ strtoupper($user->name)  }}</td>
					<td style="overflow:hidden;">{{ $user->area }}</td>
					<td>{{ $user->email }}</td>
					@if ($user->active=='true')
						<td>SI</td>
					@else
						<td>NO</td>
					@endif
					<td>
						@if (Auth::User()->hasAnyPermission(['VIP','MODIFICAR_USUARIOS']))							
							<a href="{{ route('usuarios.edit',$user->id) }}" class="btn btn-warning btn-sm" title="Modificar usuario"><i class="fas fa-user-edit"></i></i></a>							
						@endif
						@if (Auth::User()->hasAnyPermission(['VIP','ELIMINAR_USUARIOS']))							
							<a title="Eliminar usuario" href="{{ route('usuarios.destroy',$user->id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger btn-sm"><i class="fas fa-user-minus"></i></a>							
						@endif
						@if (Auth::User()->hasAnyPermission(['VIP','ASIGNAR_REMOVER_ROLES_USUARIOS']))
							
								<a href="{{ route('usuarios.asignar_roles',$user->id) }}" class="btn btn-info btn-sm"  title="Asignar permisos">
									<i class="fas fa-users-cog"></i>	   							
								</a>
							
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
                $('#tabUsuarios').DataTable({

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