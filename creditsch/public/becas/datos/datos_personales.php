    <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js">
    </script>
      <link rel = "stylesheet"
         href = "https://fonts.googleapis.com/icon?family=Material+Icons"> 
        <script>
         $(document).ready(function() {
            $('select').material_select();
         });
      </script>
                <?php 
                  $contador=1;
                        $contadorR=1;
                        $conn = mysqli_connect("localhost","root","Sistemas2018","becas");
                        if($conn ->connect_error)
                            die($conn->connect_error);
                        //CONSULTA 1 
            $sql = "SELECT p.pregunta,t.valor1,t.valor2,t.tipo FROM preguntas p JOIN tipoPregunta t ON p.tipo=t.tipo where t.tipo='op1' and id_pregunta=1";
                $result = $conn->query($sql);
                    if ($result->num_rows) {
                     while ($row=$result->fetch_assoc()) {
              
                echo "<form action=# class=center-align>";
                echo "<p><label>•{$row["pregunta"]}</label></p>";
                echo "<p><label><input name=group1 type=radio checked /><span>{$row["valor1"]}&nbsp;</span></label>";
                echo "<label><input name=group1 type=radio /><span>{$row["valor2"]}</span></label></p>";
                echo "</form>";
        
                      }
                  }else{
                echo "No encontro nada";
                  }
                     //CONSULTA 2
           echo "<div class=row >";
           echo "<form class='col s12 class=center-align'>";
           echo "<div class=row>";
           $sql = "SELECT pregunta from preguntas where id_pregunta=2;";
                $result = $conn->query($sql);
                if ($result->num_rows) {
                      while ($row=$result->fetch_assoc()) {
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
                }else{
                echo "No encontro nada";
                  }
                //CONSULTA 3
            $sql = "SELECT pregunta from preguntas where id_pregunta between 3 and 5;";
                $result = $conn->query($sql);
                if ($result->num_rows) {
                  while ($row=$result->fetch_assoc()) {
           echo "<div class='input-field col s12 m4'>";
           echo "<input id={$row["pregunta"]} type=text class=validate>";
           echo "<label for={$row["pregunta"]}>{$row["pregunta"]}</label>";
           echo "</div>";
         }
          }else{
                echo "No encontro nada";
              }
        echo "</div>";
        echo "</form>";
        echo "</div>";
         //CONSULTA 4
            $sql = "SELECT p.pregunta,t.valor1,t.valor2,t.valor3,t.valor4,t.valor5,t.valor6,t.valor6,t.valor7,t.valor8,t.valor9 from preguntas p join tipoPregunta t on p.tipo=t.tipo  WHERE id_pregunta BETWEEN 6 AND 8 group by p.id_pregunta";
           echo "<div class=row >";
           echo "<form class='col s12 m12 class=center-align'>";
           echo "<div class=row>";
                $result = $conn->query($sql);
                if ($result->num_rows) {
                  while ($row=$result->fetch_assoc()) {
                     $valor2=$row['valor2'];
                     $valor3=$row['valor3'];
                     $valor7=$row['valor7'];
                     $valor9=$row['valor9'];
        if ($valor3!='' &&  $valor7 =='') {
    echo "<div class='row col s12 m4'>";
    echo "<label>{$row["pregunta"]}</label>";
    echo "<select class='browser-default '>";
    echo "<option value='' disabled selected>Elige una opción</option>";
    echo "<option value={$row["valor1"]}>{$row["valor1"]}</option>";
    echo "<option value={$row["valor2"]}>{$row["valor2"]}</option>";
    echo "<option value={$row["valor3"]}>{$row["valor3"]}</option>";
    echo "<option value={$row["valor4"]}>{$row["valor4"]}</option>";
    echo "<option value={$row["valor5"]}>{$row["valor5"]}</option>";
    echo "<option value={$row["valor6"]}>{$row["valor6"]}</option>";
    echo "</select>";
    echo "</div>";
      }else if ($valor2!='' &&  $valor3 =='') {
    echo "<div class='row col s12 m4'>";
    echo "<label>{$row["pregunta"]}</label>";
    echo "<select class='browser-default '>";
    echo "<option value='' disabled selected>Elige una opción</option>";
    echo "<option value={$row["valor1"]}>{$row["valor1"]}</option>";
    echo "<option value={$row["valor2"]}>{$row["valor2"]}</option>";
    echo "</select>";
    echo "</div>";
      }elseif ($valor9!='') {
        echo "<div class='row col s12 m4'>";
    echo "<label>{$row["pregunta"]}</label>";
    echo "<select class='browser-default '>";
    echo "<option value='' disabled selected>Elige una opción</option>";
    echo "<option value={$row["valor1"]}>{$row["valor1"]}</option>";
    echo "<option value={$row["valor2"]}>{$row["valor2"]}</option>";
    echo "<option value={$row["valor3"]}>{$row["valor3"]}</option>";
    echo "<option value={$row["valor4"]}>{$row["valor4"]}</option>";
    echo "<option value={$row["valor5"]}>{$row["valor5"]}</option>";
    echo "<option value={$row["valor6"]}>{$row["valor6"]}</option>";
    echo "<option value={$row["valor7"]}>{$row["valor7"]}</option>";
    echo "<option value={$row["valor8"]}>{$row["valor8"]}</option>";
    echo "<option value={$row["valor9"]}>{$row["valor9"]}</option>";
    echo "</select>";
    echo "</div>";
      }
      
         }
          }else{
                echo "No encontro nada";
              }
        echo "</div>";
        echo "</form>";
        echo "</div>";  
    //CONSULTA 5
            $sql = "SELECT pregunta from preguntas where id_pregunta between 9 and 11;";
                $result = $conn->query($sql);
           echo "<div class=row >";
           echo "<form class='col s12 m12 class=center-align'>";
           echo "<div class=row>";
                if ($result->num_rows) {
                  while ($row=$result->fetch_assoc()) {
           echo "<div class='input-field col s12 m4'>";
           echo "<input id={$row["pregunta"]} type=text class=validate>";
           echo "<label for={$row["pregunta"]}>{$row["pregunta"]}</label>";
           echo "</div>";
         }
          }else{
                echo "No encontro nada";
              }
        echo "</div>";
        echo "</form>";
        echo "</div>";
        //CONSULTA 6
            $sql = "SELECT pregunta from preguntas where id_pregunta between 12 and 14;";
           echo "<div class=row >";
           echo "<form class='col s12 m12 class=center-align'>";
           echo "<div class=row>";
                $result = $conn->query($sql);
                if ($result->num_rows) {
                  while ($row=$result->fetch_assoc()) {
           echo "<div class='input-field col s12 m4'>";
           echo "<input id={$row["pregunta"]} type=text class=validate>";
           echo "<label for={$row["pregunta"]}>{$row["pregunta"]}</label>";
           echo "</div>";
         }
          }else{
                echo "No encontro nada";
              }
        echo "</div>";
        echo "</form>";
        echo "</div>";
        //CONSULTA 6
            $sql = "SELECT pregunta from preguntas where id_pregunta between 15 and 17;";
           echo "<div class=row >";
           echo "<form class='col s12 m12 class=center-align'>";
           echo "<div class=row>";
                $result = $conn->query($sql);
                if ($result->num_rows) {
                  while ($row=$result->fetch_assoc()) {
           echo "<div class='input-field col s12 m4'>";
           echo "<input id={$row["pregunta"]} type=text class=validate>";
           echo "<label for={$row["pregunta"]}>{$row["pregunta"]}</label>";
           echo "</div>";
         }
          }else{
                echo "No encontro nada";
              }
        echo "</div>";
        echo "</form>";
        echo "</div>";
     //CONSULTA 7
            $sql = "SELECT pregunta from preguntas where id_pregunta between 18 and 19;";
           echo "<div class=row >";
           echo "<form class='col s12 m12 class=center-align'>";
           echo "<div class=row>";
                $result = $conn->query($sql);
                if ($result->num_rows) {
                  while ($row=$result->fetch_assoc()) {
           echo "<div class='input-field col s12 m4'>";
           echo "<input id={$row["pregunta"]} type=text class=validate>";
           echo "<label for={$row["pregunta"]}>{$row["pregunta"]}</label>";
           echo "</div>";
         }
          }else{
                echo "No encontro nada";
              }
        echo "</div>";
        echo "</form>";
        echo "</div>";


          ?>
          <div id=boton>
                      <input type="submit" value="Guardar">
                </div>
