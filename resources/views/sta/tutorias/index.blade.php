@extends('template.molde');

@section('title','Tutorias')

@section('ruta')
    <label class="label label-success"> <a href="#">STA</a> / Tutorias</label> 
@endsection

@section('contenido')
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4"></div>
        <div class="col-sm-4">           
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCrearGrupo" title="Agregar grupo"><i class="fas fa-users"></i></button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3" id="divProfesores">
            <h5>Selecciona una profesor</h5>
            <select name="selProfesores" id="selProfesores" class="form-control">
                <option value="0">Seleccione una carrera</option>
                @foreach ($profesores as $profesores)
                    <option value="{{$profesores->cat_Clave}}">{{$profesores->cat_Nombre}} {{$profesores->cat_ApePat}} {{$profesores->cat_ApeMat}}</option>
                @endforeach
            </select>
        </div>        
        <div class="col-sm-3" id="divCarreras">
            {{-- Obtenemos las carreras activas --}}
            <h5>Selecciona la carrera a la que atendera el tutor</h5> 
            <select name="selCarreras" id="selCarreras" class="form-control">
                <option value="0">Seleccione una carrera</option>
                @foreach ($carreras as $carrera)
                    <option value="{{$carrera->car_Clave}}">{{$carrera->car_Nombre}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-3" id="divGrupos">
            {{-- Obtenemos los grupos de una carrera especifica --}}
            <h5>Selecciona el grupo a atender</h5>
            <select name="selGrupos" id="selGrupos" class="form-control">
                <option value="0">Seleccione un grupo</option>
            </select>
        </div>
        <div class="col-sm-3"></div>
    </div>  
    
    <!-- Modal -->
    <div class="modal fade" id="modalCrearGrupo" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">Agregar grupo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">                                         
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Nombre del grupo</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Nombre" aria-label="Grupo" aria-describedby="basic-addon1" name="gpo_Nombre" id="gpo_Nombre" required>
                        </div> 
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="selCarreras">Carrera</label>
                            </div>
                            <select class="form-control" id="selCarrerasMod" name="selCarrerasMod" required>
                                <option selected>Seleccione una carrera</option>
                                @foreach ($carreras as $carrera)
                                    <option value="{{$carrera->car_Clave}}">{{$carrera->car_Nombre}}</option>
                                @endforeach
                            </select>
                        </div>                         
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveGrupo()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    
    
@endsection

@section('js')
    <script type="text/javascript">       
        // Genera token para solicitudes POST
        $.ajaxSetup( {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        } );
        //Funcion para obtener los grupos de una carrera
        $(document).ready(function(){
            $("#selCarreras").change(function(){
                var car_Clave = $(this).val();
                $.ajax({
                    url: "{{route('tutorias.getGrupos')}}",
                    method: 'POST',
                    data: {
                        car_Clave:car_Clave
                    },
                    success: function(data){                        
                        $('#selGrupos').empty(); 
                        $("#selGrupos").append("<option value='0' selected='selected'>Seleccione un grupo</option>");  
                        $.each(data, function(key, value){
                            $('#selGrupos').append('<option value="'+value.id+'">'+value.gpo_Nombre+'</option>');
                        });                                               
                    },                    
                    error: function(data){                        
                            console.log('Error al recuperar los grupos, error: ',data);                        
                        }
                });                            
            });
        }); 
        //Función para guardar los grupos
        function saveGrupo(){
            var gpo_Nombre = $("#gpo_Nombre").val();
            var car_Clave = $("#selCarrerasMod").val(); 
            $.ajax({
                url: "{{route('tutorias.saveGrupo')}}",
                method: 'POST',
                data: {
                    gpo_Nombre:gpo_Nombre,
                    car_Clave:car_Clave
                },
                success: function(data){      
                    console.log(data);            
                    //Creamos mensaje de grupo guardado correctamente
                    swal('Exito', 'El grupo se creo correctamente', 'success');                                                                                    
                },                    
                error: function(data){                       
                    console.log('Error al guardar el grupo, error: ',data);                                         
                    swal('Error', 'El grupo esta duplicado', 'error');                       
                }
            }); 
        }

        //Convierte a mayusculas
        $("#gpo_Nombre").keyup(function(){
            $(this).val($(this).val().toUpperCase());
        });
    </script>
@endsection