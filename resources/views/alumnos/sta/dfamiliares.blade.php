@extends('template.molde')

@section('title','Actividades')

@section('ruta')
	<a href="" class="label label-info">STA</a>
	/
	<label class="label label-success">Datos familiares</label>
@endsection

@section('contenido')
	<form action="{{ route('alumnos.sta.dfamiliares.guargar', $alu->no_control) }}" method="get">
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<div class="card">
					<div class="container cuerpo">
						<div class="row fch">
							<fieldset class="col-md-12">
								{{--cabecera--}}
								<div>
									<div class="panel-heading">
										<h3 class="head text-center">FICHA DE
											IDENTIFICACIÓN DEL ALUMNO TUTORADO</h3>
										<div class="head text-center">
											<h4>Datos Familiares</h4>
										</div>
										<div class="progress" style="height: 18px">
											<div class="progress-bar progress-bar-striped progress-bar-animated"
												role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
												style="width: 60%">60%</div>
										</div>
									</div>
								</div>
								<br>
								<div id="cr">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h5 class="accordion-toggle collapsed" data-toggle="collapse"
												href="#collapseWidthExample" class="panel-title">
												<a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
													href="#tableFam">Nombra a los integrantes de tu familia (Mamá, Papá,
													Hermanos, del mayor al menor incluyéndote).</a>
												<a> <i class="fa fa-angle-down"></i></a>
											</h5>
										</div>
										<div class="collapse collapse-horizontal" id="collapseWidthExample">
											<div class="row">
												<div class="col-md-12">
													{{-- Tabla dinamica --}}
													<table class="table table-bordered table-hover table-sortable"
														id="tableFam">
														<thead>
															<tr>
																<th>Nombre</th>
																<th>Edad</th>
																<th>Escolaridad</th>
																<th>Parentesco</th>
																<th>Relación con el/ella</th>
																<th><input class="btn btn-info btn-sm" type="button"
																		value="Añadir otro" onclick="agregar()"></th>
															</tr>
														</thead>
														<tbody>
															@foreach($familiares as $fami )
															<tr>
																<td><input type='text' name='nombre[]' placeholder='Nombre'
																		class='form-control' value="{{ $fami->nombre }}">
																</td>
																<td><input type='number' name='edad[]' placeholder='Edad'
																		value="{{$fami->edad }}" class='form-control'></td>
																<td><select required name='escolaridad[]'
																		class='form-control float-input'>
																		<option value=''>Seleccione
																			una opcion
																		</option>
																		<option @if($fami->escolaridad=='Prescolar')
																			selected @endif
																			value='Prescolar'
																			>Prescolar
																		</option>
																		<option @if($fami->escolaridad=='Primaria')
																			selected @endif
																			value='Primaria' >Primaria
																		</option>
																		<option @if($fami->escolaridad=='Secundaria')
																			selected @endif
																			value='Secundaria'
																			>Secundaria
																		</option>
																		<option @if($fami->escolaridad=='Media superior')
																			selected @endif
																			value='Media superior'
																			>Media
																			superior</option>
																		<option @if($fami->escolaridad=='Superior')
																			selected @endif
																			value='Superior' >Superior
																		</option>
																		<option @if($fami->escolaridad=='Posgrado')
																			selected @endif
																			value='Posgrado' >Posgrado
																		</option>
																	</select>
																</td>
																<td>
																	<select required name='parentesco[]'
																		class='form-control float-input'>
																		<option value=''>Seleccione
																			una opcion
																		</option>
																		<option @if($fami->parentesco=='Padre')
																			selected @endif value='Padre'
																			>Padre</option>
																		<option @if($fami->parentesco=='Madre')
																			selected @endif value='Madre'
																			>Madre</option>
																		<option @if($fami->parentesco=='Hermano')
																			selected @endif value='Hermano'
																			>Hermano
																		</option>
																		<option @if($fami->parentesco=='Hermana')
																			selected @endif value='Hermana'
																			>Hermana
																		</option>
																		<option @if($fami->parentesco=='Yo')
																			selected @endif value='Yo'
																			>Yo
																		</option>
																	</select>
																</td>
																<td><select required name='actitud[]'
																		class='form-control float-input'>
																		<option value=''>Seleccione
																			una opcion
																		</option>
																		<option @if($fami->
																			relacion=='Buena')
																			selected @endif
																			value='Buena'>Buena</option>
																		<option @if($fami->relacion=='Regular')
																			selected @endif
																			value='Regular'>Regular</option>
																		<option @if($fami->
																			relacion=='Mala')
																			selected @endif
																			value='Mala'>Mala</option>
																	</select></td>
																<td><button onclick='eliminar()'
																		class='btn btn-success'>Borrar</button></td>
															</tr>
															@endforeach
															{{-- Contenido de la tabla --}}
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>

									<div class="panel panel-default">
										<div class="panel-heading">
											<h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#fam2"
												class="panel-title">
												<a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
													href="#fam2">¿Existen dificultades?</a>
												<a> <i class="fa fa-angle-down"></i></a>
											</h5>
										</div>
										<div id="fam2" class="panel-collapse collapse" data-parent="#cr">
											<div class="panel-body">
												<div class="row">
													<div class="col-sm-7">
														<label class="radio-inline">
															<input required @if($fam->dificultades!='No') checked
															@endif type="radio" name="dif" id="inlineRadio1" value="Si"
															onclick="$('#fiden_dificultades').attr('readonly',
															false).attr('required',true);">
															Sí
														</label>
														<label class="radio-inline">
															<input required @if($fam->dificultades=='No') checked @endif
															type="radio"
															name="dif" id="inlineRadio2" value="No"
															onclick="$('#fiden_dificultades').attr('readonly',true).attr('value','').attr('required',false);"
															> No
														</label>
													</div>
													<div class="col-sm-5">
														<div class="form-group bs-float-label">
															<label for="fiden_dificultades">¿De qué tipo?</label>
															<input @if($fam->dificultades=='No') readonly @endif
															class="form-control float-input" name="fiden_dificultades"
															value="{{ $fam->dificultades }}" placeholder=""
															id="fiden_dificultades">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#fam4"
												class="panel-title">
												<a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
													href="#fam4">¿Con quién te sientes más ligado afectivamente?</a>
												<a> <i class="fa fa-angle-down"></i></a>
											</h5>
										</div>
										<div id="fam4" class="panel-collapse collapse" data-parent="#cr">
											<div class="panel-body">
												<div class="row">
													<div class="col-sm-12">
														<div class="col-sm-6">
															<select id="fiden_ligue" name="fiden_ligue"
																class="form-control float-input" required>
																<option value=''>Selecciona una opción
																</option>
																<option value='Madre' @if($fam->
																	ligado=='Madre') selected @endif>Madre</option>
																<option value='Padre' @if($fam->
																	ligado=='Padre') selected @endif>Padre</option>
																<option value='Abuela' @if($fam->
																	ligado=='Abuela') selected @endif>Abuela</option>
																<option value='Abuelo' @if($fam->
																	ligado=='Abuelo') selected @endif>Abuelo</option>
																<option value='Hermana' @if($fam->
																	ligado=='Hermana') selected @endif>Hermana</option>
																<option value='Hermano' @if($fam->
																	ligado=='Hermano') selected @endif>Hermano</option>
																<option value='Tía' @if($fam->
																	ligado=='Tía') selected @endif>Tía</option>
																<option value='Tío' @if($fam->
																	ligado=='Tío') selected @endif>Tío</option>
																<option value='Otro' @if($fam->
																	ligado=='Otro') selected @endif>Otro</option>
															</select>
														</div>
														<div class="col-sm-6">
															<div class="form-group bs-float-label">
																<label for="fiden_ligue_T">Especifica por qué</label>
																<input required class="form-control float-input"
																	name="fiden_ligue_T" placeholder="" id="fiden_ligue_T"
																	value="{{ $fam->ligado_por }}">
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#fam5"
												class="panel-title">
												<a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
													href="#fam5">¿Quién
													se ocupa más en tu
													educación?</a>
												<a> <i class="fa fa-angle-down"></i></a>
											</h5>
										</div>
										<div id="fam5" class="panel-collapse collapse" data-parent="#cr">
											<div class="panel-body">
												<div class="row">
													<div class="col-sm-12">
														<div class="form-group bs-float-label">
															<input required class="form-control float-input"
																name="fiden_edu" placeholder="" id="fiden_edu"
																value="{{ $fam->edu }}">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#fam6"
												class="panel-title">
												<a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
													href="#fam6">¿Quién
													ha influido más en tu
													decisión para estudiar esta carrera?</a>
												<a> <i class="fa fa-angle-down"></i></a>
											</h5>
										</div>
										<div id="fam6" class="panel-collapse collapse" data-parent="#cr">
											<div class="panel-body">
												<div class="row">
													<div class="col-sm-12">
														<div class="form-group bs-float-label">
															<input required class="form-control float-input"
																name="fiden_influ" placeholder="" id="fiden_influ"
																value="{{ $fam->carrera }}">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#fam7"
												class="panel-title">
												<a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
													href="#fam7">Consideras importante facilitar
													algún otro dato sobre tu ambiente familiar</a>
												<a> <i class="fa fa-angle-down"></i></a>
											</h5>
										</div>
										<div id="fam7" class="panel-collapse collapse" data-parent="#cr">
											<div class="panel-body">
												<div class="row">
													<div class="col-sm-12">
														<div class="form-group bs-float-label">
															<input required class="form-control float-input"
																name="fiden_otro_dato" placeholder="" id="fiden_otro_dato"
																value="{{ $fam->otro_dato }}">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<hr>
									<div class="panel-footer center">
										<a href="{{ url()->previous() }}" type="button"
											class="previous btn btn-default">Anterior</a>
										<input type="submit" value="Siguiente" class="btn btn-info">
									</div>
								</div>
								<br> <br>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-1"></div>
		</div>
    </form>
