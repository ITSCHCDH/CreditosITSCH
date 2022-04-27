<head>
		<meta charset='UTF-8'/>
	   	<meta http-equiv='X-UA-Compatible' contenedor='IE=edge,chrome=1'>
	    <title>STE-ITSCH</title>
	    <meta name='viewport' contenedor='width=device-width, initial-scale=1.0'>
	   
	    <link rel='stylesheet' type='text/css' href='../css/demo.css' />
	    <link rel='stylesheet' type='text/css' href='../css/style3.css' />
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
	</head>
	<body>
    	<div class='container'>
			<br>
			<div class='topbar'>
				<a><span>Subdirección Académica </span></a>
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
			<a><span><i>Inicio / Asignar Calificación de Examen de Admisión</i></span></a>
			
		</div>

		<div class='container'>
			<section class='tabs'>
	            <input id='tab-1' type='radio' name='radio-set' class='tab-selector-1' checked='checked' style='visibility:hidden'/>
		        <label for='tab-1' class='tab-label-1'><stroke-2>BIO</label>

		       	<input id='tab-2' type='radio' name='radio-set' class='tab-selector-2' style='visibility:hidden'/>
		        <label for='tab-2' class='tab-label-2'><stroke-2>GEST</label>
		
	            <input id='tab-3' type='radio' name='radio-set' class='tab-selector-3' style='visibility:hidden'/>
		        <label for='tab-3' class='tab-label-3'><stroke-2>IND</label>

		        <input id='tab-4' type='radio' name='radio-set' class='tab-selector-4' style='visibility:hidden'/>
		        <label for='tab-4' class='tab-label-4'><stroke-2>MECA</label>

		        <input id='tab-5' type='radio' name='radio-set' class='tab-selector-5' style='visibility:hidden'/>
		        <label for='tab-5' class='tab-label-5'><stroke-2>NANO</label>

		        <input id='tab-6' type='radio' name='radio-set' class='tab-selector-6' style='visibility:hidden'/>
		        <label for='tab-6' class='tab-label-6'><stroke-2>SIST</label>

		        <input id='tab-7' type='radio' name='radio-set' class='tab-selector-7' style='visibility:hidden'/>
		        <label for='tab-7' class='tab-label-7'><stroke-2>TICS</label>
				                        
			    <div class='clear-shadow'></div>

			    <div class='contenedor'>
			    	<?PHP 
			    	require_once '../funciones/funciones.php';
			    	asignar_calif_exam_adm();
			    	?>
				</div>
			</section>
		</div>
  	</body>
</html>
