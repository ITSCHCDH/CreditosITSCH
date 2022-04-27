<?PHP session_start() ?>
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
		<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js'></script>
		<script type='text/javascript' src='../js/jquery.easing.1.3.js'></script>
		<script type='text/javascript' src='../js/jquery.bgImageMenu.js'></script>
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
			function enviar(){
				document.enviar_se3.action='registrar_se_3.php';						
				document.enviar_se3.submit();	
			}
		</script>
		<script type="text/javascript">
			function validar_vacio(){
				if (document.getElementById('campos').value.length==0){
					jError('Escriba un número entre 0 y 10','Error');
					document.getElementById('campos').focus();
					return 0;
				}
			}
		</script>
		<script type="text/javascript"> 
			function alertar() {
				jError("No Existe Registro", "Error");
			}
		</script>
		<script type="text/javascript">
			function verificar($campos){
				for (var i = 1; i <=$campos; i++) {
					nombre='nombre'+i; edad='edad'+i;parentesco='parentesco'+i;
					escolaridad='escolaridad'+i;escuela='escuela'+i;ocupacion='ocupacion'+i;
					

					if (document.getElementById(nombre).value==""){
						jError("Tiene que escribir Nombre","Mensaje");
						document.getElementById(nombre).focus();
						return 0;	
					}
					if (document.getElementById(edad).value==""){
						jError("Tiene que escribir Edad","Mensaje");
						document.getElementById(edad).focus();
						return 0;	
					}
					if (document.getElementsByName(parentesco)[0].value==""){
						jError("Tiene que seleccionar parentesco","Mensaje");
						document.getElementById(parentesco).focus();
						return 0;	
					}
					if (document.getElementsByName(escolaridad)[0].value==""){
						jError("Tiene que seleccionar escolaridad","Mensaje");
						document.getElementById(escolaridad).focus();
						return 0;	
					}
					if (document.getElementsByName(escuela)[0].value==""){
						jError("Tiene que seleccionar tipo de escuela","Mensaje");
						document.getElementById(escuela).focus();
						return 0;	
					}
					if (document.getElementById(ocupacion).value==""){
						jError("Tiene que escribir ocupación","Mensaje");
						document.getElementById(ocupacion).focus();
						return 0;	
					}

					
					
										
				}
				document.enviar_se3.action='registrar_se_3.php';						
				document.enviar_se3.submit();		
				
				
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
			<a><span><i>Inicio / Test / Estudio SE Parte 3</i></span></a>
			<span class='right_ab'>
					<a href='test.php'><strong> Regresar</strong></a>
				</span>
		</div>
	<?PHP
		
		if (isset($_SESSION['no_ficha']) AND ($_SESSION['curp'])){
			$no_ficha=$_SESSION['no_ficha'];

			require_once '../conexion/conex_mysql.php';
		
			$mysqli = new mysqli ($hostname,$username,$password,$database);
			if ($mysqli->connect_errno){
				die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
			}		

			$consulta="SELECT f_est_soc_econ3 FROM alumnos_folio WHERE no_ficha='$no_ficha'";
			$resultado= $mysqli->query($consulta);
			$rows = mysqli_fetch_array($resultado);
			$folio=$rows[0];
			

			if($folio==1)
			{
				header("location: test.php");
			}
			echo"

		
	<div class='container'>
		<section class='tabs'>
		    <input id='tab-1' type='radio' name='radio-set' class='tab-selector-1' checked='checked' style='visibility:hidden'/>
		    
		    <div class='clear-shadow'></div>
		    <div class='contenedor'>
				<div class='contenedor-1'>
				<form name='enviar_se3' id='enviar_se3' method='POST' action=''>
					<fieldset>
						<table width='675'>
							<tr>
								<td><ba>Ingrese el número de familiares que viven en la misma vivienda donde vives. Sino vive alguien más aparte de tu(s) tutor(es), escribe 0. Posteriormente de click en crear y llene los campos con la información correspondiente. </ba></td>
								<td width='200' align='right'>
									<input type='number' min='0' max='10' name='campos' size='4' title='Campos a crear' id='campos' value="; if(isset($_POST['campos'])){echo $_POST['campos'];} echo" ><pp>Familiares<pp><br><br>
									<input type='submit' name='enviar' value='Crear'>
								</td>
							</tr>
						</table>
					</fieldset>";
					if (isset($_POST['enviar'])){
						$n_campos=$_POST['campos'];
						if ($n_campos==''){
							echo "<script>validar_vacio();</script>";	
						}
						else if ($n_campos<1){
							echo "<script>enviar();</script>";
						}
		 				for ($i=1; $i <=$n_campos ; $i++) {
		 					echo "
		 					<fieldset><legend><stroke>FAMILIARES</stroke></legend>
		 						<table width='675' border='0'>
									<tr>
										<td><ba>Nombre:</ba></td>
										<td><ba>Edad:</td>
									</tr>
									<tr>
										<td width='500'>
											<input type='text' name='nombre".$i."' id='nombre".$i."' size='48' >
										</td>
										<td>
											<input type='number' name='edad".$i."' id='edad".$i."' size='3' min='0' max='150' >
										</td>	
									</tr>
								</table>
								<table width='675'>
									<tr>
										<td><ba>Parentesco:</ba></td>
										<td><ba>Escolaridad:</ba></td>
										<td><ba>Escuela:</td>
									</tr>				
									<tr>
										<td width='250'>
											<select name='parentesco".$i."' id='parentesco".$i."' >
												<option value=''></option>
												<option value='Hijo(a)'>Hijo(a)</option>
												<option value='Esposo(a)'>Esposo(a)</option>
												<option value='Hermano(a)'>Hermano(a)</option>
												<option value='Tio(a)'>Tio(a)</option>
												<option value='Primo(a)'>Primo(a)</option>
												<option value='Cuñado(a)'>Cuñado(a)</option>
												<option value='Suegro(a)'>Suegro(a)</option>
												<option value='Abuelo(a)'>Abuelo(a)</option>

												<option value='Otro'>Otro</option>	
											</select>
										</td>
										<td width='250'>
											<select name='escolaridad".$i."' id='escolaridad".$i."' >
												<option value=''></option>
												<option value='Ninguna'>Ninguna</option>
												<option value='Primaria'>Primaria</option>
												<option value='Secundaria'>Secundaria</option>
												<option value='Bachillerato'>Bachillerato</option>
												<option value='Licenciatura'>Licenciatura</option>
												<option value='Maestría'>Maestría</option>
												<option value='Doctorado'>Doctorado</option>	
											</select>
										</td>
										<td>
											<select name='escuela".$i."' id='escuela".$i."' >
												<option value=''></option>
												<option value='Ninguna'>Ninguna</option>
												<option value='Publica'>Pública</option>
												<option value='Privada'>Privada</option>	
											</select>
										</td>
									</tr>					
								</table>
								<table width='675'>
									<tr width='500'>
										<td><ba>Ocupación:</ba></td>
									</tr>
									<tr>
										<td>
											<input type='text' name='ocupacion".$i."' id='ocupacion".$i."' size='48'  placeholder='Obrero, Comerciante, Desempleado, etc.' title='Escriba la ocupación de su familiar, en caso de ser menor de edad y no trabaje escriba NINGUNA.'>
										</td>
									</tr>
								</table> 
							</fieldset>";
		 					}
		 					echo"
		 					<table align='right'>
								<tr>
									<td><br>
										<input type='button' Value='Enviar' name='enviar' onClick='verificar($n_campos)'> 
									</td>
								</tr>						
							</table>";
		 				}
					echo "					
				</form>
				</div>
			</div>
		</section>
	</div>
</body>
</html>";
			
}

?>
	