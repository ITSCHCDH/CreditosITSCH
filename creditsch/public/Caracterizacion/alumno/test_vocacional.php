<!DOCTYPE html>
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
		<script type="text/javascript"> 
			function alertar() {
				jError("No Existe Registro", "Error");
			}
			function regresar() {
          	  setTimeout(function(){window.location.href=("test.php")} , 0); 
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
			<a><span><i>Inicio / Test / Vocacional</i></span></a>
			<span class='right_ab'>
					<a href='test.php'><strong> Regresar</strong></a>
				</span>
		</div>
		<section class='tabs'>
			<div class='contenedor-1' align='justify'>
				<p>Este cuestionario tiene como fin, ayudarte a conocer tus  intereses ocupacionales.<br />Para obtener un resultado lo más certero posible, es  necesario que contestes con veracidad y exactitud.</p>              
                <p>Indica tu respuesta de acuerdo a la siguiente escala.</p>
				<form id="form1" name="form1" method="post" action="tvocacional2.php" onsubmit="return validarForm(this,nom,numero);">
				<?php
					session_start();
					$_SESSION["ss"] = 0;
					$_SESSION["ep"] = 0;
					$_SESSION["v"] = 0;
					$_SESSION["ap"] = 0;
					$_SESSION["ms"] = 0;
					$_SESSION["og"] = 0;
					$_SESSION["ct"] = 0;
					$_SESSION["cl"] = 0;
					$_SESSION["mc"] = 0;
					$_SESSION["al"] = 0;

					
					//require_once '../conexion/conexion.php';
					require_once '../conexion/conex_mysql.php';
					$con=new mysqli($hostname,$username,$password,$database);
					//$con=new mysqli($host,$user,$pwd,$bd);
					if($con->connect_error){
						die("Fallo la conexion a MySQL ");
					}

					$no_ficha=$_SESSION['no_ficha'];
					$consulta="SELECT f_test_vocac FROM alumnos_folio WHERE no_ficha='$no_ficha'";
					$mostrar= $con->query($consulta);
					$rows = mysqli_fetch_array($mostrar);
					if($rows[0]==1)
         			{
            			echo "<script type='text/javascript'>regresar()</script>"; 
         			}


					//Generar la nueva consulta y mostrar la tabla
    				$c="select * from orientacion_vocacional where num_pregunta>=1  and num_pregunta<=20 ORDER BY num_pregunta asc";	
	
					$mostrar= $con->query($c);
		
					echo "
					<table width='800' align='justify'>
						<tr>
							<td>
								<pp>0.- Me desagrada</pp><br>
								<pp>1.- Me desagrada algo o en parte</pp><br>
								<pp>2.- Me es indiferente pues ni me gusta ni me disgusta</pp><br>
								<pp>3.- Me gusta algo o mas o menos</pp><br>
								<pp>4.- Me gusta mucho</pp><br>
							</td>
						</tr>	
					</table>
					<table width='800' align='center' border='2' bordercolor='#585858'>
						<tr>
							<td width='60%' align='center'><p>Enunciado</p></td>
							<td width='8%' align='center'><p>4</p></td>
							<td width='8%' align='center'><p>3</p></td>
							<td width='8%' align='center'><p>2</p></td>
							<td width='8%' align='center'><p>1</p></td>	
							<td width='8%' align='center'><p>0</p></td>
						</tr>
					";
	
					$cont=1;
					while($rows=$mostrar->fetch_assoc()){
						echo "
							<tr> 
								<td width='60%'><pp>".$cont.".-".$rows['pregunta']."</pp></td>
								<td><center><input type='radio' name=ov".$cont." id='r4' value='4'  ></center>
								</td>
								<td><center><input type='radio' name=ov".$cont." id='r3' value='3' ></center>
								</td>
								<td><center><input type='radio' name=ov".$cont." id='r2' value='2' ></center>
								</td>
								<td><center><input type='radio' name=ov".$cont." id='r1' value='1' ></center>
								</td>
								<td><center><input type='radio' name=ov".$cont." id='r0' value='0' ></center>
								</td>
							</tr>";
						$cont++;
					}
				?>
						</table>
							<script language="javascript">
							   //nombre del control radio INSERTA EL USUARIO ***********
							   nom='ov';
							   //numero de controles CALDULADO POR EL SISTEMA ***********
							   numero=<?php echo ($cont);?>;
							</script>

  					<center><br>
    					<input type="submit" name="button" id="button" value="Siguiente" />
    				</center>
  				</form>
			</div>
		</section>
	</body>
</html>