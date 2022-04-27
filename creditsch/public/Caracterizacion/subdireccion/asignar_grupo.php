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
		<script type="text/javascript">
			function registrar($i){
				if($i==1){
					document.form1.action='guardar_grupo.php';						
					document.form1.submit();
				}
				else if($i==2){
					document.form2.action='guardar_grupo.php';						
					document.form2.submit();
				}
				else if($i==3){
					document.form3.action='guardar_grupo.php';						
					document.form3.submit();
				}
				else if($i==4){
					document.form4.action='guardar_grupo.php';						
					document.form4.submit();
				}
				else if($i==5){
					document.form5.action='guardar_grupo.php';						
					document.form5.submit();
				}
				else if($i==6){
					document.form6.action='guardar_grupo.php';						
					document.form6.submit();
				}
				else{
					document.form7.action='guardar_grupo.php';						
					document.form7.submit();
				}
				
			}
			function modificar($x){
				var fic=$x;
				
					var valor=document.getElementById('ficha'+fic).value;
				
				//document.form2.action='modificar_carrera.php';						
				//document.form2.submit();
				jError("El valor es:"+valor, "Error");
			}
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
			<a><span><i>Inicio / Asignar Grupo</i></span></a>
			
		</div>

		<?PHP 
			require '../funciones/funciones.php';
			consulta_carr2();
		?>
  	</body>
</html>
