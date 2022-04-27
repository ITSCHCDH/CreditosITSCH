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
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/query/1.6.1/jquery.min.js"></script>
		<script type="text/javascript" src="./../js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="./../js/jquery.bgImageMenu.js"></script>
		<script src="../js/jquery.alerts.mod.js" type="text/javascript"></script>
		<!--*******************************-->				
		<script src='https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js'></script>		
		<script type='text/javascript' src='../js/jquery.easing.1.3.js'></script>
		<script type='text/javascript' src='../js/jquery.bgImageMenu.js'></script>
		<script type='text/javascript'>
			$(function() {
				$('#sbi_container').bgImageMenu({
					defaultBg	: '../pic/1.jpg',
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
		<script type='text/javascript'> 
			function alertar() {
				jError('No existe registro', 'Error');
				setTimeout(function(){window.location.href=("index.php")} , 2000); 
			}
			function mensaje_registro() {
				jAlert('El Alumno se ha registrado', 'Mensaje');
				setTimeout(function(){window.location.href=("alta.php")} , 2000); 
			}
			function error(){
				jError('No se ha registrado el alumno, contacte al administrador', 'Error');
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
    <?PHP 
    session_start();
	$no_ficha= $_SESSION['ficha'];
    if (isset($no_ficha)){
		require_once '../conexion/conex_ms_sql.php';
		$link = mssql_connect($server_mssql,$user_mssql,$pwd_mssql) or die ("no se ha podido conectar");
		// Seleccionar la base de datos 'my.database-name'
		$selected=mssql_select_db($bd_mssql, $link) or die ("no se puede abrir base de datos");
		$query="SELECT * FROM AlumnosFichas WHERE alf_Folio='$no_ficha'";
		// EJECUTAMOS SENTENCIA	
		$result = mssql_query($query,$link);
		$row=mssql_fetch_array($result);
		if(empty($row)){
			header("location: alta.php");
		}
		else{
			$ficha=$row['alf_Folio'];
			$nombre=utf8_encode($row['alf_Nombre']);
			$ape_pat=utf8_encode($row['alf_ApePat']);
			$ape_mat=utf8_encode($row['alf_ApeMat']);
			$sexo=utf8_encode($row['alf_Sexo']);
			$fecha_sol=utf8_encode($row['alf_FechaSol']);
			if($sexo=='F'){	
				$sexo2='M';}
			else{
				$sexo2='H';}
		}
		echo"
    <body>
    	<div class='container'>
		<br>
			<div class='topbar'>
				<a><span>Administrador </span></a>
				<span class='right_ab'>
					<a href='index.php'><strong> Ir a Inicio</strong></a>
				</span>
			</div>
		</div>
		<br>
		<div id='sbi_container' class='sbi_container'>
			<div class='sbi_panel' data-bg='pic/2.jpg'>	</div>
		</div>
		<div class='topbar'>
			<a><span><i>Inicio / Alta / En Tiempo</i></span></a>
			<span class='right_ab'>
					<a href='alta.php'><strong> Regresar</strong></a>
				</span>
		</div>
    	<section class='tabs'>
			<fieldset> 
				<form name='regitrar_aspirante' method='POST' action='' autocomplete='off'>
		    		<table width='675' align='center'>						
						<tr>
							<td width='380'><ba>No Ficha</td>
							<td><ba>No Control</td>
						</tr>
						<tr>
							<td><input type='text' name='no_ficha' id='no_ficha' size='10' align='right' disabled value='$ficha'></td>
							<td><input type='text' name='control' id='control' size='10' disabled disabled value=''></td>
						</tr>
						<tr>
							<td><ba>Nombre (s):</td>
							<td><ba>Sexo:</td>
						</tr>
						<tr>
							<td><input type='text' name='nombre' id='nombre' size='25' disabled value='$nombre'></td>
							<td><input type='text' name='sexo' id='sexo' disabled value='$sexo2' size='2'></td>
						</tr>
						<tr>
							<td><ba>Apellido Paterno:</td>
							<td><ba>Apellido Materno:</td>
						</tr>
						<tr>
							<td><input type='text' name='ap_paterno' id='ap_paterno' size='20' disabled value='$ape_pat'></td>
							<td><input type='text' name='ap_materno' id='ap_materno' size='20' disabled value='$ape_mat'></td>
						</tr>
						<tr>
							<td><ba>Peso:</td>
							<td><ba>Estatura:</td>
						</tr>
						<tr>
							<td><input type='number' name='peso' id='peso' min='50' max='140' step='0.1'><pp>Kgs</pp></td>
							<td><input type='number' name='talla' id='talla' min='1.30' max='2.20' step='0.01'><pp>Mts</pp></td>
						</tr>
						<tr>
							<td><ba>Corrimiento de Listas</td>
							<td></td>
						</tr>
						<tr>
							<td>
								<select name='listas' id='listas' required>
									<option></option>
									<option value='Primera'>Primera</option>
									<option value='Segunda'>Segunda</option>
									<option value='Tercera'>Tercera</option>
									<option value='Cuarta'>Cuarta</option>
									<option value='Quinta'>Quinta</option>
									<option value='Otra'>Otra</option>
								</select>
							</td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td><input type='submit' value='Registrar' name='registrar' id='registrar'/></td>
						</tr>
					</table>
				</form>	
			</fieldset>
		</section>
	</body>";
	}
	if (isset($_POST['registrar'])){
		$peso=($_POST['peso']);
		$talla=(float)($_POST['talla']);
		$listas=($_POST['listas']);	
		
		if ((!empty($peso)) && (!empty($talla))){
			$imc=($peso/($talla*$talla));
			if ($imc<18.5){
				$pm_peso="Bajo peso";
			}else if ($imc<25) {
				$pm_peso="Normal";		
			}else if ($imc<30) {
					$pm_peso="Sobrepeso";
			}else {
				$pm_peso="Obesidad";
			}

		}
		else {
			$peso='0';$talla='0';$imc='0';$pm_peso='';
		}

		$link = mssql_connect($server_mssql,$user_mssql,$pwd_mssql) or die ("no se ha podido conectar");
		// Seleccionar la base de datos 'my.database-name'
		$selected=mssql_select_db($bd_mssql, $link) or die ("no se puede abrir base de datos");
			
		$query="SELECT * FROM AlumnosFichas A1 JOIN Carreras C1 ON (A1.car_Clave_PriOpc=C1.car_Clave) JOIN Municipios M1 ON (A1.mun_Clave_Dir=M1.mun_Clave) JOIN Estados E1 ON (M1.est_Clave=E1.est_Clave) WHERE alf_Folio='$no_ficha'";
		//echo $query;
		
		// EJECUTAMOS SENTENCIA	
		$result = mssql_query($query,$link);
		$row=mssql_fetch_array($result);
		if(empty($row)){
			echo "VSCIS";
		}else{
			$nombre=utf8_encode($row['alf_Nombre']);
			$ape_pat=utf8_encode($row['alf_ApePat']);
			$ape_mat=utf8_encode($row['alf_ApeMat']);
			$sexo=($row['alf_Sexo']);
			if($sexo=='F'){
				$sexo2='M';
			}
			else{
				$sexo2='H';
			}
			$fecha_sol=utf8_encode($row['alf_FechaSol']);
			$direccion=utf8_encode($row['alf_Direccion']);
			$colonia=utf8_encode($row['alf_Colonia']);	
			$cp=utf8_encode($row['alf_CP']);
			$estado=utf8_encode($row['est_Nombre']);
			$municipio=utf8_encode($row['mun_Nombre']);
			if ($municipio=='HIDALGO' || $municipio=='IRIMBO'){
				$foraneo=0;
				$procedencia=utf8_encode("Local");
			}else 
			{
				$foraneo=1;
				$procedencia=utf8_encode("Foráneo");
			}
			$promedio=utf8_encode($row['alf_PromBach']);
			$carrera=utf8_encode($row['car_Nombre']);
			$tipo_bach=utf8_encode($row['alf_espBachillerato']);
			$curp=utf8_encode($row['alf_CURP']);
			$telefono=utf8_encode($row['alf_Tel']);
		}
		
		$query="SELECT * FROM AlumnosFichas A1 JOIN Escuelas E1 ON (A1.esc_Clave=E1.esc_Clave) JOIN Municipios M1 ON (E1.mun_Clave=M1.mun_Clave) JOIN Estados E2 ON (M1.est_Clave=E2.est_Clave) WHERE alf_Folio='$no_ficha'";
		
		
		// EJECUTAMOS SENTENCIA	
		$result = mssql_query($query,$link);
		$row=mssql_fetch_array($result);
		$escuela=utf8_encode($row['esc_Nombre']);
		$municipio_esc=utf8_encode($row['mun_Nombre']);
		$estado_esc=utf8_encode($row['est_Nombre']);
		
		$query= "SELECT COUNT(DISTINCT alu_NumControl) as ocasiones_ingreso FROM AlumCom WHERE alc_Curp='$curp'";

		$result = mssql_query($query,$link);
		$row=mssql_fetch_array($result);
		$ocasiones_ingreso=($row['ocasiones_ingreso']);
		require_once '../conexion/conex_mysql.php';
		$mysqli = new mysqli ($hostname,$username,$password,$database);
		if ($mysqli->connect_errno){
			die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
		}
		try {
			$query="START TRANSACTION;";
			$resultado = $mysqli->query($query);
			
			$query = "INSERT INTO alumnos_datos_personales (se_no_ficha,se_no_control,dp_nombre,dp_ap_paterno,dp_ap_materno,dp_sexo,dp_carrera,dp_direccion,dp_colonia,dp_cod_post,dp_estado,dp_municipio,se_curp,dp_tel,dp_hijos,dp_edo_civil) VALUES ('$no_ficha','$no_ficha','".$nombre."','".$ape_pat."','".$ape_mat."','".$sexo2."','".$carrera."','".$direccion."','".$colonia."','".$cp."','".$estado."','".$municipio."','".$curp."','".$telefono."',0,0);";
			$resultado = $mysqli->query($query);
			if (!$resultado ) {
       			throw new Exception($mysqli->error);
    		}
    		
    		$query = "INSERT INTO alumnos_caracterizacion (se_no_ficha,se_no_control,se_fecha_ficha,se_procedencia_foraneo,se_esc_proced,se_esc_proced_mun,se_esc_proced_edo,se_bachillerato_prom,se_bachillerato_tipo,sa_corrimiento_listas,se_ocasiones_ingreso) VALUES ('$no_ficha','$no_ficha','".$fecha_sol."',".$foraneo.",'".$escuela."','".$municipio_esc."','".$estado_esc."',".$promedio.",'".$tipo_bach."','".$listas."',".$ocasiones_ingreso.");";
  
			$resultado = $mysqli->query($query);
			if (!$resultado ) {
       			throw new Exception($mysqli->error);
    		}

    		$query = "INSERT INTO alumnos_folio (no_ficha,no_control,f_dat_pers,f_ficha_med,f_test_trayec,f_test_vocac,f_est_soc_econ1,f_est_soc_econ2,f_est_soc_econ3) VALUES ('$no_ficha','$no_ficha',0,0,0,0,0,0,0);";
  
			$resultado = $mysqli->query($query);
			if (!$resultado ) {
       			throw new Exception($mysqli->error);
    		}

    		$query = "INSERT INTO alumnos_ficha_medica (no_ficha,no_control,fm_peso,fm_talla,fm_imc,fm_peso_diagnostico) VALUES('$no_ficha','$no_ficha',".$peso.",".$talla.",".$imc.",'".$pm_peso."');";
  
			$resultado = $mysqli->query($query);
			if (!$resultado ) {
       			throw new Exception($mysqli->error);
    		}

    		$query = "INSERT INTO semaforos_caracterizacion (no_ficha,no_control,smf_foraneo,smf_edo_civil,smf_hijos,smf_trabaja,smf_tut,smf_cb,smf_jef_car) VALUES ('$no_ficha','$no_ficha',".$foraneo.",0,0,0,0,0,0);";
  
			$resultado = $mysqli->query($query);
			if (!$resultado ) {
       			throw new Exception($mysqli->error);
    		}

    		$query = "INSERT INTO alumnos_estudio_se (no_ficha,no_control) VALUES ('$no_ficha','$no_ficha');";
  
			$resultado = $mysqli->query($query);
			if (!$resultado ) {
       			throw new Exception($mysqli->error);
    		}

    		$query = "COMMIT;";
			$resultado = $mysqli->query($query);

    		echo "<script>mensaje_registro()</script>";
		} catch (Exception $e) {
			$query = "ROLLBACK;";
			$resultado = $mysqli->query($query);
			echo "<script>error()</script>";	
		}			
	}
	?>
</html>

