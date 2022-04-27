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
				jAlert('Se modifico carrera de la ficha '+$num, 'Mensaje');
				setTimeout(function(){window.location.href=("asignar_grupo.php")} , 2000); 
			}
		</script>
	</head>
	<body>
	<?PHP 
		require_once '../conexion/conex_mysql.php';
		$con=new mysqli($hostname,$username,$password,$database);
		if($con->connect_error){
				die("Fallo la conexion a MySQL ");
			}
		if(isset($_POST['carrera'])){
			$carrera=$_POST['carrera'];
			$ficha=$_POST['ficha'];
			$grupo=$_POST['grupo'];
			$query = "UPDATE alumnos_datos_personales SET dp_carrera='$carrera' WHERE se_no_ficha='$ficha'";
			$resultado = $con->query($query);
			$query = "UPDATE alumnos_caracterizacion SET sa_grupo_gen='$grupo' WHERE se_no_ficha='$ficha'";
			$resultado = $con->query($query);
			echo "<script type='text/javascript'>alertar($ficha)</script>";
			$con->close();
		}
		else{
			header("location: asignar_grupo.php");
		}
	?>
	</body>
</html>