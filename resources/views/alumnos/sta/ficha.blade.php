@extends('template.molde')

@section('title','Actividades')

@section('ruta')
	<a href="" class="label label-info">STA</a>
	/
	<label class="label label-success">Ficha de identificación</label>
@endsection

@section('contenido')
	<?php
		$anios = \Carbon\Carbon::parse($alu2->alc_FechaNac)->age;
		if($alu1->alu_Sexo =="M" ){
			$sex="Hombre";
		}else {
			$sex="Mujer";
		}  
	?>
	<form action="{{ route('alumnos.sta.ficha.guargar', $alu->no_control) }}" id="fr" method="get">
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<div class="card ">
					<div class="container cuerpo">
						<div class="row">
							<fieldset class="col-md-12">
								{{--cabecera--}}
								<div>
									<div class="panel-heading">
										<h3 class="head text-center">FICHA DE IDENTIFICACIÓN DEL ALUMNO TUTORADO</h3>
										<div class="head text-center">
											<h4>Datos Personales </h4>
										</div>
										<br>
										<div class="progress" style="height: 18px">
											<div class="progress-bar progress-bar-striped progress-bar-animated"
												role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"
												style="width: 20%">20%</div>
										</div>
									</div>
								</div>
								<br>								
								<div>
									{{--nombre--}}
									<div class="panel">										
										<h5>Nombre completo</h5>										
										<div class="col-md-1"></div>
										<div class="panel-body">
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group bs-float-label">
														<label class="float-label">Nombre(s)</label>
														<br>
														<label id="nombre" name="nombre"><b>{{ $alu1->alu_Nombre }} </b> </label>
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group bs-float-label">
														<label class="float-label">Apellido
															Paterno</label>
														<br>
														<label id="a_pat" name="a_pat"><b>{{ $alu1->alu_ApePaterno }}</b>  </label>
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group bs-float-label">
														<label class="float-label">Apellido
															Materno</label>
														<br>
														<label id="a_mat" name="a_mat"><b>{{$alu1->alu_ApeMaterno }}</b>  </label>
													</div>
												</div>
											</div>
										</div>										
									</div>
									<hr>
									{{--Fisico--}}
									<div class="panel ">
										<div class="panel-heading ">
											<h5 class="panel-title" class="accordion-toggle collapsed"
												data-toggle="collapse" href="#fisic">
												<a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
													href="#fisic">Físico</a>
												<a> <i class="fa fa-angle-down"></i></a>
											</h5>
										</div>
										<div id="fisic" class="panel-collapse collapse" data-parent="#cr">
											<div class="panel-body">
												<div class="row">
													<div class="col-sm-4">
														<div class="form-group bs-float-label">														
															<label id="edad" name="edad"> Edad</label><br>
															<label for='edad' class="float-label">{{$anios}}</label>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form-group bs-float-label">
															<input id='estatura' name='estatura' type="number" min="0" 
																class="form-control float-input"
																value="{{ $clinicos->estatura }}" step="0.1" required>
															<label for='estatura' class="float-label">Estatura
																<sub>m</sub></label>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form-group bs-float-label">
															<input id='peso' name='peso' type="number" min="0"
																class="form-control float-input"
																value="{{ $clinicos->peso }}" step="1" required>
															<label for='peso' class="float-label">Peso <sub>kg</sub></label>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-4">
														<div class="form-group bs-float-label">
															{{--<select id="sexo" name="sexo"
																class="form-control float-input" required>
																<option value="">Seleccione una Opcion</option>
																<option value="M" @if($alu->sexo=='M') selected
																	@endif>Hombre</option>
																<option value="F" @if($alu->sexo=='F') selected @endif>Mujer
																</option>
															</select>--}}
															<label id="sexo" name="sexo"> Sexo
															</label><br>
															<label for='sexo' class="float-label">{{
																$sex }}</label>

														</div>
													</div>
													<div class="col-sm-4">
														<div class="form-group bs-float-label">
															<select id="sangre" name="sangre"
																class="form-control float-input" required>
																<option value="">Seleccione un tipo de
																	sangre</option>
																<option value='A+' @if($clinicos->
																	sangre=='A+') selected
																	@endif>A+</option>
																<option value='A-' @if($clinicos->
																	sangre=='A-') selected
																	@endif>A-</option>
																<option value='B+' @if($clinicos->
																	sangre=='B+') selected
																	@endif>B+</option>
																<option value='B-' @if($clinicos->
																	sangre=='B-') selected
																	@endif>B-</option>
																<option value='AB+' @if($clinicos->
																	sangre=='AB+') selected
																	@endif>AB+</option>
																<option value='AB-' @if($clinicos->
																	sangre=='AB-') selected
																	@endif>AB-</option>
																<option value='O+' @if($clinicos->
																	sangre=='O+') selected
																	@endif>O+</option>
																<option value='O-' @if($clinicos->
																	sangre=='O-') selected
																	@endif>O-</option>
															</select>
															<label for='sangre' class="float-label">Tipo de sangre</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									{{--Grupo--}}
									<div class="panel ">
										<div class="panel-heading">
											<h5 class="panel-title" lass="accordion-toggle collapsed" data-toggle="collapse"
												href="#grupo">
												<a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
													href="#grupo">Grupo</a>
												<a> <i class="fa fa-angle-down"></i></a>
											</h5>
										</div>
										<div id="grupo" class="panel-collapse collapse" data-parent="#cr">
											<div class="panel-body">
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group bs-float-label">
															{{-- <input type="text" class="form-control float-input"
																value="{{$carrera->nom_carr}}" required> --}}
															<label>Carrera</label><br>
															<label class="float-label"> {{$car->car_NombreCorto }}</label>

														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group bs-float-label">
															<input id="grupo" name="grupo" maxlength="6" type="text"
																class="form-control float-input" value="{{ $alu->grupo }}"
																required>
															<label for="grupo" class="float-label">Grupo</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									{{--Fecha de nacimiento--}}
									<div class="panel">
										<div class="panel-heading ">
											<h5 class="panel-title" class="accordion-toggle collapsed"
												data-toggle="collapse" href="#fenac">
												<a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
													href="#fenac">Fecha
													de nacimiento</a>
												<a> <i class="fa fa-angle-down"></i></a>
											</h5>
										</div>
										<div id="fenac" class="panel-collapse collapse" data-parent="#cr">
											<div class="panel-body">
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group bs-float-label">
															<label>Fecha de Nacimiento
															</label><br>
															<label class="float-label"> {{$alu2->alc_FechaNac }}</label>

															{{-- <input id="nac" name="nac" type="date"
																class="form-control float-input" value="{{ $alu->fec_nac }}"
																required>
															<label for="nac" class="float-label">Fecha de Nacimiento</label>
															--}}
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group bs-float-label">
															<input id="lug" name="lug" type="text"
																class="form-control float-input" value="{{ $alu->lug_pro }}"
																required>
															<label for="lug" class="float-label">Lugar de Nacimiento</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									{{--Estado civil--}}
									<div class="panel ">
										<div class="panel-heading ">
											<h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#edci"
												class="panel-title">
												<a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
													href="#edci">Estado civil</a>
												<a> <i class="fa fa-angle-down"></i></a>
											</h5>
										</div>
										<div id="edci" class="panel-collapse collapse" data-parent="#cr">
											<div class="panel-body">
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group bs-float-label">
															<select class="form-control float-input" id="est_civ"
																name="est_civ" required>
																<option value="">Seleccione una opción
																</option>
																<option value='Soltero' @if($alu->
																	est_civ=='Soltero')
																	selected
																	@endif >Soltero</option>
																<option value='Casado' @if($alu->
																	est_civ=='Casado') selected
																	@endif>Casado</option>
																<option value='Separado' @if($alu->
																	est_civ=='Separado')
																	selected
																	@endif>Separado</option>
																<option value='Divorciado' @if($alu->
																	est_civ=='Divorciado')
																	selected
																	@endif>Divorciado</option>
																<option value='Viúdo' @if($alu->
																	est_civ=='Viúdo') selected
																	@endif>Viúdo</option>
																<option value='Unión Libre' @if($alu->
																	est_civ=='Unión
																	Libre') selected
																	@endif>Unión Libre</option>
															</select>
															<label class="float-label">Estado Civil</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									{{--Trabajo--}}
									<div class="panel panel-default">
										<div class="panel-heading ">
											<h5 class="accordion-toggle collapsed " data-toggle="collapse"
												href="#inputTrabajo" class="panel-title">
												<a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
													href="#inputTrabajo">¿Trabajas?</a>
												<a> <i class="fa fa-angle-down"></i></a>
											</h5>
										</div>
										<div id="inputTrabajo" class="panel-collapse collapse" data-parent="#cr">
											<div class="panel-body">
												<div class="row">
													<div class="col-sm-6">
														<label class="radio-inline">
															<input required @if($person->trab!='No') checked
															@endif type="radio" name="trAlu" id="trAlu1" value="Si"
															onclick="$('#trabajo').attr('value','').attr('readonly',
															false).attr('required',true);"> Si
														</label>
														<label class="radio-inline">
															<input required
																onclick="$('#trabajo').attr('value','').attr('readonly',true).attr('required',false);"
																@if($person->trab=='No') checked @endif
															type="radio" name="trAlu" id="trAlu2" value="No"
															>No</label>
													</div>
													<div class="col-sm-6">
														<div class="form-group bs-float-label">
															<input @if($person->trab=='No') readonly @endif type="text"
															name="trabajo" id="trabajo"
															class="form-control float-input" value="{{ $person->trab }}" />
															<label for="trabajo" class="float-label">En qué lugar
																trabajas</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									{{--Domicilio Actual--}}
									<div class="panel panel-default">
										<div class="panel-heading">
											<h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#domi"
												class="panel-title">
												<a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
													href="#domi">Domicilio actual</a>
												<a> <i class="fa fa-angle-down"></i></a>
											</h5>
										</div>
										<div id="domi" class="panel-collapse collapse" data-parent="#cr">
											<div class="panel-body">
												<div class="row">
													<div class="col-sm-4">
														<div class="form-group bs-float-label">
															<input required type="text" class="form-control float-input"
																id="estado" name="estado" placeholder="Estado"
																value="{{ $direccion->estado }}">
															<label for="estado" class="float-label">Estado</label>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form-group bs-float-label">
															<input required type="text" class="form-control float-input"
																id="municipio" name="municipio" placeholder="Municipio"
																value="{{ $direccion->municipio }}">
															<label for="municipio" class="float-label">Municipio</label>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form-group bs-float-label">
															<input required type="number" class="form-control float-input"
																if="cp" name="cp" placeholder="Código postal"
																value="{{ $direccion->cp }}">
															<label for="cp" class="float-label">Código postal</label>
														</div>
													</div>
												</div>
												<br />
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group bs-float-label">
															<input required type="text" class="form-control float-input"
																id="direccion" name="direccion" placeholder="Calle"
																value="{{ $direccion->direccion }}">
															<label for="direccion" class="float-label">Calle</label>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group bs-float-label">
															<input required type="text" class="form-control float-input"
																id="colonia" name="colonia" placeholder="Colonia"
																value="{{ $direccion->colonia }}">
															<label for="colonia" class="float-label">Colonia</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									{{--casa--}}
									<div class="panel panel-default">
										<div class="panel-heading">
											<h5 class="accordion-toggle collapsed " data-toggle="collapse" href="#casaedo"
												class="panel-title">
												<a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
													href="#casaedo">La casa donde vives es:</a>
												<a> <i class="fa fa-angle-down"></i></a>
											</h5>
										</div>
										<div id="casaedo" class="panel-collapse collapse" data-parent="#cr">
											<div class="panel-body">
												<div class="row">
													<div class="col-sm-6">
														<label class="radio-inline">
															<input required @if($person->casa=='Rentada') checked @endif
															type="radio"
															name="casa" value="Rentada"
															onclick="$('#casatipo').attr('readonly',true).attr('value','').attr('required',false);">
															Rentada
														</label>
														<label class="radio-inline">
															<input required @if($person->casa=='Prestada') checked @endif
															type="radio" name="casa" value="Prestada"
															onclick="$('#casatipo').attr('readonly',true).attr('value','').attr('required',false);">
															Prestada
														</label>
														<label class="radio-inline">
															<input required @if($person->casa=='Propia') checked @endif
															type="radio"
															name="casa" value="Propia"
															onclick="$('#casatipo').attr('readonly',true).attr('value','').attr('required',false);">
															Propia
														</label>
														<label class="radio-inline">
															<input required @if($person->casa!='Rentada' &&
															$person->casa!='Prestada'
															&& $person->casa!='Propia') checked
															@endif type="radio" name="casa" value="Otro"
															onclick="$('#casatipo').attr('value','').attr('readonly',
															false).attr('required',true);"> Otro
														</label>
													</div>
													<div class="col-sm-6">
														<div class="form-group bs-float-label">
															<input @if($person->casa=='Rentada' || $person->casa=='Prestada'
															|| $person->casa=='Propia') readonly @endif type="text"
															name="casatipo" id="casatipo"
															class="form-control float-input" value="{{ $person->casa }}">
															<label for="casatipo" class="float-label">Define tu casa</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									{{--identificacion 2--}}
									<div class="panel panel-default">
										<div class="panel-heading">
											<h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#datai2"
												class="panel-title">
												<a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
													href="#datai2">Datos de identificación 2</a>
												<a> <i class="fa fa-angle-down"></i></a>
											</h5>
										</div>
										<div id="datai2" class="panel-collapse collapse" data-parent="#cr">
											<div class="panel-body">
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group bs-float-label">
															<input type="text" id="tel" name="tel"
																class="form-control float-input"
																placeholder="Número de Teléfono" value="{{ $alu->tel }}"
																required>
															<label for="tel" class="float-label">Número de teléfono</label>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group bs-float-label">
															<input type="email" id="email" name="email"
																class="form-control float-input"
																placeholder="Correo Electronico" value="{{ $alu->email }}"
																required>
															<label for="email" class="float-label">Correo
																Electrónico</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									{{--num de personas con las que vives--}}
									<div class="panel panel-default">
										<div class="panel-heading">
											<h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#nump"
												class="panel-title">
												<a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
													href="#nump">Número de personas con las que
													vives</a>
												<a> <i class="fa fa-angle-down"></i></a>
											</h5>
										</div>
										<div id="nump" class="panel-collapse collapse" data-parent="#cr">
											<div class="panel-body">
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group bs-float-label">
															<input type="number" name="num_person" id="num_person"
																class="form-control float-input"
																placeholder="Número de personas con las que vives"
																value="{{ $person->num_person }}" required />
															<label for="num_person" class="float-label">Número de
																personas
																con las que vives</label>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group bs-float-label">
															<input type="text" name="parentesco" id="parentesco"
																class="form-control float-input" placeholder="Parentesco"
																value="{{ $person->parentesco }}" required />
															<label for="parentesco" class="float-label">Parentesco</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									{{--dat padre--}}
									<div class="panel panel-default">
										<div class="panel-heading">
											<h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#datPad"
												class="panel-title">
												<a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
													href="#datPad">Datos del padre</a>
												<a> <i class="fa fa-angle-down"></i></a>
											</h5>
										</div>
										<div id="datPad" class="panel-collapse collapse" data-parent="#cr">
											<div class="panel-body">
												<div class="row">
													<div class="col-sm-5">
														<div class="form-group bs-float-label">
															<input required type="text" class="form-control float-input"
																name="nomPa" id="nomPa" placeholder="Nombre"
																value="{{ $dPad->nombre }}">
															<label for="nomPa" class="float-label">Nombre Completo</label>
														</div>
													</div>
													<div class="col-sm-2">
														<div class="form-group bs-float-label">
															<input required type="number" name="EdadPa" id="EdadPa"
																class="form-control float-input"
																placeholder="Edad del Padre" value="{{ $dPad->edad }}" />
															<label for="EdadPa" class="float-label">Edad del
																Padre</label>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form-group bs-float-label">
															<input required type="text" name="TelPa" id="TelPa"
																class="form-control float-input"
																placeholder="Telefono del padre" value="{{ $dPad->tel }}" />
															<label for="TelPa" class="float-label">Teléfono del
																padre</label>
														</div>
													</div>
												</div>
												<br>
												<div class="row">
													<div class="col-sm-4">
														<label>¿Trabaja?</label>
														<label class="radio-inline">
															<input required @if($dPad->ocupacion!='No') checked
															@endif type="radio" name="trPad" id="trPad1" value="Si"
															onclick="$('#trabPatext').attr('value','').attr('readonly',
															false).attr('required',true);"> Si
														</label>
														<label class="radio-inline">
															<input required
																onclick="$('#trabPatext').attr('value','').attr('readonly',true).attr('required',false);"
																@if($dPad->ocupacion=='No') checked @endif
															type="radio" name="trPad" id="trPad2" value="No"> No
														</label>
													</div>
													<div class="col-sm-4">
														<input @if($dPad->ocupacion=='No') readonly @endif type="text"
														name="trabPatext" id="trabPatext"
														class="form-control float-input"
														placeholder="En que trabaja tu Padre"
														value="{{ $dPad->ocupacion }}" />
														<label for="trabPatext" class="float-label">En que trabaja tu
															Padre</label>
													</div>
													<div class="col-sm-4">
														<div class="form-group bs-float-label">
															<input required type="text" name="ProfPa" id="ProfPa"
																class="form-control float-input"
																placeholder="Profecion del Padre"
																value="{{ $dPad->profesion }}" />
															<label for="ProfPa" class="float-label">Profesión del
																Padre</label>
														</div>
													</div>
												</div>
												<br>
												<div class="row">
													<div class="col-sm-12">
														<label style="font-weight: bold">Dirección del Padre</label>
														<div class="form-group bs-float-label">
															<div class="row">
																<div class="col-sm-4">
																	<div class="form-group bs-float-label">
																		<input required type="text"
																			class="form-control float-input" id="estadoP"
																			name="estadoP" placeholder="Estado"
																			value="{{ $direccionP->estado }}">
																		<label for="estadoP"
																			class="float-label">Estado</label>
																	</div>
																</div>
																<div class="col-sm-4">
																	<div class="form-group bs-float-label">
																		<input required type="text"
																			class="form-control float-input" id="municipioP"
																			name="municipioP" placeholder="Municipio"
																			value="{{ $direccionP->municipio }}">
																		<label for="municipioP"
																			class="float-label">Municipio</label>
																	</div>
																</div>
																<div class="col-sm-4">
																	<div class="form-group bs-float-label">
																		<input required type="number"
																			class="form-control float-input" if="cpP"
																			name="cpP" placeholder="Código postal"
																			value="{{ $direccionP->cp }}">
																		<label for="cpP" class="float-label">Código
																			postal</label>
																	</div>
																</div>
														</div>
														<br />
														<div class="row">
															<div class="col-sm-6">
																<div class="form-group bs-float-label">
																	<input required type="text"
																		class="form-control float-input" id="direccionP"
																		name="direccionP" placeholder="Calle"
																		value="{{ $direccionP->direccion }}">
																	<label for="direccionP"
																		class="float-label">Calle</label>
																</div>
															</div>
															<div class="col-sm-6">
																<div class="form-group bs-float-label">
																	<input required type="text"
																		class="form-control float-input" id="coloniaP"
																		name="coloniaP" placeholder="Colonia"
																		value="{{ $direccionP->colonia }}">
																	<label for="coloniaP"
																		class="float-label">Colonia</label>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								{{--dat madre--}}
								<div class="panel panel-default">
									<div class="panel-heading">
										<h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#datMad"
											class="panel-title">
											<a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
												href="#datMad">Datos de la madre</a>
											<a> <i class="fa fa-angle-down"></i></a>
										</h5>
									</div>
									<div id="datMad" class="panel-collapse collapse" data-parent="#cr">
										<div class="panel-body">
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group bs-float-label">
														<input required type="text" class="form-control float-input"
															name="nomMa" id="nomMa" placeholder="Nombre"
															value="{{ $dMad->nombre }}">
														<label for="nomMa" class="float-label">Nombre Completo</label>
													</div>
												</div>
												<div class="col-sm-2">
													<div class="form-group bs-float-label">
														<input required type="number" name="EdadMa" id="EdadMa"
															class="form-control float-input" placeholder="Edad de la Madre"
															value="{{ $dMad->edad }}" />
														<label for="EdadMa" class="float-label">Edad de la Madre</label>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group bs-float-label">
														<input required type="text" name="TelMa" id="TelMa"
															class="form-control float-input"
															placeholder="Telefono de la Madre" value="{{ $dMad->tel }}" />
														<label for="TelMa" class="float-label">Teléfono de la
															Madre</label>
													</div>
												</div>
											</div>
											<br>
											<div class="row">
												<div class="col-sm-4">
													<label>¿Trabaja?</label>
													<label class="radio-inline">
														<input required @if($dMad->ocupacion!='No') checked
														@endif type="radio" name="trMad" id="trMad1" value="Si"
														onclick="$('#trabMtext').attr('value','').attr('readonly',
														false).attr('required',true);"> Si
													</label>
													<label class="radio-inline">
														<input required
															onclick="$('#trabMtext').attr('value','').attr('readonly',true).attr('required',false);"
															@if($dMad->ocupacion=='No') checked @endif
														type="radio" name="trMad" id="trMad2" value="No">
														No
													</label>
												</div>
												<div class="col-sm-4">
													<input @if($dMad->ocupacion=='No') readonly @endif type="text"
													name="trabMtext" id="trabMtext" class="form-control float-input"
													placeholder="En que trabaja tu Madre" value="{{ $dMad->ocupacion }}" />
													<label for="trabMtext" class="float-label">En que trabaja tu
														Madre</label>
												</div>
												<div class="col-sm-4">
													<div class="form-group bs-float-label">
														<input required type="text" id="ProfMa" name="ProfMa"
															class="form-control float-input"
															placeholder="Profecion de la Madre"
															value="{{ $dMad->profesion }}" />
														<label for="ProfMa" class="float-label">Profesión de la
															Madre</label>
													</div>
												</div>
											</div>
											<br>
											<div class="row">
												<div class="col-sm-12">
													<label style="font-weight: bold">Dirección de la Madre</label>
													<div class="form-group bs-float-label">
														<div class="row">
															<div class="col-sm-4">
																<div class="form-group bs-float-label">
																	<input required type="text"
																		class="form-control float-input" id="estadoM"
																		name="estadoM" placeholder="Estado"
																		value="{{ $direccionM->estado }}">
																	<label for="estadoM" class="float-label">Estado</label>
																</div>
															</div>
															<div class="col-sm-4">
																<div class="form-group bs-float-label">
																	<input required type="text"
																		class="form-control float-input" id="municipioM"
																		name="municipioM" placeholder="Municipio"
																		value="{{ $direccionM->municipio }}">
																	<label for="municipioM"
																		class="float-label">Municipio</label>
																</div>
															</div>
															<div class="col-sm-4">
																<div class="form-group bs-float-label">
																	<input required type="number"
																		class="form-control float-input" if="cpM" name="cpM"
																		placeholder="Código postal"
																		value="{{ $direccionM->cp }}">
																	<label for="cpM" class="float-label">Código
																		postal</label>
																</div>
															</div>
														</div>
														<br />
														<div class="row">
															<div class="col-sm-6">
																<div class="form-group bs-float-label">
																	<input required type="text"
																		class="form-control float-input" id="direccionM"
																		name="direccionM" placeholder="Calle"
																		value="{{ $direccionM->direccion }}">
																	<label for="direccionM"
																		class="float-label">Calle</label>
																</div>
															</div>
															<div class="col-sm-6">
																<div class="form-group bs-float-label">
																	<input required type="text"
																		class="form-control float-input" id="coloniaM"
																		name="coloniaM" placeholder="Colonia"
																		value="{{ $direccionM->colonia }}">
																	<label for="coloniaM"
																		class="float-label">Colonia</label>
																</div>
															</div>
														</div>
														{{--
														<input type="text" name="DomMa" id="DomMa"
															class="form-control float-input"
															placeholder="Domicilio de la Madre"
															value="Mariano Escobedo #25" />
														<label for="DomMa" class="float-label">Domicilio de la
															Madre</label> --}}
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="panel-footer center">
									<hr>
									<a data-toggle="tooltip" type="button" class="btn btn-danger"
										href="">Cancelar</a>
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
		document.addEventListener("DOMContentLoaded", function() {
		document.getElementById("fr").addEventListener('submit', validarFormulario); });
		function validarFormulario(evento) {
		evento.preventDefault();
		var peso = document.getElementById('peso').value;
		if(peso.length == 0 ) {
			alert('Rellena todos los campos');
			return;
		}
		this.submit();
		}
	</script>
@endsection