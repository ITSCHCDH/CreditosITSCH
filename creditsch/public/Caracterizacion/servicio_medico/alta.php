<html> 
	<head>
		<meta charset='UTF-8'/>
	    <meta http-equiv='X-UA-Compatible' contenedor='IE=edge,chrome=1'>
	    <title>STE-ITSCH</title>
	    <meta name='viewport' contenedor='width=device-width, initial-scale=1.0'>
	    <link rel='stylesheet' type='text/css' href='../css/demo.css' />
	    <link rel='stylesheet' type='text/css' href='../css/style.css' />
	    <link rel='stylesheet' type='text/css' href='../css/sbimenu.css' />
	    <!--Recursos para mostrar mensajes -->
	    <link rel="stylesheet" type="text/css" href="../css/jquery.alerts.css">
		<script src="../js/jquery-1.4.2.min.js" type="text/javascript"></script>
		<script src="../js/jquery.ui.draggable.js" type="text/javascript"></script>
		<script src="../js/jquery.alerts.mod.js" type="text/javascript"></script>
		<!-- ***************************** -->		
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
		<script type='text/javascript'>
			function preguntar($fic){
				jConfirm('Alumno no registrado ¿Desea registrar?','Mensaje',function (respuesta)
				{ 
					if (respuesta)
						{window.location.href="alta2.php";}
				});			
			}
		</script>
		<script type="text/javascript"> 
			function alertar() {
				jError("El Alumno ya esta registrado", "Mensaje");
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
				<a><span>Servicio Médico </span></a>
				<span class='right_ab'>
					<a href='index.php'><strong> Ir a Inicio</strong></a>
				</span>
			</div>
		</div>
		<br>
		<div id='sbi_container' class='sbi_container'>
			<div class='sbi_panel' data-bg='pic/1.jpg'>	</div>
		</div>
		<div class='topbar'>
			<a><span><i>Inicio / Alta </i></span></a>
			<span class="right_ab">
					<a href="index.php"><strong> Regresar</strong></a>
				</span>
		</div>
    	<section class='tabss'>
			<fieldset> 
				<form name='buscar_ficha' method='POST' action='' autocomplete='off'>
		    		<table width='675' align='center'>
						<tr>
							<td width='250'><stroke><b>No Ficha:</td>
							<td></td>
						</tr>
						<tr>
							<td><input type='text' class='solo-numero' name='no_ficha' id='no_ficha' required></td>
							<td><stroke><input type='submit' value='Buscar' name='buscar' id='buscar'/></td>
						</tr>
					</table>
				</form>	
			</fieldset>
		</section>
		<?PHP
	if (isset($_POST['no_ficha'])){ 
		require_once '../conexion/conex_mysql.php';
		$no_ficha= $_POST['no_ficha'];
		$mysqli = new mysqli ($hostname,$username,$password,$database);
		if ($mysqli->connect_errno){
			die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
		}		
		$query = "SELECT * from alumnos_datos_personales where se_no_ficha='$no_ficha'";
		$resultado = $mysqli->query($query);
		$mysqli->close();
		$rows = mysqli_fetch_array($resultado);
		if(empty($rows)){
			session_start();
			$_SESSION['ficha']=$no_ficha;
			echo"<script languaje='javascript'>preguntar($no_ficha);</script>";
		}
		else{			
			$ficha=($rows['se_no_ficha']);
			$nombre=($rows['dp_nombre']);
			$apaterno=($rows['dp_ap_paterno']);
			$amaterno=($rows['dp_ap_materno']);
			$sexo=($rows['dp_sexo']);
			$carrera=($rows['dp_carrera']);
			echo "<script languaje='javascript'>alertar();</script>";
		echo"
		<section class='tabs'>
			<div class='contenedor-1'>
				<fieldset><legend><stroke><b>PERSONALES</legend>
				<table width='675' border='0'>
					<tr>
						<td width='380'><ba>No Ficha</td>
						<td><ba>No Control</td>
					</tr>
					<tr>
						<td><input type='text' name='ficha' id='ficha' size='10' align='right' disabled value='$ficha'></td>
						<td><input type='text' name='control' id='control' size='10' disabled disabled value=''></td>
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
				</table>
				</fieldset>
			</div>
		</section>";
		}
	} ?>
	</body>
</html>