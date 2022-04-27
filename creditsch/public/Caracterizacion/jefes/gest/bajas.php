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
		
		<script>
        	$(document).ready(function (){
          		$('.solo-numero').keyup(function (){
            		this.value = (this.value + '').replace(/[^0-9]/g, '');
          		});
        	});
    	</script>
    	<script>
			function preguntar($fic){
				jConfirm('¿Desea Eliminar Registro con Ficha: '+$fic+'?','Mensaje',function (respuesta)
				{ 					
					if (respuesta)
					{	
						jError('Registro Eliminado','Mensaje');
			 			//window.location.href="delete.php?no_ficha="+$fic; Descomentar para redireccionar y eliminar regstro. subir el documento delete.php al servidor.
					}	
				}
				);							
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
				<a><span>Jefe de Carrera - Gestión </span></a>
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
			<a><span><i>Inicio / Baja / Carrera</i></span></a>
			
		</div>
    	
	<?PHP
		
	
			
		echo "<div class='container'>
			<section class='tabs'>
	            <input id='tab-1' type='radio' name='radio-set' class='tab-selector-1' checked='checked' style='visibility:hidden'/>
		        <label for='tab-1' class='tab-label-1'><stroke-2>GEST</label>

		       	
			    <div class='clear-shadow'></div>
			    	<div class='contenedor'>
			        	<div class='contenedor-1'>";
			        		require_once '../../conexion/conex_mysql.php';
			        		require_once '../../consultas/sentencias_consulta_carreras.php';
							$mysqli = new mysqli ($hostname,$username,$password,$database);
							if ($mysqli->connect_errno){
								die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
							}
							$query = $gestion;
							$resultado = $mysqli->query($query);
							$array=mysqli_num_rows($resultado);														
							 if (!empty($array)){
							 	while($rows=mysqli_fetch_array($resultado)){								
								$ficha=($rows['se_no_ficha']);
								$nombre=($rows['dp_nombre']);
								$apaterno=($rows['dp_ap_paterno']);
								$amaterno=($rows['dp_ap_materno']);
								$sexo=($rows['dp_sexo']);
								$edocivil=($rows['dp_edo_civil']);
								$hijos=($rows['dp_hijos']);
								$foraneo=($rows['smf_foraneo']);								
								$trabaja=($rows['smf_trabaja']);
								$tutorias=($rows['smf_tut']);
								$cb=($rows['smf_cb']);
								$jc=($rows['smf_jef_car']);
								$grupo=($rows['sa_grupo_gen']);									
								echo "
								<fieldset><legend><stroke><b>FICHA ".$ficha."</legend>
									<form name='Gest".$ficha."' method='POST' action=''>
										<table width='670' border='0'>
											<tr>
												<td align='center' width='135'><bb>".$nombre."<br>".$apaterno."<br>".$amaterno."
													
												<br></td>
												<td align='center'><bb>Sexo<br> ";
													if ($sexo=='h' || $sexo=='H'){
														echo "<img src='../../images/masculino.png' alt='Sexo' height='65' width='65'>";	
													}
													else {
														echo "<img src='../../images/femenino.png' alt='Sexo' height='65' width='65'>";	
													}
												echo "</td>
												<td align='center'><bb>Estado Civil<br>";
												if ($edocivil==0){
													echo "<img src='../../images/clock.png' alt='Edo civil' height='65' width='65'>";
												}
												else if ($edocivil==1){
													echo "<img src='../../images/soltero.png' alt='Edo civil' height='65' width='65'>";
												}
												else if ($edocivil==2){
													echo "<img src='../../images/casado2.png' alt='Edo civil' height='65' width='65'>";
												}
												else {
													echo "<img src='../../images/otro.png' alt='Edo civil' height='65' width='65'>";
												}
												echo "	
												</td>
												<td align='center'><bb>Hijos<br>";
													if ($hijos==1){
														echo "<img src='../../images/baby.png' alt='Hijos' height='65' width='65'>";	
													}
													else {
														echo "<img src='../../images/cross.png' alt='Hijos' height='65' width='65'>";	
													}
													echo "
												</td>
												<td align='center'><bb>Trabaja<br>";
													if ($trabaja==1){
														echo "<img src='../../images/ok2.png' alt='Trabaja' height='65' width='65'>";	
													}
													else {
														echo "<img src='../../images/cross.png' alt='Hijos' height='65' width='65'>";	
													}
													echo "
												</td>
											</tr>
											
											<tr>
												<td align='center'><stroke><b>Grupo<br><br>".$grupo."</td>
												<td align='center'><bb>Foráneo<br>";
												if ($foraneo==1){
													echo "<img src='../../images/bus.png' alt='Foraneo' height='65' width='65'>";
												}
												else {
													echo "<img src='../../images/home2.png' alt='Foraneo' height='65' width='65'>";
												} 
												echo "	
												</td>
												<td align='center'><bb>Tutorías<br>";
												if ($tutorias==0){
													echo "<img src='../../images/semaforos/blue.png' alt='Tutorías' height='65' width='65'>";
												}
												else if ($tutorias==1){
													echo "<img src='../../images/semaforos/green.png' alt='Tutorías' height='65' width='65'>";
												}
												else if ($tutorias==2){
													echo "<img src='../../images/semaforos/yellow.png' alt='Tutorías' height='65' width='65'>";
												}
												else {
													echo "<img src='../../images/semaforos/red.png' alt='Tutorías' height='65' width='65'>";
												}
												echo "
												</td>
												<td align='center'><bb>C. Básicas<br>";
													if ($cb==0){
													echo "<img src='../../images/semaforos/blue.png' alt='Tutorías' height='65' width='65'>";
												}
												else if ($cb==1){
													echo "<img src='../../images/semaforos/green.png' alt='Tutorías' height='65' width='65'>";
												}
												else if ($cb==2){
													echo "<img src='../../images/semaforos/yellow.png' alt='Tutorías' height='65' width='65'>";
												}
												else {
													echo "<img src='../../images/semaforos/red.png' alt='Tutorías' height='65' width='65'>";
												}
												echo "
												</td>
												<td align='center'><bb>J. de Carrera<br>";
												if ($jc==0){
													echo "<img src='../../images/semaforos/blue.png' alt='Tutorías' height='65' width='65'>";
												}
												else if ($jc==1){
													echo "<img src='../../images/semaforos/green.png' alt='Tutorías' height='65' width='65'>";
												}
												else if ($jc==2){
													echo "<img src='../../images/semaforos/yellow.png' alt='Tutorías' height='65' width='65'>";
												}
												else {
													echo "<img src='../../images/semaforos/red.png' alt='Tutorías' height='65' width='65'>";
												}
												echo "
												</td>
											</tr>
										</table>
										<table align='right'>
											<tr>
												<td> <br>
													
													<input class='elim' value='ELIMINAR' name='Eliminar' id='Eliminar' onClick='return preguntar($ficha);' size='6'>
												</td>
											</tr>
										</table>
									</form>
								</fieldset>";								
							}}
							else {
								echo "

									<table width='670'>
										<tr>
											<td align='center'> <br>
												<img src='../../images/no_results3.png' alt='consulta'>
											</td>
										</tr>
									</table>";

								
							}
			        	echo "	
				    	</div>
		        	</div>
				</div>
			</section>
        </div>
    </body>
</html>";
		
	
	?>