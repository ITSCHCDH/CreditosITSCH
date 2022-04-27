<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset='UTF-8'/>
   	<meta http-equiv='X-UA-Compatible' contenedor='IE=edge,chrome=1'>
    <title>STE-ITSCH</title>
    <meta name='viewport' contenedor='width=device-width, initial-scale=1.0'>	   
    <link rel='stylesheet' type='text/css' href='../../css/demo.css' />
    <link rel='stylesheet' type='text/css' href='../../css/style3.css' />
    <link rel='stylesheet' type='text/css' href='../../css/sbimenu.css' />	    
	<!--Js para mensajes-->
    <link rel="stylesheet" type="text/css" href="../../css/jquery.alerts.css">
	<script src="../../js/jquery-1.4.2.min.js" type="text/javascript"></script>
	<script src="../../js/jquery.ui.draggable.js" type="text/javascript"></script>
	<script src="../../js/jquery.alerts.mod.js" type="text/javascript"></script>
	
	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js'></script>
	<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js'></script>
	<script type='text/javascript' src='../../js/jquery.easing.1.3.js'></script>
	<script type='text/javascript' src='../../js/jquery.bgImageMenu.js'></script>
	<script type="text/javascript">
		$(function() {
			$('#sbi_container').bgImageMenu({
				defaultBg	: '../../pic/5.jpg',
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
	<div class='container'>
		<br>
		<div class='topbar'>
			<a><span>Docente - Industrial</span></a>
			<span class='right_ab'>
				<a href='index.php'><strong> Ir a Inicio</strong></a>
			</span>
		</div>
	</div>
	<br>
	<div id='sbi_container' class='sbi_container'>
		<div class='sbi_panel' data-bg='../../pic/1.jpg'>
		</div>
	</div>
	<div class='topbar'>
		<a><span><i>Inicio / Consulta de Calificaciones </i></span></a>
	</div>
	<?PHP 
		require '../../funciones/funciones.php';
		consultar_calif('industrial');
	?>
</body>
</html>
