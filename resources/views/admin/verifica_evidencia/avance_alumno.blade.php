@extends('template.molde')

@section('title','Avance alumnos')

@section('links')
	<link rel="stylesheet" href="{{ asset('cssAutocompletar/autocompletar.css') }}" />
@endsection

@section('ruta')

    @if (count($ruta_data)>0)
    	<div>
			<form action="{{ route('verifica_evidencia.reportes') }}" method="get" id="ruta_input" style="float: left; margin-right: 5px;">
				<input type="hidden" name="carrera" value="{{ $ruta_data[0] }}">
				<input type="hidden" name="generacion" value="{{ $ruta_data[1] }}">
				<a href="#" onclick="document.getElementById('ruta_input').submit()">Reportes</a>
			</form>
    		/
    		<label class="label label-success">Avance alumno</label>
    	</div>
    @else
    	<label class="label label-success">Avance alumno</label>
    @endif
@endsection

@section('contenido')
	<!-- Input text donde se podra buscar a los participantes por nombre -->
	<div class="row">
		<div class="col-sm-3"></div>
		<div class="col-sm-3"></div>
		<div class="col-sm-3">
			<label for="alumno_nombre">Alumno</label>
			<input id="alumno_nombre" type="text" placeholder="Nombre" class="form-control">
		</div>
		<div class="col-sm-3">
			<form action="{{ route('verifica_evidencia.avance_alumno') }}" method="get">
				<label for="no_control">Número de control</label>
				<div class="md-form input-group mb-3">
					<input type="text" class="form-control" name="no_control" id="no_control" required placeholder="Número de control" aria-label="Número de control" aria-describedby="MaterialButton-addon2">
					<div class="input-group-append">
					  	<button class="btn btn-md btn-secondary m-0 px-3" type="submit" id="Buscar" title="Buscar"><i class="fas fa-search" style="font-size: 14px"></i></button>
					</div>
				</div>
			</form>
		</div>
	</div>


	<div class="resetear"></div>
	<br><br>
	<div class="alert-danger" style="padding: 20px; display: none;" id="mensaje-error">
		<p style="font-size: 0.9vw;"><strong>No se encuentran asignados los jefes de crédito para poder llenar los campos de la constancia.</strong></p>
	</div>
	<div class="card mb-3" style="max-width: 1550px;">
		<div class="row g-0">
			<div class="col-md-1">
				<img
				src="{{ asset('images/user.png') }}"
				alt="Imagen del alumno"
				class="img-fluid rounded-start"
				/>
			</div>
			<div class="col-md-11">
				<div class="card-body">
					<h5 class="card-title">Información del alumno</h5>
					<table class="table">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>No. Control</th>
								<th>Carrera</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									@if ($alumno_data!=null)
									{{ $alumno_data[0]->nombre_alumno }}
									@endif
								</td>
								<td>
									@if ($alumno_data!=null)
									{{ $alumno_data[0]->no_control }}
									@endif
								</td>
								<td>
									@if ($alumno_data!=null)
									{{ $alumno_data[0]->carrera }}
									@endif
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid ">
		<br><br>
		<table class="table ">
			<thead>
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
											<div style="background: #27ce1e; padding: 2; width: {{$temp_porcentaje}}%; height: 20px;max-width: 100%;";>
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
											<div style="background: #27ce1e; padding: 2; width: 0%;height: 20px;max-width: 100%";>
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
										<div style="background: #27ce1e; padding: 2; width: 0%;height: 20px;max-width: 100%";>
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
	</div>
	<div style="margin-bottom: 300px;"></div>
	@section('js')
		<script type="text/javascript">
			var alumnoNombreInput = document.getElementById("alumno_nombre");
			var alumnoNoControlInput = document.getElementById("no_control");
			var busquedaTimeout = null;
			var posicionActual = -1;

			function ucwords(text) {
				let token_list = text.split(' ');
				let result = '';
				for (let i = 0; i < token_list.length; ++i) {
					if (i > 0) {
						result += ' ';
					}
					let token = String(token_list[i]);
					let word = token.charAt(0).toUpperCase() + token.slice(1).toLowerCase();
					result += word;
				}
				return result;
			}

			function limpiarListaResultados(){
				let listaItems = document.getElementsByClassName("autocomplete-items");
				for(var x = 0; x < listaItems.length; x++){
					listaItems[x].parentNode.removeChild(listaItems[x]);
				}
			}

			function removerResultadosDandoClicEnDocumento(clickedElement){
				let listaItems = document.getElementsByClassName("autocomplete-items");
				for(var x = 0; x < listaItems.length; x++){
					if (clickedElement == listaItems[x] && clickedElement == entrada) {
						continue;
					}
					listaItems[x].parentNode.removeChild(listaItems[x]);
				}
			}

			function getDatosPorNombreAjax(busqueda) {
				if(!busqueda)
					return false;

				var participantes_arr = [];
				var divPadre = document.createElement("div");
				divPadre.setAttribute("id","div-autocomplete-list");
				divPadre.setAttribute("class","autocomplete-items");

				$.ajax({
					type: "GET",
					url: "{{ route('verifica_evidencia.alumnos_busqueda') }}",
					dataType: "json",
					data:{
						nombre: busqueda,
						peticion: 0
					},
					success: function(response){
						let busqueda_actual = $("#alumno_nombre").val();
						if (busqueda_actual != busqueda) {
							limpiarListaResultados();
							return;
						}

						participantes_arr = [];
						for(var x=0; x<response.length; x++){
							participantes_arr.push(response[x]);
						}
						limpiarListaResultados();
						alumnoNombreInput.parentNode.appendChild(divPadre);
						for(var x=0; x<participantes_arr.length; x++){
							let divHijo = document.createElement("div");
							divHijo.innerHTML = "<p><strong>"+ucwords(participantes_arr[x]['nombre'])+"</strong> &rarr; "+participantes_arr[x]['no_control']+"</p>";
							divHijo.innerHTML += "<input type = 'hidden' value='"+participantes_arr[x]['nombre']+"'>";
							divHijo.innerHTML += "<input type = 'hidden' value='"+participantes_arr[x]['no_control']+"'>";

							divHijo.addEventListener("click", function(event){
								event.preventDefault();
								let temp = document.getElementById("alumno_nombre");
								temp.value = this.getElementsByTagName("input")[0].value;
								let temp2 = document.getElementById("no_control");
								temp2.value = this.getElementsByTagName("input")[1].value;
								limpiarListaResultados();
							});

							divPadre.appendChild(divHijo);
						}
					}, error: function(response){
						console.log("Error :(");
						console.log(response);
					}
				});

			}

			function getDatosPorNombre() {
				limpiarListaResultados();

				if (busquedaTimeout != null) {
					clearTimeout(busquedaTimeout);
				}

				busquedaTimeout = setTimeout(function() {
					let busqueda = $("#alumno_nombre").val();
					getDatosPorNombreAjax(busqueda);
				}, 400);

			}

			function addActive(current){
				if(current == null) return false;
				removeActive(current);
				if(posicionActual >= current.length) posicionActual=0;
				if(posicionActual < 0) posicionActual = current.length-1;
				current[posicionActual].classList.add("autocomplete-active");
				scrollToElement(posicionActual);
			}


			function isOverflownY(element) {
			  return element.scrollHeight > element.clientHeight;
			}

			function scrollToElement(targetPosition) {
				let scrollable = document.getElementById('div-autocomplete-list');
				const firstPixelPosition = Math.floor(scrollable.childNodes[0].getBoundingClientRect().top);
				const targetPixelPosition = Math.floor(scrollable.childNodes[targetPosition].getBoundingClientRect().top);
				const marginSize = 4 * 32;

				if (isOverflownY(scrollable)) {
					if (targetPosition >= 0 && targetPosition <= 4) {
						scrollable.scrollTop = 0;
					} else {
						let scrollToTarget = targetPixelPosition - firstPixelPosition - marginSize;
						scrollable.scrollTop = scrollToTarget;
					}
				}
			}

			function removeActive(current){
				for(var x = 0; x<current.length; x++){
					current[x].classList.remove("autocomplete-active");
				}
			}

			function scrollList() {
				var lista_participantes = document.getElementById("div-autocomplete-list");
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
					limpiarListaResultados();
				}
			}

			function busquedaPorNoControl(entrada){
				event.preventDefault();
				alumnoNombreInput.value="";

				var valor = entrada.value;
				if(!valor || valor.length < 8 || valor.length > 10) {
					return false;
				}

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
							alumnoNombreInput.value = response[0]['nombre'];
						}
					},error: function(response){
						console.log("Error :(");
						console.log(response);
					}
				});
			}

			function agregarEventosAElementos() {
				alumnoNombreInput.addEventListener("input", getDatosPorNombre);
				document.addEventListener("click",removerResultadosDandoClicEnDocumento);

				alumnoNoControlInput.addEventListener("input", function(event){
					busquedaPorNoControl(alumnoNoControlInput);
				});

				alumnoNoControlInput.addEventListener("click", function(event){
					busquedaPorNoControl(alumnoNoControlInput);
				});

				alumnoNombreInput.addEventListener("keydown", scrollList);
			}

			$(document).ready(function(){
				agregarEventosAElementos();
				var mostrarMensaje = "{{ $mostrarMensaje }}";
				if(mostrarMensaje == 1){
					$('#mensaje-error').css('display','block');
				}
			});

		</script>
	@endsection
@endsection
