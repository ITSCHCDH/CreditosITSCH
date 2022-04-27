<?PHP session_start(); ?>
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
        
        <!--Funcion Validar-->        
        <script type="text/javascript">
			function verificar(){
				//Validar Radio vive_padre
				var resultado="ninguno";
        			var padre=document.getElementsByName("vive_padre");
        			// Recorremos todos los valores del radio button para encontrar el
        			// seleccionado
	        		for(var i=0;i<padre.length;i++)
	        		{
	            		if(padre[i].checked)
	               		 resultado=padre[i].value;
	               		
	        		}
	        		var resultado_pad=resultado;
				if(resultado==1){
					if (!document.getElementById('ausente_padre').checked || document.getElementById('tutor_padre').checked){
						if(document.getElementById('nombre_padre').value.length==0 ||
							document.getElementById('ocupacion_padre').value.length==0 ||
							document.getElementById('fecha_nac_padre').value.length==0 ||
							document.getElementById('escolaridad_padre').value.length==0 ||
							document.getElementById('domicilio_padre').value.length==0 ||
							document.getElementById('colonia_padre').value.length==0 ||
							document.getElementById('poblacion_padre').value.length==0){
								jError("Ingresar datos de padre o tutor ","Error");
								document.getElementById('nombre_padre').focus();
								return 0;
						}
						if (document.getElementById('tel_particular_padre').value.length==0 && document.getElementById('tel_trabajo_padre').value.length==0){
							jError("Debe registrar al menos un número de teléfono de padre o tutor","Error");
								document.getElementById('tel_particular_padre').focus();
								return 0;
						}
						if (document.getElementById('tel_particular_padre').value.length<10 && document.getElementById('tel_particular_padre').value.length>0){
							jError("El numero debe ser de 10 digitos con lada","Error");
							document.getElementById('tel_particular_padre').focus();
							return 0;
						}
						if (document.getElementById('tel_trabajo_padre').value.length<10 && document.getElementById('tel_trabajo_padre').value.length>0){
							jError("El numero debe ser de 10 digitos con lada","Error");
							document.getElementById('tel_trabajo_padre').focus();
							return 0;
						}
					}
					else{
						if(document.getElementById('nombre_padre').value.length!=0 ||
								document.getElementById('ocupacion_padre').value.length!=0 ||
								document.getElementById('fecha_nac_padre').value.length!=0 ||
								document.getElementById('escolaridad_padre').value.length!=0 ||
								document.getElementById('domicilio_padre').value.length!=0 ||
								document.getElementById('colonia_padre').value.length!=0 ||
								document.getElementById('poblacion_padre').value.length!=0){
								jError("Si padre aun vive, está ausente y no es tutor, omita esta información","Error");
								document.getElementById('nombre_padre').focus();
								return 0;
							}
						}
						
				}
				else{
					if(document.getElementById('tutor_padre').checked){
						if(document.getElementById('nombre_padre').value.length==0 ||
							document.getElementById('ocupacion_padre').value.length==0 ||
							document.getElementById('fecha_nac_padre').value.length==0 ||
							document.getElementById('escolaridad_padre').value.length==0 ||
							document.getElementById('domicilio_padre').value.length==0 ||
							document.getElementById('colonia_padre').value.length==0 ||
							document.getElementById('poblacion_padre').value.length==0){
								jError("Ingrese datos de tutor","Error");
								document.getElementById('tutor_padre').focus();
								return 0;
							}
					}
				}

				
				//Validar Radio vive_madre
				var resultado="ninguno";
        			var madre=document.getElementsByName("vive_madre");
        			// Recorremos todos los valores del radio button para encontrar el
        			// seleccionado
	        		for(var i=0;i<madre.length;i++)
	        		{
	            		if(madre[i].checked)
	               		 resultado=madre[i].value;
	               		
	        		}
	        		var resultado_mad=resultado;
				if(resultado==1){
					if (!document.getElementById('ausente_madre').checked || document.getElementById('tutor_madre').checked){
						if(document.getElementById('nombre_madre').value.length==0 ||
							document.getElementById('ocupacion_madre').value.length==0 ||
							document.getElementById('fecha_nac_madre').value.length==0 ||
							document.getElementById('escolaridad_madre').value.length==0 ||
							document.getElementById('domicilio_madre').value.length==0 ||
							document.getElementById('colonia_madre').value.length==0 ||
							document.getElementById('poblacion_madre').value.length==0){
								jError("Ingresar datos de Madre o Tutora","Error");
								document.getElementById('nombre_madre').focus();
								return 0;
						}
						if (document.getElementById('tel_particular_madre').value.length==0 && document.getElementById('tel_trabajo_madre').value.length==0){
							jError("Debe registrar al menos un número de teléfono de madre","Error");
								document.getElementById('tel_particular_madre').focus();
								return 0;
						}
						if (document.getElementById('tel_particular_madre').value.length<10 && document.getElementById('tel_particular_madre').value.length>0){
							jError("El numero debe ser de 10 digitos con lada","Error");
							document.getElementById('tel_particular_madre').focus();
							return 0;
						}
						if (document.getElementById('tel_trabajo_madre').value.length<10 && document.getElementById('tel_trabajo_madre').value.length>0){
							jError("El numero debe ser de 10 digitos con lada","Error");
							document.getElementById('tel_trabajo_madre').focus();
							return 0;
						}
					}
					else{
						if(document.getElementById('nombre_madre').value.length!=0 ||
								document.getElementById('ocupacion_madre').value.length!=0 ||
								document.getElementById('fecha_nac_madre').value.length!=0 ||
								document.getElementById('escolaridad_madre').value.length!=0 ||
								document.getElementById('domicilio_madre').value.length!=0 ||
								document.getElementById('colonia_madre').value.length!=0 ||
								document.getElementById('poblacion_madre').value.length!=0){
								jError("Si aun vive, está ausente y no es tutora, omita esta información","Error");
								document.getElementById('nombre_madre').focus();
								return 0;
							}
						}
						
				}
				else{
					if(document.getElementById('tutor_madre').checked){
						if(document.getElementById('nombre_madre').value.length==0 ||
							document.getElementById('ocupacion_madre').value.length==0 ||
							document.getElementById('fecha_nac_madre').value.length==0 ||
							document.getElementById('escolaridad_madre').value.length==0 ||
							document.getElementById('domicilio_madre').value.length==0 ||
							document.getElementById('colonia_madre').value.length==0 ||
							document.getElementById('poblacion_madre').value.length==0){
								jError("Ingrese datos de tutora","Error");
								document.getElementById('tutor_madre').focus();
								return 0;
							}
					}
				}
				//validar que al menos uno de los padres este vivo
				if ((resultado_mad==0 && resultado_pad==0) || (
					(document.getElementById('ausente_padre').checked) && resultado_mad==0) || (
					(document.getElementById('ausente_madre').checked) && resultado_pad==0)) {
					if (!document.getElementById('tutor_padre').checked && !document.getElementById('tutor_madre').checked){
						jError("En caso de no contar con padres, ingrese datos de tutor y marque la casilla correspondiente","Error");
						document.getElementById('nombre_padre').focus();
						return 0;
					}
				}

				//validar si ambos padres estan vivos y ausentes, ingresar al menos un tutor
				if (resultado_mad==1 && document.getElementById('ausente_madre').checked && resultado_pad==1 && document.getElementById('ausente_padre').checked){
					if (!document.getElementById('tutor_padre').checked && !document.getElementById('tutor_madre').checked){
						jError("En caso de tener ambos padres ausentes, seleccione la casilla tutor e ingrese sus datos","Error");
						document.getElementById('nombre_padre').focus();
						return 0;
					}
				}
				//Validar Textos de ingresos
				if(document.getElementById('ingreso_padre').value.length==0 ||
					document.getElementById('ingreso_madre').value.length==0 ||
					document.getElementById('ingreso_hermanos').value.length==0 ||
					document.getElementById('ingreso_propio').value.length==0 ||
					document.getElementById('ingreso_otros').value.length==0){
						jError("Debe escribir 0 sino tiene ingresos, pero por lo menos debe escribir uno mayor a 0","Error");
						document.getElementById('ingreso_padre').focus();
						return 0;
					}else{
						$suma=document.getElementById('ingreso_padre').value;
						$suma=$suma+document.getElementById('ingreso_madre').value;
						$suma=$suma+document.getElementById('ingreso_hermanos').value;
						$suma=$suma+document.getElementById('ingreso_propio').value;
						$suma=$suma+document.getElementById('ingreso_otros').value;
						if($suma==0){
							jError("Debe registrar al menos un ingreso mayor de 0","Error");
							document.getElementById('ingreso_padre').focus();
							return 0;
						}
					}
				
				//Validar transporte
				if((document.getElementById('medio_1').checked) || 
					(document.getElementById('medio_2').checked) ||
					(document.getElementById('medio_3').checked) ||
					(document.getElementById('medio_4').checked) ||
					(document.getElementById('medio_5').checked) || 
					(document.getElementById('medio_6').checked) ||
					(document.getElementById('medio_7').checked) ||
					(document.getElementById('medio_8').checked)){						
						if(document.getElementById('medio_8').checked && document.getElementById('otro_transporte').value.length==0){
							jError("Selecciono otro medio de transporte, ingrese el nombre del transporte en el campo adjunto","Error");
							document.getElementById('otro_transporte').focus();
							return 0;
						}
						if(!document.getElementById('medio_8').checked && document.getElementById('otro_transporte').value.length!=0){
							jError("NO selecciono OTRO medio de transporte, por lo tanto deje vacio el campo adjunto o seleccione la casilla OTRO","Error");
							document.getElementById('otro_transporte').focus();
							return 0;
						}
				}
				else{
						jError("Seleccione al menos un medio de transporte","Error");
						document.getElementById('medio_1').focus();
						return 0;
					}
				//validar horas y minutos
				if (document.getElementById('transporte_horas').value.length==0 || document.getElementById('transporte_minutos').value.length==0){
					jError("Ingrese el tiempo que hace en horas o en minutos al transportarse al tec","Error");
					document.getElementById('transporte_horas').focus();
					return 0;
				}
				if (document.getElementById('transporte_horas').value==0 && document.getElementById('transporte_minutos').value==0){
					jError("No puede escribir 0 en horas y minutos, al menos uno debe ser mayor a 0","Error");
					document.getElementById('transporte_horas').focus();
					return 0;
				}
				//validar gasto en transporte
				if (document.getElementById('gasto_transporte').value.length==0){
					jError("Ingrese cuanto gasta al transportarse hasta el Tec","Error");
					document.getElementById('gasto_transporte').focus();
					return 0;
				}
				//Validar Radio beca
				var resultado="ninguno";
        			var beca=document.getElementsByName("cuenta_con_beca");
        			// Recorremos todos los valores del radio button para encontrar el
        			// seleccionado
	        		for(var i=0;i<beca.length;i++)
	        		{
	            		if(beca[i].checked)
	               		 resultado=beca[i].value;
	        		}
				if(resultado==1){
					if(document.getElementById('beca_descripcion').value.length==0){
						jError("Selecciono que cuenta con beca, ingrese el nombre de la beca en el campo ¿Cuáles?","Error");
						document.getElementById('beca_descripcion').focus();
						return 0;
					}
					if(document.getElementById('utilidad_beca_1').checked ||
						document.getElementById('utilidad_beca_2').checked ||
						document.getElementById('utilidad_beca_3').checked ||
						document.getElementById('utilidad_beca_4').checked ||
						document.getElementById('utilidad_beca_5').checked ||
						document.getElementById('utilidad_beca_6').checked){
							if(document.getElementById('utilidad_beca_6').checked && document.getElementById('beca_otra_utilidad').value.length==0){
								jError("Selecciono la casilla Otros en ¿para qué te sirve la beca?. Escriba otra utilidad que le das a beca en el recuadro o desmarca esta casilla","Error");
								document.getElementById('beca_otra_utilidad').focus();
								return 0;
							}
					}
					else{
						jError("Selecciono que cuenta con beca, seleccione al menos una de las casillas de ¿para qué te sirve la beca?.","Error");
						document.getElementById('utilidad_beca_1').focus();
						return 0;
					}
				}
				else{
					if(document.getElementById('beca_descripcion').value.length!=0){
						jError("Selecciono que NO cuenta con beca, deje vacio el campo ¿Cuáles?.","Error");
						document.getElementById('beca_descripcion').focus();
						return 0;
					}
					if(document.getElementById('utilidad_beca_1').checked ||
						document.getElementById('utilidad_beca_2').checked ||
						document.getElementById('utilidad_beca_3').checked ||
						document.getElementById('utilidad_beca_4').checked ||
						document.getElementById('utilidad_beca_5').checked ||
						document.getElementById('utilidad_beca_6').checked){
						jError("Desmarque las casillas ya que selecciono que no cuenta con beca","Error");
						document.getElementById('beca_descripcion').focus();
						return 0;
					}
					if(document.getElementById('beca_otra_utilidad').value.length!=0){
						jError("Deje vacio este campo ya que no cuenta con beca y no pudo seleccionar la casilla Otros.","Error");
						document.getElementById('beca_otra_utilidad').focus();
						return 0;
					}
					
				}
				//validar hobby, lugares y motivo
				if(document.getElementById('hobby').value.length==0){
					jError("Escribe al menos uno de tus hobbys o pasatiempos.","Error");
					document.getElementById('hobby').focus();
					return 0;
				}
				if(document.getElementById('lugares').value.length==0){
					jError("Escribe al menos uno de los lugares que frecuentas.","Error");
					document.getElementById('lugares').focus();
					return 0;
				}
				if(document.getElementById('motivo_tec').value.length==0){
					jError("Escribe que fue lo que te motivó a estudiar en nuestro Tecnológico.","Error");
					document.getElementById('motivo_tec').focus();
					return 0;
				}

				
				document.enviar_se2.submit();		
			}
		</script>
        
        <!--Cierra Validar-->
        
        
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
			<a><span><i>Inicio / Test / Estudio SE Parte 2</i></span></a>
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

			$consulta="SELECT f_est_soc_econ2 FROM alumnos_folio WHERE no_ficha='$no_ficha'";
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
				<form name='enviar_se2' id='enviar_se2' method='POST' action='registrar_se_2.php'>
					<fieldset>
					<ba>En caso de que ambos padres hayan fallecido o ambos padres esten ausentes, agregue a alguien como tutor e ingrese sus datos.</ba></fieldset>
					<fieldset><legend><stroke>DATOS PADRE</stroke></legend>
						<table width='675' border='0'>
							<tr>
								<td width='480'><ba>Nombre completo:</td>
								<td><ba>Vive:</td>
			 				</tr>
							<tr>
								<td>
									<input type='text' size='47' name='nombre_padre' id='nombre_padre' >
								</td>
								<td>
									<input type='radio' name='vive_padre' value='1' id='vive_padre' checked><pp>SI &nbsp;&nbsp;
									<input type='radio' name='vive_padre' value='0' id='vive_padre' ><pp>NO<br>
									<input type='checkbox' name='ausente_padre' id='ausente_padre' value='1'>Ausente
									<input type='checkbox' name='tutor_padre' id='tutor_padre' value='1'>Tutor</pp>
								</td>					
							</tr>
						</table>
						<table>
							<tr>
								<td width='480'><ba>Ocupación:</td>
								<td><ba>Fecha de Nac:</td>
							</tr>
							<tr>
								<td>
									<input type='text' size='47' name='ocupacion_padre' id='ocupacion_padre'  placeholder='Obrero, Comerciante, Desempleado, etc.'>
								</td>
								<td>
									<input type='date' name='fecha_nac_padre'  id='fecha_nac_padre'  >
								</td>
							</tr>
						</table>
						<table>
							<tr>
								<td><ba>Escolaridad:</td>
							</tr>
							<tr>
								<td>
									<input type='text' size='50' name='escolaridad_padre' id='escolaridad_padre'  placeholder='Primaria, Secundaria, Bachillerato, Licenciatura, etc.' title='Escriba según sea el caso de estudios de tu padre'>
								</td>
							</tr>
							<tr>
								<td><ba>Domicilio:</td>
							</tr>
							<tr>
								<td>
									<input type='text' size='60' name='domicilio_padre' id='domicilio_padre' >
								</td>
							</tr>
						</table>
						<table>
							<tr>
								<td width='400'><ba>Colonia:</td>
								<td><ba>Teléfono particular:</td>
							</tr>
							<tr>
								<td>
									<input type='text' size='30' name='colonia_padre' id='colonia_padre' >
								</td>
								<td>
									<input type='text' class='solo-numero'	size='10' maxlength='10' name='tel_particular_padre'  id='tel_particular_padre'  pattern='[0-9]{10}' title='Escribir número de 10 dígitos incluyendo lada'>
								</td>
							</tr>
							<tr>
								<td><ba>Población:</td>
								<td><ba>Teléfono de trabajo:</td>
							</tr>
							<tr>
								<td>
									<input type='text' size='30' name='poblacion_padre'  id='poblacion_padre' >
								</td>
								<td>
									<input class='solo-numero'  type='text' size='10' maxlength='10' name='tel_trabajo_padre'  id='tel_trabajo_padre' pattern='[0-9]{10}' title='Escribir número de 10 dígitos incluyendo lada'>
								</td>
							</tr>
						</table>
						<table>
							<tr>
								<td><ba>Centro de trabajo:</td>
							</tr>
							<tr>
								<td>
									<input type='text' size='50' name='trabajo_padre' id='trabajo_padre' >
								</td>
							</tr>
						</table>
					</fieldset>
					<fieldset><legend><stroke>DATOS MADRE</stroke></legend>
						<table width='675' border='0'>
							<tr>
								<td width='480'><ba>Nombre completo:</td>
								<td><ba>Vive:</td>
						 	</tr>
							<tr>
								<td>
									<input type='text' size='47' name='nombre_madre' id='nombre_madre' >
								</td>
								<td>
									<input type='radio' name='vive_madre' value='1' id='vive_madre' checked ><pp>SI  &nbsp;&nbsp;
									<input type='radio' name='vive_madre' value='0' id='vive_madre'><pp>NO<br>
									<input type='checkbox' name='ausente_madre' id='ausente_madre' value='1'>Ausente</pp>
									<input type='checkbox' name='tutor_madre' id='tutor_madre' value='1'>Tutor</pp>
								</td>								
							</tr>
						</table>
						<table>
							<tr>
								<td width='480'><ba>Ocupación:</td>
								<td><ba>Fecha de Nac:</td>
							</tr>
							<tr>
								<td>
									<input type='text' size='47' name='ocupacion_madre' id='ocupacion_madre'  placeholder='Ama de casa, Comerciante, Desempleada, etc.'>
								</td>
								<td>
									<input type='date' name='fecha_nac_madre'  id='fecha_nac_madre'  >
								</td>
							</tr>
						</table>
						<table>
							<tr>
								<td><ba>Escolaridad:</td>
							</tr>
							<tr>
								<td>
									<input type='text' size='50' name='escolaridad_madre' id='escolaridad_madre'  placeholder='Primaria, Secundaria, Bachillerato, Licenciatura, etc.' title='Escriba según sea el caso de estudios de tu madre'>
								</td>
							</tr>
							<tr>
								<td><ba>Domicilio:</td>
							</tr>
							<tr>
								<td>
									<input type='text' size='60' name='domicilio_madre'  id='domicilio_madre' >
								</td>
							</tr>
						</table>
						<table>
							<tr>
								<td width='400'><ba>Colonia:</td>
								<td><ba>Teléfono particular:</td>
							</tr>
							<tr>
								<td>
									<input type='text' size='30' name='colonia_madre'  id='colonia_madre' >
								</td>
								<td>
									<input type='text' class='solo-numero'	size='10' maxlength='10' name='tel_particular_madre'  id='tel_particular_madre'  pattern='[0-9]{10}' title='Escribir número de 10 dígitos incluyendo lada'>
								</td>
							</tr>
							<tr>
								<td><ba>Población:</td>
								<td><ba>Teléfono de trabajo:</td>
							</tr>
							<tr>
								<td>
									<input type='text' size='30' name='poblacion_madre'  id='poblacion_madre' >
								</td>
								<td>
									<input class='solo-numero'  type='text' size='10' maxlength='10' name='tel_trabajo_madre'  id='tel_trabajo_madre' pattern='[0-9]{10}' title='Escribir número de 10 dígitos incluyendo lada'>
								</td>
							</tr>
						</table>
						<table>
							<tr>
								<td><ba>Centro de trabajo:</td>
							</tr>
							<tr>
								<td>
									<input type='text' size='50' name='trabajo_madre'  id='trabajo_madre' >
								</td>
							</tr>
						</table>
					</fieldset>
					<fieldset><legend><stroke>INGRESOS Y TRANSPORTE</stroke></legend>
						<table width='675' border='0'>
							<tr>
								<td><ba>¿Cuáles son los ingresos mensuales familiares?</td>
							</tr>
						</table>
						<table width='675' border='0'>
							<tr>
								<td width='80'>
									<ba>Padre:</ba>
								</td>
								<td>
									<input type='text' size='4' class='solo-numero' maxlength='6' name='ingreso_padre' id='ingreso_padre'  title='En caso de no tener ingreso escribir un 0'>
								</td>
								<td width='80'>
									<ba>Madre:</ba>
								</td>
								<td>
									<input type='text' size='4' class='solo-numero' maxlength='6' name='ingreso_madre' id='ingreso_madre'  title='En caso de no tener ingreso escribir un 0'>
								</td>
								<td width='80'>
									<ba>Hermanos:</ba>
								</td>
								<td>
									<input type='text' size='4' class='solo-numero' maxlength='6'  name='ingreso_hermanos' id='ingreso_hermanos'  title='En caso de no tener ingreso escribir un 0'>
								</td>
							</tr>
							<tr>
								<td width='80'><ba>Propios:</ba></td>
								<td>
									<input type='text' size='4' class='solo-numero' maxlength='6' name='ingreso_propio' id='ingreso_propio'  title='En caso de no tener ingreso escribir un 0'>
								</td>
								<td width='80'><ba>Otros:</ba></td>
								<td>
									<input type='text' size='4' class='solo-numero' maxlength='6' name='ingreso_otros' id='ingreso_otros'  title='En caso de no tener ingreso escribir un 0'>
								</td>
							</tr>
						</table>
						<br>
						<table width='675' border='0'>
						<tr>
							<td><ba>¿Cuáles son los principales medios de transporte que utilizas para trasladarte a la institución donde estudias?</ba>
							</td>
						</tr>
					</table>
					<table width='675' border='0'>
						<tr>
							<td width='200'><input type='checkbox' name='medio_1' id='medio_1' value='1'><pp>Autobús</pp></td>					
							<td><input type='checkbox' name='medio_2' id='medio_2' value='1'><pp>Microbús</pp></td>					
							<td><input type='checkbox' name='medio_3' id='medio_3' value='1'><pp>Combi</pp></td>					
						</tr>
						<tr>
							<td width='200'><input type='checkbox' name='medio_4' id='medio_4' value='1'><pp>Taxi</pp></td>					
							<td><input type='checkbox' name='medio_5' id='medio_5' value='1'><pp>Motocicleta</pp></td>					
							<td><input type='checkbox' name='medio_6' id='medio_6' value='1'><pp>Bicicleta</pp></td>	
						</tr>
					</table>
					<table width='675'>
						<tr>
							<td width='200'><input type='checkbox' name='medio_7' id='medio_7' value='1'><pp>Auto Particular</pp></td>			
							<td><input type='checkbox' name='medio_8' id='medio_8' value='1'><pp>Otro:</pp><input type='text' size='30' maxlength='30' name='otro_transporte' id='otro_transporte'  title='Escribir NO en caso de no haber seleccionado OTRO. En caso de seleccionar OTRO, describir el otro transporte.'>
							</td>	
						</tr>
					</table>
					<br>
					<table width='675'>
						<tr>
							<td width='365'><ba>¿Cuánto tiempo tardas en llegar desde tu vivienda a tu universidad?</ba></td>
							<td><ba>Normalmente, ¿cuánto gastas al día en transporte?</ba></td>
						</tr>
						<tr>
							<td>
								<input type='number' name='transporte_horas' id='transporte_horas' size='2' min='0' max='12'  style='text-align:right;' title='Escribir 0 sino se hace ninguna hora al transportarse'><pp>Horas</pp>
								<input type='number' name='transporte_minutos' id='transporte_minutos' size='2' min='0' max='59'  style='text-align:right;' title='Escribir 0 sino se hace ningun minuto al transportarse'><pp>Minutos</pp></td>
							<td>
								<pp><input type='text' class='solo-numero' name='gasto_transporte' id='gasto_transporte' size='4'  style='text-align:right;' >.00MXN</pp>
							</td>
						</tr>
					</table>
				</fieldset>
				<fieldset><legend><stroke>BECA Y HOBBIES</stroke></legend>
					<table width='675'>
						<tr>
							<td>
								<ba>¿Cuentas con algún tipo de beca?</ba>
							</td>
							<td><ba>Si tienes beca, ¿para qué te sirve?</ba><br></td>
						</tr>
						<tr>
							<td valign='top'>
								<input type='radio' name='cuenta_con_beca' value='1' id='cuenta_con_beca' ><pp>SI</pp>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type='radio' name='cuenta_con_beca' value='0' id='cuenta_con_beca' checked><pp>NO</pp><br>
								<pp>¿Cuáles?</pp>
								<br><textarea maxlength='200' rows='3' cols='33' name='beca_descripcion' id='beca_descripcion' title='Escribir NO en caso de no contar con ninguna beca. En caso de contar con beca(s) escribir cuáles tienes.' ></textarea>
							</td>
							<td>
								<input type='checkbox' name='utilidad_beca_1' value='1' id='utilidad_beca_1'><pp>Pago de colegiatura</pp><br>
								<input type='checkbox' name='utilidad_beca_2' value='1' id='utilidad_beca_2'><pp>Pago de útiles escolares</pp><br>
								<input type='checkbox' name='utilidad_beca_3' value='1' id='utilidad_beca_3'><pp>Pago de transporte a institución</pp><br>
								<input type='checkbox' name='utilidad_beca_4' value='1' id='utilidad_beca_4'><pp>Ayuda gasto familiar</pp><br>
								<input type='checkbox' name='utilidad_beca_5' value='1' id='utilidad_beca_5'><pp>Gastos personales</pp><br>
								<input type='checkbox' name='utilidad_beca_6' value='1' id='utilidad_beca_6'><pp>Otros:</pp><br><textarea maxlength='100' rows='3' cols='33' name='beca_otra_utilidad' id='beca_otra_utilidad'  title='En caso de SELECCIONAR OTROS escribir la otra utilidad que le das a la beca.'></textarea>
							</td>
						</tr>
						<tr>
							<td><ba>¿Qué haces en tus ratos libres?</ba></td>
							<td><ba>¿Qué lugares frecuentas?</ba></td>
						</tr>
						<tr>
							<td>
								<textarea maxlength='200' rows='3' cols='33' name='hobby' id='hobby'  title='Escribir tus pasatiempos'></textarea>
							</td>
							<td>
								<textarea maxlength='200' rows='3' cols='33' name='lugares' id='lugares'  title='Escribir lugares que frecuentas. Ejemplo: Parque, Cine, etc.'></textarea>
							</td>
						</tr>
					</table>
					<table width='675'>	
						<tr>
							<td><ba>¿Qué te motivó a inscribirte en el tecnológico?</ba></td>
						</tr>
						<tr>
							<td><textarea maxlength='200' rows='3' cols='80' name='motivo_tec' id='motivo_tec'  title='Escribir que fue lo que te motivo a solicitar ficha en nuestro tecnológico'></textarea></td>
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
	