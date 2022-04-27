<p>&nbsp;</p>
<form name="form1" method="post" action="">
   <?php
session_start();
require_once '../conexion/conexion.php';
$con=new mysqli($host,$user,$pwd,$bd);
if($con->connect_error){
	die("Fallo la conexion a MySQL ");
}
//Recibir datos
$res[0]=$_REQUEST['ov1'];
$res[1]=$_REQUEST['ov2'];
$res[2]=$_REQUEST['ov3'];
$res[3]=$_REQUEST['ov4'];
$res[4]=$_REQUEST['ov5'];
$res[5]=$_REQUEST['ov6'];
$res[6]=$_REQUEST['ov7'];
$res[7]=$_REQUEST['ov8'];
$res[8]=$_REQUEST['ov9'];
$res[9]=$_REQUEST['ov10'];
$res[10]=$_REQUEST['ov11'];
$res[11]=$_REQUEST['ov12'];
$res[12]=$_REQUEST['ov13'];
$res[13]=$_REQUEST['ov14'];
$res[14]=$_REQUEST['ov15'];
$res[15]=$_REQUEST['ov16'];
$res[16]=$_REQUEST['ov17'];
$res[17]=$_REQUEST['ov18'];
$res[18]=$_REQUEST['ov19'];
$res[19]=$_REQUEST['ov20'];
$ss=$res[0]+$res[10];
$ep=$res[1]+$res[11];
$v=$res[2]+$res[12];
$ap=$res[3]+$res[13];
$ms=$res[4]+$res[14];
$og=$res[5]+$res[15];
$ct=$res[6]+$res[16];
$cl=$res[7]+$res[17];
$mc=$res[8]+$res[18];
$al=$res[9]+$res[19];

//Recuperar los valores de las variables de SESSION, y asignarlos a las locales

$ss=$_SESSION["ss"];
$ep=$_SESSION["ep"];
$v=$_SESSION["v"];
$ap=$_SESSION["ap"];
$ms=$_SESSION["ms"];
$og=$_SESSION["og"];
$ct=$_SESSION["ct"];
$cl=$_SESSION["cl"];
$mc=$_SESSION["mc"];
$al=$_SESSION["al"];

$ficha=$_SESSION["ficha"];
$control=$_SESSION["control"];
$carrera=$_SESSION["carrera"];

//Sumar los valores del formulario anterior, con los de la sesion
$ss=$ss+$res[0]+$res[10];
$ep=$ep+$res[1]+$res[11];
$v=$v+$res[2]+$res[12];
$ap=$ap+$res[3]+$res[13];
$ms=$ms+$res[4]+$res[14];
$og=$og+$res[5]+$res[15];
$ct=$ct+$res[6]+$res[16];
$cl=$cl+$res[7]+$res[17];
$mc=$mc+$res[8]+$res[18];
$al=$al+$res[9]+$res[19];


//almacenar los resultados de las variables de sesion en los campos de la tabla
echo "<br>SS= ".$ss;
echo "<br>EP= ".$ep;
echo "<br>V= ".$v;
echo "<br>AP= ".$ap;
echo "<br>MS= ".$ms;
echo "<br>OG= ".$og;
echo "<br>CT= ".$ct;
echo "<br>CL= ".$cl;
echo "<br>MC= ".$mc;
echo "<br>AL= ".$al;

$dvoc=$ss.$ep.$v.$ap.$ms.$og.$ct.$cl.$mc.$al;

echo "<br>Orientacion Vocacional= ".$dvoc;

$datos[0][0]="SS";
$datos[0][1]=$ss;
$datos[1][0]="EP";
$datos[1][1]=$ep;
$datos[2][0]="V";
$datos[2][1]=$v;
$datos[3][0]="AP";
$datos[3][1]=$ap;
$datos[4][0]="MS";
$datos[4][1]=$ms;
$datos[5][0]="OG";
$datos[5][1]=$og;
$datos[6][0]="CT";
$datos[6][1]=$ct;
$datos[7][0]="CL";
$datos[7][1]=$cl;
$datos[8][0]="MC";
$datos[8][1]=$mc;
$datos[9][0]="AL";
$datos[9][1]=$al;

