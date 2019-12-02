@extends('template.molde');

@section('title','Avance alumnos')

@section('ruta')
    
    @if (count($ruta_data)>0)
    	<div style="width: 200px; height: 30px; float:right;">
    		{!! Form::open(['route' => 'verifica_evidencia.reportes','method' => 'GET','id' => 'ruta_input','style' => 'float: left; margin-right: 5px;']) !!}
    			{!! Form::hidden('carrera',$ruta_data[0]) !!}
    			{!! Form::hidden('generacion',$ruta_data[1]) !!}
    			<a href="#" onclick="document.getElementById('ruta_input').submit()"> Reportes </a>
    		{!! Form::close() !!}
    		/
    		<label class="label label-success">Avance alumno</label>
    	</div>
    @else
    	<label class="label label-success">Avance alumno</label>
    @endif
@endsection

@section('contenido')
	<!-- Input text donde se podra buscar a los participantes por nombre -->
	
		{!! Form::open(['route' => 'verifica_evidencia.avance_alumno', 'method' => 'GET','class' => 'form-inline pull-right']) !!}
			<div class="input-group  mb-3">
				{{ Form::label('no_control','No Control') }}
			    {!! Form::text('no_control',null,['class'=>'form-control','placeholder'=>'Numero de control','aria-describedby'=>'search','required','id' => 'no_control']) !!}
			    <div class="input-group-btn">
			        <button type="submit" class="btn btn-primary" > 
						<i class='fas fa-search'></i>
			        </button>
			    </div>
			</div>
			
		{!! Form::close() !!}
		<div class="autocomplete pull-right" style="width:300px; margin-right: 40px;">
		    {!! Form::label('alumno','Alumno') !!}
		    <input id="participante_nombre" type="text" placeholder="Nombre" class="form-control">
		</div>	
	

	<div class="resetear"></div>
	<br><br>
	<div class="alert-danger" style="padding: 20px; display: none;" id="mensaje-error">
		<p style="font-size: 0.9vw;"><strong>No se encuentran asignados los jefes de crédito para poder llenar los campos de la constancia.</strong></p>
	</div>
	<div class="container-fluid ">
		<div class="container">
			<h1>Información del alumno</h1>
			<div class="row">
				<div class="col-sm-1" style="background-color:#426986;color:white; " ><h4>Nombre</h4></div>
				<div class="col-sm-3" style="background-color:#426986;color:blak; " >
					<h4>
						<b>
							@if ($alumno_data!=null)
							{{ $alumno_data[0]->nombre_alumno }}
							@endif
						</b>
					</h4>
				</div>
				<div class="col-sm-2" style="background-color:#426986;color:white; " ><h4>Numero de control</h4></div> 
				<div class="col-sm-2" style="background-color:#426986;color:blak; " >
					<h4>
						<b>
							@if ($alumno_data!=null)
							{{ $alumno_data[0]->no_control }}
							@endif
						</b>
					</h4>
				</div>
				<div class="col-sm-1" style="background-color:#426986;color:white; " ><h4>Carrera</h4></div>
				<div class="col-sm-3" style="background-color:#426986;color:blak; " >
					<h4>
						<b>
							@if ($alumno_data!=null)
							{{ $alumno_data[0]->carrera }}
							@endif
							</b>
					</h4>
				</div> 
			</div>
		</div>
	  	
    
		<br>
		<table class="table ">
			<thead class="thead-dark">
				<th>Credito</th>
				<th>Actividades</th>
				<th>Porcentaje</th>
			</thead>
			<tbody>
				@php
					$temp_porcentaje = 0;
					$suma_creditos = 0;
					$y=0;
				@endphp
				@if($alumno_data!=null)
					@for ($x = 0; $x < count($creditos); $x++)
						
						@if ( $y < count($alumno_data) && $avance)
							@if ($alumno_data[$y]->nombre_credito==$creditos[$x]->nombre)
								@php
									$temp_porcentaje = ($alumno_data[$y]->por_credito >100)?100:$alumno_data[$y]->por_credito;
									$suma_creditos += (int)$temp_porcentaje;
								@endphp
								<tr>
									<td colspan="3" style="text-align:left; padding: 0;">
										<div style="position: relative;">
											<div style="background: #27ce1e; padding: 5; width: {{$temp_porcentaje}}%; height: 35px;max-width: 100%";>
												<div style="position: absolute;">
													<strong>{{ $alumno_data[$y]->nombre_credito }}</strong>
												</div>
												
											</div>
										</div>
									</td>
								</tr>
								@for (; $y < count($alumno_data) && $alumno_data[$y]->nombre_credito==$creditos[$x]->nombre; $y++)
									<tr>
										<td></td>
										<td>{{ $alumno_data[$y]->nombre_actividad }}</td>
										<td>{{ $alumno_data[$y]->por_cred_actividad.'%' }}</td>
									</tr>
								@endfor
								<tr>
									<td></td>
									<td></td>
									<td ><strong>Total</strong></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td>{{ $temp_porcentaje.'%' }}</td>
								</tr>
							@else
								<tr>
									<td colspan="3" style="text-align:left; padding: 0;">
										<div style="position: relative;">
											<div style="background: #27ce1e; padding: 5; width: 0%;height: 35px;max-width: 100%";>
												<div style="position: absolute;">
													<strong >{{ $creditos[$x]->nombre }}</strong>
												</div>
												
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td></td>
									<td>Actividades registradas</td>
									<td>0%</td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td ><strong>Total</strong></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td>0%</td>
								</tr>
							@endif
						@else
							<tr>
								<td colspan="3" style="text-align:left; padding: 0;">
									<div style="position: relative;">
										<div style="background: #27ce1e; padding: 5; width: 0%;height: 35px;max-width: 100%";>
											<div style="position: absolute;">
												<strong >{{ $creditos[$x]->nombre }}</strong>
											</div>
											
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>Actividades registradas</td>
								<td>0%</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td ><strong>Total</strong></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td>0%</td>
							</tr>
						@endif
					@endfor
					@php
						if($suma_creditos>500)$suma_creditos=500;
						$suma_creditos/=100;
					@endphp
					<tr>
							<td></td>
							<td></td>
							<td><strong>Total de creditos</strong></td>
					</tr>
					<tr>						
						<td colspan="3" style="background-color:#426986; color:white; text-align: right;"><h3>{{ $suma_creditos.' creditos' }}</h3></td>
					</tr>
				@endif
			</tbody>
		</table>
		@php
			$mostrarMensaje = 0;
		@endphp
		@if($liberado && (Auth::User()->hasAnyPermission(['VIP','IMPRIMIR_CONSTANCIAS'])))
			<form action="{{ route('constancias.imprimir') }}" style="padding: 10px;" method="post">
				{{ csrf_field() }}
				<input type="hidden" name="no_control" value="{{ $alumno_data[0]->no_control }}">
				<input type="submit" name="" value="Imprimir constancia" class="btn btn-primary">
			</form>
		@elseif($suma_creditos == 5)
			@php
				$mostrarMensaje = 1;
			@endphp
		@endif

		<div style="padding: 5px 0 50px 0;"></div>
	</div>
	@section('js')
		<script type="text/javascript">
			function autocompletar(entrada){
				var posicionActual;
				var participantes_arr = [];
				entrada.addEventListener("input", function(event){
					var divPadre, divHijo, valor = this.value;
					posicionActual = -1;
					removeAllLists();
					if(!valor) return false;
					$.ajax({
						type: "GET",
						url: "{{ route('verifica_evidencia.alumnos_busqueda') }}",
						dataType: "json",
						data:{
							nombre: valor,
							peticion: 0
						},
						success: function(response){
							participantes_arr = [];
							for(var x=0; x<response.length; x++){
								participantes_arr.push(response[x]);
							}
							removeAllLists();
							divPadre.setAttribute("id",entrada.id+"autocomplete-list");
							divPadre.setAttribute("class","autocomplete-items");
							entrada.parentNode.appendChild(divPadre);
							for(var x=0; x<participantes_arr.length; x++){
								divHijo = document.createElement("div");
								divHijo.innerHTML = "<p style='text-align: left;'><strong>"+participantes_arr[x]['nombre']+"</strong>-"+participantes_arr[x]['no_control']+"</p>";
								divHijo.innerHTML += "<input type = 'hidden' value='"+participantes_arr[x]['nombre']+"'>";
								divHijo.innerHTML += "<input type = 'hidden' value='"+participantes_arr[x]['no_control']+"'>";
								divHijo.addEventListener("click", function(event){
									event.preventDefault();
									var temp = document.getElementById("participante_nombre");
									temp.value = this.getElementsByTagName("input")[0].value;
									var temp2 = document.getElementById("no_control");
									temp2.value = this.getElementsByTagName("input")[1].value;
									removeAllLists();
								});
								divPadre.appendChild(divHijo);
							}
						}, error: function(){
							console.log("Error :(");
						}
					});
					divPadre = document.createElement("div");
					
				});

				entrada.addEventListener("keydown", function(event){
					var lista_participantes = document.getElementById(this.id+"autocomplete-list");
					if(lista_participantes) lista_participantes = lista_participantes.getElementsByTagName("div");
					if(event.keyCode == 40){
						++posicionActual;
						addActive(lista_participantes);
					}else if(event.keyCode == 38){
						--posicionActual;
						addActive(lista_participantes);
					}else if(event.keyCode == 13 && posicionActual >= 0){
						this.value = lista_participantes[posicionActual].getElementsByTagName("input")[0].value;
						var temp = document.getElementById("no_control");
						temp.value = lista_participantes[posicionActual].getElementsByTagName("input")[1].value;
						removeAllLists();
					}
				});
				function addActive(current){
					if(current == null) return false;
					removeActive(current);
					if(posicionActual >= current.length) posicionActual=0;
					if(posicionActual < 0) posicionActual = current.length-1;
					current[posicionActual].classList.add("autocomplete-active");
				}
				function removeActive(current){
					for(var x = 0; x<current.length; x++){
						current[x].classList.remove("autocomplete-active");
					}
				}
				function removeAllLists(elemento){
					var lista_items = document.getElementsByClassName("autocomplete-items");
					for(var x = 0; x < lista_items.length; x++){
						if(elemento == lista_items[x] && elemento == entrada)continue;
						lista_items[x].parentNode.removeChild(lista_items[x]);
					}
				}
				document.addEventListener("click", function (event) {
					removeAllLists(event.target);
				});
			}

			function busqueda(entrada){
				event.preventDefault();
				var temp = document.getElementById("participante_nombre");
				temp.value="";
				var valor = entrada.value;
				if(!valor) return false;
				if(valor.length < 8 || valor.length > 10) return false;
				$.ajax({
					type: "GET",
					url: "{{ route('verifica_evidencia.alumnos_busqueda') }}",
					dataType: "json",
					data:{
						no_control: valor,
						peticion: 1
					},
					success: function(response){
						if(response.length>0){
							temp.value = response[0]['nombre'];
						}
					},error: function(response){
						console.log("error :(");
					}
				});
			}
			function noControlParticipante(entrada){
				entrada.addEventListener("input", function(event){
					busqueda(entrada);
				});

				entrada.addEventListener("click", function(event){
					busqueda(entrada);
				  });
			}

			$(document).ready(function(){
				autocompletar(document.getElementById("participante_nombre"));
				noControlParticipante(document.getElementById("no_control"));
				var mostrarMensaje = "{{ $mostrarMensaje }}";
				if(mostrarMensaje == 1){
					$('#mensaje-error').css('display','block');
				}
			});
		</script>
	@endsection
@endsection