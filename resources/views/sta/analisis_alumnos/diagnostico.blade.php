@extends('template.molde')

@section('title','Alumnos')

@section('ruta')
    <label class="label label-success"> <a href="#">STA</a> /Diagnostico</label> 
@endsection

@section('contenido')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <img src="{{ asset('images/user.png') }}" class="card-img-top" alt="Datos del alumno"/>
            <div class="card-body">
                <h5 class="card-title">Datos del alumno</h5>
                <h6>Control&nbsp;:&nbsp;&nbsp;{{$alumnos[0]->alu_NumControl}}</h6>
                <h6>Nombre&nbsp;:&nbsp;&nbsp;{{$alumnos[0]->alu_Nombre}} &nbsp;{{$alumnos[0]->alu_ApePaterno}} &nbsp;{{$alumnos[0]->alu_ApeMaterno}}</h6>
                <h6>Último semestre&nbsp;:&nbsp;&nbsp;{{$alumnos[0]->alu_SemestreAct}}</h6>
                <div class="datospersonales">{{$variablegrupo}} 
                    @foreach($grupos as $al)
                        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;{{$al->gse_Observaciones}}
                    @endforeach		
                </div>
                <h6>Carrera&nbsp;:&nbsp;&nbsp;{{$alumnos[0]->car_Nombre}}</h6>
                <h6>Sexo&nbsp;:&nbsp;&nbsp;{{$alumnos[0]->alu_Sexo}}</h6>           
                <h6>Status&nbsp;:&nbsp;&nbsp;{{ $alumnos[0]->alu_StatusAct }}</h6>           
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <h2>Semáforos</h2>
        <table class="table align-middle">
            <thead>
                <tr>
                    <th scope="col" style="text-align: center">Académico</th>
                    <th scope="col" style="text-align: center">Psicológico</th>
                    <th scope="col" style="text-align: center">Médico</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><div class="{{ $alumnos[0]->semaforoAcad }}" data-mdb-toggle="tooltip" title="Académico"></div></td>
                    <td> <div class="CirculoNegro" data-mdb-toggle="tooltip" title="Medico"></div></td>
                    <td><div class="CirculoNegro" data-mdb-toggle="tooltip" title="Psicologico"></div></td>                      
                </tr>
            </tbody>
        </table>
        <br>
        <div>
            {{-- Dibuja la tabla con las calificaciones del semestre actual --}}
            <h2>{{$calificacionesvariable}}</h2>	
            <table class="table table-sm">
                <thead>
                    <tr>
                        {{-- Dibuja en la tabla el numero maximo de unidades --}}
                        <th>{{$unidadesvariable}}</th>
                        @foreach ($unidades as $uni)
                            <th>Unidad&nbsp;{{$uni->lsc_NumUnidad}}</th>
                        @endforeach                
                    </tr>
                </thead>
                <tbody> 
                    @php
                        $temp="";                      
                    @endphp                 
                    @foreach ( $materias as $calif )  
                        <tr> 
                            {{-- Agregamos el nombre de cada materia a la tabla --}}
                            <td> {{   $calif[0]->ret_NomCompleto; }} <P class="txtSmall">(PROFESOR: {{ $calif[0]->profesor; }})</P></td>                                             
                            @foreach ($calif as $c)
                                @if (!$c->lsc_Corte)
                                    <!-- El profesor no ha capturado calificaciones -->
                                    <td data-mdb-toggle="tooltip" title="El profesor no ha capturado la calificación">----</td>
                                @elseif ($c->lsc_Calificacion<70)
                                    {{-- Cambiar a color Rojo las calificaciones menores a 70 --}}   
                                    @if ($c->comentario!="")
                                        {{-- Se agrega el comentario a las materias reprobadas --}}
                                        @php
                                            //Cambiamos el numero de motivo de reprobación por su texto correspondiente
                                            $motivo="";
                                            switch ($c->motivo) {
                                                case 1:
                                                    $motivo="Responsabilidad alumno";
                                                    break;
                                                case 2:
                                                    $motivo="Inasistencia";
                                                    break; 
                                                case 3:
                                                    $motivo="Complejidad materia";
                                                    break;
                                                case 4:
                                                    $motivo="Otro";
                                                    break;                                                 
                                                default:
                                                    $motivo="El profesor no agrego un motivo especifico";
                                                    break;
                                            }
                                        @endphp
                                        <td class="txtRojo"  data-mdb-toggle="tooltip" title="Motivo: {{ $motivo }}. Comentario: {{ $c->comentario }}"> {{   $c->lsc_Calificacion; }}  </td> 
                                    @else
                                        {{-- En caso de que el profesor no agregue comentario --}}
                                        <td class="txtRojo"  data-mdb-toggle="tooltip" title="El profesor no agrego comentarios"> {{   $c->lsc_Calificacion; }}  </td> 
                                    @endif                          
                                @elseif ($c->lsc_Calificacion>=70 && $c->lsc_Calificacion<80)
                                    {{-- Cambiar a color Naranja las calificaciones menores a 80 --}}                                
                                    <td class="txtNaranja"> {{   $c->lsc_Calificacion; }}  </td> 
                                @elseif ($c->lsc_Calificacion>=80 && $c->lsc_Calificacion<86)
                                    {{-- Cambiar a color Amarillo las calificaciones menores a 86 --}}                                
                                    <td class="txtNaranja"> {{   $c->lsc_Calificacion; }}  </td> 
                                @else
                                    {{-- Cambiar a color Verde las calificaciones mayores a 86 --}} 
                                    <td class="txtVerde"> {{   $c->lsc_Calificacion; }}  </td> 
                                @endif                               
                            @endforeach  
                        </tr>                                                                                                     
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<hr>

