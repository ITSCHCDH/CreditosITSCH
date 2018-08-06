@extends('template.molde')

@section('title','Participantes')
@section('links')
    <script type="text/javascript" src="{{ asset('plugins/jsCookie/js.cookie.js') }}"></script>
@endsection
@section('ruta')
<label class="label label-success">Participantes</label>
@endsection
<!-- HTML index de los participantes -->
@section('contenido')
<div id="mensaje-actividad-alumnos">
    
</div>
<div id="mensajes-parte-superior" class="alerta-padding">
    
</div>
{!! Form::open(['route' => 'evidencias.create', 'method' => 'GET']) !!}
    <input type="hidden" name="id_actividad" value='-1' id='input_id_actividad'>
    <input type="hidden" name="id_responsable" value='-1' id='input_id_responsable'>
    <input type='submit' name='' class='btn btn-primary' value='Agregar Evidencia'>
{!! Form::close() !!}
<div class="pull-right">
    @if (Auth::User()->can('VIP'))
        <p>Total de evidencias: <strong id = "numero-evidencias">0</strong> <a href="{{ route('evidencias.index',['ruta' => 'participantes']) }}" id="evidencia-total">VER</a></p>
    @endif
    <p>Evidencias del responsable seleccionado: <strong id = "numero-evidencias-responsable">0</strong> <a href="{{ route('evidencias.index',['ruta' => 'participantes']) }}" id="evidencia-parcial">VER</a></p>
</div>
<div class="resetear"></div>
<div>
    <div class="input-group form-inline my-2 my-lg-0 mr-lg-2 pull-left" style="width: 250px;">
        <!--Cargamos las actividades y sus ID's, valor seleccionado por defecto es id de la actividad
            al que estan asignados los participantes -->
        {!! Form::label('actividades_id','Actividad') !!}
        {!! Form::select('actividades_id',$actividades,null,['class'=>'form-control','required','placeholder'=>'Seleccione una opcion','method'=>'GET']) !!}
    </div>

    <div class="input-group form-inline my-2 my-lg-0 mr-lg-2 mt-lg-10 pull-left" style="width: 250px;">
        <!--Cargamos las actividades y sus ID's, valor seleccionado por defecto es id de la actividad
            al que estan asignados los participantes -->
        {!! Form::label('responsables_id','Responsable') !!}
        {!! Form::select('responsables_id',[],0,['class'=>'form-control','required','placeholder'=>'Responsable','method'=>'GET']) !!}
    </div>

    <!-- Input text donde se podra buscar a los participantes por nombre -->
    <div class="autocomplete pull-left" style="width:270px;">
        {!! Form::label('alumno','Alumno') !!}
        <input id="participante_nombre" type="text" placeholder="Nombre" class="form-control">
    </div>
    <!-- Abrimos el formulario para guardar los participantes -->
    <div class="form-inline my-2 my-lg-0 mr-lg-2 pull-left" style="margin-top: 25px;">
        <form id="frm" method="POST">
             <div class="input-group">
                <input type="hidden" value="{{ csrf_token() }}" id="token">    
                <input type="hidden" name="id_actividad" id="id_actividad_oculto" value="-1">
                <input type="hidden" name="id_responsable" id="responsable_oculto" value='-1'>
                <input type="text" name="no_control" id="no_control" placeholder="No Control" class="form-control pull-right" list="list_no_control">
                <div class="input-group-btn">
                    <input type="submit" name="" value="Agregar" class="btn btn-primary">
                </div>
             </div>
        </form>
    </div>
    
    <datalist id="list_no_control">
    </datalist>
