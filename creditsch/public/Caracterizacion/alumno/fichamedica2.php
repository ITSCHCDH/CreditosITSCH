<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<body>
<?php
session_start();
require_once '../conexion/conexion.php';
$con=new mysqli($host,$user,$pwd,$bd);
if($con->connect_error){
die("Fallo la conexion a MySQL ");
}
$ficha=$_SESSION['no_ficha'];
$control=$_SESSION['control'];

$edad=$_REQUEST['txedad'];
$peso=$_REQUEST['txpeso'];
$estatura=$_REQUEST['txestatura'];
if($estatura>100){
$estatura=$estatura/100;	
}
$radEnf=$_REQUEST['radEnf'];
$enfermedad=$_REQUEST['txenfermedad'];
if(isset($_REQUEST['chkIssste'])){
$isste=$_REQUEST['chkIssste'];
}
if(isset($_REQUEST['chkImss'])){
$imss=$_REQUEST['chkImss'];
}
if(isset($_REQUEST['chkSP'])){
$segPop=$_REQUEST['chkSP'];
}
$seg=$_REQUEST['txseguro'];
$radAlergia=$_REQUEST['radAlergia'];
$alergia=$_REQUEST['txalergia'];
$radAlergMed=$_REQUEST['radAlergiaMed'];
$alergiaMed=$_REQUEST['txalergiaMed'];
$radMed=$_REQUEST['radMed'];
$Medicamento=$_REQUEST['txMedicamento'];
if(isset($_REQUEST['chkIR'])){
$insRenal=$_REQUEST['chkIR'];
}
if(isset($_REQUEST['chkPA'])){
$preAlta=$_REQUEST['chkPA'];
}
if(isset($_REQUEST['chkD'])){
$diab=$_REQUEST['chkD'];
}
if(isset($_REQUEST['chkC'])){
$cancer=$_REQUEST['chkC'];
}
if(isset($_REQUEST['chkEC'])){
$enfCorazon=$_REQUEST['chkEC'];
}
if(isset($_REQUEST['chkEC'])){
$enfCerebrales=$_REQUEST['chkEC'];
}
$enfOtra=$_REQUEST['txenfermedadCon'];
if(isset($_REQUEST['chkFM'])){
$mama=$_REQUEST['chkFM'];
}
if(isset($_REQUEST['chkFP'])){
$papa=$_REQUEST['chkFP'];
}
if(isset($_REQUEST['chkFH'])){
$hnos=$_REQUEST['chkFH'];
}
$famOtros=$_REQUEST['txfamOtros'];
$radRelFam=$_REQUEST['radRF'];
$radCar=$_REQUEST['radCar'];
$car=$_REQUEST['txcarrera'];
$prioridad=$_REQUEST['cmbtxprioridad'];

//Calculo IMC
$imc=$peso / ($estatura*$estatura);
if($imc<18){
$diagImc="Bajo Peso";
}else if($imc<25){
$diagImc="Peso Normal";
}else if($imc<27){
$diagImc="Sobrepeso";
}else if($imc<30){
$diagImc="Obesidad Grado I";
}else if($imc<40){
$diagImc="Obesidad Grado II";
}else if($imc>=40){
$diagImc="Obesidad Grado III";
}

$seguro="";
if(isset($isste)){
$seguro=$seguro."1";
}else{
$seguro=$seguro."0";
}
if(isset($imss)){
$seguro=$seguro."1";
}else{
$seguro=$seguro."0";
}
if(isset($segPop)){
$seguro=$seguro."1";
}else{
$seguro=$seguro."0";	
}
if(isset($seg)){
$seguro=$seguro."1";	
}else{
$seguro=$seguro."0";
}
$enf="";
$pred=0;
if(isset($insRenal)){
$enf=$enf."1";
$pred=1;
}else{
$enf=$enf."0";
}
if(isset($preAlta)){
$enf=$enf."1";
$pred=1;
}else{
$enf=$enf."0";
}
if(isset($diab)){
$enf=$enf."1";
$pred=1;
}else{
$enf=$enf."0";
}
if(isset($cancer)){
$enf=$enf."1";
$pred=1;
}else{
$enf=$enf."0";
}
if(isset($enfCorazon)){
$enf=$enf."1";
$pred=1;
}else{
$enf=$enf."0";
}
if(isset($enfCerebrales)){
$enf=$enf."1";
$pred=1;
}else{
$enf=$enf."0";
}
if($enfOtra!=""){
$pred=1;
}
//Diagnostico de enfermedades
if($pred==1){
$diagPred="Predisposicion";
}else{
$diagPred="Ninguno";
}
$fami="";
if(isset($mama)){
echo "Mama: ".$mama."<br>";
$fami=$fami."1";
}else{
$fami=$fami."0";
}
if(isset($papa)){
echo "Papa: ".$papa."<br>";
$fami=$fami."1";
}else{
$fami=$fami."0";
}
if(isset($hnos)){
echo "Hermanos: ".$hnos."<br>";
$fami=$fami."1";
}else{
$fami=$fami."0";
}

