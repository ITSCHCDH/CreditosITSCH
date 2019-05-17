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
                echo "<form action=# >";
                echo "<td><p><label>•{$row["pregunta"]}</label></p></td>";
                echo "<td><label><input name='group".$contadorR."'type=radio checked /><span>{$row["valor1"]}&nbsp;</span></label>";
                echo "<label><input name='group".$contadorR."' type=radio /><span>{$row["valor2"]}</span></label></p></td>";
                echo "</form>";
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
                  echo "<div class='row col s12 m4'>";
    echo "<label>{$row["pregunta"]}</label>";
    echo "<select class='browser-default '>";
    echo "<option value='' disabled selected>Elige una opción</option>";
    echo "<option value=1>1</option>";
    echo "<option value=2>2</option>";
    echo "<option value=3>3</option>";
    echo "<option value=1>4</option>";
    echo "<option value=2>5</option>";
    echo "<option value=3>6</option>";
    echo "<option value=1>7</option>";
    echo "<option value=2>8</option>";
    echo "<option value=3>9</option>";
    echo "</select>";
    echo "</div>";

                }

                         else if($valor10==''){
                           echo "<form action=#>";
                           echo "<label>{$row["pregunta"]}</label>";
                           echo "<p><label><input type=checkbox /><span>{$row["valor1"]}</span></label></p>";
                           echo "<p><label><input type=checkbox /><span>{$row["valor2"]}</span></label></p>";
                           echo "<p><label><input type=checkbox /><span>{$row["valor3"]}</span></label></p>";
                           echo "<p><label><input type=checkbox /><span>{$row["valor4"]}</span></label></p>";
                           echo "<p><label><input type=checkbox /><span>{$row["valor5"]}</span></label></p>";
                           echo "<p><label><input type=checkbox /><span>{$row["valor6"]}</span></label></p>";
                           echo "<p><label><input type=checkbox /><span>{$row["valor7"]}</span></label></p>";
                           echo "<p><label><input type=checkbox /><span>{$row["valor8"]}</span></label></p>";
                           echo "<p><label><input type=checkbox /><span>{$row["valor9"]}</span></label></p>";
                           echo "</form>";

                         }else if($valor10!=''){
                          echo "<form action=#>";
                           echo "<label>{$row["pregunta"]}</label>";
                           echo "<p><label><input type=checkbox /><span>{$row["valor1"]}</span></label></p>";
                           echo "<p><label><input type=checkbox /><span>{$row["valor2"]}</span></label></p>";
                           echo "<p><label><input type=checkbox /><span>{$row["valor3"]}</span></label></p>";
                           echo "<p><label><input type=checkbox /><span>{$row["valor4"]}</span></label></p>";
                           echo "<p><label><input type=checkbox /><span>{$row["valor5"]}</span></label></p>";
                           echo "<p><label><input type=checkbox /><span>{$row["valor6"]}</span></label></p>";
                           echo "<p><label><input type=checkbox /><span>{$row["valor7"]}</span></label></p>";
                           echo "<p><label><input type=checkbox /><span>{$row["valor8"]}</span></label></p>";
                           echo "<p><label><input type=checkbox /><span>{$row["valor9"]}</span></label></p>";
                           echo "<p><label><input type=checkbox /><span>{$row["valor10"]}</span></label></p>";
                           echo "<p><label><input type=checkbox /><span>{$row["valor11"]}</span></label></p>";
                           echo "</form>";

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