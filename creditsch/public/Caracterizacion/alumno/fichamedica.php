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
          function regresar() {
            setTimeout(function(){window.location.href=("test.php")} , 0); 
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
         <a><span><i>Inicio / Test / Trayectoria</i></span></a>
         <span class='right_ab'>
            <a href='test.php'><strong> Regresar</strong></a>
        </span>
      </div>
      <?PHP 
         session_start();
         require_once '../conexion/conexion.php';
         $con=new mysqli($host,$user,$pwd,$bd);
         if($con->connect_error){
            die("Fallo la conexion a MySQL ");
         }
         $ficha=$_SESSION["ficha"];
         $control=$_SESSION["control"];

         $consulta="SELECT f_ficha_med FROM alumnos_folio WHERE no_ficha='$ficha'";
         $mostrar= $con->query($consulta);
         $rows = mysqli_fetch_array($mostrar);
         if($rows[0]==1)
         {
            echo "<script type='text/javascript'>regresar()</script>"; 
         }

         $senQuery="SELECT fm_peso, fm_talla FROM alumnos_ficha_medica where no_ficha='$ficha' and no_control='$control'";
         $resulQuery=$con->query($senQuery);
         $rows = mysqli_fetch_array($resulQuery);
         $talla=$rows['fm_talla'];
         $peso=$rows['fm_peso']
      ?>
      <section class='tabs'>
         <div class='contenedor-1' align='justify'>
            <form id="form1" name="form1" method="post" action="fichamedica2.php">
               <center>
               <table width="800" border="0">
                  <tr>
                     <td width="152"><pp>Edad:</pp></td>
                     <td width="152"><pp>Peso:</pp></td>
                     <td width="152"><pp>Estatura: </pp></td>
                     
                  </tr>
                  <tr>
                     <td>
                        <input name="txedad" type="text" id="txedad" size="6" required />
                     </td>
                     <td>
                     <?PHP 
                        if ($peso==0){
                           echo"
                           <input name='txpeso' type='number' id='txpeso' size='6' min='30' max='140' step='0.1' required />
                            <pp>(kg)</pp>";
                        }
                        else {
                           echo"
                           <input name='txpeso' type='number' id='txpeso' size='6' value='$peso' disabled />
                            <pp>(kg)</pp>";
                        }
                     ?>
                     </td>
                     <td>
                     <?PHP 
                        if ($talla==0){
                            echo"
                        <input name='txestatura' type='number' id='txestatura' min='1.30' max='2.20' step='0.01' size='6' required /> 
                           <pp>(m)</pp>";
                        }
                        else
                           echo"
                        <input name='txestatura' type='number' id='txestatura' size='6' value='$talla' disabled /> 
                           <pp>(m)</pp>";
                     ?>
                        
                     </td>
                     
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     <td width="152"><pp><br>¿Padeces alguna enfermedad?</pp></td>
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     <td width="100">
                        <input type="radio" name="radEnf" id="radio" value="1" required />
                        <pp>Si</pp>
                     </td>
                     <td>
                        <input type="radio" name="radEnf" id="radio2" value="0" required />
                        <pp>No</pp>
                     </td>
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     <td>
                        <input name="txenfermedad" type="text" id="txenfermedad" size="60" placeholder="¿Cuál?" />
                     </td>
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     <td width="50%"><pp><br>¿Cuentas con algun tipo de seguro?</pp></td>
                     <td width="50%"><pp><br>¿Cual?</pp></td>
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     <td width="100"><input type="radio" name="radSeg" id="radio3" value="1" required />
                        <pp>Si</pp></td>
                     <td><input type="radio" name="radSeg" id="radio4" value="0" required />
                        <pp>No</pp></td>
                     <td width="100"><input name="chkIssste" type="checkbox" id="chkIssste" value="1" />
                        <pp>ISSSTE</pp></td>
                     <td width="100"><input name="chkImss" type="checkbox" id="chkImss" value="1" />
                        <pp>IMSS</pp></td>
                     <td width="200"><input name="chkSP" type="checkbox" id="chkSP" value="1" />
                        <pp>Seguro Popular</pp></td>
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     <td width="50%"></td>
                     <td><input name="txseguro" type="text" id="textfield3" size="35" placeholder="Otro" /></td>
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     
                  </tr>
                  
               </table>
               <table width="800" border="0">
                  <tr>
                     <td><br><pp>¿Padeces de alguna alergia?</pp></td>
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     <td width="100"><input type="radio" name="radAlergia" id="radio5" value="1" required />
                        <pp>Si</pp></td>
                     <td><input type="radio" name="radAlergia" id="radio6" value="0" required />
                        <pp>No</pp></td>
                     
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     <td><input name="txalergia" type="text" id="txalergia" size="60" placeholder="¿Cuál?" /></td>
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     <td><br><pp>¿Eres alergico a algun medicamento?</pp></td>
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     <td width="100"><input type="radio" name="radAlergiaMed" id="radio5" value="1" required />
                        <pp>Si</pp></td>
                     <td><input type="radio" name="radAlergiaMed" id="radio6" value="0" required />
                        <pp>No</pp></td>
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     <td><input name="txalergiaMed" type="text" id="txalergiaMed" size="60" placeholder="¿Cuál?" /></td>
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     <td ><br><pp>¿Actualmente, tomas algún medicamento?</pp></td>                     
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     <td width="100"><input type="radio" name="radMed" id="radio12" value="1" required />
                        <pp>Si</pp></td>
                     <td><input type="radio" name="radMed" id="radio13" value="0" required />
                        <pp>No</pp></td>
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     <td><input name="txMedicamento" type="text" id="txMedicamento" size="60" placeholder="¿Cuál?" /></td>
                  </tr>
                  <tr>
                     <td><br><pp>¿Tus papás padecen o padecieron alguna de estas enfermedades?</pp></td>
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     <td><input name="chkD" type="checkbox" id="chkD" value="1" /> 
                        <pp>Diabetes</pp></td>
                        
                     <td><input name="chkEC" type="checkbox" id="chkEC" value="1" /> 
                        <pp>Enfermedades del corazon</pp></td>
                  </tr>
                  <tr>
                     <td><input name="chkPA" type="checkbox" id="chkPA" value="1" /> 
                        <pp>Presion Alta</pp></td>
                     <td><input name="chkEC" type="checkbox" id="chkEC" value="1" /> 
                        <pp>Enfermedades cerebrales</pp></td>
                  </tr>
                  <tr>
                     <td><input name="chkC" type="checkbox" id="chkC" value="1" /> 
                        <pp>Cancer</pp></td>
                     <td><input name="chkIR" type="checkbox" id="chkIR" value="1" />
                        <pp>Insuficiencia Renal</pp></td>
                     
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     <td><input name="txenfermedadCon" type="text" id="txenfermedadCon" size="60" placeholder="Otra" /></td>
                  </tr>
                  <tr>
                     <td><br><pp>¿Has estudiado alguna  carrera técnica o trunca?</pp></td>
                     
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     <td width="100"><input type="radio" name="radCar" id="radio7" value="1" required />
                        <pp>Si</pp></td>
                     <td><input type="radio" name="radCar" id="radio8" value="0" required />
                        <pp>No</pp></td>
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     <td><input name="txcarrera" type="text" id="txcarrera" size="60" placeholder="¿Cuál?" /></td>
                  </tr>
                  <tr>
                     <td><br><pp>¿Quienes conforman tu familia?</pp></td>
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     <td width="100"><input name="chkFM" type="checkbox" id="chkFM" value="1" />
                        <pp>Mamá</pp></td>
                     <td width="100"><input name="chkFP" type="checkbox" id="chkFP" value="1" />
                        <pp>Papá</pp></td>
                     <td width="150"><input name="chkFH" type="checkbox" id="chkFH" value="1" />
                        <pp>Hermanos</pp></td>
                     <td>
                        <input name="txfamOtros" type="text" id="txfamOtros" size="40" placeholder="Otros (Esposa, Hijos, etc.)" /></td>
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     <td><br><pp>¿Como es tu relación familiar?</pp></td>
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     <td width="100"><input type="radio" name="radRF" id="radio9" value="2" required />
                        <pp>Buena</pp></td>
                     <td width="110"><input type="radio" name="radRF" id="radio10" value="1" required />
                        <pp>Regular</pp></td>
                     <td><input type="radio" name="radRF" id="radio11" value="0" required />
                        <pp>Mala</pp></td>
                  </tr>
               </table>
               <table width="800" border="0">
                  <tr>
                     <td><br>
                        <pp>En tu prioridad de escuelas a ingresar para estudiar tu carrera, el Tec de Ciudad Hidalgo lo elegiste en cual de las siguientes opciones:</pp>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <select name="cmbtxprioridad" id="cmbtxprioridad" required>
                           <option></option>
                           <option>Primera</option>
                           <option>Segunda</option>
                           <option>Tercera</option>
                           <option>Ultima</option>
                        </select>
                     </td>
                  </tr>
               </table>
                  <input type="submit" name="button" id="button" value="Guardar Datos" />
               </center>
            </form>
         </div>
      </section>
   </body>
</html>

