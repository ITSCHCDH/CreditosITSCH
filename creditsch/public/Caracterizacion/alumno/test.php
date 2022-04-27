<!DOCTYPE html>
<html lang="es">
    <head>
        <title>STE-ITCH</title>
		<meta charset="UTF-8" />        
        <link rel='stylesheet' type='text/css' href='../css/demo.css' />
        <link rel="stylesheet" type="text/css" href="../css/style2.css" />
		<link rel="stylesheet" type="text/css" href="../css/sbimenu.css" />
		<!--Js para mensajes-->
	    <link rel="stylesheet" type="text/css" href="../css/jquery.alerts.css">
		<script src="../js/jquery-1.4.2.min.js" type="text/javascript"></script>
		<script src="../js/jquery.ui.draggable.js" type="text/javascript"></script>
		<script src="../js/jquery.alerts.mod.js" type="text/javascript"></script>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
		<script type="text/javascript" src="../js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="../js/jquery.bgImageMenu.js"></script>
		<script type="text/javascript">
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
		
    </head>
    <body>
    <?PHP 
		session_start();
		if (isset($_SESSION['no_ficha']) AND ($_SESSION['curp'])){
			$no_ficha=$_SESSION['no_ficha'];
			$carrera=$_SESSION['carrera'];
			

			require_once '../conexion/conex_mysql.php';
		
			$mysqli = new mysqli ($hostname,$username,$password,$database);
			if ($mysqli->connect_errno){
				die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
			}		
			$query = "SELECT * FROM alumnos_folio WHERE no_ficha='$no_ficha'";
			$resultado = $mysqli->query($query);
			$rows = mysqli_fetch_array($resultado);
					
			if(empty($rows)){
				echo "<script type='text/javascript'>alertar()</script>"; 
			}
			else{
				$datos_personales=$rows['f_dat_pers'];
				$ficha_medica=$rows['f_ficha_med'];
				$test_trayectoria=$rows['f_test_trayec'];
				$test_vocacional=$rows['f_test_vocac'];
				$est_se1=$rows['f_est_soc_econ1'];
				$est_se2=$rows['f_est_soc_econ2'];
				$est_se3=$rows['f_est_soc_econ3'];
				$folio=$rows['f_folio'];
				echo "
		<div class='container'>
		<br>
			<div class='topbar'>
				<a><span>Alumno </span></a>
				<span class='right_ab'>
					<a href='index.php'><strong> Ir a Inicio</strong></a>
				</span>
			</div>
			<div class='content'>
			<br>
				<div id='sbi_container' class='sbi_container'>
					<div class='sbi_panel' data-bg='../pic/1.jpg'>
						<a class='sbi_label'>Test</a>
						<div class='sbi_content'>
						<ul>";
							if ($datos_personales==0){
								echo"<li><a href='datos_personales.php'>Datos Personales</a></li>";
							}
							if ($ficha_medica==0){
								echo "<li><a href='fichamedica.php'>Ficha Médica</a></li>";
							}
							if ($test_vocacional==0){
								echo"<li><a href='test_vocacional.php'>Test Vocacional</a></li>";
							}
							if ($test_trayectoria==0){
								echo"<li><a href='test_trayectoria.php'>Test Trayectoria</a></li>";
							}
							if (($datos_personales==1) && ($ficha_medica==1) && ($test_trayectoria==1) && ($test_vocacional==1)){
								echo "<li><a href='generar_folio.php'>Folio</a></li>";
							}
				echo"	</ul>
					</div>
					</div>
					<div class='sbi_panel' data-bg='../pic/2.jpg'>
						<a class='sbi_label'>Estudio SE </a>
						<div class='sbi_content'>
							<ul>";
							if ($est_se1==0){
								echo"<li><a href='estudio_se_1.php'>Estudio SE Parte 1</a></li>";
							}
							if ($est_se2==0){
								echo"<li><a href='estudio_se_2.php'>Estudio SE Parte 2</a></li>";
							}
							if ($est_se3==0){
								echo"<li><a href='estudio_se_3.php'>Estudio SE Parte 3</a></li>";
							}
			
							echo"</ul>
						</div>
					</div>

					<div class='sbi_panel'></div>
				</div>
			</div>
			<div class='topbar'>
				<a><span><i>Inicio / Test</i></span></a>
			</div>
		</div>
	</body>
</html>
				";
			}
		}
		else{
			header("location: index.php");
		}


    ?>
		

    
