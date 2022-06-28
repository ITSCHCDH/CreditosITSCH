@extends('template.molde')

@section('title','Evidencias')

@section('ruta')
	@if ($ruta)
		<a href="{{ route('participantes.index') }}">Participantes</a>
		/
		<label class="label label-success"> Evidencias</label>
	@else
		<label class="label label-success"> Evidencias</label>
	@endif
@endsection

@section('links')
	<link rel="stylesheet" type="text/css" href="{{ asset('cssGaleria/galeria.css') }}">
	<script type="text/javascript" src="{{ asset('plugins/jsCookie/js.cookie.js') }}"></script>
@endsection

@section('contenido')
	<div class="row">
		<div class="col-sm-6" >
		    <!--Cargamos las actividades y sus ID's, valor seleccionado por defecto es id de la actividad
		        al que estan asignados los participantes -->
			<label for="actividades_id">Actividad</label>
			<select name="actividades_id" id="actividades_id" class="form-control select-input placeholder-active active" required>
				<option value="" selected>Seleccione una actividad</option>
				@foreach ($actividades as $act)
					<option value="{{ $act->id }}">{{ $act->nombre }}</option>
				@endforeach
			</select>	   
		</div>
		<div class="col-sm-6">
		    <!--Cargamos las actividades y sus ID's, valor seleccionado por defecto es id de la actividad
		        al que estan asignados los participantes -->
			<label for="responsables_id">Responsable</label>		   
		    <select class="form-control" required method="GET" name="responsables_id" id="responsables_id">
		    	@if (Auth::User()->can('VIP') || Auth::User()->can('VIP_SOLO_LECTURA') || Auth::User()->can('VIP_EVIDENCIA'))
		    		<option value="nulo">Todos los responsables</option>
		    	@else
		    		<option value="{{ Auth::User()->id }}">{{ Auth::User()->name }}</option>
		    	@endif
		    </select>
		</div>
	</div>
	<div class="resetear"></div>
	<div id="mensaje-parte-superior" class="alerta-padding"></div>
	<hr>	
	<div id="div-galeria" class="row"></div>
	
	<div class="resetear" style="padding: 30px;"></div>
	@section('js')
		<script type="text/javascript">
			function comboResponsables(){
				$('#actividades_id').change(function(event){
					event.preventDefault();
					var actividad_id = $(this).val();
					Cookies.set('evidencia_actividad',actividad_id,{ expires:1});
					var todos = true;
					$.ajax({
						type:'GET',
						dataType: 'json',
						url:'{{ route('evidencias.peticion') }}',
						data:{
							id: actividad_id
						},
						success: function(response){
							$('#responsables_id').empty();
							var autenticacion = "{{ Auth::User()->can('VIP') || Auth::User()->can('VIP_SOLO_LECTURA') || Auth::User()->can('VIP_EVIDENCIA') }}"=="1"?true:false;
							if (autenticacion) {
								$('#responsables_id').append("<option value='nulo' selected>Todos los responsables</option>");
							}
							for(var x=0; x<response.length; x++){
								$('#responsables_id').append("<option value="+response[x]['id']+">"+response[x]['name']+"</option>");
							}
							var cookie_responsable = Cookies.get('evidencia_responsable');
							if($("#responsables_id option[value='"+cookie_responsable+"']").length!=0 && cookie_responsable!=null){
								todos= false;
								$('#responsables_id').val(cookie_responsable);
								$('#responsables_id').trigger('change');
							}
						},error:function(){
							console.log('Error!!!! :(');
						}
					});
					var myNode = document.getElementById("div-galeria");
					while (myNode.firstChild) {
					    myNode.removeChild(myNode.firstChild);
					}
					if(actividad_id.length>0 && todos){
						var actividad_id = $('#actividades_id').val();
						var responsable_id = $('#responsables_id').val();
						$.ajax({
							type:'GET',
							dataType:'json',
							url:'{{ route('evidencias.galeria') }}',
							data:{
								responsable_id: responsable_id,
								actividad_id: actividad_id
							},
							success: function(response){
								agregaEvidencias(response);
							},error: function(){
								console.log('Error :(');
							}
						});
					}
				});
			}
			function agregaEvidencias(response){
				for(var x=0; x<response.length; x++){
					var archivo = response[x]['nom_imagen'].toString();
					var extension = archivo.substring(archivo.length-4).toLowerCase();
					var eliminar_evidencia = "";
					var admin = "{{ Auth::User()->can('VIP')}}"=="1"? true: false;
					var admin_evidencia = "{{ Auth::User()->can('VIP_EVIDENCIA') }}"=="1"? true: false;
					var permiso_eliminar = "{{ Auth::User()->can('ELIMINAR_EVIDENCIA') }}"=="1"? true: false;
					if(admin || admin_evidencia){
						eliminar_evidencia = "<a href='#' data-actividad='"+response[x]['actividad_nombre']+"' data-archivo='"+response[x]['evidencia_id']+"' data-validado = '"+response[x]['validado']+"'data-archivo_nombre='"+archivo+"' class='eliminar-evidencia'>"
							+"<img src='{{ asset('images/eliminar_icono.png') }}' class='eliminar' width='40' heigth='40'>"
							+"</a>";
					}else if(permiso_eliminar && response[x]['validado']=="false"){
						if(response[x]['user_id']=="{{ Auth::User()->id }}"){
							eliminar_evidencia = "<a href='#' data-actividad='"+response[x]['actividad_nombre']+"' data-archivo='"+response[x]['evidencia_id']+"' data-validado = '"+response[x]['validado']+"'data-archivo_nombre='"+archivo+"' class='eliminar-evidencia'>"
								+"<img src='{{ asset('images/eliminar_icono.png') }}' class='eliminar' width='40' heigth='40'>"
								+"</a>";
						}
					}
					if(extension == '.pdf'){
						var alumno_nombre = "NO";
						if(response[x]['alumno_nombre']!=null)alumno_nombre = response[x]['alumno_nombre'];
						$('#div-galeria').append("<div class='col-sm-3'>"
						+"<a target='_blank' href='{{asset('storage/evidencias/')}}/"+response[x]['actividad_nombre']+"/"+archivo+"'>"
						+"<img src='{{asset('images/pdf_icono2.png')}}' width='100' heigth='120' class='imagenes'>"
							+eliminar_evidencia
						+"</a>"
						+"<div class='desc'>"
						+"<p><strong>Actividad: </strong>"+response[x]['actividad_nombre']+"</p>"
						+"<p><strong>Responsable: </strong>"+response[x]['responsable_nombre']+"</p>"
						+"<p><strong>Alumno: </strong>"+alumno_nombre+"</p>"
						+"<p><strong>Fecha: </strong>"+response[x]['created_at']+"</p>"
						+"</div>"
						+"</div>");
					}else{
						var alumno_nombre = "NO";
						if(response[x]['alumno_nombre']!=null)alumno_nombre = response[x]['alumno_nombre'];
						$('#div-galeria').append("<div class='col-sm-3'>"
						+"<a target='_blank' href='{{asset('storage/evidencias/')}}/"+response[x]['actividad_nombre']+"/"+archivo+"'>"
						+"<img src='{{asset('storage/evidencias/')}}/"+response[x]['actividad_nombre']+"/"+archivo+"' width='300' heigth='200' class='imagenes'>"
							+eliminar_evidencia
						+"</a>"
						+"<div class='desc'>"
						+"<p><strong>Actividad: </strong>"+response[x]['actividad_nombre']+"</p>"
						+"<p><strong>Responsable: </strong>"+response[x]['responsable_nombre']+"</p>"
						+"<p><strong>Alumno: </strong>"+alumno_nombre+"</p>"
						+"<p><strong>Fecha: </strong>"+response[x]['created_at']+"</p>"
						+"</div>"
						+"</div>");
					}
				}
			}
			function peticionGaleria(){
				$('#responsables_id').change(function(event){
					event.preventDefault();
					var actividad_id = $('#actividades_id').val();
					var responsable_id = $('#responsables_id').val();
					Cookies.set('evidencia_responsable',responsable_id,{ expires: 1});
					$.ajax({
						type:'GET',
						dataType:'json',
						url:'{{ route('evidencias.galeria') }}',
						data:{
							responsable_id: responsable_id,
							actividad_id: actividad_id
						},
						success: function(response){
							var myNode = document.getElementById("div-galeria");
							while (myNode.firstChild) {
							    myNode.removeChild(myNode.firstChild);
							}
							agregaEvidencias(response);
						},error: function(){
							console.log('Error :(');
						}
					});
				});
			}
			function elhover(){
				$(document).on('mouseover','.gallery' ,function(event){
					$(this).find('img.eliminar').css('visibility','visible');
				});
				$(document).on('mouseout','.gallery' ,function(event){
					$(this).find('img.eliminar').css('visibility','hidden');
				});
			}
			function cookiesEvidencia(){
				var actividad_id = Cookies.get('evidencia_actividad');
				if($("#actividades_id option[value='"+actividad_id+"']").length!=0 && actividad_id!=null){
					$('#actividades_id').val(actividad_id);
					$('#actividades_id').trigger('change');
				}
			} 
			function eliminarEvidencia(){
				$(document).on('click','.eliminar-evidencia',function(event){
					event.preventDefault();
					var confirmacion = confirm("¿Estas seguro que deseas eliminar esta evidencia?");
					if(confirmacion){
						var actividad = $(this).attr('data-actividad');
						var archivo_id = $(this).attr('data-archivo');
						var archivo_nombre = $(this).attr('data-archivo_nombre');
						var validado_msj = $(this).attr('data-validado');
						var validado = true;
						if(validado_msj=="true"){
							validado = confirm("La evidencia se encuentra actualmente validada,¿Seguro que deseas continuar?");
						}
						if(validado){
							$.ajax({
								type: "get",
								dataType: "json",
								url: "{{ route('evidencias.eliminar') }}",
								data:{
									actividad: actividad,
									archivo: archivo_id,
									archivo_nombre: archivo_nombre
								}, 
								success: function(response){
									mostrarMensaje(response['mensaje'],'mensaje-parte-superior',response['tipo']);
									$('#responsables_id').trigger('change');
								}, error: function(){
									mostrarMensaje("Error al eliminar la evidencia",'mensaje-parte-superior','error');
								}
							});
						}
					}
				});
			}
			$(document).ready(function(event){
				comboResponsables();
				peticionGaleria();
				elhover();
				cookiesEvidencia();
				eliminarEvidencia();
			});
		</script>
	@endsection
@endsection