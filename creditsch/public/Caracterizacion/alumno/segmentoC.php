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
				<form name="form1" method="post" action="segmentoD.php" onsubmit="return validarForm(this,nom,numero);">
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

					$res[0]=$_REQUEST['rB1'];
					$res[1]=$_REQUEST['rB2'];
					$res[2]=$_REQUEST['rB3'];
					$res[3]=$_REQUEST['rB4'];
					$res[4]=$_REQUEST['rB5'];
					$res[5]=$_REQUEST['rB6'];
					$res[6]=$_REQUEST['rB7'];
					$suma_sgB=0;
					$res_sgB="";
					for($x=0;$x<7;$x++){
						$suma_sgB+=$res[$x];		
						$res_sgB=$res_sgB.$res[$x];
					}
					$_SESSION["sumB"] = $suma_sgB;
					$_SESSION["resB"] = $res_sgB;
					//echo "<br>".$suma_sgB."<br>".$res_sgB;

					//Consultar la tabla de segmentoC, y mostrarla
					//$tel=utf8_encode($rows['dp_tel']);

					$c="select * from ta_segmento_c";
					$mostrar= $con->query($c);
					echo"
					<table width='800' align='justify'>
						<tr>	
							<td><p>Lee detenidamente cada pregunta, y selecciona la respuesta que tu consideras adecuada</p>
							</td>
						</tr>
					</table>";
					$cont=1;
					while($rows=$mostrar-> fetch_assoc()){
						if($cont==1 || $cont==3){
							echo "
							<table width='800' align='center' border='2' bordercolor='#585858'>
								<tr>
									<td colspan='2'><p>".$cont.".-".$rows['pregunta']."</p></td>
								</tr>
								<tr>
									<td width='10%'><center><pp>A</pp></center></td>
									<td width='90%'>
										<input type='radio' name=rC".$cont." id='r0' value='4'  />
										<ppp>".$rows['A']."</ppp>
									</td>
								</tr>
								<tr> 
									<td width='10%'><center><pp>B</pp></center></td>
									<td width='90%'>
										<input type='radio' name=rC".$cont." id='r1' value='2'  />
										<ppp>".$rows['B']."</ppp>
									</td>
								</tr>
								<tr> 
									<td width='10%'><center><pp>C</pp></center></td>
									<td width='90%'>
										<input type='radio' name=rC".$cont." id='r3' value='1'  />
										<ppp>".$rows['C']."</ppp>
									</td>
								</tr>
								<tr> 
									<td width='10%'><center><pp>D</pp></center></td>
									<td width='90%'>
										<input type='radio' name=rC".$cont." id='r4' value='3'  />
										<ppp>".$rows['D']."</ppp>
									</td>
								</tr>
							</table>";
						}
						else if($cont==2 || $cont==4){
							echo "
							<table width='800' align='center' border='2' bordercolor='#585858'>
								<tr>
									<td colspan='2'><p>".$cont.".-".$rows['pregunta']."</p>
								</tr>
								<tr>
									<td width='10%'><center><pp>A</pp></center></td>
									<td width='90%'>
										<input type='radio' name=rC".$cont." id='r0' value='1'  />
										<ppp>".$rows['A']."</ppp>
									</td>
								</tr>
								<tr> 
									<td width='10%'><center><pp>B</pp></center></td>
									<td width='90%'>
										<input type='radio' name=rC".$cont." id='r1' value='3'  />
										<ppp>".$rows['B']."</ppp>
									</td>
								</tr>
								<tr> 
									<td width='10%'><center><pp>C</pp></center></td>
									<td width='90%'>
										<input type='radio' name=rC".$cont." id='r3' value='2'  />
										<ppp>".$rows['C']."</ppp>
									</td>
								</tr>
								<tr> 
									<td width='10%'><center><pp>D</pp></center></td>
									<td width='90%'>
										<input type='radio' name=rC".$cont." id='r4' value='4'  />
										<ppp>".$rows['D']."</ppp>
									</td>
								</tr>
							</table>";
						}
						else if($cont==5){
							echo"
							<table width='800' align='center' border='2' bordercolor='#585858'>
								<tr>
									<td colspan='2'><p>".$cont.".-".$rows['pregunta']."</p>
								</tr>
								<tr>
									<td width='10%'><center><pp>A</pp></center></td>
									<td width='90%'>
										<input type='radio' name=rC".$cont." id='r0' value='3'  />
										<ppp>".$rows['A']."</ppp>
									</td>
								</tr>
								<tr> 
									<td width='10%'><center><pp>B</pp></center></td>
									<td width='90%'>
										<input type='radio' name=rC".$cont." id='r1' value='1'  />
										<ppp>".$rows['B']."</ppp>
									</td>
								</tr>
								<tr> 
									<td width='10%'><center><pp>C</pp></center></td>
									<td width='90%'>
										<input type='radio' name=rC".$cont." id='r3' value='4'  />
										<ppp>".$rows['C']."</ppp>
									</td>
								</tr>
								<tr> 
									<td width='10%'><center><pp>D</pp></center></td>
									<td width='90%'>
										<input type='radio' name=rC".$cont." id='r4' value='2'  />
										<ppp>".$rows['D']."</ppp>
									</td>
								</tr>
							</table>";
						}
						$cont++;
					}
				?>
					<script language="javascript">
			   			//nombre del control radio INSERTA EL USUARIO ***********
			   			nom='rC';
			   			//numero de controles CALDULADO POR EL SISTEMA ***********
			   			numero=<?php echo ($cont);?>;
					</script>
					<center><br>
						<input type="submit" name="button" id="button" value="Siguiente">
					</center>
				</form>
			</div>
		</section>
	</body>
</html>

