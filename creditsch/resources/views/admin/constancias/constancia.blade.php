<style type="text/css">
	.heading{
		width: 720px;
		height: 75px;
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
		height: 60px;
	}
</style>
<div class="heading">
		<div>
			<div id="sep" class="f-izquierda div-header">
				<img src="{{ $data['raiz'].public_path()."/images/constancias/sep_logo2.jpg" }}">
			</div>
			<div class="f-izquierda div-header" style="margin-top: 30px; margin-left: 3px; font-weight: 600; height: 40px;">
				<p class="c-vertical">TECNOLÓGICO NACIONAL DE MEXICO</p>
			</div>
			<div id="mich" class="f-izquierda div-header">
				<img src="{{ $data['raiz'].public_path()."/images/constancias/mich_logo.png" }}">
			</div>
		</div>
</div>
<div class="romper"></div>
<div di>
	<p id="institucion">INSTITUTO TECNOLÓGICO SUPERIOR DE CIUDAD HIDALGO</p>
</div>

<div class="romper"></div>
<div>
	<p id="lema">&quot;{{ $data['datos_globales']->enunciado_superior }}&quot;</p>
</div>
<div  style="width: 690px; height: 54px; margin-top: 10px;">
		<div style="height: 15px;" class="f-derecha">
			<p id="fecha" class="sin-margenes">{{ $data['dia'] }}/{{ $data['mes'] }}/{{ $data['year'] }}</p>
		</div>
		<div style="height: 15px;" class="f-derecha">
			<p  class="sin-margenes bloque">Ciudad Hidalgo, Mich.</p>
		</div>
		<div class="romper"></div>
		<div class="f-derecha">
			<p class="bloque">OFICIO No. {{ strtoupper($data['datos_globales']->oficio) }}</p>
		</div>
		
</div>
<div class="romper"></div>
<p class="jefa">L.I SANDRA YUNUEN VILLEGAS VIVAR</p>
<P class="jefa">JEFA DEL DEPTO. DE SERVICIOS ESCOLARES</P>
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
		<img style="height: 60px; width: 50px; margin-left: 40px;" class="f-izquierda" src="{{ $data['raiz'].public_path()."/images/constancias/itsch.png" }}">
		<div style="width: 240px; height: 100%; margin-left: 40px;" class="f-izquierda">
			<p class="parrafo" style="font-size: 9px;">{{ $data['datos_globales']->institucion_info }}
			</p>
		</div>
		<img style="height: 55px; width: 55px; margin-left: 40px;" class="f-izquierda" src="{{ $data['raiz'].public_path()."/images/constancias/caceca.jpg" }}">
		<img style="height: 50px; width: 120px; margin-left: 10px;" class="f-izquierda" src="{{ $data['raiz'].public_path()."/images/constancias/cacei_logo.jpg" }}">
		<img style="height: 55px; width: 40px; margin-left: 15px;" class="f-izquierda" src="{{ $data['raiz'].public_path()."/images/constancias/applus.png" }}">
		<img style="height: 55px; width: 40px; margin-left: 15px;" class="f-izquierda" src="{{ $data['raiz'].public_path()."/images/constancias/applus.png" }}">
	</div>
</div>