@endsection

@section('js')
	<script>
		//Mi ejemplo de como agregar y eliminar
		function agregar()
		{ 
			$("#tableFam>tbody").append("<tr><td><input type='text' name='nombre[]' placeholder='Nombre' class='form-control'></td> <td><input type='number' name='edad[]' placeholder='Edad' class='form-control'></td><td><select required name='escolaridad[]'class='form-control float-input'><option   value=''>Seleccione una opcion</option><option value='Prescolar'  >Prescolar</option><option value='Primaria'  >Primaria</option><option value='Secundaria'  >Secundaria</option><option value='Media superior'  >Media superior</option><option value='Superior'  >Superior</option><option value='Posgrado'  >Posgrado</option></select></td><td><select required name='parentesco[]'class='form-control float-input'><option   value=''>Seleccione una opcion</option><option value='Padre'  >Padre</option><option value='Madre'  >Madre</option><option value='Hermano'  >Hermano</option><option value='Hermana'  >Hermana</option><option value='Yo'  >Yo</option></select></td><td><select required name='actitud[]' class='form-control float-input'><option   value=''>Seleccione una opcion</option><option   value='Buena'>Buena</option><option    value='Regular'>Regular</option><option   value='Mala'>Mala</option></select></td> <td><button onclick='eliminar()' class='btn btn-success'>Borrar</button></td></tr>");	

		}

		function eliminar()
		{
			var td = event.target.parentNode;
			var tr = td.parentNode;
			var index = Array.from(tr.parentNode.children).indexOf(tr);
			tr.parentNode.removeChild(tr);
		}
	</script>
@endsection