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
			<a><span><i>Inicio / Test / Trayectoria</i></span></a>
			<span class='right_ab'>
					<a href='test.php'><strong> Regresar</strong></a>
				</span>
		</div>
		<section class='tabs'>
			<div class='contenedor-1' align='justify'>
				<form name="form1" method="post" action="trayectoria.php" onsubmit="return validarForm(this,nom,numero);">
				<?php
					session_start();
					require_once '../conexion/conex_mysql.php';
					$con=new mysqli($hostname,$username,$password,$database);
					//$con=new mysqli($host,$user,$pwd,$bd);
					if($con->connect_error){
						die("Fallo la conexion a MySQL ");
					}

					$no_ficha=$_SESSION['no_ficha'];
					$consulta="SELECT f_test_trayec FROM alumnos_folio WHERE no_ficha='$no_ficha'";
					$mostrar= $con->query($consulta);
					$rows = mysqli_fetch_array($mostrar);
					$folio=$rows[0];

					if($folio==1)
					{
						header("location: test.php");
					}

					// Guardar respuestas de SegmentoA

					$res[0]=$_REQUEST['rC1'];
					$res[1]=$_REQUEST['rC2'];
					$res[2]=$_REQUEST['rC3'];
					$res[3]=$_REQUEST['rC4'];
					$res[4]=$_REQUEST['rC5'];
					$suma_sgC=0;
					$res_sgC="";
					for($x=0;$x<5;$x++){
						$suma_sgC+=$res[$x];		
						$res_sgC=$res_sgC.$res[$x];
					}
					$_SESSION["sumC"] = $suma_sgC;
					$_SESSION["resC"] = $res_sgC;
					//echo "<br>".$suma_sgC."<br>".$res_sgC;

					//Consultar la tabla de segmentoD, y mostrarla

					$c="select * from ta_segmento_d ORDER BY num_pregunta asc";
					$mostrar= $con->query($c);
	
					echo "
					<table width='800' align='justify'>
						<tr>	
							<td><p>Lee detenidamente cada una de las siguientes preguntas, y selecciona la opcion que consideres adecuada</p>
							</td>
						</tr>
					</table>";
					$cont=1;
					while($rows=$mostrar->fetch_assoc()){
						if($cont>=1 && $cont<=10){
							echo "
							<table width='800' align='center' border='2' bordercolor='#585858'>
								<tr>
									<td width='74%'><pp>".$cont.".-".$rows['pregunta']."</pp></td>
									<td width='13%' align='center'>
										<input type='radio' name=rD".$cont." id='rv' value='1'  />
										<pp>Si</pp>
									</td>
									<td width='13%' align='center'>
										<input type='radio' name=rD".$cont." id='rf' value='0'  />
										<pp>No</pp>
									</td>
								</tr>
							</table>";
						}
						else if($cont>=11 && $cont<=14){
							echo "
							<table width='800' align='center' border='2' bordercolor='#585858'>
								<tr>
									<td width='74%'><pp>".$cont.".-".$rows['pregunta']."</pp></td>
									<td width='13%' align='center'>
										<input type='radio' name=rD".$cont." id='rv' value='1'  />
										<pp>Si</pp>
									</td>
									<td width='13%' align='center'>
										<input type='radio' name=rD".$cont." id='rf' value='0'  />
										<pp>No</pp>
									</td>
								</tr>
							</table>";
						}
						$cont++;
					}
				?>        
					<script language="javascript">
			   			//nombre del control radio INSERTA EL USUARIO ***********
			   			nom='rD';
			   			//numero de controles CALDULADO POR EL SISTEMA ***********
			   			numero=<?php echo ($cont);?>;
					</script>
  					<center>
  						<br>
    					<input type="submit" name="button" id="button" value="Terminar">
    				</center>
  				</form>
  			</div>
  		</section>
  	</body>
</html>
