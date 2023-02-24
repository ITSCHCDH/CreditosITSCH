@extends('template.molde')

@section('title','Asignar Permisos')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/checkboxcss/checkbox.css') }}">
@endsection
@section('ruta')
	<a href="{{route('roles.index')}}">Roles </a>
	/
    <label class="label label-success"> Asignar Permisos</label>
@endsection

@section('contenido')
		@if ($role!=null)
			<h4>Rol: {{ "$role->name" }}</h4>			
			<br>
			<div class="resetear" style="padding: 5px;"></div>
			<input type="hidden" name="role_id" value="{{ $role->id }}" id="role_id">
		@endif
		
		<table class="table table-striped table-bordered" id="tabla_permisos">
		    <!-- instancia al archivo table, dentro de este mismo direcctorio -->
		   <thead>
		       <th>ID</th>
		       <th>Nombre</th>
		       <th>Asignado</th>
		       <th>Asignar</th>
		   </thead>
		   <tbody>
		   	@if ($permisos!=null && $role!=null)
		   		@foreach ($permisos as $per)
			   		<tr>
			   			<td>{{ $per->id }}</td>
			   			<td>{{ $per->name }}</td>
			   			<td>
			   				@if ($per->role_id!=null)
			   					{{ "SI"}}
			   				@else
			   					{{ "NO" }}	
			   				@endif
			   			</td>
			   			<td>
			   				@if ($per->role_id!=null)
			   					<label class="control control--checkbox">
			   						<input type="checkbox" name="permisos_id[]" value="{{ $per->id}}" class="permisos_asignados" id="c{{ $per->id }}" checked>
			   						<div class="control__indicator"></div>
			   					</label>
			   				@else
			   					<label class="control control--checkbox">
			   						<input type="checkbox" name="permisos_id[]" value="{{ $per->id}}" class="permisos_asignados" id="c{{ $per->id }}" >
			   						<div class="control__indicator" style=""></div>
			   					</label>		
			   				@endif
			   			</td>
			   		</tr>
			   	@endforeach
		   	@endif
		   </tbody>
		</table>
		<hr>
		<a href="#" id="permisos-submit" class="btn btn-primary">Agregar</a>
		<div style="margin-bottom: 50px;"></div>
		@section('js')

			<script type="text/javascript">
				$.ajaxSetup( {
				    headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				    }
				} );
				var permisos_id = [];
				function inicializarArreglo(){
					var lista_permisos_ya_asignados = document.getElementsByClassName('permisos_asignados');
					for (var i = 0; i < lista_permisos_ya_asignados.length; i++) {
						if(lista_permisos_ya_asignados[i].checked){
							permisos_id.push(lista_permisos_ya_asignados[i].value);
						}
					}
				}
				function agregarPermisosArreglo(){
					$(document).on('click','.permisos_asignados',function(event){
						var checkbox_id = $(this).attr('id');
						var checkbox = document.getElementById(checkbox_id);
						if(checkbox.checked){
							permisos_id.push($(this).attr('value'));
						}else{
							for (var i = 0; i < permisos_id.length; i++) {
								if(permisos_id[i]==$(this).attr('value')){
									permisos_id.splice(i,1);
									break;
								}
							}
						}
					});
				}
				function agregarPermisosAjax(){
					$('#permisos-submit').click(function(event){
						event.preventDefault();
						role_id = $('#role_id').attr('value');
						$.ajax({
							type: "post",
							dataType: "json",
							url:"{{ url('admin/roles_permisos/role_asignar_permiso') }}",
							data:{
								permisos_id:permisos_id,
								role_id:role_id
							},
							success: function(response){
								location.href = "{{ route('roles.index') }}";
							},error: function(e){
								console.log('Error a agregar permisos',e);
							}
						});
					});					
				}
				$(document).ready(function(){
					inicializarArreglo();
					$('#tabla_permisos').DataTable({
						"pagingType":"full_numbers"
					});
					
					agregarPermisosArreglo();
					agregarPermisosAjax();
				});
			</script>
		@endsection
@endsection