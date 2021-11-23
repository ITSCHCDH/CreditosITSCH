            <div>
                    <?php 
                        $contador=1;
                        $conn = mysqli_connect("localhost","root","","becas");
                        if($conn ->connect_error)
                            die($conn->connect_error);
                        echo "<br>";// salto de linea
                        $sql2 = "SELECT p.pregunta,t.valor1,t.valor2 FROM preguntas p JOIN tipo t ON p.tipo=t.tipo where t.tipo='op1' and id_pregunta=1";

                            $result = $conn->query($sql2);

                            if ($result->num_rows) {
                                while ($row=$result->fetch_assoc()) {
                            echo "<div align=center>";
                            echo "<p> {$row["pregunta"]}"."<br>";
                            echo "<input type='radio' name='groupl' value='Si' checked>{$row["valor1"]}\n\r";
                            echo "<input type='radio' name='groupl' value='Si' checked>{$row["valor2"]}";
                            echo "</div>";
                        
                                        }
                                    }else{

                                        echo "No encontro nada";
                     
                            }
                            $sql2 = "SELECT pregunta from preguntas WHERE id_pregunta BETWEEN 2 AND 7";
                            $result = $conn->query($sql2);

                            if ($result->num_rows) {
                                while ($row=$result->fetch_assoc()) {
                            echo "<p align=center>{$row["pregunta"]}"."<br>";
                            echo "<input type=text required=required name=pgt".$contador.">"."</p>";
                            ++$contador;
                                        }

                                    }else{

                                        echo "No encontro nada";
                                    }
                                    
                              ?>

                </div><!--Fin Datos1-->
                <div id="datos2">
                    <?php 
                        $contador=1;
                        $conn = mysqli_connect("localhost","root","","becas");
                        if($conn ->connect_error)
                            die($conn->connect_error);
                        echo "<br>";// salto de linea
                   $sql2 = "SELECT pregunta from preguntas WHERE id_pregunta BETWEEN 8 AND 12";
                            $result = $conn->query($sql2);

                            if ($result->num_rows) {
                                while ($row=$result->fetch_assoc()) {
                            echo "<p align=center>{$row["pregunta"]}"."<br>";
                            echo "<input type=text required=required name=pgt".$contador.">"."</p>";
                            ++$contador;
                                    }

                                    }else{

                                        echo "No encontro nada";
                                    }
                                    
                              ?>

                </div><!--Fin Datos2-->
                <div id="datos3">
                    <?php 
                        $contador=1;
                        $conn = mysqli_connect("localhost","root","","becas");
                        if($conn ->connect_error)
                            die($conn->connect_error);
                        echo "<br>";// salto de linea
       
                        
                            $sql2 = "SELECT pregunta from preguntas WHERE id_pregunta BETWEEN 13 AND 17";
                            $result = $conn->query($sql2);

                            if ($result->num_rows) {
                                while ($row=$result->fetch_assoc()) {
                            echo "<p align=center>{$row["pregunta"]}"."<br>";
                            echo "<input type=text required=required name=pgt".$contador.">"."</p>";
                            ++$contador;
                                        }

                                    }else{

                                        echo "No encontro nada";
                                    }
                                    
                              ?>
                </div><!--Fin Datos3-->
                <div id="datos4">
                    <?php 
                        $contador=1;
                        $conn = mysqli_connect("localhost","root","","becas");
                        if($conn ->connect_error)
                            die($conn->connect_error);
                        echo "<br>";// salto de linea
       
                        
                            $sql2 = "SELECT pregunta from preguntas WHERE id_pregunta BETWEEN 18 AND 19";
                            $result = $conn->query($sql2);

                            if ($result->num_rows) {
                                while ($row=$result->fetch_assoc()) {
                            echo "<p align=center>{$row["pregunta"]}"."<br>";
                            echo "<input type=text required=required name=pgt".$contador.">"."</p>";
                            ++$contador;
                                        }

                                    }else{

                                        echo "No encontro nada";
                                    }
                                    
                              ?>
                </div> <!--Fin Datos4-->
                <div id=boton>
                      <input type="submit" value="Guardar">
                </div>