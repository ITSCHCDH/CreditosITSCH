@extends('template.molde')

@section('title','Evidencias')

@section('ruta')
    <label class="label label-success"> Evidencias</label>
@endsection

@section('contenido')
	<style>
	div.gallery {
	    margin: 5px;
	    border: 1px solid #ccc;
	    float: left;
	    width: 250px;
	    heigth: 200px;
	}

	div.gallery:hover {
	    border: 1px solid #777;
	}

	div.gallery img {
	    width: 100%;
	    height: auto;
	    height: 250px;
	}

	div.desc {
	    padding: 7px;
	    text-align: left;
	}
	</style>

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
		    	<option value="nulo">Todos los responsables</option>
		    </select>
		</div>
	</div>
	<div class="resetear" style="margin-bottom: 35px;"></div>
	<div id="div-galeria">
		
	</div>
	<div class="resetear" style="padding: 30px;"></div>
	@section('js')
		<script type="text/javascript">
			function comboResponsables(){
				$('#actividades_id').change(function(event){
					event.preventDefault();
					var actividad_id = $(this).val();
					$.ajax({
						type:'GET',
						dataType: 'json',
						url:'{{ route('evidencias.peticion') }}',
						data:{
							id: actividad_id
						},
						success: function(response){
							$('#responsables_id').empty();
							$('#responsables_id').append("<option value='nulo' selected>Todos los responsables</option>");
							for(var x=0; x<response.length; x++){
								$('#responsables_id').append("<option value="+response[x]['id']+">"+response[x]['name']+"</option>");
							}
						},error:function(){
							console.log('Error!!!! :(');
						}
					});
					var myNode = document.getElementById("div-galeria");
					while (myNode.firstChild) {
					    myNode.removeChild(myNode.firstChild);
					}
					if(actividad_id.length>0){
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
						$('#div-galeria').append("<div class='gallery'>"
						+"<a target='_blank' href='{{asset('images/evidencias/')}}/"+archivo+"'>"
						+"<img src='{{asset('images/pdf_icono2.png')}}' width='300' heigth='200' class='imagenes'>"
						+"</a>"
						+"<div class='desc'>"
						+"<p><strong>Actividad: </strong>"+response[x]['actividad_nombre']+"</p>"
						+"<p><strong>Responsable: </strong>"+response[x]['responsable_nombre']+"</p>"
						+"<p><strong>Fecha: </strong>"+response[x]['created_at']+"</p>"
						+"</div>"
						+"</div>");
					}else{
						$('#div-galeria').append("<div class='gallery'>"
						+"<a target='_blank' href='{{asset('images/evidencias/')}}/"+archivo+"'>"
						+"<img src='{{asset('images/evidencias/')}}/"+archivo+"' width='300' heigth='200' class='imagenes'>"
						+"</a>"
						+"<div class='desc'>"
						+"<p><strong>Actividad: </strong>"+response[x]['actividad_nombre']+"</p>"
						+"<p><strong>Responsable: </strong>"+response[x]['responsable_nombre']+"</p>"
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
			$(document).ready(function(event){
				comboResponsables();
				peticionGaleria();
			});
		</script>
	@endsection
@endsection