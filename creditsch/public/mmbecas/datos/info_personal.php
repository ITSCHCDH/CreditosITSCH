<div id="datos6">
<div id="datos0">
	<?php 
        $contador=15;
        $contadorR=2;
        $conn = mysqli_connect("localhost","root","","becas");
            if($conn ->connect_error)
                 die($conn->connect_error);
                        $sql1 = "SELECT p.pregunta,t.valor1,t.valor2,t.valor3,t.valor4,t.valor5 from preguntas p join tipo t on p.tipo=t.tipo  WHERE id_pregunta BETWEEN 20 AND 28 group by p.id_pregunta";
                            $result = $conn->query($sql1);

             if ($result->num_rows) {

                  while ($row=$result->fetch_assoc()) {
                  	$valor1=$row['valor1'];
                  	$valor2=$row['valor2'];
                  	$valor3=$row['valor3'];
                  	$valor4=$row['valor4'];
                  	$valor5=$row['valor5'];
                    if ($valor1=='') {
                       echo "<div>";
                   echo "<p>•{$row["pregunta"]}</p>";
                   echo "<input type=text required=required name=pgt".$contador.">"."</p>";
                   echo "</div>";
                   ++$contador;
                    }else if($valor3==''){
                    echo "<div >";
                   echo "<p>•{$row["pregunta"]}</p>";
                   echo "<td><input type='radio' name='group".$contadorR."' value='Si' checked> {$row["valor1"]}<br>";
                   echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor2"]} </td>";
                   echo "</div>";
                   ++$contadorR;
                  
                  
                  }else if($valor5==''){
                    echo "<div >";
                   echo "<p>•{$row["pregunta"]}</p>";
                   echo "<td><input type='radio' name='group".$contadorR."' value='Si' checked> {$row["valor1"]}<br>";
                   echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor2"]}<br>";
                   echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor3"]}<br>";
                   echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor4"]}</td>";
                   echo "</div>";
                   ++$contadorR;
                 }else  {
                  echo "<div >";
                   echo "<p>•{$row["pregunta"]}</p>";
                   echo "<td><input type='radio' name='group".$contadorR."' value='Si' checked> {$row["valor1"]}<br>";
                   echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor2"]}<br>";
                   echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor3"]}<br>";
                   echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor4"]}<br>";
                   echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor5"]}</td>";
                   echo "</div>";
                   ++$contadorR;
                   
                 }
                }
                     }else{
                 echo "No encontro nada";
            }

	 ?>
</div>


<div id="datos1">
	<?php 
        $conn = mysqli_connect("localhost","root","","becas");
            if($conn ->connect_error)
                 die($conn->connect_error);
                        echo "<br>";// salto de linea
                        $sql2 = "SELECT p.pregunta,t.valor1,t.valor2,t.valor3,t.valor4,t.valor5,t.valor6 from preguntas p join tipo t on p.tipo=t.tipo  WHERE id_pregunta BETWEEN 29 AND 36 group by p.id_pregunta";
                            $result = $conn->query($sql2);

             if ($result->num_rows) {

                  while ($row=$result->fetch_assoc()) {
                  	$valor1=$row['valor1'];
                  	$valor2=$row['valor2'];
                  	$valor3=$row['valor3'];
                  	$valor4=$row['valor4'];
                    $valor5=$row['valor5'];
                    $valor6=$row['valor6'];
                    if ($valor1=='caja') {
                      echo "<div>";
                      echo "<p align=center>•{$row["pregunta"]}"."<br>";
                      echo "<input type=number required=required name=pgt".$contador." min=1 max=10 step=1>"."</p>";
                      echo "</div>";
                       ++$contador;
                    }elseif ($valor1=='' && $valor2=='') {
                       echo "<div>";
                   echo "<p>•{$row["pregunta"]}</p>";
                   echo "<input type=text required=required name=pgt".$contador.">"."</p>";
                   echo "</div>";
                    ++$contador;
                     
                    }else if($valor3==''){
                        echo "<div >";
                   echo "<p>•{$row["pregunta"]}</p>";
                   echo "<td><input type='radio' name='group".$contadorR."' value='Si' checked> {$row["valor1"]}<br>";
                   echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor2"]} </td>";
                   echo "</div>";
                   ++$contadorR;
                 }elseif ($valor4=='') {
                   echo "<div >";
                   echo "<p>•{$row["pregunta"]}</p>";
                   echo "<td><input type='radio' name='group".$contadorR."' value='Si' checked> {$row["valor1"]}<br>";
                   echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor2"]}<br>";
                   echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor3"]}</td>";
                   echo "</div>";
                   ++$contadorR;
                  
                 }elseif ($valor6=='') {
                 echo "<div >";
                   echo "<p>•{$row["pregunta"]}</p>";
                   echo "<td><input type='radio' name='group".$contadorR."' value='Si' checked> {$row["valor1"]}<br>";
                   echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor2"]}<br>";
                   echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor3"]}<br>";
                   echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor4"]}<br>";
                   echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor5"]}</td>";
                   echo "</div>";
                   ++$contadorR;
                 }else{
                  echo "<div >";
                   echo "<p>•{$row["pregunta"]}</p>";
                   echo "<td><input type='radio' name='group".$contadorR."' value='Si' checked> {$row["valor1"]}<br>";
                   echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor2"]}<br>";
                   echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor3"]}<br>";
                   echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor4"]}<br>";
                   echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor5"]}<br>";
                   echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor6"]}</td>";
                   echo "</div>";
                   ++$contadorR;

                 }
                  
                 }
                   
            }else{
                 echo "No encontro nada";
            }

   ?>
</div>
</div>

<div id="boton2">
	<input type="submit" value="Guardar" id="guardar">
</div>
