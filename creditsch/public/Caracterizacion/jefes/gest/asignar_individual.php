<html> 
	<head>
		<meta charset='UTF-8'/>
	   	<meta http-equiv='X-UA-Compatible' contenedor='IE=edge,chrome=1'>
	    <title>STE-ITSCH</title>
	    <meta name='viewport' contenedor='width=device-width, initial-scale=1.0'>
	   
	    <link rel='stylesheet' type='text/css' href='../../css/demo.css' />
	    <link rel='stylesheet' type='text/css' href='../../css/style.css' />
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
    	<script>
    		function direccionar(){
				window.location="asignar_semaforo.php";
				jAlert('Se ha asignado el semáforo', 'Mensaje');
				setTimeout(function(){window.location.href=("asignar_semaforo.php")} , 2000); 
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
				<a><span>Jefe de Carrera - Gestión</span></a>
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
			<a><span><i>Inicio / Asignar Semáforo / Individual</i></span></a>
			<span class='right_ab'>
					<a href='asignar_semaforo.php'><strong> Regresar</strong></a>
				</span>
		</div>
    	
	<?PHP
		require_once '../../funciones/funciones.php';
		require_once '../../conexion/conex_mysql.php';
		$no_ficha= $_POST['ficha'];
		$mysqli = new mysqli ($hostname,$username,$password,$database);
		if ($mysqli->connect_errno){
			die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
		}		
		$query = "SELECT * from alumnos_datos_personales where se_no_ficha='$no_ficha'";
		$resultado = $mysqli->query($query);
		
		$rows = mysqli_fetch_array($resultado);
		
		if(empty($rows)){
			echo "<script type='text/javascript'>alertar()</script>"; 
		}
		else{
		
		$ficha=($rows['se_no_ficha']);
		$nombre=($rows['dp_nombre']);
		$apaterno=($rows['dp_ap_paterno']);
		$amaterno=($rows['dp_ap_materno']);
		$sexo=($rows['dp_sexo']);
		$carrera=($rows['dp_carrera']);
		$curp=($rows['se_curp']);
		$direccion=($rows['dp_direccion']);
		$colonia=($rows['dp_colonia']);
		$codpost=($rows['dp_cod_post']);
		$municipio=($rows['dp_municipio']);
		$estado=($rows['dp_estado']);
		$tel=($rows['dp_tel']);
		$email=($rows['dp_email']);
		$tiposangre=($rows['dp_tipo_sangre']);
		$edocivil=($rows['dp_edo_civil']);
		$control=($rows['se_no_control']);
		$hijos=($rows['dp_hijos']);
		if ($edocivil==0){
			$ecivil='';
		}
		else if ($edocivil==1){
			$ecivil='Soltero';
		}
		else if ($edocivil==2){
			$ecivil='Casado';
		}
		else {
			$ecivil='Otro';
		}
		$query = "SELECT * from semaforos_caracterizacion WHERE no_ficha='$no_ficha'";
		$resultado = $mysqli->query($query);
		$rows = mysqli_fetch_array($resultado);
		
		$tutorias=($rows['smf_tut']);
		$cbasicas=($rows['smf_cb']);
		$trabaja=($rows['smf_trabaja']);
		$jcarrera=($rows['smf_jef_car']);
		$foraneo=($rows['smf_foraneo']);

		$query = "SELECT * from alumnos_caracterizacion WHERE se_no_ficha='$no_ficha'";
		$resultado = $mysqli->query($query);
		$rows = mysqli_fetch_array($resultado);

		$date = date_create($rows['se_fecha_ficha']);
		$fecha=date_format($date,'d/m/Y g:i A');
		$grupo= ($rows['sa_grupo_gen']);
		$clistas = ($rows['sa_corrimiento_listas']);
		$esc_procedencia= ($rows['se_esc_proced']);
		$mun_esc=($rows['se_esc_proced_mun']);
		$edo_esc=($rows['se_esc_proced_edo']);
		$promedio=($rows['se_bachillerato_prom']);
		$tipo_bach=($rows['se_bachillerato_tipo']);
		$exam_adm=($rows['sa_exam_adm_res']);
		$ps_depresion=($rows['tut_probpsico_depresion']);
		$ps_autoestima=($rows['tut_probpsico_autoestima']);
		$ps_machover=($rows['tut_probpsico_machover']);
		$ps_diagnostico=($rows['tut_probpsico_diagnostico']);
		$pm_peso=($rows['tut_probmed_peso']);
		$pm_enf=($rows['tut_probmed_enf']);
		$pm_ad=($rows['tut_probmed_ad']);
		$pm_alergias=($rows['tut_probmed_alergias']);
		$pm_alergias_med=($rows['tut_probmed_alergmed']);
		$pm_enf_hered=($rows['tut_probmed_enf_hered']);
		$pf_res=($rows['tut_probfam_res']);
		$habitos=($rows['tut_hab_estudio']);
		$vocacional=($rows['tut_orient_vocacional']);
		$opcion_esc=($rows['tut_opc_esc']);
		$ctrunca=($rows['tut_carrera_trunca']);
		$algrebra_res=($rows['doc_curso_algebra_res']);
		$regul_res=($rows['doc_curso_regul_res']);
		$ingresos=($rows['est_se_ingresos_todos']);
		$ingreso_ocasiones=($rows['se_ocasiones_ingreso']);
		$beca=($rows['tut_becas']);
		$tipo_beca=($rows['tut_becas_detalles']);
		$vivir_con=($rows['tut_vivir_con']);
		$horario=($rows['tut_trabajo_horario']);
		$lugar=($rows['tut_trabajo_lugar']);


		$mysqli->close();
		echo "<div class='container'>
			<section class='tabs'>
	            <input id='tab-1' type='radio' name='radio-set' class='tab-selector-1' checked='checked' style='visibility:hidden'/>
		        <label for='tab-1' class='tab-label-1'><stroke-2>DATOS PERSONALES </label>

		       	<input id='tab-2' type='radio' name='radio-set' class='tab-selector-2' style='visibility:hidden'/>
		        <label for='tab-2' class='tab-label-2'><stroke-2>CARACTERIZACIÓN</label>

		        <input id='tab-3' type='radio' name='radio-set' class='tab-selector-3' style='visibility:hidden'/>
		        <label for='tab-3' class='tab-label-3'><stroke-2>ESTUDIO SE I</label>

		        <input id='tab-4' type='radio' name='radio-set' class='tab-selector-4' style='visibility:hidden'/>
		        <label for='tab-4' class='tab-label-4'><stroke-2>ESTUDIO SE II</label>
		
			    <div class='clear-shadow'></div>
			    <div class='contenedor'>
			    	<div class='contenedor-1'>
			    		<form name='asignar' id='asignar' method='POST' action=''>
			        		<fieldset><legend><stroke>PERSONALES</stroke></legend>
								<table width='675' border='0'>
									<tr>
										<td width='440'><ba>No Ficha</ba></td>
										<td><ba>No Control</ba></td>
									</tr>
									<tr>
										<td><input type='text' name='ficha' id='ficha' max='5' size='10' align='right' readonly value='$ficha'></td>
										<td><input type='text' name='control' id='control' size='10' disabled value='$control'></td>
									</tr>
									<tr>
										<td><ba>Nombre (s):</ba></td>
										<td><ba>Sexo:</ba></td>
									</tr>
									<tr>
										<td><input type='text' name='nombre' id='nombre' size='25' disabled value='$nombre'></td>
										<td><input type='text' name='sexo' id='sexo' disabled value='$sexo' size='2'></td>
									</tr>
									<tr>
										<td><ba>Apellido Paterno:</ba></td>
										<td><ba>Apellido Materno:</ba></td>
									</tr>
									<tr>
										<td><input type='text' name='ap_paterno' id='ap_paterno' size='20' disabled value='$apaterno'></td>
										<td><input type='text' name='ap_materno' id='ap_materno' size='20' disabled value='$amaterno'></td>
									</tr>
									<tr>
										<td><ba>CURP:</ba></td>
									</tr>
									<tr>
										<td><input type='text' name='curp'  max='18' id='curp' size='24' disabled value='$curp'></td>
									</tr>
								</table>
								<table width='675' border='0'>
									<tr>
										<td><ba>Carrera</ba></td>
									</tr>
									<tr>
									<td><input type='text' name='carreras' id='carreras' disabled value='$carrera' size='68'/></td>
									</tr>
								</table>
							
							</fieldset>
							<fieldset><legend><stroke>DOMICILIO</stroke></legend>
								<table width='675' border='0'>
									<tr>
										<td width='440'><ba>Dirección:</ba></td>
										
									</tr>
									<tr>
										<td><input type='text' name='direccion' id='direccion' size='35' disabled value='$direccion'></td>
									</tr>
									<tr>
										<td><ba>Colonia:</ba></td>
										<td><ba>Código Postal:</ba></td>
									</tr>
									<tr>
										<td><input type='text' name='colonia' id='colonia' size='25' disabled value='$colonia'></td>
										<td><input type='text' name='codpost' id='codpost' size='8' disabled value='$codpost'></td>
									</tr>
									<tr>
										<td><ba>Municipio:</ba></td>
										<td><ba>Estado:</ba></td>
									</tr>
									<tr>
										<td><input type='text' name='municipio' id='municipio' size='30' disabled value='$municipio'></td>
										<td><input type='text' name='estado' id='estado' size='20' disabled value='$estado'></td>
									</tr>
								</table>
							</fieldset>
							<fieldset><legend><stroke>OTROS</stroke></legend>
								<table width='675' border='0'>
									<tr>	
										<td width='440'><ba>Telefono Celular:</ba></td>
										<td><ba>Tipo de Sangre:</ba></td>
									</tr>
									<tr>
										<td><input type='text' name='telefono' id='telefono' size='12' disabled value='$tel'></td>
										<td><input type='text' name='tiposangre' id='tiposangre' size='5' disabled value='$tiposangre'></td>
									</tr>
									<tr>
										<td><ba>Correo Electronico:</ba></td>
										<td>&nbsp</td>
									</tr>
									<tr>
										<td><input type='text' name='email' id='email' size='40' disabled value='$email'></td>
										<td><ba>¿Tienes Hijos?</ba><br></td>
									</tr>
									<tr>
										<td><ba>Estado Civil:</ba><br>
										<input type='text' name='edocivil' id='edocivil' disabled value='$ecivil' size='8'></td>
										<td>";
										if($hijos==1){
											echo "<input type='radio' name='hijos' value='1' id='hijos_0' checked disabled><pp>SI <br>
											<input type='radio' name='hijos' value='0' id='hijos_1' disabled><pp>NO";
										}
										else{
											echo "<input type='radio' name='hijos' value='1' id='hijos_0' disabled><pp>SI <br>
											<input type='radio' name='hijos' value='0' id='hijos_1' checked disabled><pp>NO";
										}
										echo "</td>
									</tr>
								</table>
								<table>
									<tr>
										<td width='450'><ba>¿Has estado becado?</td>
										<td><ba>¿Cuál?</td>
									</tr>
									<tr>
										<td>";
										if ($beca==1){
											echo "
											<input type='radio' name='beca' value='1' id='beca' disabled checked><pp>SI</pp><br>
											<input type='radio' name='beca' value='0' id='beca' disabled><pp>NO</pp>
										</td>";
										}
										else{
											echo"
											<input type='radio' name='beca' value='1' id='beca' disabled><pp>SI</pp><br>
											<input type='radio' name='beca' value='0' id='beca' disabled checked><pp>NO</pp>
										</td>";
										}
										echo "<td><textarea title='Ejemplo: Pronabes, Prospera, etc.'name='tipobeca' id='tipobeca' rows='3' cols='35' maxlength='100' disabled >$tipo_beca</textarea></td>
									</tr>
								</table>
								<table width='675'>
									<tr>
										<td><ba>¿En el transcurso de tus estudios vivirás con?</td>
									</tr>
								</table>
								<table width='675'>
									";
									if($vivir_con==1){
										echo"
										<tr>
											<td>
												<input type='radio' name='vivir_con' value='1' id='vivir_con' disabled checked><pp>Familia</pp>
											</td>
											<td>
												<input type='radio' name='vivir_con' value='2' id='vivir_con' disabled><pp>Familiares cercanos (Tios, primos, abuelos)</pp>
											</td>
										</tr>
										<tr>
											<td>
												<input type='radio' name='vivir_con' value='3' id='vivir_con' disabled><pp>Otros estudiantes</pp>
											</td>
											<td>
												<input type='radio' name='vivir_con' value='4' id='vivir_con' disabled><pp>Solo</pp>
											</td>
										</tr>";
									}
									else if($vivir_con==2){
										echo"
										<tr>
											<td>
												<input type='radio' name='vivir_con' value='1' id='vivir_con' disabled ><pp>Familia</pp>
											</td>
											<td>
												<input type='radio' name='vivir_con' value='2' id='vivir_con' disabled checked><pp>Familiares cercanos (Tios, primos, abuelos)</pp>
											</td>
										</tr>
										<tr>
											<td>
												<input type='radio' name='vivir_con' value='3' id='vivir_con' disabled><pp>Otros estudiantes</pp>
											</td>
											<td>
												<input type='radio' name='vivir_con' value='4' id='vivir_con' disabled><pp>Solo</pp>
											</td>
										</tr>";
									}
									else if($vivir_con==3){
										echo"
										<tr>
											<td>
												<input type='radio' name='vivir_con' value='1' id='vivir_con' disabled ><pp>Familia</pp>
											</td>
											<td>
												<input type='radio' name='vivir_con' value='2' id='vivir_con' disabled ><pp>Familiares cercanos (Tios, primos, abuelos)</pp>
											</td>
										</tr>
										<tr>
											<td>
												<input type='radio' name='vivir_con' value='3' id='vivir_con' disabled checked><pp>Otros estudiantes</pp>
											</td>
											<td>
												<input type='radio' name='vivir_con' value='4' id='vivir_con' disabled><pp>Solo</pp>
											</td>
										</tr>";
									}
									else if($vivir_con==4){
										echo"
										<tr>
											<td>
												<input type='radio' name='vivir_con' value='1' id='vivir_con' disabled ><pp>Familia</pp>
											</td>
											<td>
												<input type='radio' name='vivir_con' value='2' id='vivir_con' disabled ><pp>Familiares cercanos (Tios, primos, abuelos)</pp>
											</td>
										</tr>
										<tr>
											<td>
												<input type='radio' name='vivir_con' value='3' id='vivir_con' disabled ><pp>Otros estudiantes</pp>
											</td>
											<td>
												<input type='radio' name='vivir_con' value='4' id='vivir_con' disabled checked><pp>Solo</pp>
											</td>
										</tr>";
									}
									else{
										echo"
										<tr>
											<td>
												<input type='radio' name='vivir_con' value='1' id='vivir_con' disabled ><pp>Familia</pp>
											</td>
											<td>
												<input type='radio' name='vivir_con' value='2' id='vivir_con' disabled ><pp>Familiares cercanos (Tios, primos, abuelos)</pp>
											</td>
										</tr>
										<tr>
											<td>
												<input type='radio' name='vivir_con' value='3' id='vivir_con' disabled ><pp>Otros estudiantes</pp>
											</td>
											<td>
												<input type='radio' name='vivir_con' value='4' id='vivir_con' disabled ><pp>Solo</pp>
											</td>
										</tr>";
									}
								echo "</table>
							</fieldset>
							<fieldset><legend><stroke>TRABAJO</stroke></legend>
								<table width='675'>
									<tr>
										<td width='440'><ba>¿Trabajas?</td>
										<td><ba>Horario:</ba></td>

									</tr>
									<tr>
										<td>";
										if ($trabaja==1){
											echo "
											<input type='radio' name='trabaja' value='1' id='trabaja' disabled checked><pp>SI</pp><br>
											<input type='radio' name='trabaja' value='2' id='trabaja' disabled><pp>NO</pp>
										</td>";
										}
										else{
											echo "
											<input type='radio' name='trabaja' value='1' id='trabaja' disabled checked><pp>SI</pp><br>
											<input type='radio' name='trabaja' value='2' id='trabaja' disabled  checked><pp>NO</pp>
										</td>";
										}
										echo "<td><input type='text' title='Ejemplo: 8:00am a 3:00pm' name='horario' id='horario' size='15' maxlength='15' disabled value='$horario'></td>
									</tr>
								</table>
								<table width='675'>
									<tr>								
										<td><ba>¿Dónde?</ba></td>
									</tr>
									<tr>
										<td>
											<input type='text' name='lugar_trabajo' id='lugar_trabajo' size='50' maxlength='50' disabled value='$lugar'></td>
										</td>									
										
									</tr>
								</table>
							</fieldset>
							</fieldset>
							<fieldset><legend><stroke>SEMÁFOROS</stroke></legend>
								<table width='675' border='0'>
									<tr>
									<td width='225'><ba>Tutorías:</ba></td>
										<td width='225'><ba>Ciencias Básicas:</ba></td>
										<td width='225'><ba>Jefes de Carrera:</ba></td>
									</tr>
									<tr>
										<td>";
											if ($tutorias==0){
												echo "<select disabled name='tutorias' id='tutorias'>
													<option value='0'>NINGUNO</option>
												</select>";
											}
											else if ($tutorias==1){
												echo "<select disabled name='tutorias' id='tutorias'>
													<option value='1'>BIEN</option>
												</select>";
											}
											else if ($tutorias==2){
												echo "<select disabled name='tutorias' id='tutorias'>
													<option value='2'>LEVE</option>
												</select>";
											}
											else if ($tutorias==3){
												echo "<select disabled name='tutorias' id='tutorias'>
													<option value='3'>SEVERO</option>
												</select>";
											}
											else {
												echo "<select disabled name='tutorias' id='tutorias'>
													<option value='4'>GRAVE</option>
												</select>";
											} echo"
										</td>
										<td>";
											if ($cbasicas==0){
												echo "<select disabled name='cbasicas' id='cbasicas'>
													<option value='0'>NINGUNO</option>
												</select>";
											}
											else if ($cbasicas==1){
												echo "<select disabled name='cbasicas' id='cbasicas'>
													<option value='1'>BIEN</option>
												</select>";
											}
											else if ($cbasicas==2){
												echo "<select disabled name='cbasicas' id='cbasicas'>
													<option value='2'>LEVE</option>
												</select>";
											}
											else if ($cbasicas==3){
												echo "<select disabled name='cbasicas' id='cbasicas'>
													<option value='3'>MODERADO</option>
												</select>";
											}
											else {
												echo "<select disabled name='cbasicas' id='cbasicas'>
													<option value='4'>GRAVE</option>
												</select>";
											} echo"
										</td>
										<td>";
											if ($jcarrera==0){
												echo "<select name='jefes' id='jefes' required >
													<option></option>
													<option value='1'>BIEN</option>
													<option value='2'>LEVE</option>
													<option value='3'>MODERADO</option>
													<option value='4'>GRAVE</option>
												</select>";
											}
											else if ($jcarrera==1){
												echo "<select name='jefes' id='jefes' required >
													<option value='1' checked>BIEN</option>
													<option value='2'>LEVE</option>
													<option value='3'>MODERADO</option>
													<option value='4'>GRAVE</option>
												</select>";
											}
											else if ($jcarrera==2){
												echo "<select name='jefes' id='jefes' required >
													<option value='2' checked>LEVE</option>
													<option value='1' >BIEN</option>
													<option value='3'>MODERADO</option>
													<option value='4'>GRAVE</option>
												</select>";
											}
											else if ($jcarrera==3){
												echo "<select name='jefes' id='jefes' required >
													<option value='3' checked>MODERADO</option>
													<option value='1' checked>BIEN</option>
													<option value='2'>LEVE</option>
													<option value='4'>GRAVE</option>
												</select>";
											} 
											else{
												echo "<select name='jefes' id='jefes' required >
													<option value='4' checked>GRAVE</option>
													<option value='1' checked>BIEN</option>
													<option value='2'>LEVE</option>
													<option value='3'>MODERADO</option>
												</select>";
											}
											echo"
										</td>
									</tr>
									
								</table>
							</fieldset>
							<table width='675'>
								<tr align='right'>
									<td> <br>
										<input type='submit' name='asignar' id='asignar' value='Asignar'/>	
									</td>
								</tr>
							</table>
							</form>
				    	</div>
			        	<div class='contenedor-2'>
						<fieldset><legend><stroke>GENERAL</stroke></legend>
							<table width='675' border='0'>
								<tr>
									<td width='400'><ba>Fecha de Solicitud:</td>
									<td><ba>Foráneo:</td>
								</tr>
								<tr>
									<td>
										<input type='text' name='fecha_ficha' id='fecha_ficha' size='18' disabled>
									</td>
									<td>";
									if ($foraneo==1){
										echo" <input type='radio' name='foraneo' value='1' id='foraneo_si' checked disabled><pp>SI
										<br>
										<input type='radio' name='foraneo' value='0' id='foraneo_no' disabled><pp>NO";
									}
									else{
										echo" <input type='radio' name='foraneo' value='1' id='foraneo_si' disabled><pp>SI
										<br>
										<input type='radio' name='foraneo' value='0' id='foraneo_no' checked disabled><pp>NO";
									}
									echo "	
									</td>
								</tr>
								<tr>
									<td><ba>Grupo Generación:</td>
									<td><ba>Corrimiento de Listas:</td>
								</tr>
								<tr>
									<td>
										<input type='text' name='grupo_gen' id='grupo_gen' size='10' value='$grupo' disabled>
									</td>
									<td>
										<input type='text' name='lista_corrimiento' id='lista_corrimiento' size='8' value='$clistas' disabled>
									</td>
								</tr>
							</table>
						</fieldset>	
						<fieldset><legend><stroke>ESCUELA PROCEDENCIA</stroke></legend>
							<table width='675' border='0'>
								<tr>
									<td width='400'><ba>Nombre de Escuela</td>
									<td><ba>Promedio:</td>
								</tr>
								<tr>
									<td>
										<input type='text' name='esc_proc' id='esc_proc' size='40' value='$esc_procedencia' disabled>
									</td>
									<td>
										<input type='text' name='prom_bach' id='prom_bach' size='5' value='$promedio' disabled>
									</td>
								</tr>
								<tr>
									<td><ba>Municipio:</td>
									<td><ba>Estado:</td>
								</tr>
								<tr>
									<td>
										<input type='text' name='mun_esc_proc' id='mun_esc_proc' size='30' value='$mun_esc' disabled>
									</td>
									<td>
										<input type='text' name='edo_esc_proc' id='edo_esc_proc' size='20' value='$edo_esc' disabled>
									</td>
								</tr>
								<tr>
									<td><ba>Tipo de Bachillerato:</td>
								</tr>
								<tr>
									<td>
										<input type='text' name='tipo_bach' id='tipo_bach' size='40' value='$tipo_bach' disabled>
									</td>
								</tr>
							</table>
						</fieldset>
						<fieldset>
						<legend><stroke>RESULTADOS DE EXÁMENES</stroke></legend>
							<table width='675' border='0'>
								<tr>
									<td width='225'><ba>Admisión:</td>
									<td width='225'><ba>Algebra:</td>
									<td width='225'><ba>Regularización:</td>
								</tr>
								<tr>
									<td><input type='text' name='exam_admision' id='exam_admision' size='8' value='$exam_adm' disabled></td>
									<td><input type='text' name='curso_algebra' id='curso_algebra' size='8' value='$algrebra_res' disabled></td>
									<td><input type='text' name='curso_regul' id='curso_regul' size='8' value='$regul_res' disabled></td>
								</tr>
							</table>
						</fieldset>
						<fieldset>
							<legend><stroke>PROBLEMAS PSICOLÓGICOS</stroke></legend>
							<table width='675'>
								<tr>
									<td width='225'><ba>Depresión:</td>
									<td width='225'><ba>Autoestima:</td>
									<td width><ba>Diagnóstico:</td>
								</tr>
								<tr>
									<td><input type='text' name='depresion' id='depresion' size='8' value='$ps_depresion' disabled></td>
									<td><input type='text' name='autoestima' id='autoestima' size='5' value='$ps_autoestima' disabled></td>
									<td><input type='text' name='diagnostico_probpsico' id='diagnostico_probpsico' size='10' value='$ps_diagnostico' disabled></td>								
								</tr>
							</table>
							<table width='675'>
								<tr>
									<td><ba>Machover:</td>
								</tr>
								<tr>
									<td><textarea maxlength='300' rows='3' cols='80' name='machover' id='machover' disabled>$ps_machover</textarea></td>
								</tr>
							</table>
						</fieldset>
						<fieldset>
							<legend><stroke>PROBLEMAS MÉDICOS</stroke></legend>
							<table width='675'>
								<tr>
									<td width='225'><ba>Enf. Hereditarias:</td>
									<td width='225'><ba>Adicciones:</td>
									<td><ba>Peso:</td>
								</tr>
								<tr>
									<td><input type='text' name='enf_hered' id='enf_hered' size='15' value='$pm_enf_hered' disabled></td>
									<td><input type='text' name='ayd' id='ayd' size='15' value='$pm_ad' disabled></td>
									<td><input type='text' name='peso' id='peso' size='20' maxlength='20' value='$pm_peso' disabled></td>
								</tr>
							</table>
							<table>
								<tr>
									<td><ba>Enfermedades:</td>
								</tr>
								<tr>
									<td><textarea maxlength='300' rows='3' cols='80' name='enfermedades' id='enfermedades' disabled>$pm_enf</textarea></td>
								</tr>
								<tr>
									<td><ba>Alergias:</td>
								</tr>
								<tr>
									<td><textarea maxlength='300' rows='3' cols='80' name='alergias' id='alergias' disabled>$pm_alergias</textarea></td>
								</tr>
								<tr>
									<td><ba>Alergia a medicamento:</td>
								</tr>
								<tr>
									<td><textarea maxlength='300' rows='3' cols='80' name='alergia_med' id='alergia_med' disabled>$pm_alergias_med</textarea></td>
								</tr>
							</table>
						</fieldset>
						<fieldset>
							<legend><stroke>PROBLEMAS FAMILIARES</stroke></legend>
							<table width='675'>
								<tr>
									<td><ba>Diagnóstico:</td>
								</tr>
								<tr>
									<td><input type='text' name='probfam' id='probfam' size='20' value='$pf_res' disabled></td>
								</tr>
							</table>
						</fieldset>
						<fieldset><legend><stroke>COMPLEMENTARIOS</stroke></legend>
							<table width='675'>
								<tr>
									<td width='225'><ba>Habitos de Estudio:</td>
									<td width='225'><ba>Orientación Vocacional:</td>
									<td><ba>¿Qué opción somos?</td>
								</tr>
								<tr>
									<td><input type='text' name='habitos' id='habitos' size='9' value='$habitos' disabled></td>
									<td><input type='text' name='vocacional' id='vocacional' size='10' value='$vocacional' disabled></td>
									<td><input type='text' name='opcesc' id='opcesc' size='10' value='$opcion_esc' disabled></td>
								</tr>
								<tr>
									<td><ba>Carrera Trunca:</td>
									<td><br><ba>Ingresos Familiares:</td>
									<td><br><ba>Inscrito Antes:</td>
								</tr>
								<tr>
									<td><textarea maxlength='50' name='trunca' rows='2' cols='20' wrap='hard' disabled>$ctrunca</textarea></td>
									<td><input type='text' name='ingresos' id='ingresos' size='5' value='$ingresos' disabled></td>
									<td><input type='text' name='ocasion_ingreso' id='ocasion_ingreso' size='5' value='$ingreso_ocasiones' disabled></td>
								</tr>
							</table>
						</fieldset>
					</div>";
					estudio_se_2($no_ficha);
				echo"</div>
			</section>
        </div>
    </body>
</html>";
	}
?>
<?PHP 
if(isset($_POST['asignar'])){
		$fic=$_POST['ficha'];
		$jefe_carrera=$_POST['jefes'];
		require_once '../../conexion/conex_mysql.php';
		$mysqli = new mysqli ($hostname,$username,$password,$database);
		if ($mysqli->connect_errno){
			die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
		}		
		$query = "UPDATE semaforos_caracterizacion SET smf_jef_car=$jefe_carrera WHERE no_ficha='$fic'";
		
		$resultado = $mysqli->query($query);
		echo"<script>direccionar()</script>";
	}
?>