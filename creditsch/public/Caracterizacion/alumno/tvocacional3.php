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
				<form name="form1" method="post" action="tvocacional4.php" onsubmit="return validarForm(this,nom,numero);">
				<?php
				session_start();
				require_once '../conexion/conexion.php';
				$con=new mysqli($host,$user,$pwd,$bd);
				if($con->connect_error){
					die("Fallo la conexion a MySQL ");
				}

				$no_ficha=$_SESSION['no_ficha'];
				$consulta="SELECT f_test_vocac FROM alumnos_folio WHERE no_ficha='$no_ficha'";
				$mostrar= $con->query($consulta);
				$rows = mysqli_fetch_array($mostrar);
				$folio=$rows[0];

				if($folio==1)
				{
					header("location: test.php");
				}

				//Recibir datos
				$res[0]=$_REQUEST['ov1'];
				$res[1]=$_REQUEST['ov2'];
				$res[2]=$_REQUEST['ov3'];
				$res[3]=$_REQUEST['ov4'];
				$res[4]=$_REQUEST['ov5'];
				$res[5]=$_REQUEST['ov6'];
				$res[6]=$_REQUEST['ov7'];
				$res[7]=$_REQUEST['ov8'];
				$res[8]=$_REQUEST['ov9'];
				$res[9]=$_REQUEST['ov10'];
				$res[10]=$_REQUEST['ov11'];
				$res[11]=$_REQUEST['ov12'];
				$res[12]=$_REQUEST['ov13'];
				$res[13]=$_REQUEST['ov14'];
				$res[14]=$_REQUEST['ov15'];
				$res[15]=$_REQUEST['ov16'];
				$res[16]=$_REQUEST['ov17'];
				$res[17]=$_REQUEST['ov18'];
				$res[18]=$_REQUEST['ov19'];
				$res[19]=$_REQUEST['ov20'];

				//Recuperar los valores de las variables de SESSION, y asignarlos a las locales

				$ss=$_SESSION["ss"];
				$ep=$_SESSION["ep"];
				$v=$_SESSION["v"];
				$ap=$_SESSION["ap"];
				$ms=$_SESSION["ms"];
				$og=$_SESSION["og"];
				$ct=$_SESSION["ct"];
				$cl=$_SESSION["cl"];
				$mc=$_SESSION["mc"];
				$al=$_SESSION["al"];

				//Sumar los valores del formulario anterior, con los de la sesion
				$ss=$ss+$res[0]+$res[10];
				$ep=$ep+$res[1]+$res[11];
				$v=$v+$res[2]+$res[12];
				$ap=$ap+$res[3]+$res[13];
				$ms=$ms+$res[4]+$res[14];
				$og=$og+$res[5]+$res[15];
				$ct=$ct+$res[6]+$res[16];
				$cl=$cl+$res[7]+$res[17];
				$mc=$mc+$res[8]+$res[18];
				$al=$al+$res[9]+$res[19];


				//Sumar las variables de los perfiles (cookies) con los datos de las variables locales

				$_SESSION["ss"] = $ss;
				$_SESSION["ep"] = $ep;
				$_SESSION["v"] = $v;
				$_SESSION["ap"] = $ap;
				$_SESSION["ms"] = $ms;
				$_SESSION["og"] = $og;
				$_SESSION["ct"] = $ct;
				$_SESSION["cl"] = $cl;
				$_SESSION["mc"] = $mc;
				$_SESSION["al"] = $al;

				//Generar la nueva consulta y mostrar la tabla
   				 $c="select * from orientacion_vocacional where num_pregunta>=41  and num_pregunta<=60 ORDER BY num_pregunta asc";	
	
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
						
						if($cont==11){
							echo "<tr><td><pp>AHORA CONTESTA QUE TANTO TE GUSTARIA TRABAJAR COMO...</pp></td></tr>";
						}
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