<?PHP
		session_start();?>
<html> 
	<head>
		<meta charset='UTF-8'/>
	   	<meta http-equiv='X-UA-Compatible' contenedor='IE=edge,chrome=1'>
	    <title>STE-ITSCH</title>
	    <meta name='viewport' contenedor='width=device-width, initial-scale=1.0'>
	    <link rel='stylesheet' type='text/css' href='../css/demo.css' />
	    <link rel='stylesheet' type='text/css' href='../css/style.css' />
	    <link rel='stylesheet' type='text/css' href='../css/sbimenu.css' />
		<!--Js para mensajes-->
	    <link rel="stylesheet" type="text/css" href="../css/jquery.alerts.css">
		<script src="../js/jquery-1.4.2.min.js" type="text/javascript"></script>
		<script src="../js/jquery.ui.draggable.js" type="text/javascript"></script>
		<script src="../js/jquery.alerts.mod.js" type="text/javascript"></script>
		
		<script src='http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js'></script>
		<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js'></script>
		<script type='text/javascript' src='../js/jquery.easing.1.3.js'></script>
		<script type='text/javascript' src='../js/jquery.bgImageMenu.js'></script>
		<script type='text/javascript'>
			$(function() {
				$('#sbi_container').bgImageMenu({
					defaultBg	: '../pic/5.jpg',
					menuSpeed	: 300,
					type		: {
						mode		: 'horizontalSlide',
						speed		: 250,
						easing		: 'jswing',
						seqfactor	: 100
					}
				});
			});	
		</script>
		<script type="text/javascript"> 
			function alertar() {
				jError("No Existe Registro", "Error");
			}
		</script>
		<script type="text/javascript">
			function verificar(){
				//validacion viven en tu casa y dependen del ingreso
					if(document.getElementById('dependen_eco').value.length==0){
						jError("Escriba el número de personas que dependen de los ingresos","Error")
								document.getElementById('dependen_eco').focus();
								return 0;
					}
					if(document.getElementById('viven_casa').value.length==0){
						jError("Escriba el número de personas que viven en tu casa","Error")
								document.getElementById('viven_casa').focus();
								return 0;
					}
				//validaciones de checkbox dependes economicamente de
					if(
						(document.getElementById('depende_1').checked) 
						|| (document.getElementById('depende_2').checked) 
						|| (document.getElementById('depende_3').checked) 
						|| (document.getElementById('depende_4').checked) 
						|| (document.getElementById('depende_5').checked) 
						|| (document.getElementById('depende_6').checked))
						{}
					else
					{
						jError("Selecciona al menos una de las opciones dependes economicamente de:","Error")
						document.getElementById('depende_1').focus();
						return 0;
						
					}
				//validaciones de checkbox con quien vives
					if(
						(document.getElementById('vive_con1').checked) 
						|| (document.getElementById('vive_con2').checked) 
						|| (document.getElementById('vive_con3').checked) 
						|| (document.getElementById('vive_con4').checked) 
						|| (document.getElementById('vive_con5').checked) 
						|| (document.getElementById('vive_con6').checked) 
						|| (document.getElementById('vive_con7').checked) 
						|| (document.getElementById('vive_con8').checked))
						{
							if (document.getElementById('vive_con8').checked && document.getElementById('otro').value.length==0){
								jError("Escriba descripción en el campo otro conocido","Error")
								document.getElementById('otro').focus();
								return 0;
							}
						}
					else
					{
						jError("Selecciona al menos una de las opciones de con quien vives actualmente","Error")
						document.getElementById('vive_con1').focus();
						return 0;
						
					}
				//validacio personas con cel
					if(document.getElementById('personas_con_cel').value.length==0){
						jError("Escriba el número de personas que cuentan con celular en tu hogar","Error")
								document.getElementById('personas_con_cel').focus();
								return 0;
					}

				//validaciones Auto
					if((document.getElementById('auto').checked))
						{
							if (document.getElementById('modelo').value.length==0){
								jError("Selecciono que cuenta con Auto, ingrese el modelo o deshabilite esa casilla","Error")
								document.getElementById('modelo').focus();
								return 0;
							}
							if(document.getElementById('marca').value.length==0){
								jError("Selecciono que cuenta con Auto, ingrese la marca o deshabilite esa casilla","Error")
								document.getElementById('modelo').focus();
								return 0;
							}
						}
					else{
						if (document.getElementById('modelo').value.length!=0){
								jError("No selecciono que cuenta con Auto, deje vacio el campo del modelo o habilite casilla Auto","Error")
								document.getElementById('modelo').focus();
								return 0;
							}
							if(document.getElementById('marca').value.length!=0){
								jError("No selecciono que cuenta con Auto, deje vacio el campo de la marca o habilite casilla Auto","Error")
								document.getElementById('modelo').focus();
								return 0;
							}
					}					
				//validaciones de checkbox combustible para cocinar
					if((document.getElementById('leña').checked) || (document.getElementById('carbon').checked) || (document.getElementById('gas_cilindro').checked))
						{
							if (document.getElementById('otro_combustible').value.length!=0){
								jError("Ya selecciono una de la opciones de combustible para cocinar, por lo tanto deje este campo vacio","Error")
								document.getElementById('otro_combustible').focus();
								return 0;
							}
						}
					else
					{
						if (document.getElementById('otro_combustible').value.length==0){
							jError("No selecciono ningun combustible por lo tanto llene este campo con el nombre de otro combustible o seleccione una de las opciones","Error")
						document.getElementById('otro_combustible').focus();
						return 0;
						}
					}
				//validaciones pago bimestral de luz
					if(document.getElementById('bimestre_luz').value.length==0 || document.getElementById('bimestre_luz').value==0){
						jError('Escriba cuanto paga de luz, escriba un valor arriba de 0', 'Error');
						document.getElementById('bimestre_luz').focus();
						return 0;
					}
				//validaciones de checkbox agua de vivienda
					if((document.getElementById('agua_de_pipa').checked) || (document.getElementById('llave_publica').checked) || (document.getElementById('agua_rio').checked) || (document.getElementById('agua_otra_vivienda').checked) || (document.getElementById('agua_entubada_fuera').checked) || (document.getElementById('agua_entubada_dentro').checked))
						{}
					else
					{
						jError("Seleccione al menos una de las opciones de la vivienda tiene:","Error")
						document.getElementById('agua_de_pipa').focus();
						return 0;
					}
				//validaciones de checkbox agua para beber
					if((document.getElementById('pozo').checked) || (document.getElementById('garrafon').checked) || (document.getElementById('agua_pipa').checked) || (document.getElementById('agua_hervida').checked) || (document.getElementById('llave_fuera').checked) || (document.getElementById('llave_dentro').checked))
						{}
					else
					{
						jError("Seleccione al menos una de las opciones de agua para beber","Error")
						document.getElementById('pozo').focus();
						return 0;
					}
				//validacion cuartos y baños
					if(document.getElementById('cuartos').value.length==0){
						jError('Ingrese el número de cuartos con los que cuenta su vivienda', 'Error');
						document.getElementById('cuartos').focus();
						return 0;
					}
					if(document.getElementById('baños').value.length==0){
						jError('Ingrese el número de baños con los que cuenta su vivienda', 'Error');
						document.getElementById('material_vivienda').focus();
						return 0;
					}
				//validacion material de vivienda y techo
					if(document.getElementById('material_techo').value.length==0){
						jError('Ingrese el nombre del material del techo de la vivienda', 'Error');
						document.getElementById('material_techo').focus();
						return 0;
					}
					if(document.getElementById('material_vivienda').value.length==0){
						jError('Ingrese el nombre del material de la vivienda', 'Error');
						document.getElementById('material_vivienda').focus();
						return 0;
					}
				//validaciones de radios de zona procedencia
					var resultado="ninguno";
        			var zona_proc=document.getElementsByName("zona_proc");
        			// Recorremos todos los valores del radio button para encontrar el
        			// seleccionado
	        		for(var i=0;i<zona_proc.length;i++)
	        		{
	            		if(zona_proc[i].checked)
	               		 resultado=zona_proc[i].value;
	        		}
					if(resultado==1 && document.getElementById('detalle_indigena').value.length==0){
						jError('Selecciono que su zona de procedencia es indígena, por lo tanto llene el campo de descripción de Etnia Indígena', 'Error');
						document.getElementById('detalle_indigena').focus();
						return 0;
					}
					if(resultado!=1 && document.getElementById('detalle_indigena').value.length!=0){
						jError('Selecciono una zona de procedencia diferente a la indígena, por lo tanto deje vacio el campo de descripción de Etnia Indígena','Error');
						document.getElementById('detalle_indigena').focus();
						return 0;
					}	
				//validaciones de checkbox servicio medico que acudes
					if((document.getElementById('IMSS').checked) || (document.getElementById('ISSSTE').checked) || (document.getElementById('Salubridad').checked) || (document.getElementById('Particular').checked))
						{}
					else
					{
						jError("Seleccione al menos un servicio médico al que acude","Error")
						document.getElementById('IMSS').focus();
						return 0;
					}				
				//validacion de enfermedades cronicas
					var resultado="ninguno";
        			var enf_cron=document.getElementsByName("enf_cronicas");
        			// Recorremos todos los valores del radio button para encontrar el
        			// seleccionado
	        		for(var i=0;i<enf_cron.length;i++)
	        		{
	            		if(enf_cron[i].checked)
	               		 resultado=enf_cron[i].value;
	        		}
					if(resultado==1 && document.getElementById('detalle_enf_cronicas').value.length==0){
						jError('Selecciono que si tiene enfermedades crónicas, por lo tanto llene el campo con detalle de enfermedades crónicas', 'Error');
						document.getElementById('detalle_enf_cronicas').focus();
						return 0;
					}
					if(resultado==0 && document.getElementById('detalle_enf_cronicas').value.length!=0){
						jError('Selecciono que no tiene enfermedades crónicas, por lo tanto deje vacio el campo con detalle de enfermedades crónicas','Error');
						document.getElementById('detalle_enf_cronicas').focus();
						return 0;
					}					
				//validacion de discapacidad
					var resultado="ninguno";
	 
	        		var discapacidad=document.getElementsByName("discapacidad");
	        		// Recorremos todos los valores del radio button para encontrar el
	        		// seleccionado
	        		for(var i=0;i<discapacidad.length;i++)
	        		{
	            		if(discapacidad[i].checked)
	               		 resultado=discapacidad[i].value;
	        		}
					if(resultado==1 && document.getElementById('detalle_discap').value.length==0){
						jError('Selecciono que si tiene discapacidad, por lo tanto llene el campo con detalle de discapacidad', 'Error');
						document.getElementById('detalle_discap').focus();
						return 0;
					}
					if(resultado==0 && document.getElementById('detalle_discap').value.length!=0){
						jError('Selecciono que no tiene discapacidad, por lo tanto deje vacio el campo con detalle de discapacidad','Error');
						document.getElementById('detalle_discap').focus();
						return 0;
					}					
				//validaciones de cantidad y edades de hijos
					if(document.getElementById('cant_hijos').value==0 && document.getElementById("edades_hijos").value!='0'){
						jError("Escribe un 0 en la edad","Error")
						document.getElementById('edades_hijos').focus();
						return 0;						
					}
					if(document.getElementById("edades_hijos").value.length==0){
						jError("Escribe la edad de los hijos que tienes, sino tienes escribe 0","Error")
						document.getElementById('edades_hijos').focus();
						return 0;
					}
					if(document.getElementById("cant_hijos").value.length==0){
						jError("Escribe la cantidad de hijos que tienes","Error")
						document.getElementById('cant_hijos').focus();
						return 0;
					}
					document.enviar_se1.submit();

			}
		</script>
		<script>
        	$(document).ready(function (){
          		$('.solo-numero').keyup(function (){
            		this.value = (this.value + '').replace(/[^0-9]/g, '');
          		});
        	});
    	</script>
		
		<!--[if lt IE 9]>
			<style>
				.contenedor{
					height: auto;
					margin: 0;	
				}
				.contenedor div {
					position: relative;
				}
			</style>
		<![endif]-->
    </head>
    <body>
    	<div class='container'>
		<br>
			<div class='topbar'>
				<a><span>Alumno </span></a>
				<span class='right_ab'>
					<a href='index.php'><strong> Ir a Inicio</strong></a>
				</span>
			</div>
		</div>
		<br>
		<div id='sbi_container' class='sbi_container'>
			<div class='sbi_panel' data-bg='../pic/1.jpg'>
				</div>
		</div>
		<div class='topbar'>
			<a><span><i>Inicio / Test / Estudio SE Parte 1</i></span></a>
			<span class='right_ab'>
					<a href='test.php'><strong> Regresar</strong></a>
				</span>
		</div>
	<?PHP
		
		if (isset($_SESSION['no_ficha']) AND ($_SESSION['curp'])){
			$no_ficha=$_SESSION['no_ficha'];

			require_once '../conexion/conex_mysql.php';
		
			$mysqli = new mysqli ($hostname,$username,$password,$database);
			if ($mysqli->connect_errno){
				die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
			}		

			$consulta="SELECT f_est_soc_econ1 FROM alumnos_folio WHERE no_ficha='$no_ficha'";
			$resultado= $mysqli->query($consulta);
			$rows = mysqli_fetch_array($resultado);
			$folio=$rows[0];
			

			if($folio==1)
			{
				header("location: test.php");
			}
			echo"

		
	<div class='container'>
		<section class='tabs'>
		    <input id='tab-1' type='radio' name='radio-set' class='tab-selector-1' checked='checked' style='visibility:hidden'/>
		    
		    <div class='clear-shadow'></div>
		    <div class='contenedor'>
				<div class='contenedor-1'>
				<form name='enviar_se1' id='enviar_se1' method='POST' action='registrar_se_1.php'>
					<fieldset><legend><stroke>HIJOS</stroke></legend>
						<table width='675'>
							<tr>
								<td><ba>Constestar esta sección si tienes hijos, de lo contrario escriba 0 en los 2 campos</ba>
								</td>
							</tr>
						</table>
						<br>
						<table width='675'>
							<tr>
								<td width='350'><ba>Hijos:</td>
								<td><ba>Edades:</td>
							</tr>
							<tr>
								<td>
									<input type='number' name='cant_hijos' id='cant_hijos' size='2' max='20' min='0' title='Número de hijos, sino cuenta con hijos poner 0' >
								</td>
								<td>
									<input type='text' name='edades_hijos' id='edades_hijos' size='15' title='Si cuenta con al menos un hijo o más escribir su edad separados por , y espacio. Ejemplo: 5, 2. De lo contrario escribir un 0' >
								</td>	
							</tr>									
						</table>
					</fieldset>								
					<fieldset><legend><stroke>MÉDICO</stroke></legend>
						<table>
							<tr>
								<td width='350'><ba>¿Discapacidad?</td>
								<td><ba>¿Enfermedades Crónicas?</td>
							</tr>
							<tr>
								<td>
									<input type='radio' name='discapacidad' value='1' id='discapacidad' title='Seleccionar si cuenta con alguna discapacidad' ><pp>SI
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input type='radio' name='discapacidad' value='0' id='discapacidad'  checked><pp>NO
						
								</td>
								<td>
									<input type='radio' name='enf_cronicas' value='1' id='enf_cronicas' title='Seleccionar si cuenta con alguna enfermedad crónica' ><pp>SI
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type='radio' name='enf_cronicas' value='0' id='enf_cronicas'  checked><pp>NO
								</td>
							</tr>
							<tr>
								<td><ba>Detalle de Discapacidad:</td>
								<td><ba>Detalle de Enf. Crónicas:</td>
							</tr>
							<tr>
								<td>
									<textarea maxlength='150' rows='3' cols='33' name='detalle_discap' id='detalle_discap' placeholder='Descripción de discapacidad' title='Si selecciono SI en discapacidad, en este recuadro mencione su discapacidad. En caso de seleccionar NO, no escriba nada.'></textarea>
								</td>
								<td>
									<textarea maxlength='150' rows='3' cols='33' name='detalle_enf_cronicas' id='detalle_enf_cronicas' placeholder='Descripción de enfermedades crónicas' title='Si selecciono SI en enfermedades crónicas, en este recuadro mencione su enfermedad. En caso de seleccionar NO, no escriba nada.'></textarea>
								</td>
							</tr>							
						</table>
						<table>
							<tr>
								<td><ba>¿Cuándo te enfermas acudes a?</td>
							</tr>
						</table>
						<table>
							<tr>
								<td width='80'>
									<input type='checkbox' name='IMSS' value='1' id='IMSS' title='Seleccionar si acudes al IMSS'><pp>IMSS
								</td>
								<td width='100'>
									<input type='checkbox' name='ISSSTE' value='1' id='ISSSTE' title='Seleccionar si acudes al ISSSTE'><pp>ISSSTE
								</td>
								<td width='125'>
									<input type='checkbox' name='Salubridad' value='1' id='Salubridad' title='Seleccionar si acudes a Salubridad o Centro de Salud'><pp>Salubridad
								</td>
								<td width='110'>
									<input type='checkbox' name='Particular' value='1' id='Particular' title='Seleccionar si acudes a Médico Particular'><pp>Particular
								</td>
							</tr>
						</table>
					</fieldset>	
					<fieldset><legend><stroke>PROCEDENCIA</stroke></legend>
						<table width='675'>
							<tr>
								<td><ba>Zona de Procedencia</td>
							</tr>
						</table>
						<table>
							<tr>
								<td width='130'>
									<input type='radio' name='zona_proc' value='1' id='zona_proc' title='Seleccionar si procedes de una Población Indígena' checked><pp>Indígena
								</td>
								<td width='110'>
									<input type='radio' name='zona_proc' value='2' id='zona_proc' title='Seleccionar si procedes de una Población Rural' ><pp>Rural
								</td>
								<td width='110'>
									<input type='radio' name='zona_proc' value='3' id='zona_proc' title='Seleccionar si procedes de una Población Urbana' ><pp>Urbana	
								</td>
								<td width='200'>
									<input type='radio' name='zona_proc' value='4' id='zona_proc' title='Seleccionar si procedes de una Población Urbana Marginada' ><pp>Urbana Marginada
								</td>
							</tr>
						</table>
						<table>
							<tr>
								<td><br><ba>Descripción de Etnia Indígena</td>
							</tr>
							<tr>
								<td>
									<textarea maxlength='50' rows='1' cols='50' name='detalle_indigena' id='detalle_indigena' title='En caso de haber seleccionado zona de procedencia Indígena mencione la Etnia a la que pertenece, en caso de seleccionar otra deje en blanco este recuadro.'></textarea>
								</td>
							</tr>
						</table>
					</fieldset>
					<fieldset><legend><stroke>BECA Y VIVIENDA</stroke></legend>
						<table>
							<tr>
								<td width='350'><ba>¿Familia con prospera?</td>
								<td><ba>¿La Casa donde vives es?</td>
							</tr>
							<tr>
								<td>
									<input type='radio' name='prospera' value='1' id='prospera' title='Seleccione SI cuenta con apoyo del programa del gobierno llamado Prospera' ><pp>SI
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type='radio' name='prospera' value='0' id='prospera' checked><pp>NO
						
								</td>
								<td>
									<input type='radio' name='vivienda' value='1' id='vivienda' checked><pp>Propia
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type='radio' name='vivienda' value='2' id='vivienda' ><pp>Rentada		
									&nbsp;<br>
									<input type='radio' name='vivienda' value='3' id='vivienda' ><pp>Prestada
									&nbsp;&nbsp;
									<input type='radio' name='vivienda' value='4' id='vivienda' ><pp>Pagando
								</td>
							</tr>
							<tr>
								<td><ba>Material de construcción de <br>la vivienda:</td>
								<td valign='top'><ba>Material del techo de vivienda:<br></td>
							</tr>
							<tr>
								<td>
									<textarea maxlength='50' rows='2' cols='33' name='material_vivienda' id='material_vivienda' placeholder='Cemento, madera, adobe, etc.' title='Escriba el material con el que está hecha la vivienda. Ejemplo: cemento, madera, adobe, etc.' ></textarea>
								</td>
								<td>
									<textarea maxlength='50' rows='2' cols='33	' name='material_techo' id='material_techo' placeholder='Lamina, cemento, madera, etc.' title='Escriba el material con el que está hecho el techo de la vivienda. Ejemplo: Lamina, cemento, madera, etc.' ></textarea>
								</td>
							</tr>
							<tr>
								<td>
									<input type='number' name='cuartos' id='cuartos' size='3' min='1' max='30' style='text-align:center;' title='Escriba el número de cuartos con los que cuenta la vivienda' > <ba> Cuartos </ba><pp>(comedor, sala, etc)
								</td>
								<td>
									<input type='number' name='baños' id='baños' size='3' min='1' max='20' title='Escriba el número de baños con los que cuenta la vivienda' style='text-align:center;' ><ba> Baños
								</td>
							</tr>
							<tr>
								<td><ba>Agua para beber:</td>
								<td><ba>La vivienda tiene:</td>
							</tr>
							<tr>
								<td>
									<input type='checkbox' name='pozo' value='1' id='pozo' ><pp>Pozo <br>
									<input type='checkbox' name='garrafon' value='1' id='garrafon' ><pp>Garrafón <br>
									<input type='checkbox' name='agua_pipa' value='1' id='agua_pipa' ><pp>Agua de pipa <br>
									<input type='checkbox' name='agua_hervida' value='1' id='agua_hervida' ><pp>Agua hervida <br>
									<input type='checkbox' name='llave_fuera' value='1' id='llave_fuera' ><pp>Agua de la llave fuera de la vivienda <br>
									<input type='checkbox' name='llave_dentro' value='1' id='llave_dentro' ><pp>Agua de la llave dentro de la vivienda
								</td>
								<td>
									<input type='checkbox' name='agua_de_pipa' value='1' id='agua_de_pipa' ><pp>Agua de pipa <br>
									<input type='checkbox' name='llave_publica' value='1' id='llave_publica' ><pp>Agua de la llave pública <br>
									<input type='checkbox' name='agua_rio' value='1' id='agua_rio' ><pp>Agua de pozo, rio, arroyo <br>
									<input type='checkbox' name='agua_otra_vivienda' value='1' id='agua_otra_vivienda' ><pp>Agua entubada de otra vivienda <br>
									<input type='checkbox' name='agua_entubada_fuera' value='1' id='agua_entubada_fuera' ><pp>Agua entubada fuera de la vivienda <br>
									<input type='checkbox' name='agua_entubada_dentro' value='1' id='agua_entubada_dentro' ><pp>Agua entubada dentro de la vivienda
								</td>
							</tr>
							<tr>
								<td><ba><ba>Pago bimestral de luz:</td>
							</tr>
							<tr>
								<td>
									<input type='number' min='0' size='5' name='bimestre_luz' id='bimestre_luz' style='text-align:center;' ><pp>.00 MXN
								</td>
							</tr>
							<tr>
								<td><ba>Drenaje o desagüe:</td>
								<td><ba>Combustible para cocinar:</td>
							</tr>
							<tr>
								<td>
									<input type='radio' name='drenaje' value='1' id='drenaje' checked><pp>Red pública <br>
									<input type='radio' name='drenaje' value='2' id='drenaje' ><pp>Fosa séptica <br>		
									<input type='radio' name='drenaje' value='3' id='drenaje' ><pp>No tiene drenaje <br>
									<input type='radio' name='drenaje' value='4' id='drenaje' ><pp>Tubería que da barranco o grieta <br>
									<input type='radio' name='drenaje' value='5' id='drenaje' ><pp>Tubería que da a rio, arroyo o lago <br>
								</td>
								<td>
									<input type='checkbox' name='leña' value='1' id='leña'><pp>Leña</pp> <br>
									<input type='checkbox' name='carbon' value='1' id='carbon'><pp>Carbón </pp><br>
									<input type='checkbox' name='gas_cilindro' value='1' id='gas_cilindro'><pp>Gas de cilindro o estacionario </pp><br>
									<textarea maxlength='40' rows='2' cols='30' name='otro_combustible' id='otro_combustible' placeholder='Descripción otro combustible' title='En caso de usar otro combustible para cocinar, ingrese el nombre de dicho combustible. De lo contrario deje el recuadro en blanco.'></textarea>								
								</td>
							</tr>
						</table>
					</fieldset>
					<fieldset><legend><stroke>ELECTRODOMÉSTICOS Y MÁS</stroke></legend>
						<table width='670'>
							<tr align='center'>
								<td><ba>Seleccione el elemento si cuenta con él en casa</ba></td>
							</tr>
						</table>
						<table width='670'>
							<tr>
								<td width='225'>
									<input type='checkbox' name='objeto1_1' value='1' id='objeto1_1'><b>Internet
								</td>
								<td width='225'>
									<input type='checkbox' name='objeto1_2' value='1' id='objeto1_2'><b>Bicicleta
								</td>
								<td>
									<input type='checkbox' name='objeto1_3' value='1' id='objeto1_3'><b>Regadera
								</td>									
							</tr>
							<tr>
								<td width='225'>
									<input type='checkbox' name='objeto1_4' value='1' id='objeto1_4'><b>Letrina
								</td>
								<td width='225'>
									<input type='checkbox' name='objeto1_5' value='1' id='objeto1_5'><b>Cisterna o aljibe
								</td>
								<td >
									<input type='checkbox' name='objeto1_6' value='1' id='objeto1_6'><b>Refrigerador
								</td>									
							</tr>
							<tr>
								<td width='225'>
									<input type='checkbox' name='objeto1_7' value='1' id='objeto1_7'><b>Estufa o parrilla eléctrica
								</td>
								<td width='225'>
									<input type='checkbox' name='objeto1_8' value='1' id='objeto1_8'><b>Estufa de gas
								</td>
								<td>
									<input type='checkbox' name='objeto1_9' value='1' id='objeto1_9'><b>Estufa de leña
								</td>									
							</tr>
							<tr>
								<td width='225'>
									<input type='checkbox' name='objeto1_10' value='1' id='objeto1_10'><b>Tinaco
								</td>
								<td width='225'>
									<input type='checkbox' name='objeto1_11' value='1' id='objeto1_11'><b>Calentador solar
								</td>
								<td>
									<input type='checkbox' name='objeto1_12' value='1' id='objeto1_12'><b>Boiler de combustible
								</td>									
							</tr>
							<tr>
								<td width='225' valign='top'>
									<input type='checkbox' name='objeto2_1' value='1' id='objeto2_1'><b>Computadora de escritorio
								</td>
								<td width='225'>
									<input type='checkbox' name='objeto2_2' value='1' id='objeto2_2'><b>iPod o reproductor de música
								</td>
								<td>
									<input type='checkbox' name='objeto2_3' value='1' id='objeto2_3'><b>Calentador de agua (Boiler)
								</td>									
							</tr>
							<tr>
								<td width='225'>
									<input type='checkbox' name='objeto2_4' value='1' id='objeto2_4'><b>iPad o tablet
								</td>
								<td width='225'>
									<input type='checkbox' name='objeto2_5' value='1' id='objeto2_5'><b>Laptop
								</td>
								<td>
									<input type='checkbox' name='objeto2_6' value='1' id='objeto2_6'><b>Horno de microondas
								</td>									
							</tr>
							<tr>
								<td width='225'>
									<input type='checkbox' name='objeto2_7' value='1' id='objeto2_7'><b>Grabadora
								</td>
								<td width='225'>
									<input type='checkbox' name='objeto2_8' value='1' id='objeto2_8'><b>Extractor de jugos
								</td>
								<td>
									<input type='checkbox' name='objeto2_9' value='1' id='objeto2_9'><b>Licuadora
								</td>									
							</tr>
							<tr>
								<td width='225'>
									<input type='checkbox' name='objeto2_10' value='1' id='objeto2_10' ><b>Plancha
								</td>
								<td width='225'>
									<input type='checkbox' name='objeto2_11' value='1' id='objeto2_11' ><b>Lavadora
								</td>
								<td>
									<input type='checkbox' name='objeto3_1' value='1' id='objeto3_1' ><b>Secadora
								</td>									
							</tr>
							<tr>
								<td width='225'>
									<input type='checkbox' name='objeto3_2' value='1' id='objeto3_2' ><b>Radio
								</td>
								<td width='225'>
									<input type='checkbox' name='objeto3_3' value='1' id='objeto3_3' ><b>Celular
								</td>
								<td>
									<input type='checkbox' name='objeto3_4' value='1' id='objeto3_4' ><b>Reproductor Dvd
								</td>									
							</tr>
							<tr>
								<td width='225'>
									<input type='checkbox' name='objeto3_5' value='1' id='objeto3_5' ><b>Televisión
								</td>
								<td width='225'>
									<input type='checkbox' name='objeto3_6' value='1' id='objeto3_6' ><b>Teléfono
								</td>
								<td>
									<input type='checkbox' name='objeto3_7' value='1' id='objeto3_7' ><b>Videocasetera
								</td>									
							</tr>
							<tr>
								<td width='225'>
									<input type='checkbox' name='objeto3_8' value='1' id='objeto3_8' ><b>Motocicleta, motoneta y/o cuatrimoto
								</td>
								<td width='225'>
									<input type='checkbox' name='objeto3_9' value='1' id='objeto3_9' ><b>Pantalla plana (Plasma, LCD, LED, etc.)
								</td>
								<td >
									<input type='checkbox' name='objeto3_10' value='1' id='objeto3_10' ><b>Servicio de televisión de paga (Sky, Telecable, etc.)
								</td>									
							</tr>
							<tr>
								<td width='225'>
									<input type='checkbox' name='objeto3_11' value='1' id='objeto3_11' ><b>Animales de granja (Caballos, puercos, gallinas, etc.) <br> <br> <br>
								</td>
								<td width='225'>
									<input type='checkbox' name='auto' value='1' id='auto'><b>Auto <br>
									<input type='text' name='marca' id='marca' placeholder='Marca de auto' title='Si selecciono Auto, escriba el nombre de la marca del auto. De lo contrario no escriba nada.'>
									<input type='text' name='modelo' id='modelo' placeholder='Modelo de auto' title='Si selecciono Auto, escriba el nombre del modelo del auto. De lo contrario no escriba nada.'>		
								</td>
							</tr>
						</table>
					</fieldset>
					<fieldset><legend><stroke>FAMILIA</stroke></legend>
						<table width='675'>
							<tr>
								<td>
									<ba>¿El domicilio donde radicas mientras estudias es el mismo donde vive tu familia?</ba>
								</td>
								<td>
									<ba>¿Cuántas personas de tu hogar, incluyéndote, cuentan con teléfono celular? </ba>
								</td>
							</tr>
							<tr>
								<td>
									<input type='radio' name='mismo_domicilio' value='1' id='mismo_domicilio' checked><pp>SI &nbsp;&nbsp;&nbsp;&nbsp;
									<input type='radio' name='mismo_domicilio' value='0' id='mismo_domicilio' ><pp>NO
								</td>
								<td><input type='number' min='0' max='50' name='personas_con_cel' style='text-align:center;' id='personas_con_cel' size='2' ><pp>Personas</pp></td>
							</tr>
							<tr>
								<td><ba>¿Con quién vives actualmente?</td>
							</tr>
						</table>
						<table>
							<tr>
								<td width='225'>
									<input type='checkbox' name='vive_con1' value='1' id='vive_con1' ><pp>Padre
								</td>
								<td width='225'>
									<input type='checkbox' name='vive_con2' value='1' id='vive_con2'><pp>Madre
								</td>
								<td >
									<input type='checkbox' name='vive_con3' value='1' id='vive_con3'><pp>Hermanos
								</td>	
							</tr>
							<tr>
								<td width='225'>
									<input type='checkbox' name='vive_con4' value='1' id='vive_con4'><pp>Cónyuge o pareja
								</td>
								<td width='225'>
									<input type='checkbox' name='vive_con5' value='1' id='vive_con5'><pp>Otro Familiar
								</td>
								<td >
									<input type='checkbox' name='vive_con6' value='1' id='vive_con6'><pp>Solo
								</td>	
							</tr>
						</table>
						<table>
							<tr>
								<td width='225'>
									<input type='checkbox' name='vive_con7' value='1' id='vive_con7'><pp>Hijos
								</td>
								<td>
									<input type='checkbox' name='vive_con8' value='1' id='vive_con8'><pp>Otro &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type='text' size='30' name='otro' id='otro' placeholder='Descripción de otro conocido' title='Si selecciono la opción Otro, ingrese la descripción de la persona con la que vive. De lo contrario no escriba nada.'>
								</td>
							</tr>
						</table>
						<table>
							<tr>
								<td><ba>Dependes económicamende de:</td>
							</tr>
						</table>
						<table>
							<tr>
								<td width='225'>
									<input type='checkbox' name='depende_1' value='1' id='depende_1'><pp>Padre
								</td>
								<td width='225'>
									<input type='checkbox' name='depende_2' value='1' id='depende_2'><pp>Madre
								</td>
								<td width='225'>
									<input type='checkbox' name='depende_3' value='1' id='depende_3'><pp>Hermanos
								</td>
							</tr>
							<tr>
								<td width='225'>
									<input type='checkbox' name='depende_4' value='1' id='depende_4'><pp>Cónyuge o pareja
								</td>
								<td width='225'>
									<input type='checkbox' name='depende_5' value='1' id='depende_5'><pp>Otro familiar
								</td>
								<td width='225'>
									<input type='checkbox' name='depende_6' value='1' id='depende_6'><pp>Yo mismo
								</td>
							</tr>
							<tr>
								<td width='225'><ba>Viven en tu casa:</td>
								<td><ba>Dependen del ingreso:</td>
							</tr>
							<tr>
								<td width='225'>
									<input type='number' min='1' max='50' size='2' name='viven_casa' id='viven_casa' style='text-align:center;' ><pp>Personas
								</td>
								<td>
									<input type='number' min='1' max='30' name='dependen_eco' size='2' id='dependen_eco' style='text-align:center;' ><pp>Personas
								</td>										
							</tr>
						</table>
					</fieldset>
					<table align='right'>
						<tr>
							<td><br>
								<input type='button' value='Enviar' name='enviar' id='enviar' onClick='verificar()'>
							</td>
						</tr>						
					</table>
				</form>
				</div>
			</div>
		</section>
	</div>
</body>
</html>";
			
	}


?>
	