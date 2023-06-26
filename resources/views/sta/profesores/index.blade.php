@extends('template.molde')

@section('title','Alumnos')

@section('ruta')
    <label class="label label-success"> <a href="#">STA</a> / Profesores</label> 
@endsection

@section('contenido')
    <div class="row">
        <div class="col-sm-3">
            <input type="hidden" name="gse_clave" id="gse_clave" readonly>
            <label for="carrera" id="labCarreras">Carrera</label>
            <div class="input-group mb-3">               
                <select name="carrera" id="carrera" class="form-control" required>
                    <option value="">Selecciona una carrera</option>
                    @foreach ($carreras as $car)            
                        <option value="{{ $car->car_Clave }}">{{ $car->car_Nombre }}</option>
                    @endforeach
                </select>                            
            </div>
        </div>
        <div class="col-sm-3" id="divProfesores" >
            <label for="profesores"  id="labProfesores">Profesores</label>
            <div class="input-group mb-3">               
                <select name="profesor" id="profesor" class="form-control" required>
                    
                </select>               
            </div>
        </div> 
        <input type="hidden" name="grupo" id="grupo" readonly>     
        <div class="col-sm-3" id="divMaterias" >
            <label for="materia"  id="labMaterias">Materias</label>
            <div class="input-group mb-3">               
                <select name="materia" id="materia" class="form-control" required>
                  
                </select>                
            </div>           
        </div>
        <div class="col-sm-1" id="divFiltrar" >
            <div class="row" style="text-align: center">
                <h6>Filtrar</h6>
            </div>
            <div class="row">
                <a href="#" type="button" class="btn btn-success" id="findUnits" title="filtrar datos" ><i class="fas fa-filter"></i></a>
            </div>
        </div>   
         <div class="col-sm-3">
           
        </div>    
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="row" style="text-align: center">
                <h6>Unidades</h6>                
                <hr>
            </div>
            <div class="row" id="unidades">
               
            </div>
        </div>  
        <div class="col-sm-1"></div>
        <div class="col-sm-5">
            <div class="row" style="text-align: center">
                <h6>Datos del filtro</h6> 
                <hr>
            </div>
            <div class="row">
                <p id="datosFiltro" style="font-size: 10px"></p>
                <p id="unidad" hidden ></p>
            </div>
        </div>      
    </div>
    <br> 
    <table class="table" id="listaCali">
        <thead>
            <tr>
                <th>No.</th>
                <th>Número de Control</th>
                <th>Nombre Completo</th>
                <th>Calificación</th>
                <th>Motivos de Reprobación</th>
                <th>Comentarios	</th>
                <th>Confirmar</th>
            </tr>
        </thead>
        <tbody>
           
        </tbody>
    </table>

    @section('js')
        <script type="text/javascript">
            //Codigo para filtrar los docentes que pertenecen a una carrera
            $('#divProfesores').hide(); 
            $('#divMaterias').hide(); 
            $('#divFiltrar').hide();          
            // Genera token para solicitudes POST
            $.ajaxSetup( {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
			} );
            //Codigo para obtener profesores de una carrera
            $(document).ready(function(){                             
                $("#carrera").change(function(e){
                    e.preventDefault(); 
                    txtFiltro();
                    //Función para obtener los profesores de una carrera
                    carrera = $('#carrera').val();                     
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        url:"{{ route('profesores.find') }}",
                        data:{
                            carrera:carrera                      
                        },
                        success: function(profesores){                                                      
                            $('#profesor').empty();                                                    
                            $.each(profesores, function(i, item) {                                
                                $('#profesor').prepend(`<option value=${item.cat_Clave}>${item.cat_Nombre} ${item.cat_ApePat} ${item.cat_ApeMat}</option>`);
                            });     
                            $('#profesor').prepend(`<option value="" selected>Selecciona un profesor</option>`);  
                            //Ponemos los datos de la carrera en datos del filtro                                                  
                        },
                        error: function(e){                        
                            console.log('Error al buscar los profesores de esta carrera',e);                        
                        }
                    });
                    $('#divProfesores').show();                                   
                });  
                $("#profesor").change(function(e){
                    e.preventDefault(); 
                    txtFiltro();
                    //Función para obtener las materias de un profesor
                    profesor = $('#profesor').val(); 
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        url:"{{ route('materias.find') }}",
                        data:{                           
                            profesor:profesor                                                 
                        },
                        success: function(materias){                               
                            //Verificamos si existe un mensaje de error
                            if(materias.error==500){
                                $('#materia').empty();  
                                $('#materia').prepend(`<option value="" selected>No tiene materias asignadas</option>`);
                                swal('Error',materias.message,'error');                                
                                return;
                            }    
                            else{
                                $('#materia').empty();                                                    
                                $.each(materias, function(i, item) {
                                    valor = JSON.stringify(item); 
                                    $('#materia').prepend(`<option value= '${valor}'>${item.ret_NomCompleto}  ${item.gse_Observaciones}</option>`);
                                });     
                                $('#materia').prepend(`<option value="" selected>Selecciona una materia</option>`);  
                            }                                         
                        },
                        error: function(e){                        
                            console.log('Error al buscar las materias de este profesor',e);                        
                        }
                    });
                    $('#divMaterias').show();                                   
                }); 
                //Función para obtener las unidades de una materia
                $("#materia").change(function(){
                    txtFiltro(); 
                    $('#divFiltrar').show();
                });                               
            });
          
            //Funcion para obtener las calificaciones de una unidad
            function getCalificaciones(unidad){  
                $("#unidad").text(unidad); 
                txtFiltro();                              
                strMateria=$('#materia').val();
                jsnMateria=JSON.parse(strMateria); 
                materia=jsnMateria.ret_Clave; 
                grupo=$('#grupo').val();     
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url:"{{ route('listaCali.find') }}",
                    data:{                                                                  
                        materia:materia,
                        unidad:unidad,
                        grupo:grupo
                    },
                    success: function(datos){                                                                                           
                        $("#gse_clave").val(datos['listaCali'][0].gse_Clave);                                                            
                        $("#listaCali > tbody").empty();  
                        van=0;                     
                        $.each(datos['listaCali'], function(i, item) {
                            if(item.lsc_Calificacion<70){
                                $.each(datos['coment'],function(x,com){
                                    van=0;
                                    if(com.no_control==item.alu_NumControl){
                                        //Repobado con comentarios
                                        $("#listaCali > tbody").append(`<tr><td>${i+1}</td> <td><input type="hidden" name="alu${i}" id="alu${i}" readonly value="${item.alu_NumControl}"><input type="hidden" name="lse_clave${i}" id="lse_clave${i}" readonly value="${item.lse_Clave}"> ${item.alu_NumControl}</td> <td>${item.alu_Nombre} ${item.alu_ApePaterno} ${item.alu_ApeMaterno}</td> <td style="color:red">${item.lsc_Calificacion}</td> <td> <select class="form-control" name="motivos${i}" id="motivos${i}" required> <option value="">Selecciona una opción</option> <option value="1">Responsabilidad alumno</option> <option value="2">Inasistencia</option> <option value="3">Complejidad materia</option> <option value="4">Otro</option> </select> </td> <td> <textarea required placeholder="Comentarios adicionales" name="comentarios${i}" id="comentarios${i}" rows="1" class="form-control">${com.comentario}</textarea> </td> <td><a onclick="guardarComentarios(${i})" type="button" class="btn btn-secondary">Guardar</a></td></tr>`);                                        
                                        $("#motivos"+i).val(com.motivos);//Seleccionamos la opcion de motivos seleccionada
                                        van=1;
                                        return false;  
                                    }                                                
                                });
                                if(van==0){
                                    //Reprobado sin comentarios
                                    $("#listaCali > tbody").append(`<tr><td>${i+1}</td> <td><input type="hidden" name="alu${i}" id="alu${i}" readonly value="${item.alu_NumControl}"><input type="hidden" name="lse_clave${i}" id="lse_clave${i}" readonly value="${item.lse_Clave}"> ${item.alu_NumControl}</td> <td>${item.alu_Nombre} ${item.alu_ApePaterno} ${item.alu_ApeMaterno}</td> <td style="color:red">${item.lsc_Calificacion}</td> <td> <select class="form-control" name="motivos${i}" id="motivos${i}" required> <option value="">Slecciona una opción</option> <option value="1">Responsabilidad alumno</option> <option value="2">Inasistencia</option> <option value="3">Complejidad materia</option> <option value="4">Otro</option> </select> </td> <td> <textarea required placeholder="Comentarios adicionales" name="comentarios${i}" id="comentarios${i}" rows="1" class="form-control"></textarea> </td> <td><a onclick="guardarComentarios(${i})" type="button" class="btn btn-secondary">Guardar</a></td></tr>`);
                                }                               
                            }
                            else{
                                //Alunos aprobados
                                $("#listaCali > tbody").append(`<tr><td>${i+1}</td> <td>${item.alu_NumControl}</td> <td>${item.alu_Nombre} ${item.alu_ApePaterno} ${item.alu_ApeMaterno}</td> <td>${item.lsc_Calificacion}</td> <td></td> <td></td> <td></td></tr>`);
                            }                                                                
                        });                        
                    },
                    error: function(e){                        
                        console.log('Error al buscar la lista de calificaciones de este grupo y unidad',e);                        
                    }
                });             
            }

            //Codigo para obtener las unidades de cada materia           
            $("#findUnits").click(function(e){                      
                e.preventDefault();               
                profesor = $('#profesor').val();                 
                strMateria=$('#materia').val();
                jsnMateria=JSON.parse(strMateria); 
                materia=jsnMateria.ret_Clave; 
                $('#grupo').val(jsnMateria.gse_Clave);
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url:"{{ route('units.find') }}",
                    data:{                                             
                        materia:materia
                    },
                    success: function(unidades){                        
                        botones = "";                        
                        for(i=0;i<unidades.ret_NumUnidades;i++)
                            botones += `<div class="col-sm-2"><a type="button" class="btn btn-info" onclick="getCalificaciones(${i+1})">Unidad ${i+1}</a></div>`;
                        $("#unidades").html(botones);
                    },
                    error: function(e){                        
                        console.log('Error al buscar los profesores de esta carrera',e);                        
                    }
                });
            });

            function guardarComentarios(r)
            {
                mot=$('#motivos'+r+' option:selected').val();
                com=$('#comentarios'+r).val();
                alu=$('#alu'+r).val();
                lse_clave=$('#lse_clave'+r).val();
                strMateria=$('#materia').val();
                jsnMateria=JSON.parse(strMateria); 
                gse_clave=jsnMateria.ret_Clave;               
                $.ajax({
                        type: "post",
                        dataType: "json",
                        url:"{{ route('comentarios.save') }}",
                        data:{                           
                            motivos:mot,
                            comentario:com,           
                            alumno:alu,
                            materia:m,
                            unidad:u,
                            lse_clave:lse_clave,
                            gse_clave:gse_clave                                              
                        },
                        success: function(){                                                    
                            swal('Exito', 'Los comentarios se guardaron de forma exitosa', 'success');                   
                        },
                        error: function(e){                        
                            console.log('Error al guardar los comentarios',e); 
                            swal('Error', 'Ocurrio un error, error #1001, consulta con el administrador del sistema', 'error');                        
                        }
                    });
            }

            function txtFiltro()
            {         
                c= $('#carrera option:selected').text();
                p= $('#profesor option:selected').text();
                m= $('#materia option:selected').text();
                u= $('#unidad').text();                 
                txt="CARRERA: "+c+"  |  PROFESOR: "+p+"  |  MATERIA: "+m+"  |UNIDAD: "+u;               
                $("#datosFiltro").text(txt);
            }
            

        </script>
    @endsection
    
@endsection