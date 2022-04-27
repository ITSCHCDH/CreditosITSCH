<?PHP	
session_start();
$no_ficha=$_SESSION['no_ficha'];
$tipo_sangre= $_POST['tiposangre'];
$email= $_POST['email'];
$estado_civil= $_POST['estado_civil'];
$hijos= $_POST['hijos'];
$beca= $_POST['beca'];
$tipo_beca= $_POST['tipobeca'];
$vivir_con= $_POST['vivir_con'];
$trabaja= $_POST['trabaja'];
$horario= $_POST['horario'];
$lugar= $_POST['lugar_trabajo'];

require_once '../conexion/conex_mysql.php';
$mysqli = new mysqli ($hostname,$username,$password,$database);
if ($mysqli->connect_errno){
die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
}
try {
$query="START COMMIT;";
$resultado = $mysqli->query($query); 

$query = "UPDATE alumnos_datos_personales SET dp_tipo_sangre='$tipo_sangre',dp_email='$email',dp_edo_civil=".$estado_civil.",dp_hijos=".$hijos." WHERE se_no_ficha='$no_ficha'";
$resultado = $mysqli->query($query); 
if (!$resultado ) {
throw new Exception($mysqli->error);
}

$query="UPDATE alumnos_folio SET f_dat_pers=1 WHERE no_ficha='$no_ficha'";
$resultado = $mysqli->query($query);
if (!$resultado ) {
throw new Exception($mysqli->error);
} 

$query="UPDATE alumnos_caracterizacion SET tut_becas=$beca, tut_becas_detalles='$tipo_beca', tut_vivir_con=$vivir_con, tut_trabajo_lugar='$lugar', tut_trabajo_horario='$horario' WHERE se_no_ficha='$no_ficha'";
$resultado = $mysqli->query($query);
if (!$resultado ) {
throw new Exception($mysqli->error);
} 

$query="UPDATE semaforos_caracterizacion SET smf_trabaja=$trabaja WHERE no_ficha='$no_ficha'";
$resultado = $mysqli->query($query);
if (!$resultado ) {
throw new Exception($mysqli->error);
} 
header("location: test.php");

} catch (Exception $e) {
$query="ROLLBACK;";
$resultado = $mysqli->query($query); 
}

?>