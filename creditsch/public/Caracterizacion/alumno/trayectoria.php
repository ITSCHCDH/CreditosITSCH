<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
	</head>
	<body>
		<?php
		session_start();
		require_once '../conexion/conex_mysql.php';
		$con = new mysqli ($hostname,$username,$password,$database);
		if ($con->connect_errno){
			die ("Fallo la conexion a MySQL: (" .$con -> mysqli_connect_errno(). ") " . $con->mysqli_connect_error());
		}	

		// Guardar respuestas de SegmentoA

		$res[0]=$_REQUEST['rD1'];
		$res[1]=$_REQUEST['rD2'];
		$res[2]=$_REQUEST['rD3'];
		$res[3]=$_REQUEST['rD4'];
		$res[4]=$_REQUEST['rD5'];
		$res[5]=$_REQUEST['rD6'];
		$res[6]=$_REQUEST['rD7'];
		$res[7]=$_REQUEST['rD8'];
		$res[8]=$_REQUEST['rD9'];
		$res[9]=$_REQUEST['rD10'];
		$res[10]=$_REQUEST['rD11'];
		$res[11]=$_REQUEST['rD12'];
		$res[12]=$_REQUEST['rD13'];
		$res[13]=$_REQUEST['rD14'];


		$suma_sgD=0;
		$res_sgD="";
		for($x=0;$x<14;$x++){
			$suma_sgD+=$res[$x];		
			$res_sgD=$res_sgD.$res[$x];
		}

		//echo "<br>".$suma_sgD."<br>".$res_sgD;


		$ficha=$_SESSION["ficha"];
		$control=$_SESSION["control"];
		$carrera=$_SESSION["carrera"];

		//Calculos de Diagnosticos
		//Diag Depre -> SegB
		$SDep=$_SESSION["sumB"];

		if($SDep<=5){
			$DiagDep="Minimo";
		}else if($SDep<=9){
			$DiagDep="Leve";
		}else if($SDep<=14){
			$DiagDep="Moderado";
		}else{
			$DiagDep="Severo";
		}

		//Diag Auto -> SegC
		$SAuto=$_SESSION["sumC"];
		$resC=$_SESSION["resC"];
		$v1=0;
		$v2=0;
		$v3=0;
		$v4=0;
		$bDiag=0;
		for($i=0;$i<5;$i++){
			if($resC[$i]=='1'){
				$v1+=1;				
			}else if($resC[$i]=='2'){
				$v2+=1;				
			}else if($resC[$i]=='3'){
				$v3+=1;				
			}else if($resC[$i]=='4'){
				$v4+=1;				
			}
		}
		if($v1>$v2 &&  $v1>$v3 && $v1>$v4){
			$DiagAuto="Bajo";
			$bDiag=1;
		}else if($v2>$v1 &&  $v2>$v3 && $v2>$v4){
			$DiagAuto="Leve";
			$bDiag=1;
		}else if($v3>$v1 &&  $v3>$v2 && $v3>$v4){
			$DiagAuto="Bueno";
			$bDiag=1;
		}else if($v4>$v1 &&  $v4>$v2 && $v4>$v3){
			$DiagAuto="Alto";
			$bDiag=1;
		}
		if($bDiag==0){
			$vA=$$v1+$v2;
			$vB=$v3+$v4;
			if($vA>$vB){
				$DiagAuto="Leve";
			}else{
				$DiagAuto="Bueno";
			}
		}


		//Diag Adic -> SegA
		$SAdi=$_SESSION["sumA"];

		if($SAdi==0){
			$DiagAdi="Bien";
		}else if($SAdi==1){
			$DiagAdi="Leve";
		}else if($SAdi==2){
			$DiagAdi="Moderado";
		}else{
			$DiagAdi="Grave";
		}

		//Diag Hab -> SegD

		$SHab=$suma_sgD;

		if($SHab<=7){
			$DiagHab="Malo";
		}else if($SHab<=11){
			$DiagHab="Regular";
		}else {
			$DiagHab="Bueno";
		}




		//Dep SegB
		//Auto SegC
		//Adic SegA
		//Hab  SegD
		$sen="INSERT INTO alumnos_test_trayectoria VALUES ('$ficha','$control',$SDep,'$DiagDep',$SAuto,'$DiagAuto',$SAdi,'$DiagAdi',$SHab,'$DiagHab');";

		$resultado=$con->query($sen);

			$sentencia="UPDATE alumnos_folio SET f_test_trayec=1 where no_ficha='$ficha'";
			$result=$con->query($sentencia);
			//echo $sentencia;
		//Registrar en tabla de caracterizacion
		$sentCarac="UPDATE alumnos_caracterizacion SET tut_probpsico_depresion='$DiagDep', tut_probpsico_autoestima='$DiagAuto', tut_probmed_ad='$DiagAdi', tut_hab_estudio='$DiagHab' WHERE se_no_ficha='$ficha'";
		$resCarac=$con->query($sentCarac);

		//echo $sentCarac;
		header("location: test.php");
	?>
	</body>
</html>