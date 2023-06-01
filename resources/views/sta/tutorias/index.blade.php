@extends('template.molde');

@section('title','Tutorias')

@section('ruta')
    <label class="label label-success"> <a href="#">STA</a> / Tutorias</label> 
@endsection

@section('contenido')

    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-7"></div>
        <div class="col-sm-1">           
            <a href="{{ route('tutorias.getGruposAll') }}" type="button" class="btn btn-primary" title="Agregar grupo"><i class="fas fa-users"></i></a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-3" id="divProfesores">
            <h5>Selecciona un profesor</h5>
            <select name="selProfesores" id="selProfesores" class="form-control">
                <option value="0">Seleccione un profesor</option>
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
        <div class="col-sm-2">
            <h5>Selecciona un semestre</h5>
            <select name="selSemestres" id="selSemestres" class="form-control" required>
                <option value="">Seleccione un semestre</option>
                <option value="Feb-Jun">Febrero Junio</option>
                <option value="Ago-Dic">Agosto Diciembre</option>
            </select>
        </div>
        <div class="col-sm-1">
            <br>
            <button type="button" class="btn btn-primary" onclick="saveGrupoTut()" title="Agregar grupo"><i class="fas fa-plus"></i></button>
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
                    url: "{{route('tutorias.getGruposCar')}}",
                    method: 'POST',
                    data: {
                        car_Clave:car_Clave
                    },
                    success: function(data){                        
                        $('#selGrupos').empty(); 
                        $("#selGrupos").append("<option value='0' selected='selected'>Seleccione un grupo</option>");  
                        $.each(data, function(key, value){
                            $('#selGrupos').append('<option value="'+value.gpo_id+'">'+value.gpo_Nombre+'</option>');
                        });                                               
                    },                    
                    error: function(data){                        
                            console.log('Error al recuperar los grupos, error: ',data);                        
                        }
                });                            
            });
        }); 
        //Función para guardar los grupos
        function saveGrupoTut(){
            var gpo_Nombre = $("#gpo_Nombre").val();
            var car_Clave = $("#selCarrerasMod").val(); 
            $.ajax({
                url: "{{route('tutorias.saveGrupoTut')}}",
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
    </script>
@endsection