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
	<div>
		<div class="input-group form-inline my-2 my-lg-0 mr-lg-2 pull-left" style="width: 250px;">
		    <!--Cargamos las actividades y sus ID's, valor seleccionado por defecto es id de la actividad
		        al que estan asignados los participantes -->
		    {!! Form::label('actividades_id','Actividad') !!}
		    {!! Form::select('actividades_id',$actividades,null,['class'=>'form-control','required','placeholder'=>'Seleccione una actividad','method'=>'GET']) !!}
		</div>
		<div class="input-group form-inline my-2 my-lg-0 mr-lg-2 pull-left" style="width: 250px; margin-left: 30px;">
		    <!--Cargamos las actividades y sus ID's, valor seleccionado por defecto es id de la actividad
		        al que estan asignados los participantes -->
		    {!! Form::label('responsables_id','Responsable') !!}
		    <select class="form-control" required method="GET" name="responsables_id" id="responsables_id">
		    	@if (Auth::User()->can('ADMIN'))
		    		<option value="nulo">Todos los responsables</option>
		    	@else
		    		<option value="{{ Auth::User()->id }}">{{ Auth::User()->name }}</option>
		    	@endif
		    </select>
		</div>
	</div>
	<div class="resetear"></div>
	<div id="mensaje-parte-superior" class="alerta-padding">
		
	</div>
	<div id="div-galeria">
		
	</div>
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
							var autenticacion = "{{ Auth::User()->can('VIP') }}"=="1"?true:false;
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
					var extension = archivo.substring(archivo.length-3).toLowerCase();
					if(extension == 'pdf'){
						var alumno_nombre = "NO";
						if(response[x]['alumno_nombre']!=null)alumno_nombre = response[x]['alumno_nombre'];
						$('#div-galeria').append("<div class='gallery'>"
						+"<a target='_blank' href='{{asset('storage/evidencias/')}}/"+response[x]['actividad_nombre']+"/"+archivo+"'>"
						+"<img src='{{asset('images/pdf_icono2.png')}}' width='300' heigth='200' class='imagenes'>"
							+"<a href='#' data-actividad='"+response[x]['actividad_nombre']+"' data-archivo='"+response[x]['evidencia_id']+"' data-archivo_nombre='"+archivo+"' class='eliminar-evidencia'>"
							+"<img src='{{ asset('images/eliminar_icono.png') }}' class='eliminar' width='40' heigth='40'>"
							+"</a>"
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
						$('#div-galeria').append("<div class='gallery'>"
						+"<a target='_blank' href='{{asset('storage/evidencias/')}}/"+response[x]['actividad_nombre']+"/"+archivo+"'>"
						+"<img src='{{asset('storage/evidencias/')}}/"+response[x]['actividad_nombre']+"/"+archivo+"' width='300' heigth='200' class='imagenes'>"
							+"<a href='#' data-actividad='"+response[x]['actividad_nombre']+"' data-archivo='"+response[x]['evidencia_id']+"' data-archivo_nombre='"+archivo+"' class='eliminar-evidencia'>"
							+"<img src='{{ asset('images/eliminar_icono.png') }}' class='eliminar' width='40' heigth='40'>"
							+"</a>"
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
								console.log("Error al eliminar la evidencia");
							}
						});
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