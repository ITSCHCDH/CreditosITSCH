<?PHP 
	function crear_tabla_temp($mysqli2){
		$mysqli=conexion();
		$query="CREATE TABLE IF NOT EXISTS alumnos_control (se_no_control varchar(10) COLLATE utf8_spanish2_ci);";
		$resultado = $mysqli->query($query);
		$query="SELECT * FROM alumnos_datos_personales;";
		$resultado2 = $mysqli2->query($query);
		$rows = mysqli_num_rows($resultado2);
		while($rows=mysqli_fetch_array($resultado2)){
			$query="INSERT INTO alumnos_control VALUES ('".$rows[0]."');";
			$resultado = $mysqli->query($query);
		}
	}
	function eliminar_tabla(){
		$mysqli=conexion();
		$query="DROP TABLE IF EXISTS alumnos_control";
		$resultado = $mysqli->query($query);
	}
	function conexion(){
		require '../conexion/conex_mysql.php';
		$mysqli = new mysqli ($hostname,$username,$password,$database);
		if ($mysqli->connect_errno){
			die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
		}
		return $mysqli;
	}
	function consultar_alumnos_dp($mysqli2){
		$mysqli=conexion();
		$query = "SELECT * FROM alumnos_datos_personales T1 LEFT JOIN alumnos_control T2 ON T1.se_no_control=T2.se_no_control WHERE T2.se_no_control is NULL;";
		//echo $query;
		$resultado = $mysqli->query($query);
		$rows = mysqli_num_rows($resultado);
		if (!empty($rows)){
			insertar_adp($mysqli2,$rows,$resultado);
		}
	}
	function insertar_adp($mysqli2,$rows,$resultado){
		while($rows=mysqli_fetch_array($resultado)){
			if (strlen($rows[1])==9){
				if(empty($rows[17])){
					$rows[17]=1;
				}
				if(empty($rows[18])){
					$rows[18]=0;
				}
				$query = "INSERT INTO alumnos_datos_personales VALUES 
				('".$rows[1]."','".$rows[2]."','".$rows[3]."','".$rows[4]."','".$rows[5]."','".$rows[6]."','".$rows[7]."','".$rows[8]."','".$rows[9]."','".$rows[10]."','".$rows[11]."','".$rows[12]."','".$rows[13]."','".$rows[14]."','".$rows[15]."',".$rows[16].",".$rows[17].");";
				//echo $query;
				$resultado2 = $mysqli2->query($query);
				if (!$resultado2 ) {
       				throw new Exception($mysqli2->error);
    			}
			}
		}
	}
	function consultar_caracterizacion($mysqli2){
		$mysqli=conexion();
		$query = "SELECT * FROM alumnos_caracterizacion T1 LEFT JOIN alumnos_control T2 ON T1.se_no_control=T2.se_no_control WHERE T2.se_no_control is NULL;";
		$resultado = $mysqli->query($query);
		$rows = mysqli_num_rows($resultado);
		if (!empty($rows)){
			insertar_caracterizacion($mysqli2,$rows,$resultado);
		}
	}
	function insertar_caracterizacion($mysqli2,$rows,$resultado){
		while($rows=mysqli_fetch_array($resultado)){
			if(empty($rows[3])){
				$rows[3]=0;
			}
			if(empty($rows[11])){
				$rows[11]=0;
			}
			if(empty($rows[27])){
				$rows[27]=0;
			}
			if(empty($rows[28])){
				$rows[28]=0;
			}
			if(empty($rows[29])){
				$rows[29]=0;
			}
			if(empty($rows[31])){
				$rows[31]=0;
			}
			if(empty($rows[33])){
				$rows[33]=0;
			}
			if (strlen($rows[1])==9){
				$query = "INSERT INTO alumnos_caracterizacion VALUES
				('".$rows[1]."','".$rows[2]."',".$rows[3].",'".$rows[4]."','".$rows[5]."','".$rows[6]."',".$rows[7].",'".$rows[8]."','".$rows[9]."','".$rows[10]."',".$rows[11].",'".$rows[12]."','".$rows[13]."','".$rows[14]."','".$rows[15]."','".$rows[16]."','".$rows[17]."','".$rows[18]."','".$rows[19]."','".$rows[20]."','".$rows[21]."','".$rows[22]."','".$rows[23]."','".$rows[24]."','".$rows[25]."','".$rows[26]."',".$rows[27].",".$rows[28].",".$rows[29].",".$rows[30].",".$rows[31].",'".$rows[32]."',".$rows[33].",'".$rows[34]."','".$rows[35]."');";
				//echo $query;
				$resultado2 = $mysqli2->query($query);
				if (!$resultado2 ) {
       				throw new Exception($mysqli2->error);
    			}
			}
		}
	}
	function consultar_ficha_med($mysqli2){
		$mysqli=conexion();
		$query = "SELECT * FROM (SELECT * from alumnos_ficha_medica T1 INNER JOIN alumnos_datos_personales T2 ON T1.no_ficha=T2.se_no_ficha) T3 LEFT JOIN alumnos_control T4 ON T3.se_no_control=T4.se_no_control WHERE T4.se_no_control is NULL;";
		$resultado = $mysqli->query($query);
		$rows = mysqli_num_rows($resultado);
		if (!empty($rows)){
			insertar_ficha_med($mysqli2,$rows,$resultado);
		}
	}
	function insertar_ficha_med($mysqli2,$rows,$resultado){
		while($rows=mysqli_fetch_array($resultado)){
			if (strlen($rows[1])==9){
				if(empty($rows[2]))
				{$rows[2]=0;}
				if(empty($rows[7]))
					{$rows[7]=0;}
				if(empty($rows[11]))
					{$rows[11]=0;}
				if(empty($rows[13]))
					{$rows[13]=0;}
				if(empty($rows[15]))
					{$rows[15]=0;}
				if(empty($rows[21]))
					{$rows[21]=0;}
				$query = "INSERT INTO alumnos_ficha_medica VALUES ('".$rows[1]."',".$rows[2].",".$rows[3].",".$rows[4].",".$rows[5].",'".$rows[6]."',".$rows[7].",'".$rows[8]."','".$rows[9]."','".$rows[10]."',".$rows[11].",'".$rows[12]."',".$rows[13].",'".$rows[14]."',".$rows[15].",'".$rows[16]."','".$rows[17]."','".$rows[18]."','".$rows[19]."','".$rows[20]."',".$rows[21].",'".$rows[22]."','".$rows[23]."','".$rows[24]."','".$rows[25]."');";
				//echo $query;
				$resultado2 = $mysqli2->query($query);
				if (!$resultado2 ) {
       				throw new Exception($mysqli2->error);
    			}
			}
		}
	}
	function consultar_semaforos($mysqli2){
		$mysqli=conexion();
		$query = "SELECT * FROM (SELECT * from semaforos_caracterizacion T1 INNER JOIN alumnos_datos_personales T2 ON T1.no_ficha=T2.se_no_ficha) T3 LEFT JOIN alumnos_control T4 ON T3.se_no_control=T4.se_no_control WHERE T4.se_no_control is Null;";
		$resultado = $mysqli->query($query);
		$rows = mysqli_num_rows($resultado);
		if (!empty($rows)){
			insertar_semaforos($mysqli2,$rows,$resultado);
		}
	}
	function insertar_semaforos($mysqli2,$rows,$resultado){
		while($rows=mysqli_fetch_array($resultado)){
			if (strlen($rows['1'])==9){
				if(empty($rows[2]))
					{$rows[2]=0;}
				if(empty($rows[3]))
					{$rows[3]=0;}
				if(empty($rows[4]))
					{$rows[4]=0;}
				if(empty($rows[5]))
					{$rows[5]=0;}
				if(empty($rows[6]))
					{$rows[6]=0;}
				if(empty($rows[7]))
					{$rows[7]=0;}
				if(empty($rows[8]))
					{$rows[8]=0;}
				$query = "INSERT INTO semaforos_caracterizacion VALUES ('".$rows[1]."',".$rows[2].",".$rows[3].",".$rows[4].",".$rows[5].",".$rows[6].",".$rows[7].",".$rows[8].");";
				//echo $query;
				$resultado2 = $mysqli2->query($query);
				if (!$resultado2 ) {
       				throw new Exception($mysqli2->error);
    			}
			}
		}
	}
	function consultar_estudio_se($mysqli2){
		$mysqli=conexion();
		$query = "SELECT * FROM alumnos_estudio_se T1 LEFT JOIN alumnos_control T2 ON T1.no_control=T2.se_no_control WHERE T2.se_no_control is NULL;";
		$resultado = $mysqli->query($query);
		$rows = mysqli_num_rows($resultado);
		if (!empty($rows)){
			insertar_estudio_se($mysqli2,$rows,$resultado);
		}
	}
	function insertar_estudio_se($mysqli2,$rows,$resultado){
		while($rows=mysqli_fetch_array($resultado)){
			if (strlen($rows[1])==9){
				if(empty($rows[2]))
					{$rows[2]=0;}
				if(empty($rows[4]))
					{$rows[4]=0;}
				if(empty($rows[6]))
					{$rows[6]=0;}
				if(empty($rows[9]))
					{$rows[9]=0;}
				if(empty($rows[11]))
					{$rows[11]=0;}
				if(empty($rows[12]))
					{$rows[12]=0;}
				if(empty($rows[15]))
					{$rows[15]=0;}
				if(empty($rows[16]))
					{$rows[16]=0;}
				if(empty($rows[19]))
					{$rows[19]=0;}
				if(empty($rows[20]))
					{$rows[20]=0;}
				if(empty($rows[26]))
					{$rows[26]=0;}
				if(empty($rows[31]))
					{$rows[31]=0;}
				if(empty($rows[33]))
					{$rows[33]=0;}
				if(empty($rows[34]))
					{$rows[34]=0;}
				if(empty($rows[37]))
					{$rows[37]=0;}
				if(empty($rows[38]))
					{$rows[38]=0;}
				if(empty($rows[39]))
					{$rows[39]=0;}
				if(empty($rows[40]))
					{$rows[40]=0;}
				if(empty($rows[41]))
					{$rows[41]=0;}
				$query = "INSERT INTO alumnos_estudio_se VALUES (
				'".$rows[1]."',
					".$rows[2].",
				'".$rows[3]."',
					".$rows[4].",
				'".$rows[5]."',
					".$rows[6].",
				'".$rows[7]."',
				'".$rows[8]."',
					".$rows[9].",
				'".$rows[10]."',
					".$rows[11].",
					".$rows[12].",
				'".$rows[13]."',
				'".$rows[14]."',
					".$rows[15].",
					".$rows[16].",
				'".$rows[17]."',
				'".$rows[18]."',
					".$rows[19].",
					".$rows[20].",
				'".$rows[21]."',
				'".$rows[22]."',
				'".$rows[23]."',
				'".$rows[24]."',
				'".$rows[25]."',
					".$rows[26].",
				'".$rows[27]."',
				'".$rows[28]."',
				'".$rows[29]."',
				'".$rows[30]."',
					".$rows[31].",
				'".$rows[32]."',
					".$rows[33].",
					".$rows[34].",
				'".$rows[35]."',
				'".$rows[36]."',
					".$rows[37].",
					".$rows[38].",
					".$rows[39].",
					".$rows[40].",
					".$rows[41].",
				'".$rows[42]."',
				'".$rows[43]."',
				'".$rows[44]."',
				'".$rows[45]."',
				'".$rows[46]."',
				'".$rows[47]."');";
				//echo $query;
				$resultado2 = $mysqli2->query($query);
				if (!$resultado2 ) {
       				throw new Exception($mysqli2->error);
    			}
			}
		}
	}
	function consultar_ingresos($mysqli2){
		$mysqli=conexion();
		$query = "SELECT * FROM (SELECT * FROM alumnos_ingresos T1 RIGHT JOIN alumnos_datos_personales T2 ON T1.no_ficha=T2.se_no_ficha) T3 LEFT JOIN alumnos_control T4 ON T3.se_no_control=T4.se_no_control WHERE T4.se_no_control is Null;";
		$resultado = $mysqli->query($query);
		$rows = mysqli_num_rows($resultado);
		if (!empty($rows)){
			insertar_ingresos($mysqli2,$rows,$resultado);
		}
	}
	function insertar_ingresos($mysqli2,$rows,$resultado){
		while($rows=mysqli_fetch_array($resultado)){
			if (strlen($rows[10])==9){
				if(empty($rows[0])){
					$rows[0]=$rows[9];
				}
				if(empty($rows[3])){
					$rows[3]=0;
				}
				if(empty($rows[4])){
					$rows[4]=0;
				}
				if(empty($rows[5])){
					$rows[5]=0;
				}
				if(empty($rows[6])){
					$rows[6]=0;
				}
				if(empty($rows[7])){
					$rows[7]=0;
				}
				if(empty($rows[8])){
					$rows[8]=0;
				}
				$query = "INSERT INTO alumnos_ingresos VALUES (
				NULL,
				'".$rows[10]."',
				".$rows[3].",
				".$rows[4].",
				".$rows[5].",
				".$rows[6].",
				".$rows[7].",
				".$rows[8].");";
				//echo $query;
				$resultado2 = $mysqli2->query($query);
				if (!$resultado2 ) {
       				throw new Exception($mysqli2->error);
    			}
			}
		}
	}
	function consultar_test_vocac($mysqli2){
		$mysqli=conexion();
		$query = "SELECT * FROM (SELECT * FROM alumnos_test_vocacional T1 RIGHT JOIN alumnos_datos_personales T2 ON T1.no_ficha=T2.se_no_ficha) T3 LEFT JOIN alumnos_control T4 ON T3.se_no_control=T4.se_no_control WHERE T4.se_no_control is Null;";
		$resultado = $mysqli->query($query);
		$rows = mysqli_num_rows($resultado);
		if (!empty($rows)){
			insertar_test_voca($mysqli2,$rows,$resultado);
		}
	}
	function insertar_test_voca($mysqli2,$rows,$resultado){
		while($rows=mysqli_fetch_array($resultado)){
			if (strlen($rows[19])==9){
				if(empty($rows[3])){
					$rows[3]=0;
				}
				if(empty($rows[4])){
					$rows[4]=0;
				}
				if(empty($rows[5])){
					$rows[5]=0;
				}
				if(empty($rows[6])){
					$rows[6]=0;
				}
				if(empty($rows[7])){
					$rows[7]=0;
				}
				if(empty($rows[8])){
					$rows[8]=0;
				}
				if(empty($rows[9])){
					$rows[9]=0;
				}
				if(empty($rows[10])){
					$rows[10]=0;
				}
				if(empty($rows[11])){
					$rows[11]=0;
				}
				if(empty($rows[12])){
					$rows[12]=0;
				}
				$query = "INSERT INTO alumnos_test_vocacional VALUES (
				'".$rows[19]."',
				'".$rows[2]."',
				".$rows[3].",
				".$rows[4].",
				".$rows[5].",
				".$rows[6].",
				".$rows[7].",
				".$rows[8].",
				".$rows[9].",
				".$rows[10].",
				".$rows[11].",
				".$rows[12].",
				'".$rows[13]."',
				'".$rows[14]."',
				'".$rows[15]."',
				'".$rows[16]."',
				'".$rows[17]."');";
				//echo $query;
				$resultado2 = $mysqli2->query($query);
				if (!$resultado2 ) {
       				throw new Exception($mysqli2->error);
    			}
			}
		}
	}
	function consultar_dpadres($mysqli2){
		$mysqli=conexion();
		$query = "SELECT * FROM alumnos_datos_padres T3 LEFT JOIN alumnos_control T4 ON T3.no_control=T4.se_no_control WHERE T4.se_no_control is Null;";
		$resultado = $mysqli->query($query);
		$rows = mysqli_num_rows($resultado);
		if (!empty($rows)){
			insertar_dpadres($mysqli2,$rows,$resultado);
		}
	}
	function insertar_dpadres($mysqli2,$rows,$resultado){
		while($rows=mysqli_fetch_array($resultado)){
			if (strlen($rows[2])==9){
				$query = "INSERT INTO alumnos_datos_padres VALUES (
				NULL,
				'".$rows[2]."',
				'".$rows[3]."',
				".$rows[4].",
				".$rows[5].",
				".$rows[6].",
				'".$rows[7]."',
				'".$rows[8]."',
				'".$rows[9]."',
				'".$rows[10]."',
				'".$rows[11]."',
				'".$rows[12]."',
				'".$rows[13]."',
				'".$rows[14]."',
				'".$rows[15]."');";
				//echo $query;
				$resultado2 = $mysqli2->query($query);
				if (!$resultado2 ) {
       				throw new Exception($mysqli2->error);
    			}
			}
		}
	}
	function consultar_hab_casa($mysqli2){
		$mysqli=conexion();
		$query = "SELECT * FROM alumnos_hab_casa T3 LEFT JOIN alumnos_control T4 ON T3.no_control=T4.se_no_control WHERE T4.se_no_control is Null;";
		$resultado = $mysqli->query($query);
		$rows = mysqli_num_rows($resultado);
		if (!empty($rows)){
			insertar_hab_casa($mysqli2,$rows,$resultado);
		}
	}
	function insertar_hab_casa($mysqli2,$rows,$resultado){
		while($rows=mysqli_fetch_array($resultado)){
			if (strlen($rows[2])==9){
				$query = "INSERT INTO alumnos_hab_casa VALUES (
				NULL,
				'".$rows[2]."',
				'".$rows[3]."',
				'".$rows[4]."',
				".$rows[5].",
				'".$rows[6]."',
				'".$rows[7]."',
				'".$rows[8]."');";
				//echo $query;
				$resultado2 = $mysqli2->query($query);
				if (!$resultado2 ) {
       				throw new Exception($mysqli2->error);
    			}
			}
		}
	}
	function commit($mysqli){
		$query="COMMIT;";
		//echo $query;
		$resultado2 = $mysqli->query($query);
		echo "<script>commit()</script>";
		eliminar_tabla();
	}
	function rollback($mysqli){
		$query="ROLLBACK;";
		//echo $query;
		$resultado2 = $mysqli->query($query);
		echo "<script>rollback()</script>";
		eliminar_tabla();
	}
?>