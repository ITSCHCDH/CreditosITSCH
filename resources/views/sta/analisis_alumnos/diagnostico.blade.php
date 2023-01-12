@extends('template.molde')

@section('title','Alumnos')

@section('ruta')
    <label class="label label-success"> <a href="#">STA</a> / <a href="{{ route('analisis.index') }}">Jefes de carrera</a>/Diagnostico</label> 
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
                    <td>                        
                        @if ($especiales > 0 || $nivelaciones >= 10 || $repeticiones > 2) <!-- rojo -->
                            <div  class="CirculoRojo" data-mdb-toggle="tooltip" 
                            title="Nivelaciones:&nbsp;{{$nivelaciones}}&nbsp;&nbsp;Repeticiones:&nbsp;{{$repeticiones}}&nbsp;&nbsp;Especiales:&nbsp;{{$especiales}}"
                            ></div>
                        @else
                            @if ($repeticiones <= 2 && ($nivelaciones >= 3 && $nivelaciones <10)) <!-- naranja -->
                                <div class="CirculoNaranja" data-mdb-toggle="tooltip" 
                                title="Nivelaciones:&nbsp;{{$nivelaciones}}&nbsp;&nbsp;Repeticiones:&nbsp;{{$repeticiones}}&nbsp;&nbsp;Especiales:&nbsp;{{$especiales}}"
                                ></div>
                            @else

                                @if ($nivelaciones > 1 && $nivelaciones <=5)<!-- amarillo -->
                                    <div class="CirculoAmarillo" data-mdb-toggle="tooltip" 
                                    title="Nivelaciones:&nbsp;{{$nivelaciones}}&nbsp;&nbsp;Repeticiones:&nbsp;{{$repeticiones}}&nbsp;&nbsp;Especiales:&nbsp;{{$especiales}}"
                                    ></div>
                                @else
                                    @if ($nivelaciones <= 1)<!-- verde --> 
                                        <div class="CirculoVerde" data-mdb-toggle="tooltip" 
                                        title="Nivelaciones:&nbsp;{{$nivelaciones}}&nbsp;&nbsp;Repeticiones:&nbsp;{{$repeticiones}}&nbsp;&nbsp;Especiales:&nbsp;{{$especiales}}"
                                        ></div>
                                    @else
                                        <div class="CirculoNegro" data-mdb-toggle="tooltip" 
                                        title="Nivelaciones:&nbsp;{{$nivelaciones}}&nbsp;&nbsp;Repeticiones:&nbsp;{{$repeticiones}}&nbsp;&nbsp;Especiales:&nbsp;{{$especiales}}"
                                        ></div>
                                    @endif
                                @endif
                            @endif
                        @endif
                    </td>
                    <td>
                        @if ($tamsempsicologico > 0)
                            @if ($tam_msm_psicologico == 0)
                                @if ($psicologico[0]->status_psico == 0) <!-- verde --> 
                                    <div class="CirculoVerde" data-mdb-toggle="tooltip" title="No hay Comentarios"></div>
                                @endif
                                @if ($psicologico[0]->status_psico == 1) <!-- amarillo -->
                                    <div class="CirculoAmarillo" data-mdb-toggle="tooltip" title="No hay Comentarios"></div>
                                @endif
                                @if ($psicologico[0]->status_psico == 2) <!-- naranja -->
                                    <div class="CirculoNaranja" data-mdb-toggle="tooltip" title="No hay Comentarios"></div>
                                @endif							
                                @if ($psicologico[0]->status_psico == 3) <!-- rojo -->
                                    <div class="CirculoRojo" data-mdb-toggle="tooltip" title="No hay Comentarios"></div>
                                @endif									
                            @else
                                @if ($psicologico[0]->status_psico == 0) <!-- verde --> 
                                    <div class="CirculoVerde" data-mdb-toggle="tooltip" title="{{$msm_psicologico[0]->mensaje}}"></div>
                                @endif
                                @if ($psicologico[0]->status_psico == 1) <!-- amarillo -->
                                    <div class="CirculoAmarillo" data-mdb-toggle="tooltip" title="{{$msm_psicologico[0]->mensaje}}"></div>
                                @endif
                                @if ($psicologico[0]->status_psico == 2) <!-- naranja -->
                                    <div class="CirculoNaranja" data-mdb-toggle="tooltip" title="{{$msm_psicologico[0]->mensaje}}"></div>
                                @endif							
                                @if ($psicologico[0]->status_psico == 3) <!-- rojo -->
                                    <div class="CirculoRojo" data-mdb-toggle="tooltip" title="{{$msm_psicologico[0]->mensaje}}"></div>
                                @endif                                
                            @endif
                        @else
                            <div class="CirculoNegro" data-mdb-toggle="tooltip" title="Sin Evaluar"></div>
                        @endif
                    
                    </td>
                    <td>
                        @if ($tamsemmedico > 0)
                            @if ($tam_msm_medico == 0)

                                @if ($medico[0]->status_medico == 0) <!-- verde --> 
                                    <div class="CirculoVerde" data-mdb-toggle="tooltip" title="No hay Comentarios"></div>
                                @endif
                                @if ($medico[0]->status_medico == 1) <!-- amarillo -->
                                    <div class="CirculoAmarillo" data-mdb-toggle="tooltip" title="No hay Comentarios"></div>
                                @endif
                                @if ($medico[0]->status_medico == 2) <!-- naranja -->
                                    <div class="CirculoNaranja" data-mdb-toggle="tooltip" title="No hay Comentarios"></div>
                                @endif							
                                @if ($medico[0]->status_medico == 3) <!-- rojo -->
                                        <div class="CirculoRojo" data-mdb-toggle="tooltip" title="No hay Comentarios"></div>
                                @endif								

                            @else
                                
                                @if ($medico[0]->status_medico == 0) <!-- verde --> 
                                    <div class="CirculoVerde" data-mdb-toggle="tooltip" title="{{$msm_medico[0]->mensaje}}"></div>
                                @endif
                                @if ($medico[0]->status_medico == 1) <!-- amarillo -->
                                    <div class="CirculoAmarillo" data-mdb-toggle="tooltip" title="{{$msm_medico[0]->mensaje}}"></div>
                                @endif
                                @if ($medico[0]->status_medico == 2) <!-- naranja -->
                                    <div class="CirculoNaranja" data-mdb-toggle="tooltip" title="{{$msm_medico[0]->mensaje}}"></div>
                                @endif							
                                @if ($medico[0]->status_medico == 3) <!-- rojo -->
                                        <div class="CirculoRojo" data-mdb-toggle="tooltip" title="{{$msm_medico[0]->mensaje}}"></div>
                                @endif

                            @endif

                        @else
                            <div class="CirculoNegro" data-mdb-toggle="tooltip" title="Sin Evaluar"></div>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <div>
            <h2>{{$calificacionesvariable}}</h2>	
            <table class="table">
                <tbody>	
                    <tr>
                        <td>{{$unidadesvariable}}</td>
                        @foreach ($unidades as $uni)
                            <td>Unidad&nbsp;{{$uni->lsc_NumUnidad}}</td>
                        @endforeach                
                    </tr>            
                        @php
                            $m = true;
                        @endphp
                        @foreach ($tablacalificaciones as $calif)                
                            @if ($m == true)
                                <tr>
                                <td>{{$calif->ret_NomCompleto}}&nbsp; <b>-- {{$calif->lse_clave}}</b> </td>	
                                @php
                                    $m = false;
                                @endphp	
                            @endif
                            @if ($calif -> lsc_NumUnidad == $calif->ret_NumUnidades)
                                @if ($calif->lsc_Calificacion<=69)
                                    @if ($calif->lsc_Corte)
                                        <!-- Color Rojo -->
                                        @if ($tamcomentarios == 0)
                                            <td class="txtRojo" data-mdb-toggle="tooltip" title="El profesor no agrego comentario">{{$calif->lsc_Calificacion}}</td>			
                                        @else
                                        @foreach ($comentarios as $rescomentarios)
                                                @if ($calif->lse_clave == $rescomentarios->lse_clave)
                                                    @if ($calif -> lsc_NumUnidad == $rescomentarios -> num_tema)
                                                        <td class="txtRojo" data-mdb-toggle="tooltip" title="{{$rescomentarios->comentario}}">{{$calif->lsc_Calificacion}}</td>				
                                                    @else
                                                        <td class="txtRojo" data-mdb-toggle="tooltip" title="El profesor no agrego comentario">{{$calif->lsc_Calificacion}}</td>			
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                    @else                                        
                                        <td data-mdb-toggle="tooltip" title="El profesor no ha capturado la calificación">----</td>
                                    @endif
                                @else
                                    @if ($calif->lsc_Calificacion>=86)
                                        <!-- Color Verde -->
                                        <td class="txtVerde">{{$calif->lsc_Calificacion}}</td>	
                                    @else
                                        @if ($calif->lsc_Calificacion>=80)
                                            <!-- Color Amarillo -->
                                            <td class="txtAmarillo">{{$calif->lsc_Calificacion}}</td>		
                                        @else
                                            <!-- Color Naranja -->
                                            <td class="txtNaranja">{{$calif->lsc_Calificacion}}</td>			
                                        @endif
                                        
                                    @endif
                                @endif
                                </tr>
                                @php
                                    $m = true;
                                @endphp
                            @else	
                                @if ($calif->lsc_Calificacion<=69)
                                    @if ($calif->lsc_Corte)
                                        <!-- Color Rojo -->
                                        @if ($tamcomentarios == 0)
                                            <td class="txtRojo" data-mdb-toggle="tooltip" title="El profesor no agrego comentario">{{$calif->lsc_Calificacion}}</td>			
                                        @else
                                        @foreach ($comentarios as $rescomentarios)
                                                @if ($calif->lse_clave == $rescomentarios->lse_clave)
                                                    @if ($calif -> lsc_NumUnidad == $rescomentarios -> num_tema)
                                                        <td class="txtRojo" data-mdb-toggle="tooltip" title="{{$rescomentarios->comentario}}">{{$calif->lsc_Calificacion}}</td>				
                                                    @else
                                                        <td class="txtRojo" data-mdb-toggle="tooltip" title="El profesor no agrego comentario">{{$calif->lsc_Calificacion}}</td>			
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                    @else
                                        <!-- Color Blanco -->
                                        <td data-mdb-toggle="tooltip" title="El profesor no ha capturado la calificación">----</td>
                                    @endif
                                @else
                                    @if ($calif->lsc_Calificacion>=86)
                                        <!-- Color Verde -->
                                        <td class="txtVerde">{{$calif->lsc_Calificacion}}</td>	
                                    @else
                                        @if ($calif->lsc_Calificacion>=80)
                                            <!-- Color Amarillo -->
                                            <td class="txtAmarillo">{{$calif->lsc_Calificacion}}</td>		
                                        @else
                                            <!-- Color Naranja -->
                                            <td class="txtNaranja">{{$calif->lsc_Calificacion}}</td>			
                                        @endif                                
                                    @endif
                                @endif					
                            @endif                    
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