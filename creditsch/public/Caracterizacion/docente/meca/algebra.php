<!DOCTYPE html>
<html> 
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
		<script type='text/javascript'>
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
		<script type="text/javascript"> 
			function alertar() {
				jError("No Existe Registro", "Error");
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
				<a><span>Docente - Mecatrónica</span></a>
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
			<a><span><i>Inicio / Registrar Calificación de Ciencias Básicas</i></span></a>
		</div>
		<?PHP 
			require_once '../../funciones/funciones.php';
			asignar_calif_algebra('meca');
		?>
</body>
</html>
