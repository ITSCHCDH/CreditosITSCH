<!DOCTYPE html>
<html>
   <head>
      <meta charset='UTF-8'/>
      <meta http-equiv='X-UA-Compatible' contenedor='IE=edge,chrome=1'>
      <title>STE-ITSCH</title>
      <meta name='viewport' contenedor='width=device-width, initial-scale=1.0'>     
      <link rel='stylesheet' type='text/css' href='../css/demo.css' />
      <link rel='stylesheet' type='text/css' href='../css/style.css' />
      <link rel='stylesheet' type='text/css' href='../css/sbimenu.css' />            
      
      <script src='http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js'></script>
      <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js'></script>
      <script type='text/javascript' src='../js/jquery.easing.1.3.js'></script>
      <script type='text/javascript' src='../js/jquery.bgImageMenu.js'></script>
      <script type='text/javascript'>
         $(function() {
            $('#sbi_container').bgImageMenu({
               defaultBg: '../pic/5.jpg',
               menuSpeed: 300,
               type: {
                  mode: 'horizontalSlide',
                  speed: 250,
                  easing: 'jswing',
                  seqfactor: 100
               }
            });
         }); 
      </script>
      <script type="text/javascript"> 
         function alertar() {
            jError("No Existe Registro", "Error");
          }
      </script>
      <script>
         $(document).ready(function (){
            $('.solo-numero').keyup(function (){
               this.value = (this.value + '').replace(/[^0-9]/g, '');
            });
         });
      </script>
        
    <!--[if lt IE 9]>
      <style>
        .contenedor{
          height: auto;
          margin: 0;  
        }
        .contenedor div {
          position: relative;
        }
      </style>
    <![endif]-->
   </head>
   <body>
      <div class='container'>
         <br>
         <div class='topbar'>
            <a><span>Alumno </span></a>
            <span class='right_ab'>
               <a href='index.php'><strong> Ir a Inicio</strong></a>
            </span>
         </div>
      </div>
      <br>
      <div id='sbi_container' class='sbi_container'>
         <div class='sbi_panel' data-bg='../pic/1.jpg'></div>
      </div>
      <div class='topbar'>
         <a><span><i>Inicio / Test / Folio</i></span></a>
         <span class='right_ab'>
            <a href='test.php'><strong> Regresar</strong></a>
        </span>
      </div>

	<?php
		session_start();
		//Obtener ficha 
		$ficha=$_SESSION["ficha"];
		
		require_once '../conexion/conexion.php';
		$con=new mysqli($host,$user,$pwd,$bd);
		if($con->connect_error){
			die("Fallo la conexion a MySQL ");
		}

		$consulta= "SELECT f_folio FROM alumnos_folio WHERE no_ficha='$ficha'";
		$resultado=$con->query($consulta);
		$row=mysqli_fetch_array($resultado);
		$folio=$row['f_folio'];
		
		

		if (!empty($folio)){
			echo "<center><folio>FOLIO:$folio</folio></center>";
		}
		else{
			//Obtener la curp
			$sent="SELECT se_curp FROM alumnos_datos_personales WHERE se_no_ficha='$ficha'";
			$res=$con->query($sent);
			$rows=mysqli_fetch_array($res);
			$curp=$rows[0];

			//echo "FICHA: ".$ficha."<br>CURP: ".$curp;

			//Generar Folio
			//Convertir a Hexa la ficha
			$num=$ficha*1;
			$hexa=$curp[0].$curp[1].$curp[2].$curp[3];
			$resid="";
			while($num>0){
				$div=$num%16;
				//echo "<br>Num: ".$num."<br> Divisor: ".$div;
				if($div<10){
					$resid=$resid.$div;
				}else if($div==10) {
					$resid=$resid."A";
				}else if($div==11) {
					$resid=$resid."B";
				}else if($div==12) {
					$resid=$resid."C";
				}else if($div==13) {
					$resid=$resid."D";
				}else if($div==14) {
					$resid=$resid."E";
				}else if($div==15) {
					$resid=$resid."F";
				}
				$num=(int)($num/16);
			}
			$tam = strlen($resid);
			 for ($i=$tam-1,$j=0; $i>=0; $i--,$j++){
			   	$invercad[$j] = $resid[$i];	
			} 
			for($x=0;$x<$tam;$x++){
				$hexa=$hexa.$invercad[$x];
			}
			echo "<center><folio>FOLIO:$hexa</folio></center>";
			//echo "<br>FOLIO: ".$hexa;

			$sent="UPDATE alumnos_folio SET f_folio='$hexa' WHERE no_ficha='$ficha'";
			$res=$con->query($sent);
			//echo $sent;
		}
	?>
</body>
</html>