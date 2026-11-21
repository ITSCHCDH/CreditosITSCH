@extends('template.molde')

@section('title','Actividades')

@section('links')
    <link rel="stylesheet" href="{{ asset('css/checkbox.css')}}">
    <script type="text/javascript" src="{{ asset('plugins/jsCookie/js.cookie.js') }}"></script>
    <style>
        .activity-page-toolbar { display:flex;align-items:flex-end;justify-content:space-between;gap:1rem;margin-bottom:1rem; }
        .activity-page-toolbar h1 { margin:0;color:#102b4a;font-size:clamp(1.5rem,3vw,2.1rem);font-weight:700; }
        .activity-page-toolbar p { margin:.35rem 0 0;color:#6b7280; }
        .activity-filter-card { display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1rem;padding:.85rem 1rem;border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06); }
        .activity-table-card { border:1px solid #e7edf4;border-radius:1.1rem;background:#fff;overflow:hidden;box-shadow:0 1rem 2.25rem rgba(29,78,116,.12),0 .25rem .65rem rgba(16,43,74,.07); }
        .activity-table-card .table { margin:0; }
        @media(max-width:767.98px){.activity-page-toolbar,.activity-filter-card{align-items:flex-start;flex-direction:column}.activity-filter-card .btn{width:100%}}
    </style>
@endsection

@section('ruta')
@endsection

@section('contenido')
<div class="activity-page-toolbar">
    <div><h1>Actividades</h1><p>Consulta, administra y asigna participantes.</p></div>
    @if(Auth::User()->hasAnyPermission(['VIP','CREAR_ACTIVIDAD','VIP_ACTIVIDAD']))
        <a href="{{ route('actividades.create') }}" class="btn btn-primary rounded-pill"><i class="fa-solid fa-plus me-2"></i>Nueva actividad</a>
    @endif
</div>

<div class="activity-filter-card">
    <div class="d-flex align-items-center gap-2">
        <i class="fa-solid fa-filter text-primary"></i>
        <strong>Filtros</strong>
    </div>
    <form action="{{ route('actividades.index') }}" method="GET" id="actividades-submit">
        <div class="form-check form-switch mb-0">
            <input type="checkbox" id="vigente" class="form-check-input" name="vigente"/>
            <label for="vigente" class="form-check-label">Mostrar actividades cerradas</label>
        </div>
    </form>
</div>

<div class="activity-table-card">
    <div class="table-responsive">
        <table class="table align-middle mb-0" id="tabActividades">
            <thead class="table-light">
                <th>Actividad</th>
                <th>No Alumnos</th>
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
            <form id="formEliminar" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-primary">Eliminar</button>
            </form>
            </div>
        </div>
        </div>
    </div>  

    @section('js')
        <script>
            function eliminar(act)
            {   
                $('#formEliminar').attr('action',"{{ url('/admin/actividades') }}/"+act);
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
