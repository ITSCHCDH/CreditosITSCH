@extends('template.molde')

@section('title','Alumnos')

@section('ruta')
    <label class="label label-success"> <a href="#">STA</a> / <a href="{{ route('analisis.index') }}">Jefes de carrera</a>/Ficha del alumno</label> 
@endsection

@section('contenido')
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
            <div class="col-sm-2"><img src="{{ asset('/images/itsch.jpg') }}" alt="Logo itsch" style="width: 60px;"></div>
            <div class="col-sm-8"><h5>TECNOLÓGICO NACIONAL DE MÉXICO CAMPUS CIUDAD HIDALGO</h5></div>
            <div class="col-sm-2">
                @if($alu->foto==null)
                    <img
                        src="{{ asset('images/user.png') }}"
                        alt="Imagen del alumno"
                        class="img-fluid rounded-start"
                        style="width: 50px;"
                    />
                @else
                    <img
                        src="{{ asset('storage/alumnos/img/'.$alu->foto) }}"
                        alt="Imagen del alumno"
                        class="img-fluid rounded-start"
                        style="width: 50px;"
                    />
                @endif
            </div>
        </div>       
         
        <hr style="height: 1px; border:none; background-color: orange;">     
        <div class="row">
            <div class="col-sm-4">
                <b>Numero de Control:</b> {{ $alu1->alu_NumControl }}            
            </div>
            <div class="col-sm-4">
                <b>Nombre:</b> {{ $alu1->alu_Nombre }} {{ $alu1->alu_ApePaterno }} {{$alu1->alu_ApeMaterno }}
            </div>
            <div class="col-sm-4">
                <b>Carrera:</b> {{$car->car_NombreCorto}}
            </div>
        </div>  
        <br>
        <h5>Datos personales</h5>
        <hr>  
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <table class="table">
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
            <div class="col-sm-2"></div>
        </div>
        <h5>Datos del padre</h5>
        <hr>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <table class="table">
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
            <div class="col-sm-2"></div>
        </div> 
        <h5>Datos de la madre</h5>
        <hr>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <table class="table">
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
            <div class="col-sm-2"></div>
        </div>  
        <h5>Estado de salud</h5>
        <hr> 
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <table class="table">
                    <tbody>
                        <tr>
                            <td><b>Enfermedades: </b></td>
                            <td>{{ $enfermedades }}</td>
                        </tr>
                        <tr>
                            <td><b>Discapacidades: </b></td>
                            <td>{{ $discapacidades }}</td>
                        </tr>   
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
            <div class="col-sm-2"></div>
        </div>  
        <h5> Familiares </h5>
        <hr> 
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Edad</th>
                            <th>Escolaridad</th>
                            <th>Parentesco</th>
                            <th>Relación con el/ella</th>
                        </tr>                
                    </thead>           
                    <tbody class="txtSmall">
                        @foreach($familiares as $fami )
                            <tr>
                                <td class="etTd">{{ $fami->nombre }}</td> 
                                <td class="etTd">{{$fami->edad }}</td>
                                <td class="etTd">{{ $fami->escolaridad }}</td>
                                <td class="etTd">{{ $fami->parentesco }}</td>
                                <td class="etTd">{{ $fami->relacion }}</td>
                            </tr>                    
                        @endforeach
                    </tbody>
                </table> 
            </div>
            <div class="col-sm-2"></div>
        </div>  
        <h5>Situación familiar</h5> 
        <hr> 
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <table class="table">
                    <tbody>
                        <tr>
                            <td><b>¿Existen dificultades? ¿De qué tipo?</b></td>
                            <td>{{ $fam->dificultades }}</td>
                        </tr>
                        <tr>
                            <td><b>¿Con quién te sientes más ligado afectivamente?</b></td>
                            <td>{{ $fam->ligado . ', ' . $fam->ligado_por }}</td>
                        </tr>
                        <tr>
                            <td><b>¿Quién se ocupa más directamente de tu educación?</b></td>
                            <td> {{ $fam->edu }}</td>
                        </tr>
                        <tr>
                            <td><b>¿Quién ha influido más en tu decisión para estudiar esta carrera?</b></td>
                            <td>{{ $fam->carrera }}</td>
                        </tr>
                        <tr>
                            <td><b>Consideras importante facilitar algún otro dato sobre tu ambiente familiar</b></td>
                            <td>{{ $fam->dificultades }}</td>
                        </tr>              
                    </tbody>
                </table>  
            </div>
            <div class="col-sm-2"></div>
        </div>  
        <h5> Área social</h5>
        <hr>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <table class="table">
                    <tbody>
                        <tr>
                            <td><b>¿Cómo es la relación con los compañeros?</b></td>
                            <td>{{ $soc->rel_comp . ', ' . $soc->comp_por }}</td>
                        </tr>
                        <tr>
                            <td><b>¿Como es la relación con tus amigos?</b></td>
                            <td>{{ $soc->rel_amig . ', ' . $soc->amig_por }}</td>
                        </tr>
                        <tr>
                            <td><b>¿Cómo es la relación con tu pareja? (si tienes)</b></td>
                            <td>{{ $soc->pareja }}</td>
                        </tr>
                        <tr>
                            <td><b>¿Cómo es la relación con tus profesores?</b></td>
                            <td>{{ $soc->rel_prof . ', ' . $soc->prof_por }}</td>
                        </tr>
                        <tr>
                            <td><b>¿Como es la relación con las autoridades académicas?</b></td>
                            <td>{{ $soc->rel_auto_ac . ', ' . $soc->auto_ac_por }}</td>
                        </tr>
                        <tr>
                            <td><b>¿Qué haces en tu tiempo libre?</b></td>
                            <td>{{ $soc->tiempo_lib }}</td>
                        </tr>
                        <tr>
                            <td><b>¿Cuál es tu actividad recreativa?</b></td>
                            <td>{{ $soc->recreativa }}</td>
                        </tr>              
                    </tbody>
                </table> 
            </div>
            <div class="col-sm-2"></div>
        </div>  
        <h5>Plan de vida</h5>
        <hr>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <table class="table">
                    <tbody>
                        <tr>
                            <td><b>¿Cuáles son tus planes inmediatos?</b></td>
                            <td>{{ $soc->planes_in }}</td>
                        </tr>
                        <tr>
                            <td><b>¿Cuáles son tus metas en la vida?</b></td>
                            <td>{{ $soc->metas_vida }}</td>
                        </tr>
                        <tr>
                            <td><b>Yo soy:</b></td>
                            <td>{{ $soc->yo_soy }}</td>
                        </tr>
                        <tr>
                            <td><b>Mi carácter es:</b></td>
                            <td>{{ $soc->caracter }}</td>
                        </tr>
                        <tr>
                            <td><b>A mí me gusta:</b></td>
                            <td> {{ $soc->me_gusta }}</td>
                        </tr>
                        <tr>
                            <td><b>Yo aspiro en la vida</b></td>
                            <td>{{ $soc->aspiraciones }} </td>
                        </tr>
                        <tr>
                            <td><b>Yo tengo miedo:</b></td>
                            <td>{{ $soc->miedo }}</td>
                        </tr>
                       
                    </tbody>
                </table>
            </div>
            <div class="col-sm-2"></div>
        </div>            
@endsection