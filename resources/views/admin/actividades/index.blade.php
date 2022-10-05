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
                <input type="checkbox" id="vigente" class="css-checkbox" name="vigente"/>
                <label for="vigente" name="checkbox2_lbl" class="css-label lite-blue-check">Actividades cerradas</label>
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
                <th>Actividad</th>
                <th>No Alumnos</th>
                <th>Porcentaje crédito</th>
                <th>Administrador</th>
                <th>Crédito</th>
                <th>Creado</th>               
                <th>Cierre</th>
                <th>Acción</th>
            </thead>
            <tbody>
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

             //Codigo para adornar las tablas con datatables
             $(document).ready(function() {
                var dataTable = $('#tabActividades').DataTable({

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
                    serverSide: true,
                    ajax: function(data, callback, settings) {
                        data.vigente = document.getElementById('vigente').checked; 
                        $.ajax({
                            url: "{{ route('actividades.cargar.ajax') }}",
                            type: "get",
                            data: data 
                        }).done(function(response) {                            
                            for (let i = 0; i < response.data.length; ++i) {
                                response.data[i]['alumnos'] = (response.data[i]['alumnos'] == 'true' ? 'Si' : 'No');
                                response.data[i]['vigente'] = (response.data[i]['vigente'] == 'true' ? 'Si' : 'No');
                            }
                            callback({
                                draw:response.draw,
                                data:response.data,
                                recordsTotal:response.recordsTotal,
                                recordsFiltered:response.recordsFiltered
                            });
                        });
                    },
                    columns: [
                        {data: 'actividad_nombre'},
                        {data: 'no_alumnos', orderable: true, searchable: false},
                        {data: 'por_cred_actividad', orderable: true, searchable: false},
                        {data: 'administrador', orderable: true, searchable: true},
                        {data: 'credito_nombre'},
                        {data: 'fecha_creacion'},                        
                        {data: 'fecCierre', orderable: false, searchable: false},
                        {data: 'acciones', orderable: false, searchable: false}
                    ],

                });

                $('#vigente').click(function(event){
                    dataTable.ajax.reload();
                });
            });
        </script>
    @endsection
@endsection
