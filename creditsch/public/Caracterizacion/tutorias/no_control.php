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
		
		<script src='http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js'></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
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
		function mensaje($reg,$act){
			jError("Hay "+$reg+" nuevos #s de Control de los cuales \n se actualizaron "+$act+" en nuestra base de datos", "Mensaje");
			setTimeout(function(){window.location.href=("index.php")} , 3000); 
		}
	</script>
</head>
<body>
	<div class="container">
		<br>
		<div class="topbar">
			<a><span>Tutorías </span></a>
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
			<a><span><i>Inicio / Asignar #s de Control</i></span></a>
		</div>
		
	</div>
	<?PHP 
		require '../funciones/funciones.php';
		asignar_control();

	?>
</body>
</html>