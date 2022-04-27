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
			<form name="form1" method="post" action="segmentoC.php" onsubmit="return validarForm(this,nom,numero);">
    			<?php
					session_start();
					//require_once '../conexion/conexion.php';
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
					$res[0]=$_REQUEST['rA1'];
					$res[1]=$_REQUEST['rA2'];
					$res[2]=$_REQUEST['rA3'];
					$res[3]=$_REQUEST['rA4'];
					$res[4]=$_REQUEST['rA5'];
					$suma_sgA=0;
					$res_sgA="";
					for($x=0;$x<5;$x++){
						if($res[$x]==1){
							$suma_sgA++;		
						}	
						$res_sgA=$res_sgA.$res[$x];
					}
					$_SESSION["sumA"] = $suma_sgA;
					$_SESSION["resA"] = $res_sgA;
					//echo "<br>".$suma_sgA."<br>".$res_sgA;
					//$rec=$_SESSION['recibo'];

					//$sen="update respuestas set ta_sa1='".$res1."',ta_sa2='".$res2."',ta_sa3='".$res3."',ta_sa4='".$res4."',ta_sa5='".$res5."' where folio=".$_SESSION['folio'];
					//$resultado=$con->query($sen);


					//Generar la consulta del segmento B y mostrar la tabla
					$c="select * from ta_segmento_b";
					$mostrar= $con->query($c);
						$pr[1]='<p>A</p>';$pr[2]='<p>B</p>';$pr[3]='<p>C</p>';$pr[4]='<p>D</p>';$pr[5]='<p>E</p>';$pr[6]='<p>F</p>';$pr[7]='<p>G</p>';
	
					echo "
					<table width='800' align='center' >
						<tr>
							<td colspan='2' align='justify'><p>SEGMENTO  B: Elija una oracion de cada grupo, la que mejor describa como se ha sentido  las últimas dos semanas, incluyendo el día de hoy. Si varios enunciados de un  mismo grupo parecen igualmente apropiados, elija el más relevante para usted.</p>
							</td>
    					</tr> 
    				</table>";
	
					//	$preg[]={'A','B','C','D','E','F'};
					$cont=1;
					while($rows=$mostrar->fetch_assoc()){
						echo "
						<table width='800' align='center' border='2' bordercolor='#585858'>
							<tr>
								<td width='10%' rowspan='4'>
									<center>".$pr[$cont]."</center>
								</td>
								<td width='90%'><input type='radio' name=rB".$cont." id='0' value='0'  />
									<pp>".$rows['opcion1']."</pp>
								</td>
							</tr>
							<tr>
								<td>
									<input type='radio' name=rB".$cont." id='1' value='1' />
										<pp>".$rows['opcion2']."</pp>
								</td>
							</tr>
							<tr>
								<td>
									<input type='radio' name=rB".$cont." id='2' value='2'  />
										<pp>".$rows['opcion3']."</pp>
								</td>
							</tr>
							<tr>
								<td>
									<input type='radio' name=rB".$cont." id='3' value='3'  />
										<pp>".$rows['opcion4']."</pp>
								</td>
							</tr>
						</table>";
						$cont++;
					}
				?>
					<script language="javascript">
			   			//nombre del control radio INSERTA EL USUARIO ***********
			   			nom='rB';
			   			//numero de controles CALDULADO POR EL SISTEMA ***********
			   			numero=<?php echo ($cont);?>;
					</script>
				<center><br>
  					<input type="submit" name="button" id="button" value="Siguiente">
  				</center>
    		</form>
    		</div>
  		</section>>
	</body>
</html>	