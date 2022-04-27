<?PHP 
	if (isset($_POST['tutorias'])){
		$ficha=$_POST['fic'];
		$semaforo_tut=$_POST['tutorias'];
		$prob_med_diagnostico=$_POST['diagnostico_probpsico'];
		$machover=$_POST['machover'];
		$prob_fam_res=$_POST['probfam'];

		require_once '../conexion/conex_mysql.php';
		$mysqli = new mysqli ($hostname,$username,$password,$database);
		if ($mysqli->connect_errno){
			die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
		}
		$query = "UPDATE alumnos_caracterizacion SET tut_probpsico_machover='$machover', tut_probpsico_diagnostico='$prob_med_diagnostico',tut_probfam_res='$prob_fam_res' WHERE se_no_ficha='$ficha'";
		$resultado = $mysqli->query($query); 
		echo $query;
		$query="UPDATE semaforos_caracterizacion SET smf_tut=$semaforo_tut WHERE no_ficha='$ficha'";
		$resultado = $mysqli->query($query); 
		header("location: asentar_diagnostico.php");

	}
	else{
		header("location: index.php");
	}
	
?>