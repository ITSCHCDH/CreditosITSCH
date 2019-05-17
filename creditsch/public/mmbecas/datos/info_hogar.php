<div id="datos6">
	<?php 
    $contadorR=14;
	$conn = mysqli_connect("localhost","root","","becas");
            if($conn ->connect_error)
                 die($conn->connect_error);
                        echo "<br>";// salto de linea
                        $sql2 = "SELECT pregunta FROM preguntas WHERE id_pregunta =37";
                            $result = $conn->query($sql2);

             if ($result->num_rows) {
             	while ($row=$result->fetch_assoc()) {
                  	echo "<div >";
                            echo "<p>•{$row["pregunta"]}"."<br>";
                            echo "</div>";

                  }
                     }else{
                 echo "No encontro nada";
                  }

                    $sql3 = "SELECT v.pregunta,t.valor1,t.valor2 from viviendapre v join tipo t on v.tipo=t.tipo";
                            $result = $conn->query($sql3);
                            echo "<table width=100% border=1px>";

             if ($result->num_rows) {
             	while ($row=$result->fetch_assoc()) {
                  	echo "<div >";
                  	echo "<tr>";
                            echo "<td><p>{$row["pregunta"]}"."</td>";
                            echo "<td><input type='radio' name='group".$contadorR."' value='Si' checked> {$row["valor1"]}\t";
                            echo "<input type='radio' name='group".$contadorR."' value='No' checked> {$row["valor2"]} </td>";
                            ++$contadorR;
                    echo "</tr>";
                    echo "</div>";        
                            echo "</div>";

                  }
                     }else{
                 echo "No encontro nada";
             }
                            echo "</table>";

            ?>
            <?php 
   
$conn = mysqli_connect("localhost","root","","becas");
            if($conn ->connect_error)
                 die($conn->connect_error);
                        echo "<br>";// salto de linea
                        

                $sql = "SELECT p.pregunta,t.valor1,t.valor2,t.valor3,t.valor4,t.valor5,t.valor6,t.valor7,t.valor8,t.valor9,t.valor10,t.valor11 from preguntas p join tipo t on p.tipo=t.tipo where id_pregunta between 38 and 40";
                            $result = $conn->query($sql);
                            

             if ($result->num_rows) {
              while ($row=$result->fetch_assoc()) {
                    $valor1=$row['valor1'];
                    $valor10=$row['valor10'];

                         if($valor1==''){
                          echo "<div >";
                          echo "<p> •{$row["pregunta"]}"."<br>";
                          echo "</div>";


                         } else if($valor1 == 'caja'){
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

                         else if($valor10==''){
                             echo "<div >";
                             echo "<p>•{$row["pregunta"]}"."<br>";
               echo "<input type='checkbox' name='option1' value='option1' >{$row["valor1"]}<br>";
               echo "<input type='checkbox' name='option1' value='option2' >{$row["valor2"]}<br>";
               echo "<input type='checkbox' name='option1' value='option3' >{$row["valor3"]}<br>";
               echo "<input type='checkbox' name='option1' value='option4' >{$row["valor4"]}<br>";
               echo "<input type='checkbox' name='option1' value='option5' >{$row["valor5"]}<br>";
               echo "<input type='checkbox' name='option1' value='option6' >{$row["valor6"]}<br>";
               echo "<input type='checkbox' name='option1' value='option7' >{$row["valor7"]}<br>";
               echo "<input type='checkbox' name='option1' value='option8' >{$row["valor8"]}<br>";
               echo "<input type='checkbox' name='option1' value='option9' >{$row["valor9"]}<br>";
               echo "</div>";


                         }else if($valor10!=''){
                          echo "<div >";
                            echo "<p> •{$row["pregunta"]}"."<br>";
                            echo "<input type='radio' name='group".$contadorR."' value='{$row["valor1"]}' checked>{$row["valor1"]}<br>";
                            echo "<input type='radio' name='group".$contadorR."' value='{$row["valor2"]}' checked>{$row["valor2"]}<br>";
                            echo "<input type='radio' name='group".$contadorR."' value='{$row["valor3"]}' checked>{$row["valor3"]}<br>";
                            echo "<input type='radio' name='group".$contadorR."' value='{$row["valor4"]}' checked>{$row["valor4"]}<br>";
                            echo "<input type='radio' name='group".$contadorR."' value='{$row["valor5"]}' checked>{$row["valor5"]}<br>";
                            echo "<input type='radio' name='group".$contadorR."' value='{$row["valor6"]}' checked>{$row["valor6"]}<br>";
                            echo "<input type='radio' name='group".$contadorR."' value='{$row["valor7"]}' checked>{$row["valor7"]}<br>";
                            echo "<input type='radio' name='group".$contadorR."' value='{$row["valor8"]}' checked>{$row["valor8"]}<br>";
                            echo "<input type='radio' name='group".$contadorR."' value='{$row["valor9"]}' checked>{$row["valor9"]}<br>";
                            echo "<input type='radio' name='group".$contadorR."' value='{$row["valor10"]}' checked>{$row["valor10"]}<br>";
                            echo "<input type='radio' name='group".$contadorR."' value='{$row["valor11"]}' checked>{$row["valor11"]}";
                            ++$contadorR;
                            echo "</div>";

                         }

                        }
                     }else{
                 echo "No encontro nada";

                 
            }

   ?>
</div>

<div>
	<input type="submit" value="Guardar" id="guardar2">
</div>