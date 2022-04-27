<?PHP session_start() ?>
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
			function verificar(){
				//validamos que si beca SI esta seleccionado no deje vacio cuál beca
					var resultado="ninguno";
        			var beca=document.getElementsByName("beca");
        			// Recorremos todos los valores del radio button para encontrar el
        			// seleccionado
	        		for(var i=0;i<beca.length;i++)
	        		{
	            		if(beca[i].checked)
	               		 resultado=beca[i].value;
	               		
	        		}
	        		if(resultado==1){
	        			if(document.getElementById('tipobeca').value.length==0){
	        				jError('Ingrese el nombre de la beca','Error');
	        				document.getElementById('tipobeca').focus();
	        				return 0;
	        			}
	        		}
	        		else{
	        			if(document.getElementById('tipobeca').value.length!=0){
	        				jError('Deje vacio el nombre de beca ya que selecciono que no ha contado con beca','¿Cuál beca has tenido?');
	        				document.getElementById('tipobeca').focus();
	        				return 0;
	        			}
	        		}
	        	//validamos que si trabajo SI esta seleccionado no deje vacio el campo horario y lugar de trabajo
					var resultado="ninguno";
        			var trabajo=document.getElementsByName("trabaja");
        			// Recorremos todos los valores del radio button para encontrar el
        			// seleccionado
	        		for(var i=0;i<trabajo.length;i++)
	        		{
	            		if(trabajo[i].checked)
	               		 resultado=trabajo[i].value;
	               		
	        		}
	        		if(resultado==1){
	        			if(document.getElementById('horario').value.length==0){
	        				jError('Escriba el horario que tiene de trabajo','Horario');
	        				document.getElementById('horario').focus();
	        				return 0;
	        			}
	        			if(document.getElementById('lugar_trabajo').value.length==0){
	        				jError('Escriba su lugar de trabajo','¿Lugar de Trabajo?');
	        				document.getElementById('lugar_trabajo').focus();
	        				return 0;
	        			}

	        		}
	        		else{
	        			if(document.getElementById('horario').value.length!=0){
	        				jError('Deje vacio el campo  de horario, ya que selecciono que no trabaja','Horario');
	        				document.getElementById('horario').focus();
	        				return 0;
	        			}
	        			if(document.getElementById('lugar_trabajo').value.length!=0){
	        				jError('Deje vacio el campo de lugar de trabajo, ya que selecciono que no trabaja','¿Lugar de Trabajo?');
	        				document.getElementById('lugar_trabajo').focus();
	        				return 0;
	        			}
	        		}
	        	document.registrar.submit();
			}
		</script>
		<script type="text/javascript"> 
			function alertar() {
				jError("No Existe Registro", "Error");
			}
			function regresar() {
				setTimeout(function(){window.location.href=("test.php")} , 0); 
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
			<a><span><i>Inicio / Test / Datos Personales</i></span></a>
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

			$consulta="SELECT f_dat_pers FROM alumnos_folio WHERE no_ficha='$no_ficha'";
			$resultado= $mysqli->query($consulta);
			$rows = mysqli_fetch_array($resultado);
			if($rows[0]==1)
			{
				echo "<script type='text/javascript'>regresar()</script>"; 
			}
			$query = "SELECT * from alumnos_datos_personales WHERE se_no_ficha='$no_ficha'";
			$resultado = $mysqli->query($query);
			$rows = mysqli_fetch_array($resultado);
		
			if(empty($rows)){
				echo "<script type='text/javascript'>alertar()</script>"; 
			}
			else{
				$ficha=$rows['se_no_ficha'];
				$nombre=( $rows['dp_nombre']);
				$sexo=$rows['dp_sexo'];
				$apaterno=($rows['dp_ap_paterno']);
				$amaterno=($rows['dp_ap_materno']);
				$curp=$rows['se_curp'];
				$carrera=($rows['dp_carrera']);
				$direccion=($rows['dp_direccion']);
				$colonia=($rows['dp_colonia']);
				$codpost=$rows['dp_cod_post'];
				$municipio=($rows['dp_municipio']);
				$estado=($rows['dp_estado']);
				$tel=$rows['dp_tel'];
	 			echo" 
				<section class='tabs'>
					<div class='contenedor-1'>
					<form name='registrar' id='registrar' method='POST' action='datos.php' autocomplete='off'>
						<fieldset><legend><stroke>PERSONALES</stroke></legend>
							<table width='750' border='0'>
								<tr>
									<td width='440'><ba>No Ficha:</td>
									<td><ba>No Control:</td>
								</tr>
								<tr>
									<td><input type='text' name='ficha' id='ficha' max='5' size='10' align='right' disabled value='$ficha'></td>
									<td><input type='text' name='control' id='control' size='10' disabled value=''></td>
								</tr>
								<tr>
									<td><ba>Nombre (s):</td>
									<td><ba>Sexo:</td>
								</tr>
								<tr>
									<td><input type='text' name='nombre' id='nombre' size='25' disabled value='$nombre'></td>
									<td><input type='text' name='sexo' id='sexo' disabled value='$sexo' size='2'></td>
								</tr>
								<tr>
									<td><ba>Apellido Paterno:</td>
									<td><ba>Apellido Materno:</td>
								</tr>
								<tr>
									<td><input type='text' name='ap_paterno' id='ap_paterno' size='20' disabled value='$apaterno'></td>
									<td><input type='text' name='ap_materno' id='ap_materno' size='20' disabled value='$amaterno'></td>
								</tr>
								<tr>
									<td><ba>CURP:</td>
								</tr>
								<tr>
									<td><input type='text' name='curp'  max='18' id='curp' size='24' disabled value='$curp'></td>
								</tr>
							</table>
							<table width='675' border='0'>
								<tr>
									<td><ba>Carrera</td>
								</tr>
								<tr>
									<td><input type='text' name='carreras' id='carreras' disabled value='$carrera' size='68'/></td>
								</tr>
							</table>
						</fieldset>
						<fieldset><legend><stroke>DOMICILIO</stroke></legend>
							<table width='750' border='0'>
								<tr>
									<td width='440'><ba>Dirección:</td>
									
								</tr>
								<tr>
									<td><input type='text' name='direccion' id='direccion' size='35' disabled value='$direccion'></td>
									
								</tr>
								<tr>
									<td><ba>Colonia:</td>
									<td><ba>Código Postal:</td>
								</tr>
								<tr>
									<td><input type='text' name='colonia' id='colonia' size='25' disabled value='$colonia'></td>
									<td><input type='text' name='codpost' id='codpost' size='8' disabled value='$codpost'></td>
								</tr>
								<tr>
									<td><ba>Municipio:</td>
									<td><ba>Estado:</td>
								</tr>
								<tr>
									<td><input type='text' name='municipio' id='municipio' size='30' disabled value='$municipio'></td>
									<td><input type='text' name='estado' id='estado' size='20' disabled value='$estado'></td>
								</tr>
							</table>
						</fieldset>
						<fieldset><legend><stroke>OTROS</stroke></legend>
							<table width='750' border='0'>
								<tr>	
									<td width='450'><ba>Telefono Celular:</td>
									<td><ba>Tipo de Sangre:</td>
								</tr>
								<tr>
									<td><input type='text' name='telefono_cel' id='telefono_cel' size='12' disabled value='$tel'></td>
									<td>
										<select id='tiposangre' name='tiposangre' >
											<option value='N/P'>N/P</option>
											<option value='O+'>O+</option>
											<option value='O-'>O-</option>
											<option value='A+'>A+</option>
											<option value='A-'>A-</option>
											<option value='B+'>B+</option>
											<option value='B-'>B-</option>
											<option value='AB+'>AB+</option>
											<option value='AB-'>AB-</option>
										</select>
									</td>
								</tr>
								<tr>
									<td><ba>Correo Electronico:</td>
									<td>&nbsp</td>
								</tr>
								<tr>
									<td><input type='text' maxlength='50' title='mail@ejemplo.com' name='email' id='email' size='40' pattern='^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.([a-zA-Z]{2,4})+'  placeholder='mail@ejemplo.com'></td>
									<td><ba>¿Tienes Hijos?<br></td>
								</tr>
								<tr>
									<td>
										<ba>Estado Civil:<br>
										<select id='estado_civil' name='estado_civil' >
											<option value='1'>Soltero</option>
											<option value='2'>Casado</option>
											<option value='3'>Otro</option>
										</select>
									</td>
									<td>
										<input type='radio' name='hijos' value='1' id='hijos' ><pp>SI</pp><br>
										<input type='radio' name='hijos' value='0' id='hijos' checked><pp>NO</pp>
									</td>
								</tr>
								<tr>
									<td width='450'><ba>¿Has estado becado?</td>
									<td><ba>¿Cuál beca has tenido?</td>
								</tr>
								<tr>
									<td>
										<input type='radio' name='beca' value='1' id='beca' ><pp>SI</pp><br>
										<input type='radio' name='beca' value='0' id='beca' checked><pp>NO</pp>
									</td>
									<td><textarea title='Ejemplo: Pronabes, Prospera, etc.'name='tipobeca' id='tipobeca' rows='3' cols='35' maxlength='100'  placeholder='Pronabes, Prospera, etc.'></textarea></td>
								</tr>
							</table>
							<table width='750'>
								<tr>
									<td><ba>¿En el transcurso de tus estudios vivirás con?</td>
								</tr>
							</table>
							<table width='750'>
								<tr>
									<td>
										<input type='radio' name='vivir_con' value='1' id='vivir_con' checked><pp>Familia</pp>
									</td>
									<td>
										<input type='radio' name='vivir_con' value='2' id='vivir_con' ><pp>Familiares cercanos (Tios, primos, abuelos)</pp>
									</td>
								</tr>
								<tr>
									<td>
										<input type='radio' name='vivir_con' value='3' id='vivir_con' ><pp>Otros estudiantes</pp>
									</td>
									<td>
										<input type='radio' name='vivir_con' value='4' id='vivir_con' ><pp>Solo</pp>
									</td>
								</tr>
							</table>
						</fieldset>
						<fieldset><legend><stroke>TRABAJO</stroke></legend>
							<table width='750'>
								<tr>
									<td width='440'><ba>¿Trabajas?</td>
									<td><ba>Horario:</ba></td>
								</tr>
								<tr>
									<td>
										<input type='radio' name='trabaja' value='1' id='trabaja' ><pp>SI</pp><br>
										<input type='radio' name='trabaja' value='0' id='trabaja' checked><pp>NO</pp>
									</td>
									<td><input type='text' title='Ejemplo: 8:00am a 3:00pm' name='horario' id='horario' size='15' maxlength='15'  placeholder='8:00am a 3:00pm'></td></td>
								</tr>
							</table>
							<table width='750'>
								<tr>								
									<td><ba>¿Lugar de Trabajo?</ba></td>
								</tr>
								<tr>
									<td>
										<input type='text' name='lugar_trabajo' id='lugar_trabajo' size='50' maxlength='50' ></td>
									</td>									
								</tr>
							</table>
						</fieldset>
						<table width='800'>
							<tr>
								<td align='right'><br><stroke><input type='button' value='Guardar' name='guardar' id='guardar' onClick='verificar()'></td>
							</tr>
						</table>
					</form>
					</div>
				</section>";
	}}?>
	</body>
</html>
	