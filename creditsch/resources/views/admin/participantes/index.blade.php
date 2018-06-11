@extends('template.molde')

@section('title','Participantes')

@section('ruta')
    <label class="label label-success">Participantes</label>
@endsection
<!-- HTML index de los participantes -->
@section('contenido')
    {!! Form::open(['route' => 'evidencias.create', 'method' => 'GET']) !!}
        <input type="hidden" name="id_actividad" value='-1' id='input_id_actividad'>
        <input type="hidden" name="id_responsable" value='-1' id='input_id_responsable'>
        <input type='submit' name='' class='btn btn-primary' value='Agregar Evidencia'>
    {!! Form::close() !!}
    <div class="input-group form-inline my-2 my-lg-0 mr-lg-2 pull-left">
        <!--Cargamos las actividades y sus ID's, valor seleccionado por defecto es id de la actividad
            al que estan asignados los participantes -->
        {!! Form::label('actividades_id','Actividad') !!}
        {!! Form::select('actividades_id',$actividades,$valorActividad,['class'=>'form-control','required','placeholder'=>'Seleccione una opcion','method'=>'GET']) !!}
    </div>

    <div class="input-group form-inline my-2 my-lg-0 mr-lg-2 mt-lg-10 pull-left">
        <!--Cargamos las actividades y sus ID's, valor seleccionado por defecto es id de la actividad
            al que estan asignados los participantes -->
        {!! Form::label('responsables_id','Responsable') !!}
        {!! Form::select('responsables_id',[],null,['class'=>'form-control','required','placeholder'=>'Responsable','method'=>'GET']) !!}
    </div>
    <!-- Abrimos el formulario para guardar los participantes -->

    <form id="frm" method="POST" class="form-inline my-2 my-lg-0 mr-lg-2 navbar-form pull-right">
         <div class="input-group">
            <input type="hidden" value="{{ csrf_token() }}" id="token">    
            <input type="hidden" name="id_evidencia" id="oculto" value="-1">
            <input type="hidden" name="id_actividad" id="id_actividad_oculto" value="-1">
            <input type="hidden" name="id_responsable_oculto" id="responsable_oculto" value='-1'>
            <input type="text" name="no_control" id="no_control" placeholder="No Control" required class="form-control pull-right">
            <div class="input-group-btn">
                <input type="submit" name="" value="Agregar" class="btn btn-primary">
            </div>
         </div>
    </form>
    <!---------------------------------------------------------------------------------------------->
    
    <!-- Tabla donde se muestran los participantes -->
    <table class="table table-striped" id="mitabla">
        <!-- instancia al archivo table, dentro de este mismo direcctorio -->
       <thead>
           <th>ID</th>
           <th>Numero de Control</th>
           <th>Nombre</th>
           <th>Carrera</th>
           <th>Accion</th>
       </thead>
       <tbody>
       </tbody>
    </table>
@section('js')
    <script>
        $.ajaxSetup( {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        } );
        function comboActividades(){
            $('#actividades_id').change(function(){
                var current_id = $(this).val();
                $('#oculto').val(-1);
                $('#responsable_oculto').val(-1);
                $('#input_id_actividad').val(current_id);
                $('#input_id_responsable').val(-1);
                $('#id_actividad_oculto').val($(this).val());
                $.ajax({
                    type:"GET",
                    url:"{{ url('admin/evidencias/peticion')}}",
                    cache:false,
                    data:{id:current_id},
                    dataType: 'json',
                    success:function(response){
                        console.log(response);
                        $('#mitabla tbody').empty();
                        $('#responsables_id').empty();
                        $('#responsables_id').append("<option value='' disabled selected >Responsable</option>");
                        for(var x=0; x<response.length; x++){
                            var id = response[x]['id'];
                            var nombre = response[x]['name'];
                            $('#responsables_id').append("<option value='"+id+"'>"+nombre+"</option>");
                        }
                    },error:function(){
                        console.log('Error :(');
                    }
                });
            });
        }
        function comboResponsables(){
                var id_actividad = $('#actividades_id').val();
                var id_responsable = $('#responsables_id').val();
                $('#responsable_oculto').val($('#responsables_id').val());
                $('#input_id_responsable').val($('#responsables_id').val());
                $.ajax({
                    type:"GET",
                    url: "{{ url('admin/participantes/peticion')}}",
                    cache:false,
                    data:{id_actividad:id_actividad, id_responsable:id_responsable},
                    dataType:'json',
                    success:function(response){
                        var len = response.length;
                        $('#mitabla tbody').empty();
                        var id_evidencia=response[0]['id_evidencia'];
                        $('#oculto').val(id_evidencia);
                        if(response[0]['id']!=-1){
                            for(var x=0; x<len; x++){
                                var nombre = response[x]['nombre'];
                                var carrera = response[x]['carrera'];
                                var id = response[x]['id'];
                                var no_control = response[x]['no_control'];
                                $('#mitabla tbody').append("<tr><td>"+id+"</td> <td>"+no_control+"</td> <td>"+nombre+"</td> <td>"+carrera+"</td> <td> <a href='' value='"+id+"' class='btn btn-danger claseEliminaParticipante' data-token='{{ csrf_token() }}'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></a> </td></tr>");
                            }
                        }
                    },error:function(){
                        console.log('Error :(');
                    }
                });
            
        }
        function eliminaParticipante(){
            $(document).on('click','.claseEliminaParticipante',function(event){
                var confirmacion= confirm('Estas seguro de eliminar al participante');
                event.preventDefault();
                if(confirmacion){
                    var token = $(this).data('token');
                    var id = $(this).attr('value');
                    $.ajax({
                        type:'GET',
                        url:'participantes/'+id+'/destroy',
                        dataType:'json',
                        data:{
                            'id':id,
                            '_METHOD':'DELETE',
                            '_token':token
                        },
                        success:function(response){
                            console.log(response);
                        },error:function(){
                            console.log('Error al eliminar');
                        }
                    });
                    comboResponsables();
                }  
            });
        }
        function agregaParticipante(){
            $('#frm').on('submit',function(event){
                event.preventDefault();
                var participante_data = $(this).serialize();
                $.ajax({
                    type:'POST',
                    url:'{{ url('admin/participantes/guardar')}}',
                    data:participante_data,
                    dataType:'json',
                    success:function(response){
                        console.log(response);
                    },error:function(){
                        console.log('Error al guardar');
                    }
                });
                comboResponsables();
            });
        }

        $(document).ready(function(){
            comboActividades();
            $('#responsables_id').change(function(event){
                event.preventDefault();
                comboResponsables();
            });
            agregaParticipante();
            eliminaParticipante();
        });
        
    </script>
@endsection
@endsection