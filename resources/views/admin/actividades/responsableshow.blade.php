@extends('template.molde')

@section('title','Responsables')

@section('ruta')
    <a href="{{route('actividades.index')}}">Actividades</a>
    /
    <label class="label label-success">Responsables</label>
@endsection

@section('contenido')
    @if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD']))
        @if ($actividad!=null)
            @if($actividad->vigente=="true")                
                <a href="{{route('responsables.index',$actividad->id)}}" title="Agregar responsables">
                    <i class="fas fa-users fa-3x amber-text"></i>
                </a>                               
            @endif
        @endif
    @elseif(Auth::User()->hasAllPermissions(['AGREGAR_RESPONSABLES','ELIMINAR_RESPONSABLES']))
        @if ($actividad!=null)
            @if ($actividad->id_user==Auth::User()->id && $actividad->vigente=="true")
                <a href="{{route('responsables.index',$actividad->id)}}" title="Agregar responsables">
                    <i class="fas fa-users fa-3x amber-text"></i>
                </a>                
            @endif
        @endif
    @endif
    <div class="table-responsive">
        <br>
        <table class="table" id="tabResponsables">
            <thead>
                <th>Nombre</th>
                <th>Area</th>
                @if (Auth::User()->hasAnyPermission(['ELIMINAR_RESPONSABLES','VIP','VIP_ACTIVIDAD']))
                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD']))
                        <th>Accion</th>
                    @elseif($actividad!=null && Auth::User()->can('ELIMINAR_RESPONSABLES'))
                        @if($actividad->id_user==Auth::User()->id)
                            <th>Accion</th>
                        @endif
                    @endif
                @endif
            </thead>
            <tbody>
                @if($responsables!=null && $actividad!=null)
                    @foreach($responsables as $res)
                        <tr>
                            <td>
                                {{$res->name}}
                            </td>
                            <td>
                                {{$res->area}} 
                            </td>
                            @if (Auth::User()->hasAnyPermission(['ELIMINAR_RESPONSABLES','VIP','VIP_ACTIVIDAD']))
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD']))
                                    @if($actividad->vigente=="true")
                                        <td>                                            
                                            <a href="#" data-mdb-toggle="modal"  data-mdb-target="#modEliminar" onclick="eliminar({{ $res->actividad_evidencia_id  }})"  title="Quitar responsable">
                                                <i class="far fa-trash-alt fa-lg red-text"></i>
                                            </a>                                                                            
                                        </td>
                                    @else
                                        <td>
                                            {{ "Ninguna" }}
                                        </td>
                                    @endif                     
                                @elseif($actividad->id_user==Auth::User()->id)
                                    @if($actividad->vigente=="true")
                                        <td>
                                            <a href="#" data-mdb-toggle="modal"  data-mdb-target="#modEliminar" onclick="eliminar({{ $res->actividad_evidencia_id  }})"  title="Quitar responsable">
                                                <i class="far fa-trash-alt fa-lg red-text"></i>
                                            </a>                                            
                                        </td>
                                    @else
                                        <td>
                                            {{ "Ninguna" }}
                                        </td>
                                    @endif
                                @endif
                            @endif                            
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modEliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Eliminar responsable</h5>
            <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Estas seguro(a) de eliminar este responsable </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
            <a id="btnEliminar" type="button" class="btn btn-primary">Eliminar</a>
            </div>
        </div>
        </div>
    </div>


    <div style="margin-bottom: 50px;"></div>
    @section('js')
        <script type="text/javascript">
            function eliminar(act)
            {   //Sirve para cambiar una ruta y que no se concatene con lo anterior
                c="{{ url("")}}";            
                r=c+"/admin/actividad_evidencias/"+act+"/destroy";  
                //Agregamos la ruta a una etiqueta a        
                $('#btnEliminar').attr('href',r);              
            }


             //Codigo para adornar las tablas con datatables
             $(document).ready(function() {
                $('#tabResponsables').DataTable({

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
@endsection