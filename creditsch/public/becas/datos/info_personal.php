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
           echo "<div class='input-field col s12 m4'>";
           echo "<input id=pgt".$contador." type=text class=validate>";
           echo "<label for={$row["pregunta"]}>{$row["pregunta"]}</label>";
           echo "</div>";
           ++$contador;
                    }else if($valor3==''){

                echo "<form action=# >";
                echo "<p><label>•{$row["pregunta"]}</label></p>";
                echo "<p><label><input name='group".$contadorR."'type=radio checked /><span>{$row["valor1"]}&nbsp;</span></label></p>";
                echo "<p><label><input name='group".$contadorR."' type=radio /><span>{$row["valor2"]}</span></label></p>";
                echo "</form>";
                   ++$contadorR;
                  
                  
                  }else if($valor5==''){
                echo "<form action=#>";
                echo "<p><label>•{$row["pregunta"]}</label></p>";
                echo "<p><label><input name='group".$contadorR."'type=radio checked /><span>{$row["valor1"]}&nbsp;</span></label>";
                echo "<p><label><input name='group".$contadorR."' type=radio /><span>{$row["valor2"]}</span></label></p>";
                echo "<p><label><input name='group".$contadorR."' type=radio /><span>{$row["valor3"]}</span></label></p>";
                echo "<p><label><input name='group".$contadorR."' type=radio /><span>{$row["valor4"]}</span></label></p>";
                echo "</form>";
                   ++$contadorR;
                 }else  {
                echo "<form action=#>";
                echo "<p><label>•{$row["pregunta"]}</label></p>";
                echo "<p><label><input name='group".$contadorR."'type=radio checked /><span>{$row["valor1"]}&nbsp;</span></label>";
                echo "<p><label><input name='group".$contadorR."' type=radio /><span>{$row["valor2"]}</span></label></p>";
                echo "<p><label><input name='group".$contadorR."' type=radio /><span>{$row["valor3"]}</span></label></p>";
                echo "<p><label><input name='group".$contadorR."' type=radio /><span>{$row["valor4"]}</span></label></p>";
                echo "<p><label><input name='group".$contadorR."' type=radio /><span>{$row["valor5"]}</span></label></p>";
                echo "</form>";
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
                    }elseif ($valor1=='' && $valor2=='') {
           echo "<div class='input-field col s12 m4'>";
           echo "<input id={$row["pregunta"]} type=text class=validate>";
           echo "<label for={$row["pregunta"]}>{$row["pregunta"]}</label>";
           echo "</div>";
                     
                    }else if($valor3==''){
                       echo "<form action=# >";
                echo "<p><label>•{$row["pregunta"]}</label></p>";
                echo "<p><label><input name='group".$contadorR."'type=radio checked /><span>{$row["valor1"]}&nbsp;</span></label></p>";
                echo "<p><label><input name='group".$contadorR."' type=radio /><span>{$row["valor2"]}</span></label></p>";
                echo "</form>";
                   ++$contadorR;
                 }elseif ($valor4=='') {
                echo "<form action=# >";
                echo "<p><label>•{$row["pregunta"]}</label></p>";
                echo "<p><label><input name='group".$contadorR."'type=radio checked /><span>{$row["valor1"]}&nbsp;</span></label></p>";
                echo "<p><label><input name='group".$contadorR."' type=radio /><span>{$row["valor2"]}</span></label></p>";
                echo "<p><label><input name='group".$contadorR."' type=radio /><span>{$row["valor3"]}</span></label></p>";
                echo "</form>";
                   ++$contadorR;
                  
                 }elseif ($valor6=='') {
                  echo "<form action=# >";
                echo "<p><label>•{$row["pregunta"]}</label></p>";
                echo "<p><label><input name='group".$contadorR."'type=radio checked /><span>{$row["valor1"]}&nbsp;</span></label></p>";
                echo "<p><label><input name='group".$contadorR."' type=radio /><span>{$row["valor2"]}</span></label></p>";
                echo "<p><label><input name='group".$contadorR."' type=radio /><span>{$row["valor3"]}</span></label></p>";
                echo "<p><label><input name='group".$contadorR."' type=radio /><span>{$row["valor4"]}</span></label></p>";
                echo "<p><label><input name='group".$contadorR."' type=radio /><span>{$row["valor5"]}</span></label></p>";
                echo "</form>";
                   ++$contadorR;
                 }else{
                  echo "<form action=# >";
                echo "<p><label>•{$row["pregunta"]}</label></p>";
                echo "<p><label><input name='group".$contadorR."'type=radio checked /><span>{$row["valor1"]}&nbsp;</span></label></p>";
                echo "<p><label><input name='group".$contadorR."' type=radio /><span>{$row["valor2"]}</span></label></p>";
                echo "<p><label><input name='group".$contadorR."' type=radio /><span>{$row["valor3"]}</span></label></p>";
                echo "<p><label><input name='group".$contadorR."' type=radio /><span>{$row["valor4"]}</span></label></p>";
                echo "<p><label><input name='group".$contadorR."' type=radio /><span>{$row["valor5"]}</span></label></p>";
                 echo "<p><label><input name='group".$contadorR."' type=radio /><span>{$row["valor6"]}</span></label></p>";
                echo "</form>";
                   ++$contadorR;

                 }
                  
                 }
                   
            }else{
                 echo "No encontro nada";
            }

   ?>
</div>

<div id="boton2">
	<input type="submit" value="Guardar" id="guardar">
</div>