<h2>Cardex</h2>	

@php
    $semestreTem = 0;
    $contador = 1;
@endphp
<table class="table align-middle">
    <tbody>				
        @foreach ($cardex as $res)
            @if ($semestreTem != $res->cdx_SemXPrime)
                <tr class="renMorado">
                    <td colspan = "5" style="font-size: 20px; ">Semestre&nbsp;&nbsp;{{$res->cdx_SemXPrime}}</td>
                </tr>				
                <tr style="font-size: 15px; ">
                    <th id="DatosEncabezadoCardex">#</th>	
                    <th id="DatosEncabezadoCardex2">Nombre Materia</th>	
                    <th id="DatosEncabezadoCardex">Año</th>	
                    <th id="DatosEncabezadoCardex">Calificación</th>	
                    <th id="DatosEncabezadoCardex">Acreditación</th>	
                </tr>                
                @php $contador = 1;@endphp									
                <tr id="FilaDatosCardex">
                    <td id="DatosCardex">1</td>	
                    <td id="DatosCardex">{{$res -> ret_NomCompleto}}</td>	
                    <td id="DatosCardexCentrados">{{$res -> cdx_AnioXPrime}}</td>
                    @if ($res->cdx_Calif<=69)
                        <!-- Color Rojo -->
                        <td class="txtRojo" data-mdb-toggle="tooltip" title="No Acreditada ">{{$res->cdx_Calif}}</td>		
                    @else
                    @if ($res->cdx_Calif>=86)
                        <!-- Color Verde -->
                        <td class="txtVerde">{{$res->cdx_Calif}}</td>	
                    @else
                        @if ($res->cdx_Calif>=80)
                            <!-- Color Amarillo -->
                            <td class="txtAmarillo">{{$res->cdx_Calif}}</td>		
                        @else
                            <!-- Color Naranja -->
                            <td class="txtNaranja">{{$res->cdx_Calif}}</td>			
                        @endif
                        
                    @endif
                @endif                        
                    @if ($res -> cdx_UltOpcAcred == 1)
                        <td class="txtVerde">Ordinario</td>		
                    @endif
                    @if ($res -> cdx_UltOpcAcred == 2)
                        <td class="txtVerde">Ordinario Complementario</td>		
                    @endif			
                    @if ($res -> cdx_UltOpcAcred == 3)
                        <td class="txtNaranja">Repeticion</td>		
                    @endif
                    @if ($res -> cdx_UltOpcAcred == 4)
                        <td class="txtNaranja">Repeticion Complementario</td>		
                    @endif		
                    @if ($res -> cdx_UltOpcAcred == 5)
                        <td class="txtRojo">Especial</td>		
                    @endif							
                    @if ($res -> cdx_UltOpcAcred == 6)
                        <td class="txtRojo">Especial Complementario</td>		
                    @endif
                </tr>
                @php $semestreTem = $res->cdx_SemXPrime; @endphp
            @else

                <tr id="FilaDatosCardex">
                    <td id="DatosCardex">@php $contador++; echo $contador; @endphp</td>	
                    <td id="DatosCardex">{{$res -> ret_NomCompleto}}</td>	
                    <td id="DatosCardexCentrados">{{$res -> cdx_AnioXPrime}}</td>                      
                @if ($res->cdx_Calif<=69)
                        <!-- Color Rojo -->
                        <td class="txtRojo" data-mdb-toggle="tooltip" title="No Acreditada ">{{$res->cdx_Calif}}</td>		
                @else
                    @if ($res->cdx_Calif>=86)
                        <!-- Color Verde -->
                        <td class="txtVerde">{{$res->cdx_Calif}}</td>	
                    @else
                        @if ($res->cdx_Calif>=80)
                            <!-- Color Amarillo -->
                            <td class="txtAmarillo">{{$res->cdx_Calif}}</td>		
                        @else
                            <!-- Color Naranja -->
                            <td class="txtNaranja">{{$res->cdx_Calif}}</td>			
                        @endif
                        
                    @endif
                @endif               
                    @if ($res -> cdx_UltOpcAcred == 1)
                        <td class="txtVerde">Ordinario</td>		
                    @endif
                    @if ($res -> cdx_UltOpcAcred == 2)
                        <td class="txtVerde">Ordinario Complementario</td>		
                    @endif			
                    @if ($res -> cdx_UltOpcAcred == 3)
                        <td class="txtNaranja">Repeticion</td>		
                    @endif
                    @if ($res -> cdx_UltOpcAcred == 4)
                        <td class="txtNaranja">Repeticion Complementario</td>		
                    @endif		
                    @if ($res -> cdx_UltOpcAcred == 5)
                        <td class="txtRojo">Especial</td>		
                    @endif							
                    @if ($res -> cdx_UltOpcAcred == 6)
                        <td class="txtRojo">Especial Complementario</td>		
                    @endif																		
                </tr>
            @endif            
        @endforeach
    </tbody>
</table>	
@endsection