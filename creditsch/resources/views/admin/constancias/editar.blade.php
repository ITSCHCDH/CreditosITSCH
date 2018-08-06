@extends('template.molde')

@section('title','Constancias')
@section('links')
	<script type="text/javascript" src="{{ asset('plugins/jsCookie/js.cookie.js') }}"></script>
@endsection
@section('ruta')
	<label class="label label-success">Datos de Constancia</label>
@endsection

@section('contenido')
	<input type="hidden" name="" id="variable-ocultar" value="@if ($datos_globales->count()==0)
		{{ 0 }}
	@else
		{{ 1 }}
	@endif">
	@if ($datos_globales->count()==0)
		<div class="alert-warning alerta-padding" id="mensaje-agregar-datos">
			<strong>Atención!!!</strong>
			Debe proporcionar los datos globales de la constancia antes de crear o editar constancias
		</div>
	@endif
	<div id ="mensajes-parte-superior">
		
	</div>
	<h3>Datos globales de la constancia</h3>
	<form id="form-datos-globales" method="POST">
		<input type="hidden" value="{{ csrf_token() }}" id="token"> 
		<div class="form-group">
			<label for ="enunciado_superior">Enunciado superior</label>
			@if ($datos_globales->count()>0)
				<textarea class="form-control" name="enunciado_superior" id = "enunciado_superior" placeholder="Enunciado que aparece en la parte superior (escribirlo sin comillas). Si no sabes cual es, se agregará por defecto el siguiente:&#10;&#13;&quot;Año del Centenario de la Promulgación de la Constitución Política de los Estados Unidos Mexicanos&quot;">{{ $datos_globales[0]->enunciado_superior }}</textarea>
			@else
				<textarea class="form-control" name="enunciado_superior" id = "enunciado_superior" placeholder="Enunciado que aparece en la parte superior (escribirlo sin comillas). Si no sabes cual es, se agregará por defecto el siguiente:&#10;&#13;&quot;Año del Centenario de la Promulgación de la Constitución Política de los Estados Unidos Mexicanos&quot;"></textarea>
			@endif
			
		</div>
		<div class="form-group">
			<label for ="institucion_info">Datos acerca de la institución</label>
			<textarea class="form-control" name="institucion_info" id = "institucion_info" placeholder="Especificar la información de la institución, tales datos como: dirección, contacto, municipio, Codigo Postal, Teléfono, etc... (max 255 caracteres). En caso de no contar con estos datos en el momento se agregará el predefinodo por este sitio.">@if ($datos_globales->count()>0){{ $datos_globales[0]->institucion_info  }}@endif</textarea>
		</div>
		<div class="form-group">
			<label for ="plan_de_estudios">Plan de estudios</label>
			@if ($datos_globales->count()>0)
				<input type="text" name="plan_de_estudios" id="plan_de_estudios" class="form-control" placeholder="Dejar en blanco este campo agregará el siguiente plan de estudios por defecto: &quot;ISIC-2010-224&quot;" value="{{ $datos_globales[0]->plan_de_estudios }}">
			@else
				<input type="text" name="plan_de_estudios" id="plan_de_estudios" class="form-control" placeholder="Dejar en blanco este campo agregará el siguiente plan de estudios por defecto: &quot;ISIC-2010-224&quot;">
			@endif
			
		</div>
		<div class="form-group">
			<label for ="oficio">Oficio</label>
			@if ($datos_globales->count()>0)
				<input type="text" name="oficio" id="oficio" class="form-control" placeholder="Dejar en blanco este campo agregará el siguiente oficio por defecto: &quot;DISC/117/2017&quot;" value="{{ $datos_globales[0]->oficio }}">
			@else
				<input type="text" name="oficio" id="oficio" class="form-control" placeholder="Dejar en blanco este campo agregará el siguiente oficio por defecto: &quot;DISC/117/2017&quot;">
			@endif
			
		</div>
		<input type="submit" name="" value="Guardar" class="btn btn-primary">
	</form>

	<!-- Segundo formulario -->
	<!-- Datos especificos de constancia por carrera -->
	<div class="alert-warning alerta-padding ocultar-formulario" id = "constancias-faltantes">
		Es importante proporcionar los datos requeridos de todas las constancias de las carreras para evitar problemas al realizar consultas de las mismas. Ha continuación se muestran las constancias que faltan se dichos datos.
		<div style= "width: 35%; margin-left: 45%;">
			<ul>
			</ul>
		</div>
	</div>
	<h3 class="ocultar-formulario">Datos específicos de constancia por carrera</h3>
	<div id="mensajes-parte_media">
		
	</div>
	<form class="ocultar-formulario" method = "post" id = "form-datos-especificos">
		<input type="hidden" value="{{ csrf_token() }}" id="token">
		<input type="hidden" name="carrera_nom_completo" value="" id="carrera_nom_completo"> 
		<div class="form-group">
			<label for="carrera">Carrera</label>
			<select id="carrera" name="carrera" class="form-control" required>
				<option value="" selected>Seleccione una carrera</option>
				@for ($x = 0; $x < count($carreras); $x++)
					@php
						$subcadena = substr((string)$carreras[$x]['valor'],0,3);
					@endphp
					 <option value="{{ $carreras[$x]['valor'] }}" data-nombre="{{ $carreras[$x]['carrera'] }}" id = "option{{ $subcadena }}">{{ $carreras[$x]['carrera']}}</option>
				@endfor
			</select>
		</div>
		<div class="form-group" >
			<label>Jefe de departamento</label>
			<div>
				<select class="form-control pull-left" style="width: 30%;" name="profesion_jefe_depto" id="profesion_jefe_depto">
					<option value="">Abreviatura de profesión</option>
					<option value="otro-" id="otro-jefe-depto">Otro (especificar)</option>
					@for ($x = 0; $x < count($abreviaturas); $x++)
						<option value="{{ $abreviaturas[$x]['abreviatura'] }}">{{ $abreviaturas[$x]['profesion'] }}->{{ $abreviaturas[$x]['abreviatura'] }}</option>
					@endfor
				</select>
				<select name="jefe_depto" id="jefe_depto" class="form-control pull-left" required style="width: 70%;">
					<option value="">Nombre del jefe de departamento</option>
					@foreach ($users as $user)
						<option value = "{{ $user->id }}">{{ $user->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="resetear"></div>
		</div>
		<div class="form-group">
			<label for="jefe_depto_enunciado">Puesto</label>
			<input type="text" name="jefe_depto_enunciado" id="jefe_depto_enunciado" required placeholder="Puesto del jefe de depto. Ejem Jefe del depto. de Servicios Escolares" class="form-control">
		</div>
		<div class="form-group">
			<label>Jefe de división</label>
			<div>
				<select class="form-control pull-left" style="width: 30%;" name="profesion_jefe_division" id="profesion_jefe_division">
					<option value="">Abreviatura de profesión</option>
					<option value="otro-" id="otro-jefe-division">Otro (especificar)</option>
					@for ($x = 0; $x < count($abreviaturas); $x++)
						<option value="{{ $abreviaturas[$x]['abreviatura'] }}">{{ $abreviaturas[$x]['profesion'] }}->{{ $abreviaturas[$x]['abreviatura'] }}</option>
					@endfor
				</select>
				<select name="jefe_division" id="jefe_division" class="form-control pull-left" required style="width: 70%;">
					<option value="">Nombre del jefe de division</option>
					@foreach ($users as $user)
						<option value = "{{ $user->id }}">{{ $user->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="resetear"></div>
				
		</div>
		<div class="form-group">
			<label>Vo.Bo</label>
			<div>
				<select class="form-control pull-left" style="width: 30%;" name = "profesion_certificador" id = "profesion_certificador">
					<option value="">Abreviatura de profesión</option>
					<option value="otro-" id="otro-certificador">Otro (especificar)</option>
					@for ($x = 0; $x < count($abreviaturas); $x++)
						<option value="{{ $abreviaturas[$x]['abreviatura'] }}">{{ $abreviaturas[$x]['profesion'] }}->{{ $abreviaturas[$x]['abreviatura'] }}</option>
					@endfor
				</select>
				<select name="certificador" id="certificador" class="form-control pull-left" required style="width: 70%;">
					<option value="">Nombre de quien cerfica el documento</option>
					@foreach ($users as $user)
						<option value = "{{ $user->id }}">{{ $user->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="resetear"></div>
		</div>
		<div class="form-group">
			<label >Puesto del Vo.Bo</label>
			<input type="text" name="certificador_enunciado" id="certificador_enunciado" required placeholder="Puesto/posicion en que tiene quien certifica el documento. Ejem: Director Academico" class="form-control">
		</div>
		<input type="submit" name="" value="Guardar" class="btn btn-primary">
	</form>
	<div style="margin-bottom: 80px;"></div>
	@section('js')
		<script type="text/javascript">
			$.ajaxSetup( {
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			} );
			function ocultarDatosEspecificosConstancia(){
				var existen_datos = $('#variable-ocultar').attr('value');
				if(existen_datos==1){
					$('.ocultar-formulario').fadeIn();
					$('#mensaje-agregar-datos').fadeOut();
				}else{
					$('.ocultar-formulario').fadeOut();
					$('#mensaje-agregar-datos').fadeIn();
				}
				
			}
			function guardarDatosGlobales(){
				$(document).on('submit','#form-datos-globales',function(event){
					event.preventDefault();
					var datos = $('#form-datos-globales').serialize();
					$.ajax({
						type: 'POST',
						url: '{{ route('constancias.guardar_datos_globales') }}',
						dataType: 'json',
						data:datos,
						success: function(response){
							var variable_ocultar = document.getElementById('variable-ocultar');
							variable_ocultar.value=1;
							ocultarDatosEspecificosConstancia();
							actualizarDatosGlobales(response['data']);
							mostrarMensaje(response['mensaje'],'mensajes-parte-superior',response['mensaje_tipo']);
						},error: function(){
							mostrarMensaje('Error al guardar datos globales','mensajes-parte-superior','error');
						}
					});
				});
			}
			function actualizarDatosGlobales(response){
				$('#institucion_info').val(response['institucion_info']);
				$('#enunciado_superior').val(response['enunciado_superior']);
				$('#oficio').val(response['oficio']);
				$('#plan_de_estudios').val(response['plan_de_estudios']);
			}
			function abreviaturasEspeciales(abreviatura,option_id){
				var token  = abreviatura.substring(0,5);
				if(token == "otro-"){
					var opcion = document.getElementById(option_id);
					var resto_token = abreviatura.substring(5);
					opcion.value = abreviatura;
					opcion.innerHTML = "Otro->"+resto_token;
				}	
			}
			function actualizarDatosEspecificos(response,accion = "llenar"){
				if(accion=="llenar"){
					abreviaturasEspeciales(response['profesion_jefe_division'],'otro-jefe-division');
					abreviaturasEspeciales(response['profesion_jefe_depto'],'otro-jefe-depto');
					abreviaturasEspeciales(response['profesion_certificador'],'otro-certificador');
					$('#jefe_depto').val(response['jefe_depto']);
					$('#jefe_depto_enunciado').val(response['jefe_depto_enunciado']);
					$('#profesion_jefe_depto').val(response['profesion_jefe_depto']);
					$('#jefe_division').val(response['jefe_division']);
					$('#profesion_jefe_division').val(response['profesion_jefe_division']);
					$('#certificador').val(response['certificador']);
					$('#certificador_enunciado').val(response['certificador_enunciado']);
					$('#profesion_certificador').val(response['profesion_certificador']);
				}else{
					$('#jefe_depto').val('');
					$('#jefe_depto_enunciado').val('');
					$('#profesion_jefe_depto').val('');
					$('#jefe_division').val('');
					$('#profesion_jefe_division').val('');
					$('#certificador').val('');
					$('#certificador_enunciado').val('');
					$('#profesion_certificador').val('');
				}
			}
			function comboCarrera(){
				$(document).on('change','#carrera',function(event){
					event.preventDefault();
					var carrera_nombre = $('#carrera').val();
					var carrera_nombre_subcadena = carrera_nombre.substring(0,3);;
					var carrera_nom_completo = document.getElementById('carrera_nom_completo');
					$('#carrera').removeAttr("disabled");
					if(carrera_nombre.length>0){
						var ruta = "{{ route('constancias.obtener_datos_especificos','aux') }}"
						ruta = ruta.replace('aux',carrera_nombre);
						carrera_nom_completo.value = $('#option'+carrera_nombre_subcadena).attr('data-nombre');
						$.ajax({
							type: 'get',
							dataType: 'json',
							cache: true,
							url: ruta,
							success: function(response){
								if(response.length>0){
									actualizarDatosEspecificos(response[0]);
								}else{
									actualizarDatosEspecificos(response, "vaciar");
								}
								$('#form-datos-especificos input').removeAttr("disabled");
								$('#form-datos-especificos select').removeAttr("disabled");
								var temp_cookie = document.getElementById('carrera').value;
								Cookies.set('constancias_carrera_val',temp_cookie,{expires: 1});
							},error: function(){
								console.log("Error al obtener datos especificos");
							}
						});
					}else{
						carrera_nom_completo.value="";
						$('#form-datos-especificos input').attr("disabled","disabled");
						$('#form-datos-especificos select').attr("disabled","disabled");
						$('#carrera').removeAttr("disabled");
					}	
				});
			}
			function guardarDatosEspecificos(){
				$(document).on('submit','#form-datos-especificos',function(event){
					event.preventDefault();
					var constancia_data = $('#form-datos-especificos').serialize();
					var ruta = "{{ route('constancias.guardar_datos_especificos','aux') }}";
					var carrera_nombre = $('#carrera').val();
					ruta = ruta.replace("aux",carrera_nombre);
					$.ajax({
						type: "post",
						dataType: "json",
						data:constancia_data,
						url: ruta,
						success: function(response){
							console.log(response);
							mostrarMensaje(response['mensaje'],'mensajes-parte_media',response['mensaje_tipo']);
							mostrarConstanciasFaltantes();
						},error: function(){
							mostrarMensaje("Error al guardar datos especificos de la constancia",'mensajes-parte_media','error');
						}
					});
				});
			}

			function mostrarConstanciasFaltantes(){
				$.ajax({
					type: "get",
					dataType: "json",
					url: "{{ route('constancias.constancias_faltantes') }}",
					success: function(response){
						var existen_datos = $('#variable-ocultar').attr('value');
						if(response.length>0){
							if(existen_datos==1)$('#constancias-faltantes').fadeIn();
							$('#constancias-faltantes div ul').empty();
							for (var i = 0; i < response.length; i++) {
								$('#constancias-faltantes div ul').append("<li style = 'text-align: left;'>"+response[i]+"</li>");
							}

						}else{
							$('#constancias-faltantes div ul').empty();
							$('#constancias-faltantes').fadeOut();
						}
					},error: function(){
						mostrarMensaje("Error al obtener las constancias faltantes","constancias-faltantes","error");
					}
				});
			}
			function otros(){
				$(document).on('change','#profesion_jefe_depto',function(event){
					var identificador = $(this).val();
					var identificador_token = identificador.substring(0,5);
					if(identificador_token=="otro-"){
						var abreviatura = prompt("Favor de expecificar abreviatura (max: 10 caracteres)");
						if(abreviatura!=null){
							$("#otro-jefe-depto").val("otro-"+abreviatura);
							var opcion = document.getElementById('otro-jefe-depto');
							opcion.innerHTML= "Otro->"+abreviatura;
						}else if(identificador==identificador_token){
							$(this).val('');
						}
					}
				});
				$(document).on('change','#profesion_jefe_division',function(event){
					var identificador = $(this).val();
					var identificador_token = identificador.substring(0,5);
					if(identificador_token=="otro-"){
						var abreviatura = prompt("Favor de expecificar abreviatura (max: 10 caracteres)");
						if(abreviatura!=null){
							$("#otro-jefe-division").val("otro-"+abreviatura);
							var opcion = document.getElementById('otro-jefe-division');
							opcion.innerHTML= "Otro->"+abreviatura;
						}else if(identificador==identificador_token){
							$(this).val('');
						}
					}
				});
				$(document).on('change','#profesion_certificador',function(event){
					var identificador = $(this).val();
					var identificador_token = identificador.substring(0,5);
					if(identificador_token=="otro-"){
						var abreviatura = prompt("Favor de expecificar abreviatura (max: 10 caracteres)");
						if(abreviatura!=null){
							$("#otro-certificador").val("otro-"+abreviatura);
							var opcion = document.getElementById('otro-certificador');
							opcion.innerHTML= "Otro->"+abreviatura;
						}else if(identificador==identificador_token){
							$(this).val('');
						}
					}
				});
			}
			function getCookie(){
				var constancias_cookie = Cookies.get('constancias_carrera_val');
				if(constancias_cookie!=null){
					$('#carrera').val(constancias_cookie);
					$('#carrera').trigger('change');
				}
			}
			$(document).ready(function(){
				ocultarDatosEspecificosConstancia();
				guardarDatosGlobales();
				comboCarrera();
				guardarDatosEspecificos();
				mostrarConstanciasFaltantes();
				otros();
				$('#form-datos-especificos input').attr("disabled","disabled");
				$('#form-datos-especificos select').attr("disabled","disabled");
				$('#carrera').removeAttr("disabled");
				getCookie();
			});
		</script>
	@endsection
@endsection