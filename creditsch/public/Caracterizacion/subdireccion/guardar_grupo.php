<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />		
		<link rel='stylesheet' type='text/css' href='../css/demo.css' />
	    <link rel='stylesheet' type='text/css' href='../css/style3.css' />
	    <link rel='stylesheet' type='text/css' href='../css/sbimenu.css' />
		<!--Js para mensajes-->
	    <link rel="stylesheet" type="text/css" href="../css/jquery.alerts.css">
		<script src="../js/jquery-1.4.2.min.js" type="text/javascript"></script>
		<script src="../js/jquery.ui.draggable.js" type="text/javascript"></script>
		<script src="../js/jquery.alerts.mod.js" type="text/javascript"></script>

		<title>STE-ITSCH</title>
		<script type='text/javascript'> 
			function alertar($num) {
				jAlert('Se han registrado '+$num+' Alumnos', 'Mensaje');
				setTimeout(function(){window.location.href=("asignar_grupo.php")} , 2000); 
			}
		</script>
	</head>

	<body>
	<?php
		session_start();
		require_once '../conexion/conex_mysql.php';

		$con=new mysqli($hostname,$username,$password,$database);
		if($con->connect_error){
			die("Fallo la conexion a MySQL ");
		}
		$carrera=$_POST['carrera'];
		if($carrera=='1'){
			$alumnos=$_SESSION["arreglo1"];
			$num_alum=$alumnos[0];
	
			for($x=1;$x<=$alumnos[0];$x++){
				$grupos[$x]=$_REQUEST['gpo'.$x];
				//echo "Alumno Ficha = ".$alumnos[$x].", Grupo = ".$grupos[$x]."<br>";
		
				$query = "UPDATE alumnos_caracterizacion SET sa_grupo_gen='$grupos[$x]' WHERE se_no_ficha='$alumnos[$x]'";
				$resultado = $con->query($query);

			}
			echo "<script type='text/javascript'>alertar($num_alum)</script>";
			$con->close();
		}
		if($carrera=='2'){
			$alumnos=$_SESSION["arreglo2"];
			$num_alum=$alumnos[0];
	
			for($x=1;$x<=$alumnos[0];$x++){
				$grupos[$x]=$_REQUEST['gpo'.$x];
				//echo "Alumno Ficha = ".$alumnos[$x].", Grupo = ".$grupos[$x]."<br>";
		
				$query = "UPDATE alumnos_caracterizacion SET sa_grupo_gen='$grupos[$x]' WHERE se_no_ficha='$alumnos[$x]'";
				$resultado = $con->query($query);

			}
			echo "<script type='text/javascript'>alertar($num_alum)</script>";
			$con->close();
		}
		if($carrera=='3'){
			$alumnos=$_SESSION["arreglo3"];
			$num_alum=$alumnos[0];
	
			for($x=1;$x<=$alumnos[0];$x++){
				$grupos[$x]=$_REQUEST['gpo'.$x];
				//echo "Alumno Ficha = ".$alumnos[$x].", Grupo = ".$grupos[$x]."<br>";
		
				$query = "UPDATE alumnos_caracterizacion SET sa_grupo_gen='$grupos[$x]' WHERE se_no_ficha='$alumnos[$x]'";
				$resultado = $con->query($query);

			}
			echo "<script type='text/javascript'>alertar($num_alum)</script>";
			$con->close();
		}
		if($carrera=='4'){
			$alumnos=$_SESSION["arreglo4"];
			$num_alum=$alumnos[0];
	
			for($x=1;$x<=$alumnos[0];$x++){
				$grupos[$x]=$_REQUEST['gpo'.$x];
				//echo "Alumno Ficha = ".$alumnos[$x].", Grupo = ".$grupos[$x]."<br>";
		
				$query = "UPDATE alumnos_caracterizacion SET sa_grupo_gen='$grupos[$x]' WHERE se_no_ficha='$alumnos[$x]'";
				$resultado = $con->query($query);

			}
			echo "<script type='text/javascript'>alertar($num_alum)</script>";
			$con->close();
		}
		if($carrera=='5'){
			$alumnos=$_SESSION["arreglo5"];
			$num_alum=$alumnos[0];
	
			for($x=1;$x<=$alumnos[0];$x++){
				$grupos[$x]=$_REQUEST['gpo'.$x];
				//echo "Alumno Ficha = ".$alumnos[$x].", Grupo = ".$grupos[$x]."<br>";
		
				$query = "UPDATE alumnos_caracterizacion SET sa_grupo_gen='$grupos[$x]' WHERE se_no_ficha='$alumnos[$x]'";
				$resultado = $con->query($query);

			}
			echo "<script type='text/javascript'>alertar($num_alum)</script>";
			$con->close();
		}
		if($carrera=='6'){
			$alumnos=$_SESSION["arreglo6"];
			$num_alum=$alumnos[0];
	
			for($x=1;$x<=$alumnos[0];$x++){
				$grupos[$x]=$_REQUEST['gpo'.$x];
				//echo "Alumno Ficha = ".$alumnos[$x].", Grupo = ".$grupos[$x]."<br>";
		
				$query = "UPDATE alumnos_caracterizacion SET sa_grupo_gen='$grupos[$x]' WHERE se_no_ficha='$alumnos[$x]'";
				$resultado = $con->query($query);

			}
			echo "<script type='text/javascript'>alertar($num_alum)</script>";
			$con->close();
		}
		if($carrera=='7'){
			$alumnos=$_SESSION["arreglo7"];
			$num_alum=$alumnos[0];
	
			for($x=1;$x<=$alumnos[0];$x++){
				$grupos[$x]=$_REQUEST['gpo'.$x];
				//echo "Alumno Ficha = ".$alumnos[$x].", Grupo = ".$grupos[$x]."<br>";
		
				$query = "UPDATE alumnos_caracterizacion SET sa_grupo_gen='$grupos[$x]' WHERE se_no_ficha='$alumnos[$x]'";
				$resultado = $con->query($query);

			}
			echo "<script type='text/javascript'>alertar($num_alum)</script>";
			$con->close();
		}
?>
</body>
</html>
