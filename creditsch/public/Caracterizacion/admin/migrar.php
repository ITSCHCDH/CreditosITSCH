<!DOCTYPE html>
<html lang="es">
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

		
		<script type="text/javascript" src="./../js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="./../js/jquery.bgImageMenu.js"></script>
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
	<script type="text/javascript">
		function rollback(){
			jError("No se realizo la migración de datos", "Mensaje");
			setTimeout(function(){window.location.href=("database.php")} , 3000); 
		}
		function commit(){
			jMessage("Se realizo la migración de datos", "Mensaje");
			setTimeout(function(){window.location.href=("database.php")} , 3000); 
		}
	</script>
</head>
<body>
	<div class="container">
		<br>
		<div class="topbar">
			<a><span>Administrador </span></a>
			<span class="right_ab">
				<a href="index.php"><strong> Ir a Inicio</strong></a>
			</span>
		</div>
		
		<div class="content">
			<br>
			<div id="sbi_container" class="sbi_container">
				<div class="sbi_panel" data-bg="../pic/1.jpg">
					
				</div>
			</div>
		</div>
		<div class="topbar">
			<a><span><i>Inicio / Base de Datos / Migrar Datos a Trayectoria</i></span></a>
		</div>
		
	</div>
	<?PHP
		require_once '../funciones/funciones_migracion.php';
		try {
			require '../conexion/conex_trayec_mysql.php';
			$mysqli = new mysqli ($hostname2,$username2,$password2,$database2);
			if ($mysqli->connect_errno){
				die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
			}
			//$mysqli->autocommit(FALSE);
			$query="START TRANSACTION;";
			$resultado = $mysqli->query($query);
			crear_tabla_temp($mysqli);
			consultar_alumnos_dp($mysqli);
			consultar_caracterizacion($mysqli);
			consultar_ficha_med($mysqli);
			consultar_semaforos($mysqli);
			consultar_estudio_se($mysqli);
			consultar_ingresos($mysqli);
			consultar_test_vocac($mysqli);
			consultar_dpadres($mysqli);
			consultar_hab_casa($mysqli);
			commit($mysqli);
		} catch (Exception $e) {
			rollback($mysqli);
		}
	?>
</body>
</html>

