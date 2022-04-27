<!DOCTYPE html>
<html lang="es">
    <head>
        <title>STE-ITCH</title>
		<meta charset="UTF-8" />
		<link rel='stylesheet' type='text/css' href='../css/demo.css' />
        <link rel="stylesheet" type="text/css" href="../css/style2.css" />
		<link rel="stylesheet" type="text/css" href="../css/sbimenu.css" />
		<!--Js para mensajes-->
	    <link rel="stylesheet" type="text/css" href="../css/jquery.alerts.css">
		<script src="../js/jquery-1.4.2.min.js" type="text/javascript"></script>
		<script src="../js/jquery.ui.draggable.js" type="text/javascript"></script>
		<script src="../js/jquery.alerts.mod.js" type="text/javascript"></script>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
		<script type="text/javascript" src="../js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="../js/jquery.bgImageMenu.js"></script>
		<script type="text/javascript">
			$(function() {
				$('#sbi_container').bgImageMenu({
					defaultBg	: '../pic/5.jpg',
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
				jError("No de Ficha o CURP no son validas", "Error");
			}
		</script>
		<script type='text/javascript'> 
			function direccionar($ficha) {
				document.getElementById("logear").action = "test.php";
     			document.logear.submit();
			}
		</script>
		<script>
        	$(document).ready(function (){
          		$('.solo-numero').keyup(function (){
            		this.value = (this.value + '').replace(/[^0-9]/g, '');
          		});
        	});
    	</script>
    </head>
   
    <body>
		<div class='container'>
		<br>
			<div class='topbar'>
				<a><span>Alumno </span></a>
				<span class='right_ab'>
					<a><strong>Bienvenido, Buen Día</strong></a>
				</span>
			</div>
		</div>
		<br>
		<div id='sbi_container' class='sbi_container'>
			<div class='sbi_panel' data-bg='../pic/1.jpg'>
				</div>
		</div>
		<div class='topbar'>
			<a><span><i>Inicio /</i></span></a>
			
		</div>
    	<section class='tabss'>
			<fieldset>
				<form id="logear" name='logear' method='POST' action='' autocomplete='off'>
		    		<table align='center' width="675">
						<tr>
							<td><stroke><b>No Ficha:</b></stroke></td>
							<td><stroke><b>CURP:</b></stroke></td>
							<td></td>

						</tr>
						<tr>
							<td>
								<input size="5" type='text' class='solo-numero' name='no_ficha' id='no_ficha' required autofocus>
							</td>
							
								<td><input type='text' name='curp' id='curp' size='24' maxlength='18' pattern='[A-Z]{1}[AEIOUX]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}' required></td>
							</td>
							<td align="center"><stroke><input type='submit' value='Login' name='login' id='login'></td>
						</tr>
					</table>
				</form>	
			</fieldset>
		</section>
		<?PHP
		session_start();

		//if (isset($_SESSION['no_ficha']) AND ($_SESSION['curp'])){
		//	header("location: test.php");
		//}
		
		if (isset($_POST['login'])){ 
			
			require_once '../conexion/conex_mysql.php';
			$no_ficha= $_POST['no_ficha'];
			$curp= $_POST['curp'];
			$mysqli = new mysqli ($hostname,$username,$password,$database);
			if ($mysqli->connect_errno){
				die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
			}		
			$query = "SELECT * from alumnos_datos_personales WHERE se_no_ficha='$no_ficha' AND se_curp='$curp'";
			$resultado = $mysqli->query($query);
			$rows = mysqli_fetch_array($resultado);
			$carrera=utf8_encode($rows['dp_carrera']);


			
			if(empty($rows)){
				echo "<script type='text/javascript'>alertar()</script>"; 
			}
			else{
				
				$_SESSION['no_ficha']=$no_ficha;
				$_SESSION['ficha']=$no_ficha;
				$_SESSION['control']=$no_ficha;
				$_SESSION['curp']=$curp;
				$_SESSION['carrera']=$carrera;
				echo "<script type='text/javascript'>direccionar($no_ficha)</script>"; 	
			}
		}
		echo "
	</body>
</html>";
?>
    