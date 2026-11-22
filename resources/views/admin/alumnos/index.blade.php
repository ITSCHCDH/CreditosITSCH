@extends('template.molde')

@section('title','Alumnos')

@section('ruta')
    <label class="label label-success">Alumnos</label>
@endsection

@section('contenido')
    <div class="table-responsive">
        <table class="table" id="tabla-alumnos">
            <thead>
                <th>ID</th>
                <th>Numero de Control</th>
                <th>Nombre</th>
                <th>Carrera</th>
                <th>Correo</th>
                <th>Estatus</th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    @section('js')
        <script>
            //Codigo para adornar las tablas con datatables
            $(document).ready(function() {
                $('#tabla-alumnos').DataTable({

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
                    ajax: {
                        url: "{{ route('admin.alumnos.cargar.ajax') }}",
                        type: "get",
                    },
                    columns: [
                        {data: 'alumno_id', searchable: false},
                        {data: 'no_control'},
                        {data: 'nombre'},
                        {data: 'carrera'},
                        {data: 'email'},
                        {data: 'status', orderable: true, searchable: false}
                    ],
                });
            });
        </script>
    @endsection
@endsection
