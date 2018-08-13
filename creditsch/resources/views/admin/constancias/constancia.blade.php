<style type="text/css">
	.heading{
		width: 720px;
		height: 135px;
		margin-bottom: 5px;
	}
	.marco{
		width: 650px;
		margin-left: 40px;
	}
	.parrafo{
		text-align: justify;
		font-size: 14px;
	}
	#tabla-constancia{
		width: 100%;
		border-collapse: collapse;
	}
	#tabla-constancia thead{
		background-color: #4CAF50;
	}
	#tabla-constancia td{
		padding: 3px;
		border: 1px solid black;
		font-size: 14px;
	}
	#tabla-constancia th{
		border: 1px solid black;
		font-size: 14px;
		padding: 1px;
	}
	.centrado{
		text-align: center;
	}
	#sep img{
		width: 270px;
		height: 75px;
	}
	#mich img{
		width: 120px;
		height: 50px;
		margin-left: 15px;
		margin-top: 15px;
	}
	.f-izquierda{
		float: left;
	}
	.f-derecha{
		float: right;
	}
	.romper{
		clear: both;
	}
	.div-header{
		height: 75px;
	}
	.c-vertical{
		margin-top: auto;
		margin-bottom: auto;
	}
	#fecha{
		display: inline-block;
		background-color: green;
		color: white;
		margin-left: 5px;
	}
	.jefa{
		margin-top: 3px;
		margin-bottom: 3px;
		margin-left: 40px;
		font-weight: 600;
		font-size: 14px;
	}
	#lema{
		font-family: 'Times New Roman';
		font-size: 11px;
		display: inline-block;
		height: 11px;margin-left:
		140px;
		margin-top: 2px;
		padding-top: 0;
	}
	#institucion{
		margin-left: 290px;
		font-family: 'Times New Roman'; 
		font-size: 14px;
		display: inline-block;
		height: 13px;
		margin-top: 0;
	}
	.sin-margenes{
		padding: 0;
		margin: 0;
	}
	.no-margen-izq{
		margin-left: 0;
	}
	.bloque{
		display: inline-block;
	}
	.firmas{
		width: 250px;
	}
	#pie-pagina{
		position:fixed;
		bottom:0;
		height: 90px;
	}
</style>
<div class="heading">
		<div>
			<img src="{{ $data['raiz'].public_path()."/storage/constancia_imagenes/encabezado/".$data['datos_globales']->imagen_encabezado }}" width="100%" height="135px;">
		</div>
</div>

<div class="romper"></div>
<div  style="width: 690px; height: 54px; margin-top: 10px;">
		<div style="height: 15px;" class="f-derecha">
			<p id="fecha" class="sin-margenes">{{ $data['dia'] }}/{{ $data['mes'] }}/{{ $data['year'] }}</p>
		</div>
		<div style="height: 15px;" class="f-derecha">
			<p  class="sin-margenes bloque">Ciudad Hidalgo, Mich.</p>
		</div>
		<div class="romper"></div>
		<div class="f-derecha">
			<p class="bloque">OFICIO No. DISC/S-{{ $data['datos_globales']->numero_oficio }}/{{ $data['year'] }}</p>
		</div>
		
</div>
<div class="romper"></div>
@if (substr($data['jefe_depto']->profesion_jefe_depto, 0, 5) == "otro-")
	@php
		$cadena = substr($data['jefe_depto']->profesion_jefe_depto,5);
	@endphp
	<p class="jefa">{{ strtoupper($cadena) }}. {{ strtoupper((string)$data['jefe_depto']->name) }}</p>
@else
	<p class="jefa">{{ strtoupper($data['jefe_depto']->profesion_jefe_depto) }}. {{ strtoupper((string)$data['jefe_depto']->name) }}</p>
