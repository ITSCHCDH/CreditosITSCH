<?PHP 
session_start();
if (isset($_POST['cuenta_con_beca']) AND ($_SESSION['no_ficha']) AND ($_SESSION['curp'])){
	$no_ficha=$_SESSION['no_ficha'];
	$nom_padre=$_POST['nombre_padre'];
	$vive_padre=$_POST['vive_padre'];
	if(isset($_POST['tutor_padre'])){
		$tutor_padre=$_POST['tutor_padre'];	
	}
	else{
		$tutor_padre=0;
	}
	if(isset($_POST['ausente_padre'])){
		$ausente_padre=$_POST['ausente_padre'];	
	}
	else{
		$ausente_padre=0;
	}
	$ocupacion_padre=$_POST['ocupacion_padre'];
	$fnac_padre=$_POST['fecha_nac_padre'];
	$esc_padre=$_POST['escolaridad_padre'];
	$domic_padre=$_POST['domicilio_padre'];
	$colonia_padre=$_POST['colonia_padre'];
	$tel_part_padre=$_POST['tel_particular_padre'];
	$pob_padre=$_POST['poblacion_padre'];
	$tel_trab_padre=$_POST['tel_trabajo_padre'];
	$trabajo_padre=$_POST['trabajo_padre'];

	$nom_madre=$_POST['nombre_madre'];
	$vive_madre=$_POST['vive_madre'];
	if(isset($_POST['tutor_madre'])){
		$tutor_madre=$_POST['tutor_madre'];	
	}
	else{
		$tutor_madre=0;
	}
	if(isset($_POST['ausente_madre'])){
		$ausente_madre=$_POST['ausente_madre'];	
	}
	else{
		$ausente_madre=0;
	}
	
	$ocupacion_madre=$_POST['ocupacion_madre'];
	$fnac_madre=$_POST['fecha_nac_madre'];
	$esc_madre=$_POST['escolaridad_madre'];
	$domic_madre=$_POST['domicilio_madre'];
	$colonia_madre=$_POST['colonia_madre'];
	$tel_part_madre=$_POST['tel_particular_madre'];
	$pob_madre=$_POST['poblacion_madre'];
	$tel_trab_madre=$_POST['tel_trabajo_madre'];
	$trabajo_madre=$_POST['trabajo_madre'];

	$ingreso_padre=$_POST['ingreso_padre'];
	$ingreso_madre=$_POST['ingreso_madre'];
	$ingreso_hermanos=$_POST['ingreso_hermanos'];
	$ingreso_propio=$_POST['ingreso_propio'];
	$ingreso_otro=$_POST['ingreso_otros'];
	$total_ingresos=$ingreso_padre+$ingreso_madre+$ingreso_hermanos+$ingreso_propio+$ingreso_otro;

	$medio_transporte='';
	
	for ($i=1; $i <=8 ; $i++) {
		$nombre='medio_'.$i;
		if(isset($_POST[$nombre])){
			$medio_transporte.=$_POST[$nombre];
		}else{$medio_transporte.=0;}	
	}
	$otro_transporte=$_POST['otro_transporte'];
	$horas=$_POST['transporte_horas'];
	$minutos=$_POST['transporte_minutos'];
	$gasto_transporte=$_POST['gasto_transporte'];

	$beca=$_POST['cuenta_con_beca'];
	$beca_det=$_POST['beca_descripcion'];
	$utilidad_beca='';
	for ($i=1; $i <=6 ; $i++) {
		$nombre='utilidad_beca_'.$i;
		if(isset($_POST[$nombre])){
			$utilidad_beca.=$_POST[$nombre];
		}else{$utilidad_beca.=0;}	
	}
	$beca_otra_utilidad=$_POST['beca_otra_utilidad'];
	$hobby=$_POST['hobby'];
	$lugares=$_POST['lugares'];
	$motivo_tec=$_POST['motivo_tec'];

	require_once '../conexion/conex_mysql.php';
	$mysqli = new mysqli ($hostname,$username,$password,$database);
	if ($mysqli->connect_errno){
		die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
	}
	$query="INSERT INTO alumnos_datos_padres (
	no_ficha,	no_control,	dp_padre_nombre, dp_tutor, dp_ausente,	dp_padre_vive, 
	dp_padre_fecnac,	dp_padre_ocup,	dp_padre_nivest,	
	dp_padre_domicilio,	dp_padre_colonia,	dp_padre_poblacion,
	dp_padre_telparticular,	dp_padre_centro_trabajo,	dp_padre_teltrabajo)
	values 
	('$no_ficha',	'$no_ficha',	'$nom_padre', $tutor_padre, $ausente_padre,	$vive_padre, 	
	'$fnac_padre',	'$ocupacion_padre',	'$esc_padre',	
	'$domic_padre',	'$colonia_padre',	'$pob_padre',	
	'$tel_part_padre',	'$trabajo_padre',	'$tel_trab_padre')";
	
	$resultado = $mysqli->query($query);

	$query="INSERT INTO alumnos_datos_padres (
	no_ficha,	no_control,	dp_padre_nombre, dp_tutor, dp_ausente,	dp_padre_vive, 
	dp_padre_fecnac,	dp_padre_ocup,	dp_padre_nivest,	
	dp_padre_domicilio,	dp_padre_colonia,	dp_padre_poblacion,
	dp_padre_telparticular,	dp_padre_centro_trabajo,	dp_padre_teltrabajo)
	values 
	('$no_ficha',	'$no_ficha',	'$nom_madre', $tutor_madre, $ausente_madre,	$vive_madre, 	
	'$fnac_madre',	'$ocupacion_madre',	'$esc_madre',	
	'$domic_madre',	'$colonia_madre',	'$pob_madre',	
	'$tel_part_madre',	'$trabajo_madre',	'$tel_trab_madre')";
	
	$resultado = $mysqli->query($query);

	$query="INSERT INTO alumnos_ingresos 
	(id_ingresos,no_ficha,no_control,est_ingreso_padre,est_ingreso_madre,est_ingreso_hermanos,est_ingreso_propio,est_ingreso_otros,est_total_ingresos) VALUES ($no_ficha,'$no_ficha','$no_ficha',$ingreso_padre,$ingreso_madre,$ingreso_hermanos,$ingreso_propio,$ingreso_otro,$total_ingresos)";
	$resultado = $mysqli->query($query);

	$query="UPDATE alumnos_caracterizacion SET est_se_ingresos_todos=$total_ingresos WHERE se_no_ficha='$no_ficha'";
	$resultado = $mysqli->query($query);
	
	$query="UPDATE alumnos_estudio_se SET 
	est_transporte='$medio_transporte',
	est_transporte_otro='$otro_transporte',
	est_transporte_esc_hrs=$horas,
	est_transporte_esc_min=$minutos,
	est_transporte_gasto=$gasto_transporte,
	est_becas=$beca,
	est_becas_detalle='$beca_det',
	est_becas_utilidad='$utilidad_beca',
	est_becas_utilidad_otra='$beca_otra_utilidad',
	est_hobby='$hobby',
	est_lug_frecuentes='$lugares',
	est_motivo_inscripcion='$motivo_tec' WHERE no_ficha='$no_ficha'";
	$resultado = $mysqli->query($query);

	$query="UPDATE alumnos_folio SET f_est_soc_econ2=1 WHERE no_ficha='$no_ficha'";
	$resultado = $mysqli->query($query);		

	header("location: test.php");
}
else{
	header("location: test.php");
}

?>