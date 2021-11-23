                <?php 
                        $contador=1;
                        $contadorR=1;
                        $conn = mysqli_connect("localhost","root","Sistemas2018","becas");
                        if($conn ->connect_error)
                            die($conn->connect_error);
                        
            $sql2 = "SELECT p.pregunta,t.valor1,t.valor2,t.tipo FROM preguntas p JOIN tipoPregunta t ON p.tipo=t.tipo where t.tipo='op1' and id_pregunta=1";
                $result = $conn->query($sql2);
                    if ($result->num_rows) {
                           while ($row=$result->fetch_assoc()) {
                echo "<div >";
                echo "<p align=center> •{$row["pregunta"]}"."<br>";
                echo "<input type='radio' name='group".$contadorR."' value='Si' checked><b>{$row["valor1"]}</b>\n\r";
                echo "<input type='radio' name='group".$contadorR."' value='No' checked><b>{$row["valor2"]}</b>";
                            ++$contadorR;
                echo "</div>";
                        }
                        }else{
                            echo "No encontro nada";
                        }
                $sql2 = "SELECT p.pregunta,t.valor1,t.valor2,t.valor3,t.valor4,t.valor5,t.valor6,p.tipo from preguntas p join tipoPregunta t on p.tipo=t.tipo  WHERE id_pregunta BETWEEN 2 AND 7 group by p.id_pregunta";
                $result = $conn->query($sql2);
                    if ($result->num_rows) {
                                while ($row=$result->fetch_assoc()) {
                                     $valor2=$row['valor2'];
                                     $valor3=$row['valor3'];
                                     $valor6=$row['valor6'];
                                     $tipo=$row['tipo'];
                    if ($tipo=='opción') {
             echo "<div id=contenedor>";
             echo "<p align=center>•{$row["pregunta"]}"."<br>";
             echo "<input type=number required=required name=pgt".$contador." min=1 max=10 step=1>"."</p>";
             echo "</div>";
                ++$contador;
                    }else if ($valor2!='' && $valor3=='' ) {
             echo "<div id=contenedor>";
             echo "<p align=center>•{$row["pregunta"]}";
             echo "<select name='{$row["pregunta"]}' align=center>";
             echo "<option value='{$row["valor1"]}'>{$row["valor1"]}</option>";
             echo "<option value='{$row["valor2"]}'>{$row["valor2"]}</option>";
             echo "</select>";
             echo "</div>";
                                         
                                     }else if ($valor6!='') {
             echo "<div id=contenedor>";
             echo "<p align=center>•{$row["pregunta"]}";
             echo "<select name='{$row["pregunta"]}' align=center>";
             echo "<option value='{$row["valor1"]}'>{$row["valor1"]}</option>";
             echo "<option value='{$row["valor2"]}'>{$row["valor2"]}</option>";
             echo "<option value='{$row["valor3"]}'>{$row["valor3"]}</option>";
             echo "<option value='{$row["valor4"]}'>{$row["valor4"]}</option>";
             echo "<option value='{$row["valor5"]}'>{$row["valor5"]}</option>";
             echo "<option value='{$row["valor6"]}'>{$row["valor6"]}</option>";
             echo "</select>";
             echo "</div>";
        }else{
            echo "<div id=contenedor>";
            echo "<p align=center>•{$row["pregunta"]}"."<br>";
            echo "<input type=text required=required name=pgt".$contador.">"."</p>";
            echo "</div>";
             ++$contador;
         }
     }
 }else{
       echo "No encontro nada";
   }
                                    
?>

<?php 
      $conn = mysqli_connect("localhost","root","Sistemas2018","becas");
           if($conn ->connect_error)
                die($conn->connect_error);
//Llama de pregunta 8 hasta la 12
        $sql2 = "SELECT p.pregunta,t.valor1,t.valor2,t.valor3,t.valor4,t.valor5,t.valor6,t.valor7,t.valor8,t.valor9,p.tipo from preguntas p join tipo t on p.tipo=t.tipo  WHERE id_pregunta BETWEEN 8 AND 12 group by p.id_pregunta";
             $result = $conn->query($sql2); if ($result->num_rows) {
                                while ($row=$result->fetch_assoc()) {
                                    $valor9=$row['valor2'];
                 if ($valor9!='') {
                      echo "<div id=contenedor>";
             echo "<p align=center>•{$row["pregunta"]}";
             echo "<select name='{$row["pregunta"]}' align=center>";
             echo "<option value='{$row["valor1"]}'>{$row["valor1"]}</option>";
             echo "<option value='{$row["valor2"]}'>{$row["valor2"]}</option>";
             echo "<option value='{$row["valor3"]}'>{$row["valor3"]}</option>";
             echo "<option value='{$row["valor4"]}'>{$row["valor4"]}</option>";
             echo "<option value='{$row["valor5"]}'>{$row["valor5"]}</option>";
             echo "<option value='{$row["valor6"]}'>{$row["valor6"]}</option>";
             echo "<option value='{$row["valor7"]}'>{$row["valor7"]}</option>";
             echo "<option value='{$row["valor8"]}'>{$row["valor8"]}</option>";
             echo "<option value='{$row["valor9"]}'>{$row["valor9"]}</option>";
             echo "</select>";
             echo "</div>";
                 }else{
                    echo "<div id=contenedor>";
                    echo "<p align=center>•{$row["pregunta"]}"."<br>";
                    echo "<input type=text required=required name=pgt".$contador.">"."</p>";
                    echo "</div>";
                        ++$contador;
                        }
            }
        }else{
            echo "No encontro nada";
             }
        ?>
    <?php
                    $conn = mysqli_connect("localhost","root","","becas");
                        if($conn ->connect_error)
                            die($conn->connect_error);
                    $sql2 = "SELECT pregunta from preguntas WHERE id_pregunta BETWEEN 13 AND 17";
                            $result = $conn->query($sql2);
                            if ($result->num_rows) {
                                while ($row=$result->fetch_assoc()) {
                    echo "<div id=contenedor>";
                    echo "<p align=center>•{$row["pregunta"]}"."<br>";
                    echo "<input type=text required=required name=pgt".$contador.">"."</p>";
                    echo "</div>";
                    ++$contador;
                        }
                    }else{
                    echo "No encontro nada";
                        }
                    ?>
                <?php 
                    $conn = mysqli_connect("localhost","root","","becas");
                        if($conn ->connect_error)
                            die($conn->connect_error);
                    $sql2 = "SELECT pregunta from preguntas WHERE id_pregunta BETWEEN 18 AND 19";
                    $result = $conn->query($sql2);
                    if ($result->num_rows) {
                                while ($row=$result->fetch_assoc()) {
                                      echo "<div id=contenedor>";
                    echo "<p align=center>•{$row["pregunta"]}"."<br>";
                    echo "<input type=text required=required name=pgt".$contador.">"."</p>";
                    echo "</div>";
                    ++$contador;
                        }
                    }else{
                    echo "No encontro nada";
                      }
                      ?>
                <div id=boton>
                      <input type="submit" value="Guardar">
                </div>