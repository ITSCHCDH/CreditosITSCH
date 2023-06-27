@extends('template.molde');

@section('title','Tutorias')

@section('ruta')
    <label class="label label-success"> <a href="#">STA</a> / <a href="{{ route('tutorias.index') }}">Tutorias</a>/Grupos </label> 
@endsection

@section('contenido')
    <form action="{{ route('tutorias.saveGrupo') }}" method="POST">
        @csrf
        <div class="row">        
            <div class="col-sm-1"></div>
            <div class="col-sm-3">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Semestre</span>
                    </div>
                    <select name="gpo_Semestre" id="gpo_SemestreInp" class="form-control" required>
                        <option value="">Selecciona un semestre</option>
                        <option value="Feb-Jun">Febrero Junio</option>
                        <option value="Ago-Dic">Agosto Diciembre</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Nombre del grupo</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Nombre" aria-label="Grupo" aria-describedby="basic-addon1" name="gpo_Nombre" id="gpo_Nombre" required>
                </div> 
            </div>
            <div class="col-sm-4">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="selCarreras">Carrera</label>
                    </div>
                    <select class="form-control" id="selCarreras" name="id_Carrera" required>
                        <option value="">Seleccione una carrera</option>
                        @foreach ($carreras as $carrera)
                            <option value="{{$carrera->car_Clave}}">{{$carrera->car_Nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>      
        </div>
    </form>
    <div class="container">
        <table class="table" id="tabGrupos">
            <thead>
                <th>Numero</th>
                <th>Nombre</th>
                <th>Carrera</th>
                <th>Semestre</th>
                <th>Status</th>
                <th>Acciones</th>
            </thead>
            <tbody>
                @foreach ($grupos as $grupo)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$grupo->gpo_Nombre}}</td>
                        <td>{{$grupo->gpo_Carrera}}</td>
                        <td>{{$grupo->gpo_Semestre}}</td>
                        <td>@if($grupo->gpo_Status==0)Sin asignar @else Asignado @endif</td>
                        <td>                            
                            <button type="button" class="btn btn-warning" onclick="modificarGrupo({{ $grupo }})" data-mdb-toggle="modal" data-mdb-target="#myModalUpdate">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger" onclick="eliminarGrupo({{ $grupo }})"  data-mdb-toggle="modal" data-mdb-target="#myModalDelete">
                                <i class="fas fa-trash"></i>
                            </button>
                          
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

   
  
    <!-- Modal Editar-->
    <div class="modal fade" id="myModalUpdate" tabindex="-1" aria-labelledby="myModalUpdate" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formUpdateGrupo" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="myModalUpdate">Editar Grupo</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">               
                            <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >Nombre del grupo</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Nombre" aria-label="Grupo" aria-describedby="basic-addon1" name="gpo_Nombre" id="gpo_NombreMod" required>                    
                            <input type="hidden" id="status" name="gpo_Status" readonly> 
                        </div>                   
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="selCarreras">Carrera</label>
                            </div>
                            <select class="form-control" id="selCarrerasMod" name="id_Carrera" required>
                                <option value="">Seleccione una carrera</option>
                                @foreach ($carreras as $carrera)
                                    <option value="{{$carrera->car_Clave}}">{{$carrera->car_Nombre}}</option>
                                @endforeach
                            </select>                       
                        </div>  
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="selCarreras">Semestre</label>
                            </div>
                            <select class="form-control" id="selSemestreMod" name="gpo_Semestre" required>
                                <option value="">Seleccione un semestre</option>
                                <option value="Feb-Jun">Febrero Junio</option>
                                <option value="Ago-Dic">Agosto Diciembre</option>
                            </select>                       
                        </div>                              
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Editar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Eliminar-->      
    <div class="modal fade" id="myModalDelete" tabindex="-1" aria-labelledby="myModalDelete" aria-hidden="true">
        <div class="modal-dialog">
            {{-- Creamos un form sin action para cuando la variable grupo no contiene datos --}}
            @if(isset($grupo))
                <form action="{{ route('tutorias.deleteGrupo',$grupo->id) }}" method="get">
            @else
                <form action="" method="get">
            @endif            
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="myModalDelete">Eliminar Grupo</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            
                            <p id="mensaje"></p>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Eliminar</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
@endsection



@section('js')
    <script>
         //Convierte a mayusculas
         $("#gpo_Nombre").keyup(function(){
            $(this).val($(this).val().toUpperCase());
        });

        function modificarGrupo(grupo){          
            $("#gpo_NombreMod").val(grupo.gpo_Nombre);
            $("#selCarrerasMod").val(grupo.id_Carrera);
            $("#status").val(grupo.gpo_Status);
            $("#selSemestreMod").val(grupo.gpo_Semestre);
            $("#formUpdateGrupo").attr('action', "{{ URL::to('/admin/sta') }}/tutorias/grupos/"+grupo.id+"/update"); 
        }

        function eliminarGrupo(grupo){
            $("#mensaje").html("¿Estas seguro de eliminar el grupo "+grupo.gpo_Nombre+"?");
            $("#formDeleteGrupo").attr('action', "{{ URL::to('/admin/sta') }}/tutorias/grupos/"+grupo.id+"/delete"); 
        }

        //Codigo para adornar las tablas con datatables
        $(document).ready(function() {
            $('#tabGrupos').DataTable({

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