//Ordenar para obtener mayores y menores
$var=1;
$varl=0;
for($i=0;$i<9;$i++){
	for($j=$i+1;$j<10;$j++){
		if($datos[$i][$var]>$datos[$j][$var]){
			$aux=$datos[$i][$var];
			$auxl=$datos[$i][$varl];
			$datos[$i][$var]=$datos[$j][$var];
			$datos[$i][$varl]=$datos[$j][$varl];
			$datos[$j][$var]=$aux;
			$datos[$j][$varl]=$auxl;
		}
	}
}

$may1=$datos[9][0];
$may2=$datos[8][0];
$men1=$datos[0][0];
$men2=$datos[1][0];


for($i=0;$i<10;$i++){
	echo "Perfil: ".$datos[$i][0]." puntuacion: ".$datos[$i][1]."<br>";
}

echo "<br>El mayor es ".$datos[9][0]." con ".$datos[9][1];
echo "<br>El segundo mayor es: ".$datos[8][0]." con ".$datos[8][1];

echo "<br>El menor es ".$datos[0][0]." con ".$datos[0][1];
echo "<br>El segundo menor es: ".$datos[1][0]." con ".$datos[1][1];
//Determinar Acorde o NO
$consulta="SELECT dp_carrera FROM alumnos_datos_personales where se_no_ficha='$ficha'";
$res_con=$con->query($consulta);
$rows=mysqli_fetch_array($res_con);
$inge=$rows[0];
echo "<br>".$inge."<br>";
$acorde="No Acorde";
if($inge="INGENIERIA EN SISTEMAS COMPUTACIONALES"){
	if($may1=="CL" || $may1=="MC" || $may1=="OG" || $may1=="CT"
		|| $may2=="CL" || $may2=="MC" || $may2=="OG" || $may2=="CT"){
			$acorde="Acorde";
		}
}else if($inge="INGENIERIA INDUSTRIAL"){
	if($may1=="CL" || $may1=="MC" || $may1=="EP" 
		|| $may2=="CL" || $may2=="MC" || $may2=="EP"){
			$acorde="Acorde";
		}
}else if($inge="INGENIERIA MECATRONICA"){
	if($may1=="CL" || $may1=="MC" || $may1=="CT" 
		|| $may2=="CL" || $may2=="MC" || $may2=="CT"){
			$acorde="Acorde";
		}
}else if($inge="INGENIERIA BIOQUIMICA"){
	if($may1=="CL" || $may1=="EP" || $may1=="CT" 
		|| $may2=="CL" || $may2=="EP" || $may2=="CT"){
			$acorde="Acorde";
		}
}else if($inge="INGENIERIA EN GESTION EMPRESARIAL"){
	if($may1=="CL" || $may1=="EP" || $may1=="OG" 
		|| $may2=="CL" || $may2=="EP" || $may2=="OG"){
			$acorde="Acorde";
		}
}else if($inge="INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES"){
	if($may1=="CL" || $may1=="CT" || $may1=="OG" 
		|| $may2=="CL" || $may2=="CT" || $may2=="OG"){
			$acorde="Acorde";
		}
}else if($inge="INGENIERÍA EN NANOTECNOLOGÍA"){
	if($may1=="CL" || $may1=="MC" || $may1=="CT" 
		|| $may2=="CL" || $may2=="MC" || $may2=="CT"){
			$acorde="Acorde";
		}
}

//Registrar en la base de Datos STE
$sen="insert into alumnos_test_vocacional values ('$ficha','$control','$carrera',".$ss.",".$ep.",".$v.",".$ap.",".$ms.",".$og.",".$ct.",".$cl.",".$mc.",".$al.",'$may1','$may2','$men1','$men2','$acorde')";

$resultado=$con->query($sen);
echo $sen;

			$sentencia="UPDATE alumnos_folio SET f_test_vocac=1 where no_ficha='$ficha'";
			$result=$con->query($sentencia);

//Registrar en tabla de caracterizacion
$sentCarac="UPDATE alumnos_caracterizacion SET tut_orient_vocacional='$acorde' WHERE se_no_ficha='$ficha'";
$resCarac=$con->query($sentCarac);

echo $sentCarac;

header("location: test.php");
?>
</form>
<p>&nbsp;</p>
