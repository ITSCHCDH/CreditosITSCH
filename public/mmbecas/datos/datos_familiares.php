<div id="datos8">
	<?php
  $contador=20;
  $contadorR=39;
  $contadorT=1;
  $op=1;
	$conn = mysqli_connect("localhost","root","Sistemas2018","becas");
            if($conn ->connect_error)
                 die($conn->connect_error);
                        echo "<br>";// salto de linea
              $sql = "SELECT pregunta FROM preguntas WHERE id_pregunta=41";
                            $result = $conn->query($sql);

             if ($result->num_rows) {
             	while ($row=$result->fetch_assoc()) {
                       echo "<div >";
                             echo "<p>•{$row["pregunta"]}</p>";
                             echo "<select = name='numerico'>";
                              echo "<option value='1'>1</option>";
                              echo "<option value='2'>2</option>";
                              echo "<option value='3'>3</option>";
                              echo "<option value='4'>4</option>";
                              echo "<option value='5'>5</option>";
                              echo "<option value='6'>6</option>";
                              echo "<option value='7'>7</option>";
                              echo "<option value='8'>8</option>";
                              echo "<option value='9'>9</option>";
                              echo "<option value='10'>10</option>";
                              echo "</select>";
                       echo "</div>";
                  }
                     }else{
                 echo "No encontro nada";
                  }

   $sql2 = "SELECT pregunta FROM preguntas WHERE id_pregunta=42";
                            $result = $conn->query($sql2);
                              if ($result->num_rows) {
              while ($row=$result->fetch_assoc()) {
                       echo "<div >";
                             echo "<p>•{$row["pregunta"]}</p>";
                             
                       echo "</div>";
                  }
                     }else{
                 echo "No encontro nada";
                  }
                  ?>
                  <table width="100%" border="1px" align="center">
<tr align="center">
        <td>Nombre</td>
        <td>Edad</td>
        <td>Parentesco</td>
        <td>Grado Académico</td>
        <td>Ocupación</td>
 </tr>
 <?php  
 $bandera=1;
while ( $bandera <= 5) {
  echo "<tr>";
  echo "<td> <input id=datos type=text required=required name=vtable".$contadorT.">"."</td>";
  ++$contadorT;
  echo "<td> <input id=datos type=text required=required name=vtable".$contadorT.">"."</td>";
  ++$contadorT;
  echo "<td> <input id=datos type=text required=required name=vtable".$contadorT.">"."</td>";
  ++$contadorT;
  echo "<td> <input id=datos type=text required=required name=vtable".$contadorT.">"."</td>";
  ++$contadorT;
  echo "<td> <input id=datos type=text required=required name=vtable".$contadorT.">"."</td>";
  echo "</tr>";
  ++$contadorT;
  ++$bandera;
}

 ?>
 </table>


 <?php  

$sql3 = "SELECT p.pregunta,t.valor1,t.valor2,t.valor3,t.valor4,t.valor5,p.tipo from preguntas p join tipo t on p.tipo=t.tipo  WHERE id_pregunta BETWEEN 43 AND 46 group by p.id_pregunta";
    $result = $conn->query($sql3);
      if ($result->num_rows) {
              while ($row=$result->fetch_assoc()) {
                $valor1=$row['valor1'];
                $valor3=$row['valor3'];
                $valor5=$row['valor5'];

                if($valor1==''){
                  echo "<div >";
                   echo "<p>•{$row["pregunta"]}</p>";
                   echo "<input type=text required=required name=pgt".$contador.">"."</p>";
                   echo "</div>";
                   ++$contador;
                   

                }else if ($valor3=='') {
                   echo "<div >";
                   echo "<p>•{$row["pregunta"]}</p>";
                   echo "<td><input type='radio' name='group".$contadorR."' value='Si' checked> {$row["valor1"]}\t";
                   echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor2"]} </td>";
                   echo "</div>";
                   ++$contadorR;
                  
                }else if($valor5!=''){
                     echo "<div >";
                   echo "<p>•{$row["pregunta"]}</p>";
               echo "<input type='checkbox' name='option".$op."' value='option1' >{$row["valor1"]}<br>";
               echo "<input type='checkbox' name='option".$op."' value='option2' >{$row["valor2"]}<br>";
               echo "<input type='checkbox' name='option".$op."' value='option3' >{$row["valor3"]}<br>";
               echo "<input type='checkbox' name='option".$op."' value='option4' >{$row["valor4"]}<br>";
               echo "<input type='checkbox' name='option".$op."' value='option5' >{$row["valor5"]}<br>";
                   echo "</div>";
                   ++$op;

                }
                      
                  }
                     }else{
                 echo "No encontro nada";
                  }



 ?>
	
</div>
<div id="datos8">
  <?php  

  $sql4 = "SELECT p.pregunta,t.valor1,t.valor2,t.valor3,t.valor4,t.valor5,p.tipo from preguntas p join tipo t on p.tipo=t.tipo  WHERE id_pregunta BETWEEN 47 AND 51 group by p.id_pregunta";
    $result = $conn->query($sql4);
      if ($result->num_rows) {
              while ($row=$result->fetch_assoc()) {
                $valor1=$row['valor1'];
                $valor3=$row['valor3'];
                $valor5=$row['valor5'];
                $tipo=$row['tipo'];

                if($valor1==''){

                   echo "<div >";
                   echo "<p>•{$row["pregunta"]}</p>";
                   echo "<input type=text required=required name=pgt".$contador.">"."</p>";
                   echo "</div>";
                   ++$contador;

                }else if($valor1 == 'caja'){
                  echo "<div >";
                    echo "<p>•{$row["pregunta"]}</p>";
                             echo "<select = name='numerico'>";
                                echo "<option value='1'>1</option>";
                                echo "<option value='2'>2</option>";
                                echo "<option value='3'>3</option>";
                                echo "<option value='4'>4</option>";
                                echo "<option value='5'>5</option>";
                                echo "<option value='6'>6</option>";
                                echo "<option value='7'>7</option>";
                                echo "<option value='8'>8</option>";
                                echo "<option value='9'>9</option>";
                                echo "<option value='10'>10</option>";
                                echo "</select>";
                    echo "</div>";

                }else if ($valor3=='') {
                   echo "<div >";
                   echo "<p>•{$row["pregunta"]}</p>";
                   echo "<td><input type='radio' name='group".$contadorR."' value='Si' checked> {$row["valor1"]}\t";
                   echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor2"]} </td>";
                   echo "</div>";
                   ++$contadorR;
                  
                }else if($valor5!=''){
                     echo "<div >";
                   echo "<p>•{$row["pregunta"]}</p>";
               echo "<input type='checkbox' name='option".$op."' value='option1' >{$row["valor1"]}<br>";
               echo "<input type='checkbox' name='option".$op."'value='option2' >{$row["valor2"]}<br>";
               echo "<input type='checkbox' name='option".$op."'value='option3' >{$row["valor3"]}<br>";
               echo "<input type='checkbox' name='option".$op."'value='option4' >{$row["valor4"]}<br>";
               echo "<input type='checkbox' name='option".$op."' value='option5' >{$row["valor5"]}<br>";
                   echo "</div>";
                   ++$op;

                }
                      
                  }
                     }else{
                 echo "No encontro nada";
                  }



  ?>
	
</div>
<div>
  <input type="submit" value="Guardar" id="guardar3">
</div>