</div>

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
<div style="margin-bottom: 50px;"></div>
@section('js')
<script>
    //Header necesarios para las peticiones Ajax
    $.ajaxSetup( {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    } );
    // variable sesion inicia en true pues la pagina ha sido cargada por primera vez
    var sesion = true;
    var lista_no_control = [];
    function comboActividades(){
        $('#actividades_id').change(function(){
            var current_id = $(this).val();
            $('#responsable_oculto').val(-1);
            $('#input_id_actividad').val(current_id);
            $('#input_id_responsable').val(-1);
            $('#id_actividad_oculto').val($(this).val());
            $.ajax({
                type:"GET",
                url:"{{ route('participantes.actividad_responsables') }}",
                cache:false,
                data:{id:current_id},
                dataType: 'json',
                success:function(response){
                    //Vaciamos la tabla de los participantes
                    $('#mitabla tbody').empty();
                    //Vaciamos el combobox de los responsables
                    $('#responsables_id').empty();
                    $('#responsables_id').append("<option value='' disabled selected >Responsable</option>");
                    //Agregamos los responsables al combobox
                    for(var x=0; x<response['responsables'].length; x++){
                        var id = response['responsables'][x]['id'];
                        var nombre = response['responsables'][x]['name'];
                        $('#responsables_id').append("<option value='"+id+"'>"+nombre+"</option>");
                    }
                    //Mensaje para las actividades con alumnos responsables
                    var temp_mensaje = document.getElementById('mensaje-actividad-alumnos');
                    if(response['actividad']['alumnos']=="true"){
                        temp_mensaje.innerHTML = "<div class='alert-warning alerta-padding'>"+
                        "En esta actividad los participantes también podran subir sus propias evidencias.</div>"
                    }else{
                        temp_mensaje.innerHTML = "";
                    }

                    //Indicamos  el numero de evidencias que tiene la actividad
                    var msj_numero_evidencias = document.getElementById('numero-evidencias');
                    msj_numero_evidencias.innerHTML = response['no_evidencias'];

                    //Obtenemos el valor actual del combobox de las actividades
                    var temp_actividad_cookie = document.getElementById('actividades_id').value;
                    //Lo guardamos en una cookie
                    Cookies.set('participantes_actividad',temp_actividad_cookie,{ expires: 1});
                    var temp_respon_cookie = Cookies.get('participantes_responsable');
                    //Valdamos que la cookie no sea nula y que la pagina haya sido refrescada
                    if(temp_respon_cookie!=null && sesion){
                        //Validamos que el valor exista en el combobox responsables
                        if($("#responsables_id option[value='"+temp_respon_cookie+"']").length!=0){
                            $('#responsables_id').val(temp_respon_cookie);
                            $('#responsables_id').trigger('change'); //Provocamos un evento de tipo change
                        }
                        sesion = false;
                    }
                },error:function(){
                    console.log('Error :(');
                }
            });
        });
    }
    function comboResponsables(){
            $('#responsables_id').change(function(event){
                event.preventDefault();
                var id_actividad = $('#actividades_id').val();
                var id_responsable = $('#responsables_id').val();
                $('#responsable_oculto').val($('#responsables_id').val());
                $('#input_id_responsable').val($('#responsables_id').val());
                //Guardamos el valor actual del combo responsables y la guardamos en una cookie
                var temp_respon_cookie = document.getElementById('responsables_id').value;
                Cookies.set('participantes_responsable',temp_respon_cookie,{ expires:1});
                $.ajax({
                    type:"GET",
                    url: "{{ url('admin/participantes/peticion')}}",
                    cache:false,
                    data:{id_actividad:id_actividad, id_responsable:id_responsable},
                    dataType:'json',
                    success:function(response){
                        var len = response['participantes_data'].length;
                        $('#mitabla tbody').empty(); // vaciamos la tabla de los participantes
                        //Llenamos la tabla con los valores retornados mediante json
                        if(response['participantes_data'][0]['id']!=-1){
                            for(var x=0; x<len; x++){
                                var nombre = response['participantes_data'][x]['nombre'];
                                var carrera = response['participantes_data'][x]['carrera'];
                                var id = response['participantes_data'][x]['id'];
                                var no_control = response['participantes_data'][x]['no_control'];
                                $('#mitabla tbody').append("<tr><td>"+id+"</td> <td>"+no_control+"</td> <td>"+nombre+"</td> <td>"+carrera+"</td> <td> <a href='' value='"+id+"' class='btn btn-danger claseEliminaParticipante' data-token='{{ csrf_token() }}'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></a> </td></tr>");
                            }
                        }
                        var msj_numero_evidencias = document.getElementById('numero-evidencias-responsable');
                        msj_numero_evidencias.innerHTML = response['no_evidencias'];
                    },error:function(){
                        console.log('Error :(');
                    }
                });
            });
    }
    function eliminaParticipante(){
        $(document).on('click','.claseEliminaParticipante',function(event){
            var confirmacion= confirm('¡Estas seguro de eliminar al participante?');
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
                        mostrarMensaje(response['mensaje'],'mensajes-parte-superior',response['mensaje_tipo']);
                    },error:function(){
                        console.log('Error al eliminar');
                    }
                });
                $('#responsables_id').trigger('change');
            }  
        });
    }
    function agregaParticipante(){
        $('#frm').on('submit',function(event){
            event.preventDefault();
            //Guardamos los numeros de control en ua variable
            var temp_no_control = $('#no_control').val();
            var tk = temp_no_control.split(" "); //Este metodo parte en pedazos una cadena cada vez que encuentra un espacio y lo guarda en un arreglo
            //Si es mas de un numero de control los agregamos a la lista de numeros de control
            if(tk.length>1){
                for(var x = 0; x<tk.length; x++){
                    //Anexamos los numeros de control a una lista y validamos que no se encuentra ya agregada
                    if(!$('#'+tk[x]).length){
                        $('#list_no_control').append('<option value="'+tk[x]+'" id="'+tk[x]+'"');
                        lista_no_control.push(tk[x]);
                    }
                }
                $('#no_control').val('');
            }else if(temp_no_control.length>0){
                if(!$('#'+tk[0]).length){
                    $('#list_no_control').append('<option value="'+tk[0]+'" id="'+tk[0]+'"');
                    lista_no_control.push(tk[x]);
                }
                var participante_data = $(this).serialize();
                $.ajax({
                    type:'post',
                    url:'{{ url('admin/participantes/guardar')}}',
                    data:participante_data,
                    dataType:'json',
                    success:function(response){
                        mostrarMensaje(response['mensaje'],"mensajes-parte-superior",response['mensaje_tipo']);
                    },error:function(){
                        console.log('Error al guardar');
                    }
                });
                $('#no_control').val('');
                $('#participante_nombre').val(''); 
                $('#responsables_id').trigger('change');
            }else{
                var id_responsable = $('#responsables_id').val()!=null? $('#responsables_id').val(): -1;
                var id_actividad = $('#actividades_id').val()!=null? $('#actividades_id').val(): -1;
                for (var i = 0; i < lista_no_control.length; i++) {
                    $.ajax({
                        type:'post',
                        url:'{{ url('admin/participantes/guardar')}}',
                        data:{
                            no_control: lista_no_control[i],
                            id_responsable: id_responsable,
                            id_actividad: id_actividad
                        },
                        dataType:'json',
                        success:function(response){
                            mostrarMensaje(response['mensaje'],"mensajes-parte-superior",response['mensaje_tipo']);
                        },error:function(){
                            console.log('Error al guardar');
                        }
                    });
                }
                
                $('#no_control').val('');
                $('#participante_nombre').val(''); 
                $('#responsables_id').trigger('change');
            }
        });
    }

    function autocompletar(entrada){
        var posicionActual;
        var participantes_arr = [];
        entrada.addEventListener("input", function(event){
            var divPadre, divHijo, valor = this.value;
            posicionActual = -1;
            removeAllLists();
            if(!valor) return false;
            $.ajax({
                type: "GET",
                url: "{{ url('admin/participantes/busqueda') }}",
                dataType: "json",
                data:{
                    nombre: valor,
                    peticion: 0
                },
                success: function(response){
                    participantes_arr = [];
                    for(var x=0; x<response.length; x++){
                        participantes_arr.push(response[x]);
                    }
                    removeAllLists();
                    divPadre.setAttribute("id",entrada.id+"autocomplete-list");
                    divPadre.setAttribute("class","autocomplete-items");
                    entrada.parentNode.appendChild(divPadre);
                    for(var x=0; x<participantes_arr.length; x++){
                        divHijo = document.createElement("div");

                        divHijo.innerHTML = "<p style='text-align: left;'><strong>"+participantes_arr[x]['nombre']+"</strong>-"+participantes_arr[x]['no_control']+"</p>";
                        divHijo.innerHTML += "<input type = 'hidden' value='"+participantes_arr[x]['nombre']+"'>";
                        divHijo.innerHTML += "<input type = 'hidden' value='"+participantes_arr[x]['no_control']+"'>";
                        divHijo.addEventListener("click", function(event){
                            event.preventDefault();
                            var temp = document.getElementById("participante_nombre");
                            temp.value = this.getElementsByTagName("input")[0].value;
                            var temp2 = document.getElementById("no_control");
                            temp2.value = this.getElementsByTagName("input")[1].value;
                            removeAllLists();
                        });
                        divPadre.appendChild(divHijo);
                    }
                }, error: function(){
                    console.log("Error :(");
                }
            });
            divPadre = document.createElement("div");
            
        });

        entrada.addEventListener("keydown", function(event){
            var lista_participantes = document.getElementById(this.id+"autocomplete-list");
            if(lista_participantes) lista_participantes = lista_participantes.getElementsByTagName("div");
            if(event.keyCode == 40){
                ++posicionActual;
                addActive(lista_participantes);
            }else if(event.keyCode == 38){
                --posicionActual;
                addActive(lista_participantes);
            }else if(event.keyCode == 13 && posicionActual >= 0){
                this.value = lista_participantes[posicionActual].getElementsByTagName("input")[0].value;
                var temp = document.getElementById("no_control");
                temp.value = lista_participantes[posicionActual].getElementsByTagName("input")[1].value;
                removeAllLists();
            }
        });
        function addActive(current){
            if(current == null) return false;
            removeActive(current);
            if(posicionActual >= current.length) posicionActual=0;
            if(posicionActual < 0) posicionActual = current.length-1;
            current[posicionActual].classList.add("autocomplete-active");
        }
        function removeActive(current){
            for(var x = 0; x<current.length; x++){
                current[x].classList.remove("autocomplete-active");
            }
        }
        function removeAllLists(elemento){
            var lista_items = document.getElementsByClassName("autocomplete-items");
            for(var x = 0; x < lista_items.length; x++){
                if(elemento == lista_items[x] && elemento == entrada)continue;
                lista_items[x].parentNode.removeChild(lista_items[x]);
            }
        }
        document.addEventListener("click", function (event) {
            removeAllLists(event.target);
        });
    }

    function busqueda(entrada){
        event.preventDefault();
        var temp = document.getElementById("participante_nombre");
        temp.value="";
        var valor = entrada.value;
        if(!valor) return false;
        if(valor.length < 8 || valor.length > 10) return false;
        $.ajax({
            type: "GET",
            url: "{{ url('admin/participantes/busqueda') }}",
            dataType: "json",
            data:{
                no_control: valor,
                peticion: 1
            },
            success: function(response){
                if(response.length>0){
                    temp.value = response[0]['nombre'];
                }
                console.log(response);
            },error: function(response){
                console.log("error :(");
            }
        });
    }
    function noControlParticipante(entrada){
        entrada.addEventListener("input", function(event){
            busqueda(entrada);
        });

        entrada.addEventListener("click", function(event){
            busqueda(entrada);
        });
    }
    function getActividadCookie(){
        var temp_actividad_cookie = Cookies.get('participantes_actividad');
        if(temp_actividad_cookie!=null){
            $('#actividades_id').val(temp_actividad_cookie);
            $('#actividades_id').trigger('change');
        }
    }
    function evidenciaTotal(){
        $(document).on('click','#evidencia-total', function(event){
            var actividad = document.getElementById('actividades_id').value;
            Cookies.set('evidencia_actividad', actividad,{ expires: 1});
            Cookies.set('evidencia_responsable','nulo',{ expires: 1});
        });
    }
    function evidenciaParcial(){
        $(document).on('click','#evidencia-parcial',function(){
            var actividad = document.getElementById('actividades_id').value;
            var responsable = document.getElementById('responsables_id').value;
            Cookies.set('evidencia_actividad', actividad,{ expires: 1});
            Cookies.set('evidencia_responsable',responsable,{ expires: 1});
        });
    }
    $(document).ready(function(){
        comboActividades();
        getActividadCookie();
        comboResponsables();
        agregaParticipante();
        eliminaParticipante();
        autocompletar(document.getElementById("participante_nombre"));
        noControlParticipante(document.getElementById("no_control"));
        evidenciaTotal();
        evidenciaParcial();
    });
</script>
@endsection
@endsection