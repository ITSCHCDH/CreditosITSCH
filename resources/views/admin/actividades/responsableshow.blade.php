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
                                            <a href="{{ route('actividad_evidencias.destroy',$res->actividad_evidencia_id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" title="Quitar responsable">
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
                                            <div class="toltip">
                                                 <a href="{{ route('actividad_evidencias.destroy',$res->actividad_evidencia_id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
                                                <span class="toltiptext">Eliminar Responsable</span>     
                                            </div>                                            
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
    <div style="margin-bottom: 50px;"></div>
    @section('js')
        <script type="text/javascript">
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