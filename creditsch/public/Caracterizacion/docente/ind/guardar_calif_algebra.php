<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>STE-ITSCH</title>
	<!--Js para mensajes-->
    <link rel="stylesheet" type="text/css" href="../../css/jquery.alerts.css">
	<script src="../../js/jquery-1.4.2.min.js" type="text/javascript"></script>
	<script src="../../js/jquery.ui.draggable.js" type="text/javascript"></script>
	<script src="../../js/jquery.alerts.mod.js" type="text/javascript"></script>

	<script type='text/javascript'> 
			function alertar($num) {
				jAlert('Se han registrado '+$num+' Alumnos', 'Mensaje');
				setTimeout(function(){window.location.href=("index.php")} , 800); 
			}
		</script>
</head>

<body>
	<?php
	session_start();
	require_once '../../conexion/conex_mysql.php';
	$con=new mysqli($hostname,$username,$password,$database);
	if($con->connect_error){
		die("Fallo la conexion a MySQL ");
	}
	$nombre=$_POST['nombre'];
	$alumnos=$_SESSION[$nombre];
	//echo "El numero de registros es :".$alumnos;
	
	for($x=1;$x<=$alumnos[0];$x++){
		$datos[$x]=$_REQUEST['tx'.$x];
		$num_alum=$alumnos[0];
	//	echo "Alumno Ficha = ".$alumnos[$x].", Calificacion = ".$datos[$x]."<br>";
		
		$query = "UPDATE alumnos_caracterizacion SET doc_curso_algebra_res=$datos[$x] WHERE se_no_ficha='$alumnos[$x]'";
		$resultado = $con->query($query);

		$query="UPDATE semaforos_caracterizacion SET smf_cb=$datos[$x] WHERE no_ficha='$alumnos[$x]'";
		$resultado = $con->query($query);

	}
	echo "<script type='text/javascript'>alertar($num_alum)</script>";
	$con->close();
	?>
</body>
</html>