if($radRelFam==2){
$radRelFam="B";
}else if($radRelFam==1){
$radRelFam="R";
}else {
$radRelFam="M";
}

//Verificar si ya tiene registrados peso y estatura
$senQuery="SELECT fm_peso, fm_talla, fm_peso_diagnostico FROM alumnos_ficha_medica where no_ficha='$ficha' and no_control='$control'";

$resulQuery=$con->query($senQuery);
$rows = mysqli_fetch_array($resulQuery);
if($rows[0]!=0 && $rows[1]!=0){
$diagImc=$rows[2];
$sen="UPDATE alumnos_ficha_medica set fm_edad=$edad,  fm_enfermedad=$radEnf, fm_enfermedad_detalle='$enfermedad', fm_seguro='$seguro', fm_seguro_otro='$seg', fm_alergias=$radAlergia, fm_alergias_detalle='$alergia', fm_alergias_med=$radAlergMed, fm_alergias_med_detalle='$alergiaMed', fm_med=$radMed, fm_med_detalle='$Medicamento', fm_enf_padres='$enf', fm_enf_padres_detalles='$enfOtra', fm_enf_padres_diagnostico='$diagPred', fm_opc_esc='$prioridad', fm_carr_trunca=$radCar, fm_carr_trunca_detalle='$car', fm_conf_fam='$fami', fm_con_fam_otros='$famOtros', fm_relac_fam='$radRelFam' where no_ficha='$ficha' AND no_control='$control'";
}
else{
$sen="UPDATE alumnos_ficha_medica set fm_edad=$edad, fm_peso=$peso, fm_talla=$estatura, fm_imc=$imc, fm_peso_diagnostico='$diagImc', fm_enfermedad=$radEnf, fm_enfermedad_detalle='$enfermedad', fm_seguro='$seguro', fm_seguro_otro='$seg', fm_alergias=$radAlergia, fm_alergias_detalle='$alergia', fm_alergias_med=$radAlergMed, fm_alergias_med_detalle='$alergiaMed', fm_med=$radMed, fm_med_detalle='$Medicamento', fm_enf_padres='$enf', fm_enf_padres_detalles='$enfOtra', fm_enf_padres_diagnostico='$diagPred', fm_opc_esc='$prioridad', fm_carr_trunca=$radCar, fm_carr_trunca_detalle='$car', fm_conf_fam='$fami', fm_con_fam_otros='$famOtros', fm_relac_fam='$radRelFam' where no_ficha='$ficha' AND no_control='$control'";
}
//echo "<br>".$sen;
$resul=$con->query($sen);

//Tabla alumnos_folio
$sentencia="UPDATE alumnos_folio SET f_ficha_med=1 where no_ficha='$ficha'";
$result=$con->query($sentencia);

//Tabla caracterizacion
$sentCarac="UPDATE alumnos_caracterizacion SET tut_probmed_peso='$diagImc', tut_probmed_enf='$enfermedad', tut_probmed_alergias='$alergia', tut_probmed_alergmed='$alergiaMed', tut_probmed_enf_hered='$diagPred', tut_opc_esc='$prioridad', tut_carrera_trunca='$car' WHERE se_no_ficha='$ficha'";
$resCarac=$con->query($sentCarac);
//	echo "<br>".$sentCarac;
header("location: test.php");
?>
</body>
</html>