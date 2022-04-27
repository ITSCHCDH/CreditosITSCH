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
				<a><span>Tutorías</span></a>
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
			<a><span><i>Inicio / Consulta / Individual</i></span></a>
			<span class='right_ab'>
				<a href='index.php'><strong> Regresar</strong></a>
			</span>
		</div>
    	<section class='tabss'>
			<fieldset>
				<form name='buscar_ficha' method='POST' action='' autocomplete='off'>
		    		<table width='675' align='center'>
						<tr>
							<td width='380'><stroke><b>No Ficha: </b></stroke></td>
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
		require_once '../funciones/funciones.php';
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
		echo "
		<div class='container'>
			<section class='tabs'>
	            <input id='tab-1' type='radio' name='radio-set' class='tab-selector-1' checked='checked' style='visibility:hidden'/>
		        <label for='tab-1' class='tab-label-1'><stroke-2>DATOS PERSONALES</stroke-2></label>

		       	<input id='tab-2' type='radio' name='radio-set' class='tab-selector-2'  style='visibility:hidden'/>
		        <label for='tab-2' class='tab-label-2'><stroke-2>CARACTERIZACIÓN</stroke-2></label>
		
	            <input id='tab-3' type='radio' name='radio-set' class='tab-selector-3'  style='visibility:hidden'/>
		        <label for='tab-3' class='tab-label-3'><stroke-2>ESTUDIO SE-I</stroke-2></label>

		        <input id='tab-4' type='radio' name='radio-set' class='tab-selector-4'  style='visibility:hidden'/>
		        <label for='tab-4' class='tab-label-4'><stroke-2>ESTUDIO SE-II</stroke-2></label>
				                        
			    <div class='clear-shadow'></div>
			    	<div class='contenedor'>";
			        	datos_todos($no_ficha);
					echo "</div>
				</section>
        	</div>
    </body>
</html>";
		}
	}	
	?>