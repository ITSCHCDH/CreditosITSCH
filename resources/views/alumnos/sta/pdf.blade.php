
<!DOCTYPE html>
<html lang="en">
    <head>   
        <title>{{ $alu->no_cont }}</title>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">        

        
    </head>

    <body style="background-color:rgb(255, 255, 255);">
        <?php
            $anios = \Carbon\Carbon::parse($alu2->alc_FechaNac)->age;
            $enfermedades = "";
            $discapacidades = "";
            if($alu1->alu_Sexo =="M" ){
                $sex="Hombre";
            }else {
                $sex="Mujer";
            }  
            if ($clinicos->enfermedad =="No") {
                    $enfermedades = $clinicos->enfermedad;
            }else {
                $enfermedades = "Sí, las siguientes: ";
                if ($clinicos->diabetes == 'Diabetes') {
                    $enfermedades = $enfermedades . 'Diabetes ';
                }
                if ($clinicos->hipertension == 'Hipertensión') {
                    $enfermedades = $enfermedades . 'Hipertensión ';
                }
                if ($clinicos->epilepsia == 'Epilepsia') {
                    $enfermedades = $enfermedades . 'Epilepsia ';
                }
                if ($clinicos->anorexia == 'Anorexia') {
                    $enfermedades = $enfermedades . 'Anorexia ';
                }
                if ($clinicos->bulimia == 'Bulimia') {
                    $enfermedades =  $enfermedades . 'Bulimia ';
                }
                if ($clinicos->sexual == 'Enfermedad de Transmisión Sexual') {
                    $enfermedades = $enfermedades . 'Enfermedad de Transmisión Sexual ';
                }
                if ($clinicos->depresion == 'Depresión') {
                    $enfermedades = $enfermedades . 'Depresión ';
                }
                if ($clinicos->tristeza == 'Tristeza Profunda') {
                    $enfermedades = $enfermedades . 'Tristeza Profunda ';
                }
                if ($clinicos->otra_enf != '') {
                    $enfermedades = $enfermedades . $clinicos->otra_enf;
                }
            }
            if ($clinicos->cap_dif == 'No') {
                    $discapacidades = $clinicos->cap_dif;
            }else {
                $discapacidades = "Sí, las siguientes: ";
                if ($clinicos->vista == 'Vista') {
                    $discapacidades = $discapacidades . 'Vista ';
                }
                if ($clinicos->oido == 'Oído') {
                    $discapacidades = $discapacidades . 'Oído ';
                }
                if ($clinicos->lenguaje == 'Lenguaje') {
                    $discapacidades = $discapacidades . 'Lenguaje ';
                }
                if ($clinicos->motora == 'Motora') {
                    $discapacidades = $discapacidades . 'Motora ';
                }
                if ($clinicos->otra_enf != '') {
                    $discapacidades =  $discapacidades . $clinicos->otra_enf;
                }
            }
        ?>
        
        <div class="row">
            <div class="col-sm-4">x</div>
            <div class="col-sm-4">x</div>
            <div class="col-sm-4">x</div>
        </div>

        <div><img src="{{ asset('/images/itsch.jpg') }}" alt="Logo itsch" style="width: 60px;"></div>
        <div class="row" style="text-align: center;">
            <h5>TECNOLÓGICO NACIONAL DE MÉXICO CAMPUS CIUDAD HIDALGO</h5>
        </div>
        <hr style="height: .5px; background-color: orange;">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td width="200px"><b>Numero de Control:</b></td>
                    <td>{{ $alu->no_cont }}</td>
                    <td><b>Nombre:</b></td>
                    <td width="200px">{{ $alu1->alu_Nombre }} {{ $alu1->alu_ApePaterno }} {{$alu1->alu_ApeMaterno }}</td>
                    <td><b>Carrera:</b></td>
                    <td width="200px">{{$car->car_NombreCorto}}</td>
                </tr>
            </tbody>
        </table>     

        <div class="nav">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <br><br>
                <div class="row">              
                    
                    <div class="row">
                        <div class=" col-md-4">
                            <table class="table table-user-information">
                                <tbody>
                                    <tr>
                                        <td><b>Fecha de nacimiento:</b></td>
                                        <td>{{ $alu2->alc_FechaNac }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Edad:</b></td>
                                        <td>{{ $anios }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Sexo:</b></td>
                                        <td>{{ $sex }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Trabaja:</b></td>
                                        <td>{{ $person->trab }} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class=" col-md-4">
                            <table class="table table-user-information">
                                <tbody>
                                    <tr>
                                        <td><b>Lugar de nacimiento:</b></td>
                                        <td>{{ $alu->lug_pro }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Estatura:</b> </td>
                                        <td>{{ $clinicos->estatura }}m</td>
                                    </tr>
                                    <tr>
                                        <td><b>Sangre:</b></td>
                                        <td>{{ $clinicos->sangre }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Correo electronico:</b></td>
                                        <td>{{ $alu->email }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class=" col-md-4">
                            <table class="table table-user-information">
                                <tbody>
                                    <tr>
                                        <td><b>Estado civil:</b></td>
                                        <td>{{ $alu->est_civ }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Peso:</b> </td>
                                        <td>{{ $clinicos->peso }}Kg</td>
                                    </tr>
                                    <tr>
                                        <td><b>Teléfono:</b></td>
                                        <td>{{ $alu->tel }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>La casa donde vives es:</b></td>
                                        <td>{{ $person->casa }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Dirección :</b></td>
                                        <td>{{ $direccion->estado . " " . $direccion->municipio . " " . $direccion->cp . " "
                                            . $direccion->colonia . " " . $direccion->direccion }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <hr><br>
                    <div class="row">
                        <div class=" col-md-4">
                            <table class="table table-user-information">
                                <tbody>
                                    <tr>
                                        <td><b>Nombre del padre:</b></td>
                                        <td>{{ $dPad->nombre }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Teléfono:</b> </td>
                                        <td>{{ $dPad->tel }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Edad:</b></td>
                                        <td>{{ $dPad->edad }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Trabaja: </b></td>
                                        <td>{{ $dPad->ocupacion }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Domicilio:</b></td>
                                        <td>{{ $direccionP->estado . " " . $direccionP->municipio . " " . $direccionP->cp .
                                            " "
                                            . $direccionP->colonia . " " . $direccionP->direccion }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Profesión:</b> </td>
                                        <td>{{ $dPad->profesion }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <hr><br>
                    <div class="row">
                        <div class=" col-md-4">
                            <table class="table table-user-information">
                                <tbody>
                                    <tr>
                                        <td><b>Nombre de la madre:</b></td>
                                        <td>{{ $dMad->nombre }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Teléfono:</b> </td>
                                        <td>{{ $dMad->tel }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Edad:</b></td>
                                        <td>{{ $dMad->edad }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Trabaja:</b> </td>
                                        <td>{{ $dMad->ocupacion }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Domicilio:</b></td>
                                        <td>{{ $direccionM->estado . " " . $direccionM->municipio . " " . $direccionM->cp .
                                            " "
                                            . $direccionM->colonia . " " . $direccionM->direccion }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Profesión:</b> </td>
                                        <td>{{ $dMad->profesion }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <hr color="#000000">
                    <h4 class="head text-center"> <b>SALUD</b> </h4>
                    <div class="row">
                        <div class=" col-md-6">
                            <table class="table table-user-information">
                                <tbody>
                                    <tr>
                                        <td><b>Enfermedades: </b></td>
                                        <td>{{ $enfermedades }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Discapacidades: </b></td>
                                        <td>{{ $discapacidades }}</td>
                                    </tr>                              
                                </tbody>
                            </table>
                        </div>
                        <div class=" col-md-6">
                            <table class="table table-user-information">
                                <tbody>
                                    <tr>
                                        <td><b>Diagnóstico Clínico:</b></td>
                                        <td>{{ $clinicos->dia_med }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Hace cuánto:</b> </td>
                                        <td>{{ $clinicos->cuanto_med }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Diagnóstico Psicológico:</b></td>
                                        <td>{{ $clinicos->dia_psico }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Hace cuánto:</b></td>
                                        <td>{{ $clinicos->cuanto_psico }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <hr color="#000000">
                    <h4 class="head text-center"> <b>DATOS FAMILIARES</b> </h4>
                    <h4> <b>Tabla de familiares</b> </h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Edad</th>
                                <th>Escolaridad</th>
                                <th>Parentesco</th>
                                <th>Relación con el/ella</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($familiares as $fami )
                            <tr>
                                <td>{{ $fami->nombre }}</td>
                                <td>{{$fami->edad }}</td>
                                <td>{{ $fami->escolaridad }}</td>
                                <td>{{ $fami->parentesco }}</td>
                                <td>{{ $fami->relacion }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h4> <b>¿Existen dificultades? ¿De qué tipo?</b> </h4>
                    <p>{{ $fam->dificultades }} </p>
                    <h4> <b>¿Con quién te sientes más ligado afectivamente?</b> </h4>
                    <p> {{ $fam->ligado . ', ' . $fam->ligado_por }} </p>
                    <h4> <b>¿Quién se ocupa más directamente de tu educación?</b> </h4>
                    <p> {{ $fam->edu }} </p>
                    <h4> <b>¿Quién ha influido más en tu decisión para estudiar esta carrera?</b> </h4>
                    <p> {{ $fam->carrera }} </p>
                    <h4> <b>Consideras importante facilitar algún otro dato sobre tu ambiente familiar</b> </h4>
                    <p>{{ $fam->dificultades }} </p>
                    <hr color="#000000">
                    <h4 class="head text-center"> <b>ÁREA SOCIAL</b> </h4>
                    <h4> <b>¿Cómo es la relación con los compañeros?</b> </h4>
                    <p>{{ $soc->rel_comp . ', ' . $soc->comp_por }} </h5>
                    <h4> <b>¿Como es la relación con tus amigos?</b> </h4>
                    <p> {{ $soc->rel_amig . ', ' . $soc->amig_por }} </p>
                    <h4> <b>¿Cómo es la relación con tu pareja? (si tienes)</b> </h4>
                    <p> {{ $soc->pareja }}</p>
                    <h4> <b>¿Cómo es la relación con tus profesores?</b> </h4>
                    <p> {{ $soc->rel_prof . ', ' . $soc->prof_por }} </p>
                    <h4> <b>¿Como es la relación con las autoridades académicas?</b> </h4>
                    <p> {{ $soc->rel_auto_ac . ', ' . $soc->auto_ac_por }}</p>
                    <h4> <b>¿Qué haces en tu tiempo libre?</b> </h4>
                    <p> {{ $soc->tiempo_lib }} </p>
                    <h4> <b>¿Cuál es tu actividad recreativa?</b> </h4>
                    <p>{{ $soc->recreativa }}</p>
                    <hr color="#000000">
                    <h4 class="head text-center"> <b>PLAN DE VIDA</b> </h4>
                    <h4> <b>¿Cuáles son tus planes inmediatos?</b> </h4>
                    <p>{{ $soc->planes_in }}</p>
                    <h4> <b>¿Cuáles son tus metas en la vida?</b> </h4>
                    <p> {{ $soc->metas_vida }} </p>
                    <h4> <b>Yo soy:</b> </h4>
                    <p> {{ $soc->yo_soy }} </p>
                    <h4> <b>Mi carácter es:</b> </h4>
                    <p> {{ $soc->caracter }} </p>
                    <br>
                    <h4> <b>A mí me gusta:</b> </h4>
                    <p> {{ $soc->me_gusta }} </p>
                    <h4> <b>Yo aspiro en la vida</b> </h4>
                    <p>{{ $soc->aspiraciones }} </p>
                    <h4> <b>Yo tengo miedo:</b> </h4>
                    <p>{{ $soc->miedo }}</p>
                    <br><br><br>
                    <h4 class="head text-center" style="text-align: center">
                        <hr width=30% color="#000000">
                        <b style="color:#000000"> Firma</b>
                        <b style="color:#000000"> {{ $alu->nombre }} {{ $alu->a_pat }} {{ $alu->a_mat }}</b>
                    </h4>
                    <br><br><br>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>       
    </body>

</html>