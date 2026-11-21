@extends('template.molde')

@section('title','Participantes')
@section('links')
    <script type="text/javascript" src="{{ asset('plugins/jsCookie/js.cookie.js') }}"></script>
    <style>
        .participant-control-card,.participant-summary-card,.participant-table-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
        .participant-control-card{margin-bottom:1rem;padding:1.25rem}
        .participant-control-card h1{margin:0;color:#102b4a;font-size:1.25rem;font-weight:700}
        .participant-control-card p{margin:.2rem 0 0;color:#6b7280;font-size:.88rem}
        .participant-summary-card{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:.75rem;margin-bottom:1rem}
        .participant-summary-item{padding:.9rem 1rem;border-right:1px solid #edf1f5}
        .participant-summary-item:last-child{border-right:0}
        .participant-summary-item span{display:block;color:#6b7280;font-size:.78rem}
        .participant-summary-item strong{color:#102b4a}
        .participant-table-card{overflow:hidden}
        .participant-table-card-head{display:flex;align-items:center;justify-content:space-between;gap:1rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc}
        .participant-table-card-head h2{margin:0;color:#102b4a;font-size:1.05rem}
        .participant-table-card .table{margin:0}
        @media(max-width:767.98px){.participant-summary-card{grid-template-columns:1fr}.participant-summary-item{border-right:0;border-bottom:1px solid #edf1f5}.participant-summary-item:last-child{border-bottom:0}.participant-table-card-head{align-items:flex-start;flex-direction:column}}
    </style>
@endsection
@section('ruta')
    <span class="d-inline-flex align-items-center gap-2">
        <i class="fa-solid fa-users" style="color:#2d6da3"></i>
        <a href="{{ route('actividades.index') }}" class="text-decoration-none">Actividades</a>
        <span class="text-muted">/</span>
        Participantes
    </span>
@endsection
<!-- HTML index de los participantes -->
@section('contenido')

<div class="participant-control-card">
    <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
        <div><h1>Asignar participantes</h1><p>Selecciona una actividad, responsable y alumno de SIT.</p></div>
        @if (Auth::User()->hasAnyPermission(['VIP','CREAR_EVIDENCIA']))
            <form action="{{ route('evidencias.create') }}" method="get" class="mb-0">
                <input type="hidden" name="id_actividad" value="-1" id="input_id_actividad">
                <input type="hidden" name="id_responsable" value="-1" id="input_id_responsable">
                <button type="submit" class="btn btn-outline-primary rounded-pill" title="Agregar evidencia"><i class="fa-solid fa-cloud-arrow-up me-2"></i>Evidencia</button>
            </form>
        @endif
    </div>
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label" for="actividades_id">Actividad</label>
            <select name="actividades_id" id="actividades_id" required class="form-select">
                @foreach ($actividades as $act)
                    <option value="{{ $act->id }}">{{ $act->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label" for="responsables_id">Responsable</label>
            <select name="responsables_id[]" id="responsables_id" class="form-select" required></select>
        </div>
        @if (Auth::User()->hasAnyPermission(['AGREGAR_PARTICIPANTES','VIP']))
            <div class="col-md-4">
                <label class="form-label" for="participante_nombre">Alumno</label>
                <input id="participante_nombre" type="text" placeholder="Nombre del alumno" class="form-control">
            </div>
        @endif
    </div>
    @if (Auth::User()->hasAnyPermission(['AGREGAR_PARTICIPANTES','VIP']))
        <form id="frm" method="POST" class="mt-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-9">
                    <label class="form-label" for="no_control">Número de control</label>
                    <input type="hidden" value="{{ csrf_token() }}" id="token">
                    <input type="hidden" name="id_actividad" id="id_actividad_oculto" value="-1">
                    <input type="hidden" name="id_responsable" id="responsable_oculto" value="-1">
                    <input type="text" name="no_control" id="no_control" placeholder="Ej. 00030001" class="form-control" list="list_no_control">
                </div>
                <div class="col-md-3 d-grid">
                    <button type="submit" class="btn btn-primary rounded-pill"><i class="fa-solid fa-user-plus me-2"></i>Agregar</button>
                </div>
            </div>
        </form>
    @endif
</div>

<datalist id="list_no_control"></datalist>

<div class="participant-summary-card">
    @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VIP_EVIDENCIA']))
        <div class="participant-summary-item"><span>Total de evidencias</span><strong id="numero-evidencias">0</strong></div>
    @endif
    <div class="participant-summary-item"><span>Evidencias del responsable</span><strong id="numero-evidencias-responsable">0</strong></div>
    <div class="participant-summary-item" id="parrafo-validado" style="display:none"><span>Actividad validada</span><strong id="validado">NO</strong></div>
</div>

<div id="mensaje-actividad-alumnos"></div>

<div class="participant-table-card">
    <div class="participant-table-card-head">
        <h2>Participantes asignados</h2>
        <input class="form-control" id="myInput" type="text" placeholder="Buscar participante..." style="max-width:260px">
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0" id="mitabla">
            <input type="hidden" id="participante_id" name="participante_id">
            <thead class="table-light">
                <tr><th>ID</th><th>Número de control</th><th>Nombre</th><th>Carrera</th><th>Acción</th></tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar participante</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Estas seguro de eliminar este participante?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-mdb-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="eliminar">Eliminar</button>
      </div>
    </div>
  </div>
</div>


{{-- Sección JS --}}

@section('js')
    <script>
        $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#mitabla tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        });
    </script>

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
        var alumnos_responsables = false;
        function comboActividades(){
            $('#actividades_id').change(function(){
                document.getElementById('mensaje-actividad-alumnos').innerHTML = "";
                document.getElementById('numero-evidencias-responsable').innerHTML = "0";
                document.getElementById('validado').innerHTML="NO";
                $('#parrafo-validado').css('display','none');
                var current_id = $(this).val();
                $('#responsable_oculto').val(-1);
                $('#input_id_actividad').val(current_id);
                $('#input_id_responsable').val(-1);
                $('#id_actividad_oculto').val($(this).val());
                if(current_id!=""){
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
                            if(response['responsables'].length==0){
                                $('#responsables_id').append("<option value='' disabled>Sin responsables</option>");
                            }

                            //Agregamos los responsables al combobox
                            for(var x=0; x<response['responsables'].length; x++){
                                var id = response['responsables'][x]['id'];
                                var nombre = response['responsables'][x]['name'];
                                if(x==0){
                                    $('#responsables_id').append("<option value='"+id+"' selected>"+nombre+"</option>");
                                }else{
                                    $('#responsables_id').append("<option value='"+id+"'>"+nombre+"</option>");
                                }
                            }
                            //Mensaje para las actividades con alumnos responsables
                            var temp_mensaje = document.getElementById('mensaje-actividad-alumnos');
                            if(response['actividad']['alumnos']=="true"){
                                alumnos_responsables = true;
                                temp_mensaje.innerHTML = "<div class='alert-warning alerta-padding'>"+
                                "<p class='text-center font-weight-bold'>En esta actividad los participantes son responsables de subir sus evidencias de manera individual<br>Alumno que no suba evidencia antes de validar la actividad, no se asignará el porcentaje de liberación correspondiente.</p></div>"
                            }else{
                                alumnos_responsables = false;
                                temp_mensaje.innerHTML = "";
                            }

                            //Indicamos  el numero de evidencias que tiene la actividad
                            var msj_numero_evidencias = document.getElementById('numero-evidencias');
                            if(msj_numero_evidencias!=null)msj_numero_evidencias.innerHTML = response['no_evidencias'];

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
                            $('#responsables_id').trigger('change');
                        },error:function(e){
                            console.log('Error:',e);
                        }
                    });
                }else{
                    //Vaciamos la tabla de los participantes
                    $('#mitabla tbody').empty();
                    //Vaciamos el combobox de los responsables
                    $('#responsables_id').empty();
                    $('#responsables_id').append("<option value='' disabled selected >Responsable</option>");
                }
            });
        }
        function comboResponsables(){
                $('#responsables_id').change(function(event){
                    event.preventDefault();
                    var id_actividad = $('#actividades_id').val();
                    var id_responsable = $('#responsables_id').val();
                    $('#responsable_oculto').val($('#responsables_id').val());
                    $('#input_id_responsable').val($('#responsables_id').val());
                    $('#parrafo-validado').css('display','block');
                    //Guardamos el valor actual del combo responsables y la guardamos en una cookie
                    var temp_respon_cookie = document.getElementById('responsables_id').value;
                    Cookies.set('participantes_responsable',temp_respon_cookie,{ expires:1});
                    $.ajax({
                        type:"GET",
                        url: "{{ url('admin/participantes/peticion') }}",
                        cache:false,
                        data:{id_actividad:id_actividad, id_responsable:id_responsable},
                        dataType:'json',
                        success:function(response){
                            var len = response['participantes_data'].length;
                            $('#mitabla tbody').empty(); // vaciamos la tabla de los participantes
                            //Llenamos la tabla con los valores retornados mediante json
                            var tiene_permisos = "{{ Auth::User()->hasAnyPermission(['VIP']) }}"=="1"? true : false;

                            if(response['participantes_data'][0]['id']!=-1){
                                for(var x=0; x<len; x++){
                                    var nombre = response['participantes_data'][x]['nombre'];
                                    var carrera = response['participantes_data'][x]['carrera'];
                                    var id = response['participantes_data'][x]['id'];
                                    var actividad_id = response['actividad_id'];
                                    var responsable_id = response['responsable_id'];
                                    var no_control = response['participantes_data'][x]['no_control'];
                                    var tiene_evidencia = response['participantes_data'][x]['tiene_evidencia'];
                                    var advertencia = "<div class='btn btn-warning' title='No ha subido evidencia'><i class='fas fa-exclamation-triangle'></i></div>";
                                    var validar_evidencia_advertencia = "<div class='btn btn-warning' title='Falta validar la evidencia'><i class='fas fa-exclamation-triangle'></i></div>";
                                    var ver_evidencia_link = "{{ route('participantes.ver_evidencia') }}"+"?id="+id+"&actividad_id="+actividad_id+"&responsable_id="+responsable_id;
                                    var ver_evidencia = "<a href='"+ver_evidencia_link+"' class='btn btn-primary' title='Ver evidencia'><i class='fas fa-camera'></i></a>";
                                    if(response['validado'] == "false"){
                                        if(tiene_permisos || ("{{ Auth::User()->can('ELIMINAR_PARTICIPANTES') }}" == "1" || response['user_id'] == "{{ Auth::User()->id}}") || (response['validador_id'] == "{{ Auth::User()->id }}")){
                                            if(alumnos_responsables){
                                                if(tiene_evidencia == null){
                                                    $('#mitabla tbody').append("<tr><td>"+id+"</td> <td>"+no_control+"</td> <td>"+nombre+"</td> <td>"+carrera+"</td> <td> <span value='"+id+"' class='btn btn-danger' onclick='mostrarModalEliminar(" +id+")' title='Eliminar participante'><i class='far fa-trash-alt'></i></span>"+advertencia+"</td></tr>");
                                                }else{
                                                    $('#mitabla tbody').append("<tr><td>"+id+"</td> <td>"+no_control+"</td> <td>"+nombre+"</td> <td>"+carrera+"</td> <td> <span value='"+id+"' class='btn btn-danger' onclick='mostrarModalEliminar(" +id+")' title='Eliminar participante'><i class='far fa-trash-alt'></i></span>"+ver_evidencia+"</td></tr>");
                                                }
                                            }else{
                                                $('#mitabla tbody').append("<tr><td>"+id+"</td> <td>"+no_control+"</td> <td>"+nombre+"</td> <td>"+carrera+"</td> <td> <span value='"+id+"' class='btn btn-danger' onclick='mostrarModalEliminar(" +id+")' title='Eliminar participante'><i class='far fa-trash-alt'></i></span></td></tr>");
                                            }
                                        }else{
                                            $('#mitabla tbody').append("<tr><td>"+id+"</td> <td>"+no_control+"</td> <td>"+nombre+"</td> <td>"+carrera+"</td><td>Ninguna</td></tr>");
                                        }
                                    }else if(response['validado'] == "true"){
                                        if(tiene_permisos || response['validador_id'] == "{{ Auth::User()->id }}"){
                                            if(alumnos_responsables){
                                                if(tiene_evidencia == null){
                                                    $('#mitabla tbody').append("<tr><td>"+id+"</td> <td>"+no_control+"</td> <td>"+nombre+"</td> <td>"+carrera+"</td> <td> <span value='"+id+"' class='btn btn-danger' onclick='mostrarModalEliminar(" +id+")' title='Eliminar participante'><i class='far fa-trash-alt'></i></span>"+advertencia+"</td></tr>");
                                                }else if(response['participantes_data'][x]['evidencia_validada'] == 'no' && response['participantes_data'][x]['momento_agregado'] == 'posteriormente'){
                                                    $('#mitabla tbody').append("<tr><td>"+id+"</td> <td>"+no_control+"</td> <td>"+nombre+"</td> <td>"+carrera+"</td> <td> <span value='"+id+"' class='btn btn-danger' onclick='mostrarModalEliminar(" +id+")' title='Eliminar participante'><i class='far fa-trash-alt'></i></span>"+ver_evidencia+validar_evidencia_advertencia+"</td></tr>");
                                                }else{
                                                    $('#mitabla tbody').append("<tr><td>"+id+"</td> <td>"+no_control+"</td> <td>"+nombre+"</td> <td>"+carrera+"</td> <td> <span value='"+id+"' class='btn btn-danger' onclick='mostrarModalEliminar(" +id+")' title='Eliminar participante'><i class='far fa-trash-alt'></i></span>"+ver_evidencia+"</td></tr>");
                                                }
                                            }else{
                                                $('#mitabla tbody').append("<tr><td>"+id+"</td> <td>"+no_control+"</td> <td>"+nombre+"</td> <td>"+carrera+"</td> <td> <span href=\"#\" value='"+id+"' class='btn btn-danger claseEliminaParticipante' onclick='mostrarModalEliminar(" +id+")' title='Eliminar participante'><i class='far fa-trash-alt'></i></span></td></tr>");
                                            }
                                        }else{
                                            $('#mitabla tbody').append("<tr><td>"+id+"</td> <td>"+no_control+"</td> <td>"+nombre+"</td> <td>"+carrera+"</td><td>Ninguna</td></tr>");
                                        }
                                    }
                                }
                            }
                            var msj_numero_evidencias = document.getElementById('numero-evidencias-responsable');
                            msj_numero_evidencias.innerHTML = response['no_evidencias'];
                            document.getElementById('validado').innerHTML = response['validado']=="true"? "SI": "NO";

                        },error:function(){
                            console.log('Error :(');
                        }
                    });
                });
        }

        function mostrarModalEliminar(id){
            $('#participante_id').val(id);
            $('#modalEliminar').modal('show');
        }

        function eliminarParticipante(event){
            var id = $('#participante_id').val();
            var token = $('#token').val();
            $.ajax({
                type:'DELETE',
                url:"{{ url('/admin/participantes') }}/"+id,
                dataType:'json',
                data:{
                    'id':id,
                    '_METHOD':'DELETE',
                    '_token':token
                },
                success:function(response){
                    //Mensaje
                    swal({
                        title: response.mensaje_tipo,
                        text: response.mensaje,
                        icon: response.icono,
                        button: "Cerrar!",
                    });
                    setTimeout(function(){
                        window.location.replace("{{ route('participantes.index') }}");
                    },2000);
                },error:function(e){
                    swal({
                        title: "Error",
                        text: "Ocurrio un error al eliminar!",
                        icon: "error",
                        button: "Cerrar!",
                    });
                    setTimeout(function(){
                        window.location.replace("{{ route('participantes.index') }}");
                        },2000);
                }
            });
        }

        function agregaParticipante(){
            $('#frm').on('submit',function(event){
                event.preventDefault();
                //Guardamos los numeros de control en ua variable
                var temp_no_control = $('#no_control').val();
                var tk = temp_no_control.split(" "); //Este metodo parte en pedazos una cadena cada vez que encuentra un espacio y lo guarda en un arreglo
                var id_responsable = $('#responsables_id').val()!=null? $('#responsables_id').val(): -1;
                var id_actividad = $('#actividades_id').val()!=null? $('#actividades_id').val(): -1;
                for (var i = 0; i < tk.length; i++) {
                    $.ajax({
                        type:'post',
                        url:'{{ url('admin/participantes/guardar')}}',
                        data:{
                            no_control: tk[i],
                            id_responsable: id_responsable,
                            id_actividad: id_actividad                           
                        },
                        dataType:'json',
                        success:function(response){
                           //Mensaje                           
                           swal({
                                title: response.mensaje_tipo,
                                text: response.mensaje,
                                icon: response.icono,
                                button: "Cerrar!",
                            });
                            setTimeout(function(){
                                window.location.replace("{{ route('participantes.index') }}");
                             },2000);
                        },error:function(){
                            swal({
                                title: "Error",
                                text: "Ocurrio un error al guardar!",
                                icon: "error",
                                button: "Cerrar!",
                            });
                            setTimeout(function(){
                                window.location.replace("{{ route('participantes.index') }}");
                             },2000);
                        }
                    });
                }
                $('#no_control').val('');
                $('#participante_nombre').val('');
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
        function cargarDatos(){
            var temp_actividad_cookie = Cookies.get('participantes_actividad');
            if(temp_actividad_cookie!=null){
                if($("#actividades_id option[value='"+temp_actividad_cookie+"']").length!=0){
                    $('#actividades_id').val(temp_actividad_cookie);
                }
            }
            $('#actividades_id').trigger('change');
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

        function addEventListeners(){
            $('#eliminar').on('click', eliminarParticipante);
        }

        $(document).ready(function(){
            addEventListeners();
            comboActividades();
            cargarDatos();
            comboResponsables();
            agregaParticipante();
            var tiene_permisos = "{{ Auth::User()->hasAnyPermission(['VIP','AGREGAR_PARTICIPANTES']) }}"=="1"?true: false;
            if(tiene_permisos){
                autocompletar(document.getElementById("participante_nombre"));
                noControlParticipante(document.getElementById("no_control"));
            }
            evidenciaTotal();
            evidenciaParcial();
        });
    </script>
@endsection
@endsection
