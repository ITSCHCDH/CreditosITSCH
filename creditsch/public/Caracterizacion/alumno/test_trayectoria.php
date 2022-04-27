<html> 
	<head>
		<meta charset='UTF-8'/>
	  	<meta http-equiv='X-UA-Compatible' contenedor='IE=edge,chrome=1'>
	  	<title>STE-ITSCH</title>
	  	<meta name='viewport' contenedor='width=device-width, initial-scale=1.0'>	   
	  	<link rel='stylesheet' type='text/css' href='../css/demo.css' />
	  	<link rel='stylesheet' type='text/css' href='../css/style.css' />
	  	<link rel='stylesheet' type='text/css' href='../css/sbimenu.css' />	    	    
		
		<script src='http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js'></script>
		<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js'></script>
		<script type='text/javascript' src='../js/jquery.easing.1.3.js'></script>
		<script type='text/javascript' src='../js/jquery.bgImageMenu.js'></script>
		<!--Validar radios -->
      	<script type="text/javascript" src="../js/JSvalidar0.js"></script>
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
		<script>
			function regresar() {
            	setTimeout(function(){window.location.href=("test.php")} , 0); 
         	}
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
				<a><span>Alumno </span></a>
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
			<a><span><i>Inicio / Test / Trayectoria</i></span></a>
			<span class='right_ab'>
					<a href='test.php'><strong> Regresar</strong></a>
				</span>
		</div>
		<section class='tabs'>
			<div class='contenedor-1' align='justify'>
				<form id="form1" name="form1" method="post" action="segmentoB.php" onsubmit="return validarForm(this,nom,numero);">
  					<p>Este  test consiste en una serie de preguntas que nos permitirá identificar cuáles  son tus inquietudes, intereses, áreas de oportunidad y fortalezas, por lo cual te  pedimos que contestes de manera sincera y honesta cada una de las siguientes  preguntas. Te recordamos que las respuestas nos ayudan a conocerte un poco más,  además de que solo serán del conocimiento del departamento de Tutorías y  servicios psicopedagógicos.</p>
  					

  		<?php
			session_start();
			require_once '../conexion/conex_mysql.php';
      		$no_ficha=$_SESSION['no_ficha'];
      		$con=new mysqli($hostname,$username,$password,$database);
			//$con=new mysqli($host,$user,$pwd,$bd);
			if($con->connect_error){
				die("Fallo la conexion a MySQL ");
			}

			$consulta="SELECT f_test_trayec FROM alumnos_folio WHERE no_ficha='$no_ficha'";
			$mostrar= $con->query($consulta);
			$rows = mysqli_fetch_array($mostrar);
			if($rows[0]==1)
         	{
           		echo "<script type='text/javascript'>regresar()</script>"; 
        	}
			//Generar la consulta del segmento A y mostrar la tabla
			$c="select * from ta_segmento_a";
			$mostrar= $con->query($c);
	
	echo "
	<table width='800'>
		<tr>
      		<td align='center'><p>SEGMENTO A: Lee la pregunta y contesta según sea tu caso:</p></td>
    	</tr>
	</table>
    <table width='800'>";
		$cont=1;
		while($rows=$mostrar->fetch_assoc()){
	echo 
		"<tr>
			<td width='500'><p>".$rows['pregunta']."</p></td>
			<td width='20'></td>
			<td width='60'><p><input type='radio' name=rA".$cont." id='rv' value='1' />
				Si</p></td>

			<td width='60'><p><input type='radio' name=rA".$cont." id='rf' value='0'/>
				No</p></td>
		</tr>";
			$cont++;
		}
	echo 
	"</table>";
?>
    		<script language="javascript">
			   //nombre del control radio INSERTA EL USUARIO ***********
			   nom='rA';
			   //numero de controles CALDULADO POR EL SISTEMA ***********
			   numero=<?php echo ($cont);?>;
			</script>
          <center>
            <input type="submit" name="button" id="button" value="Siguiente" />
          </center>
        </form>		
      </div>
    </section>
	</body>
</html>