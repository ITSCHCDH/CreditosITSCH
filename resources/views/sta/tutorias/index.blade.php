@extends('template.molde')

@section('title','Tutorias')

@section('ruta')
    <label class="label label-success"> <a href="#">STA</a> / Tutorias</label> 
@endsection

@section('contenido')
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-6"></div>
        <div class="col-sm-2">           
            <a href="{{ route('tutorias.getGruposAll') }}" type="button" class="btn btn-primary" title="Agregar grupo"><i class="fas fa-users"></i></a>
            <a href="{{ route('analisis.index') }}" class="btn btn-success" title="Analizar alumnos"><i class="fas fa-user-graduate"></i></a>
        </div>
    </div>
    <hr>
    <form action="{{ route('tutorias.saveGrupoTut') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-sm-2">
                <h5>Selecciona un profesor</h5>
                <select name="tut_Clave" id="selProfesores" class="form-control" required>
                    <option value="">Seleccione un profesor</option>
                    @foreach ($profesores as $profesor)
                        <option value="{{$profesor->id}}">{{$profesor->nombre}}</option>
                    @endforeach
                </select>
            </div> 
            <div class="col-sm-2">
                <h5>Selecciona un semestre</h5>
                <select name="gtu_Semestre" id="gtu_Semestre" class="form-control" required>
                    <option value="">Seleccione un semestre</option>
                    <option value="Feb-Jun">Febrero Junio</option>
                    <option value="Ago-Dic">Agosto Diciembre</option>
                </select>
            </div>       
            <div class="col-sm-3">
                {{-- Obtenemos las carreras activas --}}
                <h5>Selecciona la carrera a la que atendera el tutor</h5> 
                <select name="car_Clave" id="selCarreras" class="form-control" required>
                    <option value="">Seleccione una carrera</option>
                    @foreach ($carreras as $carrera)
                        <option value="{{$carrera->car_Clave}}">{{$carrera->car_Nombre}}</option>
                    @endforeach
                </select>
            </div>           
            <div class="col-sm-2">
                {{-- Obtenemos los grupos de una carrera especifica --}}
                <h5>Selecciona el grupo a atender</h5>
                <select name="gpo_Id" id="selGrupos" class="form-control" required>
                    <option value="">Seleccione un grupo</option>
                </select>
            </div>           
            <div class="col-sm-2">
                <h5>Selecciona el tipo de tutoria</h5>
                <select name="gtu_Tipo" id="selTipo" class="form-control" required>
                    <option value="">Seleccione un tipo de tutoria</option>
                    <option value="Ingreso">Ingreso</option>
                    <option value="Permanencia">Permanencia</option>
                    <option value="Egreso">Egreso</option>
                    <option value="Jornada">Jornada</option>
                </select>
            </div>       
            <div class="col-sm-1">
                <br>
                <button type="submmit" class="btn btn-primary"  title="Asignar grupo de tutorias"><i class="fas fa-plus"></i></button>
            </div>
        </div>   
    </form>
    <div class="row">
        <div class="col-sm-12">
            <hr>
            <h5>Grupos asignados</h5>
            <table class="table table-hover" id="tabGruposTut">
                <thead>
                    <tr>
                        <th>Numero</th>
                        <th>Profesor</th>                       
                        <th>Grupo</th>
                        <th>Carrera atendida</th>
                        <th>Semestre</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach ($gruTutorias as $grupo)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$grupo->name }}</td>                            
                            <td>{{$grupo->gpo_Nombre}}</td>
                            <td>{{$grupo->car_Nombre}}</td>
                            <td>{{$grupo->gtu_Semestre}} {{ $grupo->gtu_Año }}</td>
                            <td>{{$grupo->gtu_Tipo}}</td>
                            <td>                               
                                <a data-mdb-toggle="modal" data-mdb-target="#modalEliminar" onclick="eliminarGrupo({{ $grupo }})" type="button" class="btn btn-danger" title="Eliminar"><i class="fas fa-trash-alt"></i></a>
                                <a href="{{ route('tutorias.asigTutPDF',$grupo->id) }}" class="btn btn-success" target="_blank"><i class="fas fa-file-contract" title="Imprimir asignación"></i></a>
                                <a href="{{ route('tutorias.libTutPDF',$grupo->id) }}" class="btn btn-secondary" target="_blank"><i class="fas fa-file-contract" title="Imprimir liberación"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>            
        </div>
    </div>  

    {{-- Modal para eliminar grupos --}}
    <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="miModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="formEliminar" method="get">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="miModalLabel">Título del modal</h5>
                    <button type="button" class="close" data-mdb-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <!-- Contenido del modal -->
                        <label id="mensaje"></label>
                        <input type="hidden" name="gpo_Id" id="idGrupo" readonly>
                        <input type="hidden" name="gpo_Nombre" id="gpo_Nombre" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cerrar</button>
                        <button type="submmit" class="btn btn-primary">Eliminar</button>
                    </div>
                </div>
            </form>
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

        //Funcion para llimpiar grupos cuando cambie el semestre
        $("#gtu_Semestre").change(function(){
            $('#selGrupos').empty(); 
            $("#selGrupos").append("<option value='' selected='selected' >Seleccione un grupo</option>"); 
            //Cambiamos la opción seleccionada del select de carreras
            $("#selCarreras").val(""); 
        });

        //Funcion para obtener los grupos de una carrera       
        $("#selCarreras").change(function(){
            var car_Clave = $(this).val();
            var gpo_Semestre = $("#gtu_Semestre").val();
            $.ajax({
                url: "{{route('tutorias.getGruposCar')}}",
                method: 'POST',
                data: {
                    car_Clave:car_Clave,
                    gpo_Semestre:gpo_Semestre
                },
                success: function(data){                        
                    $('#selGrupos').empty(); 
                    $("#selGrupos").append("<option value='' selected='selected'>Seleccione un grupo</option>");  
                    $.each(data, function(key, value){ 
                        $('#selGrupos').append('<option value="'+value.id+'">'+value.gpo_Nombre+'</option>');
                    });                                               
                },                    
                error: function(data){                        
                        console.log('Error al recuperar los grupos, error: ',data);                        
                    }
            });                            
        });          
        
        //Funcion para eliminar un grupo de tutorias
        function eliminarGrupo(grupo){                    
            $("#miModalLabel").text('Eliminar grupo de tutorias');
            $("#mensaje").text('¿Esta seguro de eliminar el grupo de tutorias '+grupo.gpo_Nombre+'?');
            $("#formEliminar").attr('action', "{{ URL::to('/admin/sta') }}/tutorias/tutoriasDestroy/"+grupo.id);
            $("#idGrupo").val(grupo.gpo_Id);
            $("#gpo_Nombre").val(grupo.gpo_Nombre);
        }   
        
       

        //Codigo para adornar las tablas con datatables
        $(document).ready(function() {
            $('#tabGruposTut').DataTable({
                dom: 'Bfrtip',
                responsive: {
                    breakpoints: [
                    {name: 'bigdesktop', width: Infinity},
                    {name: 'meddesktop', width: 1366},
                    {name: 'smalldesktop', width: 1280},
                    {name: 'medium', width: 1188},
                    {name: 'tabletl', width: 1024},
                    {name: 'btwtabllandp', width: 848},
                    {name: 'tabletp', width: 768},
                    {name: 'mobilel', width: 600},
                    {name: 'mobilep', width: 320}
                    ]
                },
                lengthMenu: [
                    [ 5, 10, 25, 50, -1 ],
                    [ '5 reg', '10 reg', '25 reg', '50 reg', 'Ver todo' ]
                ],
                buttons: [
                    {extend: 'collection', text: 'Exportar',
                        buttons: [
                            { extend: 'copyHtml5', text: 'Copiar' },
                            'excelHtml5',
                            'pdfHtml5',
                            { extend: 'print', text: 'Imprimir' },
                        ]},
                    { extend: 'colvis', text: 'Columnas visibles' },
                    { extend:'pageLength',text:'Ver registros'},
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },            
            });
        });
    </script>
@endsection