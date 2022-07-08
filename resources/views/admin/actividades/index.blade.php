@extends('template.molde')

@section('title','Actividades')

@section('links')
    <link rel="stylesheet" href="{{ asset('css/checkbox.css')}}">
    <script type="text/javascript" src="{{ asset('plugins/jsCookie/js.cookie.js') }}"></script>
@endsection

@section('ruta')
    <label class="label label-success"> Actividades</label>
@endsection

@section('contenido')
    <form action="{{ route('actividades.index') }}" method="GET" id="actividades-submit">
        <div class="row">    
            <div class="col-sm-4"></div>
            <div class="col-sm-4">                           
                @if ($vigente=='true')
                    <input type="checkbox" id="checkbox5" class="css-checkbox" checked="checked" name="vigente"/>
                @else
                    <input type="checkbox" id="checkbox5" class="css-checkbox" name="vigente"/>
                @endif
                <label for="checkbox5" name="checkbox2_lbl" class="css-label lite-blue-check">Actividades no vigentes</label> 
            </div>  
            <div class="col-sm-4" style="text-align: right !important;">
                @if (Auth::User()->hasAnyPermission(['VIP','CREAR_ACTIVIDAD','VIP_ACTIVIDAD']))                  
                        <a href="{{route('actividades.create')}}" class="text-success">
                            <i class="fa fa-plus fa-2x" aria-hidden="true" title="Agregar actividad"></i>
                        </a>                   
                @endif
            </div>
        </div> 
    </form>
    <br>  
         
    <div class="table-responsive">
        <table class="table" id="tabActividades">
            <thead>
                <th>ID</th>
                <th>Actividad</th>
                <th>Porcentaje crédito</th>
                <th>Crédito</th>
                <th>Alumnos</th>
                <th>No Alumnos</th>
                <th>Administrador</th>
                <th>Vigente</th>
                @if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD','MODIFICAR_ACTIVIDAD','CREAR_ACTIVIDAD','ELIMINAR_ACTIVIDAD','AGREGAR_RESPONSABLES','VIP_SOLO_LECTURA']))
                    <th>Acción</th>
                @endif
            </thead>
            <tbody>
                @foreach($actividad as $act)
                    <tr>
                        <td>{{$act->id}}</td>
                        <td>{{$act->actividad_nombre}}</td>
                        <td>{{$act->por_cred_actividad}}</td>
                        <td>{{$act->credito_nombre}}</td>
                        <td>
                            @if ($act->alumnos == "true")
                                {{ "SI" }}
                            @else
                                {{ "NO" }}
                            @endif
                        </td>
                        <td>{{ $act->no_alumnos }}</td>
                        <td>
                            {{ $act->usuario_nombre }}
                        </td>
                        <td>
                            @if($act->vigente == "true")
                                {{ "SI" }}
                            @else
                                {{ "NO" }}
                            @endif
                        </td>
                        @if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD','MODIFICAR_ACTIVIDAD','CREAR_ACTIVIDAD','ELIMINAR_ACTIVIDAD','AGREGAR_RESPONSABLES','VIP_SOLO_LECTURA']))
                            <td>
                                @if (Auth::User()->hasAnyPermission(['VIP','MODIFICAR_ACTIVIDAD','VIP_ACTIVIDAD']))                               
                                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD']))
                                        <a href="{{ route('actividades.edit',[$act->id]) }}" class="btn btn-warning btn-sm" title="Editar actividad"><i class="fas fa-pencil-alt" style='font-size:14px'></i></a>
                                    @elseif($act->id_user==Auth::User()->id)
                                        <a href="{{ route('actividades.edit',[$act->id]) }}" class="btn btn-warning btn-sm" title="Editar actividad"><i class="fas fa-pencil-alt" style='font-size:14px'></i></a>
                                    @endif                                                            
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','ELIMINAR_ACTIVIDAD','VIP_ACTIVIDAD']))                                
                                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD']))
                                        <button data-mdb-toggle="modal"  data-mdb-target="#modEliminar" onclick="eliminar({{ $act->id  }})" class="btn btn-danger btn-sm" title="Eliminar actividad"> <i class="far fa-trash-alt" style='font-size:14px'></i></button>
                                    @elseif($act->id_user==Auth::User()->id)
                                        <button data-mdb-toggle="modal"  data-mdb-target="#modEliminar" onclick="eliminar({{ $act->id  }})" class="btn btn-danger btn-sm" title="Eliminar actividad"> <i class="far fa-trash-alt" style='font-size:14px'></i></button>
                                    @endif                                                         
                                @endif
                                @if ($act->vigente == 'true' && Auth::User()->hasAnyPermission(['VIP','CREAR_ACTIVIDAD','VIP_ACTIVIDAD']))                               
                                    <a href="#" class="btn btn-info btn-sm" onclick="redireccionar( {{ $act->id }} );" title="Agregar participantes (Alumnos) a la actividad">
                                        <i class="fas fa-users" style='font-size:14px'></i>
                                    </a>                              
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_EVIDENCIA','VERIFICAR_EVIDENCIA','VIP_ACTIVIDAD']))                                
                                    <a href="{{ route('verifica_evidencia.index',['validadas=on','busqueda='.$act->actividad_nombre,"actividades_link=true"]) }}" class="btn btn-success btn-sm" title="Verificar evidencias de esta actividad">
                                        <i class="far fa-edit" style='font-size:14px'></i>
                                    </a>                                                          
                                @endif                               
                                @if (Auth::User()->hasAnyPermission(['VIP','VER_RESPONSABLES','VIP_ACTIVIDAD','VIP_SOLO_LECTURA']))                                
                                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD','VIP_SOLO_LECTURA']))
                                        <a href="{{ route('responsables',$act->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-user-plus" style='font-size:14px' title="Asignar responsables"></i></a>
                                    @elseif($act->id_user==Auth::User()->id)
                                        <a href="{{ route('responsables',$act->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-user-plus" style='font-size:14px' title="Asignar responsables"></i></a>
                                    @endif                                                             
                                @endif  
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>    


   <!-- Modal -->
    <div class="modal fade" id="modEliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Eliminar actividad</h5>
            <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Estas seguro(a) de eliminar está actividad</div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
            <a id="btnEliminar" type="button" class="btn btn-primary">Eliminar</a>
            </div>
        </div>
        </div>
    </div>
    
    <div style="margin-bottom: 200px;"></div>

    @section('js')
        <script>
            function eliminar(act)
            {                
                r="actividades/"+act+"/destroy";  
                $('#btnEliminar').attr('href',r);              
            }

            function redireccionar(actividad_id)
            {                
                Cookies.set('participantes_actividad',actividad_id,{ expires: 1});
                window.location.href = "{{ route('participantes.index',['actividades_link=true']) }}";
            }
            
            $('#checkbox5').click(function(event){
                var value = $(this).is(':checked');                
                $('#actividades-submit').submit();
            });

             //Codigo para adornar las tablas con datatables
             $(document).ready(function() {               
                $('#tabActividades').DataTable({

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