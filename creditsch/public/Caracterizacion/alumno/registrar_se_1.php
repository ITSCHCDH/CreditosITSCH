<?PHP 
session_start();

if (isset($_POST['dependen_eco']) AND ($_SESSION['no_ficha']) AND ($_SESSION['curp'])){
	$no_ficha=$_SESSION['no_ficha'];
	$cant_hijos=$_POST['cant_hijos'];
	$edades_hijos=$_POST['edades_hijos'];
	$discapacidad=$_POST['discapacidad'];
	$enf_cronicas=$_POST['enf_cronicas'];
	$det_discapacidad=$_POST['detalle_discap'];
	$det_enf_cronicas=$_POST['detalle_enf_cronicas'];
	/* checkbox acudes a servicio médico*/
	if(isset($_POST['IMMS'])){
		$acude_a=$_POST['IMMS'];
	}else{$acude_a=0;}
	if(isset($_POST['ISSSTE'])){
		$acude_a.=$_POST['ISSSTE'];
	}else{$acude_a.=0;}
	if(isset($_POST['Salubridad'])){
		$acude_a.=$_POST['Salubridad'];
	}else{$acude_a.=0;}
	if(isset($_POST['Particular'])){
		$acude_a.=$_POST['Particular'];
	}else{$acude_a.=0;}
	/********************************/
	$zona=$_POST['zona_proc'];
	$det_indigena=$_POST['detalle_indigena'];
	$prospera=$_POST['prospera'];
	$vivienda=$_POST['vivienda'];
	$material_vivienda=$_POST['material_vivienda'];
	$material_techo=$_POST['material_techo'];
	$cuartos=$_POST['cuartos'];
	$baños=$_POST['baños'];
	/*checkbox agua de beber*/
	if(isset($_POST['pozo'])){
		$agua_beber=$_POST['pozo'];
	}else{$agua_beber=0;}	
	if(isset($_POST['garrafon'])){
		$agua_beber.=$_POST['garrafon'];
	}else{$agua_beber.=0;}	
	if(isset($_POST['agua_pipa'])){
		$agua_beber.=$_POST['agua_pipa'];
	}else{$agua_beber.=0;}
	if(isset($_POST['agua_hervida'])){
		$agua_beber.=$_POST['agua_hervida'];
	}else{$agua_beber.=0;}
	if(isset($_POST['llave_fuera'])){
		$agua_beber.=$_POST['llave_fuera'];
	}else{$agua_beber.=0;}
	if(isset($_POST['llave_dentro'])){
		$agua_beber.=$_POST['llave_dentro'];
	}else{$agua_beber.=0;}
	/********************************/
	/* chechbox agua en vivienda*/
	if(isset($_POST['agua_de_pipa'])){
		$agua_vivienda=$_POST['agua_de_pipa'];
	}else{$agua_vivienda=0;}
	if(isset($_POST['llave_publica'])){
		$agua_vivienda.=$_POST['llave_publica'];
	}else{$agua_vivienda.=0;}
	if(isset($_POST['agua_rio'])){
		$agua_vivienda.=$_POST['agua_rio'];
	}else{$agua_vivienda.=0;}
	if(isset($_POST['agua_otra_vivienda'])){
		$agua_vivienda.=$_POST['agua_otra_vivienda'];
	}else{$agua_vivienda.=0;}
	if(isset($_POST['agua_entubada_fuera'])){
		$agua_vivienda.=$_POST['agua_entubada_fuera'];
	}else{$agua_vivienda.=0;}
	if(isset($_POST['agua_entubada_dentro'])){
		$agua_vivienda.=$_POST['agua_entubada_dentro'];
	}else{$agua_vivienda.=0;}
	/**********************************/
	$pago_luz=$_POST['bimestre_luz'];
	$drenaje=$_POST['drenaje'];

	/*checkbox combustible*/
	if(isset($_POST['leña'])){
		$combustible=$_POST['leña'];
	}else{$combustible=0;}	
	if(isset($_POST['carbon'])){
		$combustible.=$_POST['carbon'];
	}else{$combustible.=0;}	
	if(isset($_POST['gas_cilindro'])){
		$combustible.=$_POST['gas_cilindro'];
	}else{$combustible.=0;}
	/*****************************/
	$otro_combustible=$_POST['otro_combustible'];
	/*recorrido de checkbox y concatenación en variable objeto1_casa*/
	$objeto1_casa='';
	
	for ($i=1; $i <=12 ; $i++) {
		$nombre='objeto1_'.$i;
		if(isset($_POST[$nombre])){
			$objeto1_casa.=$_POST[$nombre];
		}else{$objeto1_casa.=0;}	
	}
	/******************************************/
	/*recorrido de checkbox y concatenación en variable objeto2_casa*/
	$objeto2_casa='';
	for ($i=1; $i <=11 ; $i++) {
		$nombre='objeto2_'.$i;
		if(isset($_POST[$nombre])){
			$objeto2_casa.=$_POST[$nombre];
		}else{$objeto2_casa.=0;}	
	}
	/******************************************/
	/*recorrido de checkbox y concatenación en variable objeto3_casa*/
	$objeto3_casa='';
	for ($i=1; $i <=11 ; $i++) {
		$nombre='objeto3_'.$i;
		if(isset($_POST[$nombre])){
			$objeto3_casa.=$_POST[$nombre];
		}else{$objeto3_casa.=0;}	
	}
	/******************************************/
	/*checkbox auto*/
	if(isset($_POST['auto'])){
		$auto=$_POST['auto'];
	}else{$auto=0;}
	$marca=$_POST['marca'];
	$modelo=$_POST['modelo'];
	/***************/
	$domicilio=$_POST['mismo_domicilio'];
	$con_cel=$_POST['personas_con_cel'];
	/*recorrido de checkbox y concatenación en vive_con*/
	$vive_con='';
	for ($i=1; $i <=8 ; $i++) {
		$nombre='vive_con'.$i;
		if(isset($_POST[$nombre])){
			$vive_con.=$_POST[$nombre];
		}else{$vive_con.=0;}	
	}
	$vive_otro=$_POST['otro'];
	/******************************************/
	/*recorrido de checkbox y concatenación en depende_de*/
	$depende_de='';
	for ($i=1; $i <=6 ; $i++) {
		$nombre='depende_'.$i;
		if(isset($_POST[$nombre])){
			$depende_de.=$_POST[$nombre];
		}else{$depende_de.=0;}	
	}
	/******************************************/
	$viven_casa=$_POST['viven_casa'];
	$dependen=$_POST['dependen_eco'];

	//UPDATE en Registros en Tabla alumnos_estudio_se eb BD

	require_once '../conexion/conex_mysql.php';
	$mysqli = new mysqli ($hostname,$username,$password,$database);
	if ($mysqli->connect_errno){
		die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
	}		

	$query = "UPDATE alumnos_estudio_se SET 
	est_hijos_cant=$cant_hijos,
	est_hijos_detalle='$edades_hijos',
	est_discap=$discapacidad,
	est_discap_detalle='$det_discapacidad',
	est_enf_cron=$enf_cronicas,
	est_enf_cron_detalle='$det_enf_cronicas',
	est_consulta_med='$acude_a',
	est_zona_proc=$zona,
	est_zona_proc_detalle='$det_indigena',
	est_apoyo_prospera=$prospera,
	est_vivienda=$vivienda,
	est_material_vivienda='$material_vivienda',
	est_material_techo='$material_techo',
	est_no_cuartos=$cuartos,
	est_no_banios=$baños,
	est_agua_beber='$agua_beber',
	est_agua_vivienda='$agua_vivienda',
	est_gasto_luz=$pago_luz,
	est_drenaje='$drenaje',
	est_combust='$combustible',
	est_combust_detalle='$otro_combustible',
	est_objetos_casa1='$objeto1_casa',
	est_objetos_casa2='$objeto2_casa',
	est_objetos_casa3='$objeto3_casa',
	est_auto=$auto,
	est_auto_modelo='$modelo',
	est_auto_marca='$marca',
	est_mismo_domicilio=$domicilio,
	est_prsns_celular=$con_cel,
	est_cqvive='$vive_con',
	est_cqvive_otro='$vive_otro',
	est_depende_econo='$depende_de',
	est_no_prsns_vivienda=$viven_casa,
	est_np_depen_ingre=$dependen WHERE no_ficha='$no_ficha'";
		
	$resultado = $mysqli->query($query);

	$query="UPDATE alumnos_folio SET f_est_soc_econ1=1 WHERE no_ficha='$no_ficha'";
	$resultado = $mysqli->query($query);

	header("location: test.php");
}
else{
	header("location: test.php");
}
	
	
?>