@endif
<P class="jefa">{{ strtoupper((string)$data['jefe_depto']->jefe_depto_enunciado) }}</P>
<P class="jefa">PRESENTE</P>
<div class="marco">
	<p class="parrafo">Por medio del presente le envió un cordial saludo, y aprovecho la oportunidad para hacer de su conocimiento que de acuerdo a lo establecido en el lineamiento para la acreditación de actividades complementarias para el plan de estudios {{ strtoupper($data['datos_globales']->plan_de_estudios) }}, el(a) alumno(a) <strong>Jehú Jair Ruiz Villegas</strong> con el numero de control <strong>15030205</strong> de la carrera INGENIERÍA EN SISTEMAS COMPUTACIONALES ha <strong style="text-decoration: underline;">concluido satisfactoriamente</strong> con las actividades necesarias para liberar los créditos complementarios. Dichas actividades se resumen a continuación: </p>
	<table id="tabla-constancia">
		<thead>
			<tr>
				<th>Actividad</th>
				<th>Créditos</th>
				<th>Responsable</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1er Congreso Estatal de Tecnologías Emergentes</td>
				<td class="centrado">1</td>
				<td>Oscar Delgado Camacho</td>
			</tr>
			<tr>
				<td>1er Congreso Estatal de Tecnologías Emergentes</td>
				<td class="centrado">2</td>
				<td>Sánchez Hernández Alejandro</td>
			</tr>
			<tr>
				<td>1er Congreso Estatal de Tecnologías Emergentes</td>
				<td class="centrado">3</td>
				<td>Jehu Jair Ruiz Villegas</td>
			</tr>
			<tr>
				<td>1er Congreso Estatal de Tecnologías Emergentes</td>
				<td class="centrado">4</td>
				<td>García Hernández José</td>
			</tr>
			<tr>
				<td>1er Congreso Estatal de Tecnologías Emergentes</td>
				<td class="centrado">5</td>
				<td>García Hernández José</td>
			</tr>
			<tr>
				<td>1er Congreso Estatal de Tecnologías Emergentes</td>
				<td class="centrado">6</td>
				<td>García García María</td>
			</tr>
			<tr>
				<td>1er Congreso Estatal de Tecnologías Emergentes</td>
				<td class="centrado">7</td>
				<td>Hernández Hernández Juan Carlos</td>
			</tr>
			<tr>
				<td>1er Congreso Estatal de Tecnologías Emergentes</td>
				<td class="centrado">8</td>
				<td>Mark Zuckerberg</td>
			</tr>
			<tr>
				<td>1er Congreso Estatal de Tecnologías Emergentes</td>
				<td class="centrado">9</td>
				<td>Manuel Antonio Fernández Ortubey</td>
			</tr>
			<tr>
				<td>1er Congreso Estatal de Tecnologías Emergentes</td>
				<td class="centrado">10</td>
				<td>Juan María Estévez Raimúndez</td>
			</tr>
			<tr>
				<td style="font-size: 13px;"><strong>TOTAL</strong></td>
				<td class="centrado" style="font-size: 13px;"><strong>5</strong></td>
				<td style="border-style: none !important;"></td>
			</tr>
		</tbody>
	</table>
	<p class="parrafo" style="margin-bottom: 7px; margin-top: 10px;">Sin más por el medio me despido de usted y quedo a sus órdenes para cualquer aclaración</p>
	<div>
		<div class="firmas f-izquierda">
			<p class="jefa no-margen-izq">ATENTAMENTE</p>
			<p class="parrafo sin-margenes" style="font-size: 9px;">EDUCACIÓN HERENCIA PARA EL ÉXITO</p>
			<div style="height: 40px;">
				
			</div>
			<p class="jefa no-margen-izq">ING. OSCAR DELGADO CAMACHO</p>
			<p class="jefa no-margen-izq">DIV. DE ING. SIST. COMP</p>
		</div>
		<div class="firmas f-derecha">
			<p class="jefa no-margen-izq">Vo.Bo</p>
			<div style="height: 49px;">
				
			</div>
			<p class="jefa no-margen-izq">ISC. ESMERALDA DELGADO PEREZ</p>
			<p class="jefa no-margen-izq">SUBDIRECTORA ACADEMICA</p>
		</div>
	</div>
	<div id="pie-pagina">
		<img src="{{ $data['raiz'].public_path()."/storage/constancia_imagenes/pie_de_pagina/".$data['datos_globales']->imagen_pie }}" width="100%" height="90px">
	</div>
</div>