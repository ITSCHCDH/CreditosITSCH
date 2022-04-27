<?PHP 
	session_start();
	if (isset($_POST['campos']) AND ($_SESSION['no_ficha']) AND ($_SESSION['curp'])){
	$n_campos=$_POST['campos'];
	$no_ficha=$_SESSION['no_ficha'];
	if ($n_campos>0){
		for ($i=1; $i <=$n_campos ; $i++) {
				$nom='nombre'.$i; 
			$nombre=$_POST[$nom];
				$ed='edad'.$i;
			$edad=$_POST[$ed];
				$parentes='parentesco'.$i;
			$parentesco=$_POST[$parentes];
				$escolar='escolaridad'.$i;
			$escolaridad=$_POST[$escolar];
				$esc_pp='escuela'.$i;
			$tipo_esc=($_POST[$esc_pp]);
				$ocup='ocupacion'.$i;
			$ocupacion=$_POST[$ocup];

			require_once '../conexion/conex_mysql.php';
			$mysqli = new mysqli ($hostname,$username,$password,$database);
			if ($mysqli->connect_errno){
				die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
			}
	
			$query="INSERT INTO alumnos_hab_casa (no_ficha,no_control,nombre,parentesco,edad,escolaridad,esc_pub_priv,ocupacion) Values ('$no_ficha','$no_ficha','$nombre','$parentesco',$edad,'$escolaridad','$tipo_esc','$ocupacion');";
			$resultado = $mysqli->query($query);
			mysqli_close($mysqli);
		}

	}
	
		require_once '../conexion/conex_mysql.php';
		$mysqli = new mysqli ($hostname,$username,$password,$database);
		if ($mysqli->connect_errno){
			die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
		}
	
		$query="UPDATE alumnos_folio SET f_est_soc_econ3=1 WHERE no_ficha='$no_ficha'";
		
		$resultado = $mysqli->query($query);
		mysqli_close($mysqli);

		header("location: test.php");
	}
else{
	header("location: test.php");
	
}



?>