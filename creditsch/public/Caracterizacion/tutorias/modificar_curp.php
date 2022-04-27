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
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
		<script type="text/javascript" src="./../js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="./../js/jquery.bgImageMenu.js"></script>
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
			function mensaje_modificar($c) {
				jMessage("Se modifico la CURP: "+$c, "Mensaje");
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
				<a><span>Tutorías </span></a>
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
			<a><span><i>Inicio / Modificar CURP</i></span></a>
			
		</div>
    	<section class='tabss'>
			<fieldset>
				<form name='buscar_ficha' method='POST' action='' autocomplete='off'>
		    		<table width='675' align='center'>
						<tr>
							<td width='380'><stroke><b>No Ficha:</td>
							<td></td>
						</tr>
						<tr>
							<td><input type='text' class='solo-numero' name='no_ficha' id='no_ficha' required></td>
							<td><stroke><input type='submit' value='Buscar' name='buscar' id='buscar'></td>
						</tr>
					</table>
				</form>	
			</fieldset>
		</section>
	<?PHP
	if (isset($_POST['buscar'])){ 
		require_once '../conexion/conex_mysql.php';
		$no_ficha= $_POST['no_ficha'];
		$mysqli = new mysqli ($hostname,$username,$password,$database);
		if ($mysqli->connect_errno){
			die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
		}		
		$query = "SELECT * from alumnos_datos_personales WHERE se_no_ficha='$no_ficha'";
		$resultado = $mysqli->query($query);
		$rows = mysqli_fetch_array($resultado);
		
		if(empty($rows)){
			echo "<script type='text/javascript'>alertar()</script>"; 
		}
		else{
		
		$ficha=($rows['se_no_ficha']);
		$nombre=($rows['dp_nombre']);
		$apaterno=($rows['dp_ap_paterno']);
		$amaterno=($rows['dp_ap_materno']);
		$sexo=($rows['dp_sexo']);
		$carrera=($rows['dp_carrera']);
		$curp=($rows['se_curp']);
		$control=($rows['se_no_control']);
		

		$mysqli->close();
		echo "
		<div class='container'>
			<section class='tabs'>
	            <input id='tab-1' type='radio' name='radio-set' class='tab-selector-1' checked='checked' style='visibility:hidden'/>
		        		            
			    <div class='clear-shadow'></div>
		      	<div class='contenedor'>
		        	<div class='contenedor-1'>
		        		<fieldset><legend><stroke>PERSONALES</stroke></legend>
							<form name='modificar_curp' method='POST' action='' autocomplete='off'>
								<table width='675' border='0'>
									<tr>
										<td width='410'><ba>No Ficha:</td>
										<td><ba>No Control:</td>
									</tr>
									<tr>
										<td><input type='text' name='ficha' id='ficha' max='5' size='10' align='right' readonly value='$ficha'></td>
										<td><input type='text' name='control' id='control' size='10' disabled value='$control'></td>
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
										<td><input type='text' name='curp'  max='18' id='curp' size='20' value='$curp' pattern='[A-Z]{1}[AEIOU]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}'></td>
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
								<table width='675'>
									<tr align='right'> <br>
										<td><input type='submit' value='Modificar' name='modificar' id='modificar'>
										</td>
									</tr>
								</table>
							</form>									
						</fieldset>							
					</div>
				</div>
			</section>
        </div>
    </body>
</html>";
		}
	}

	if (isset($_POST['modificar'])){
		require_once '../conexion/conex_mysql.php';
		$curp=$_POST['curp'];
		$ficha=$_POST['ficha'];

		$mysqli = new mysqli ($hostname,$username,$password,$database);
		if ($mysqli->connect_errno){
			die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
		}

		$query = "UPDATE alumnos_datos_personales SET se_curp='$curp' WHERE se_no_ficha='$ficha'";
		$resultado = $mysqli->query($query);

		echo "<script type='text/javascript'>mensaje_modificar('$curp')</script>"; 
	}	
	?>