@extends('template.molde')

@section('title','Alumnos')

@section('ruta')
    <label class="label label-success"> Alumnos</label>
@endsection

@section('contenido')
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <div style="text-align: right;">
                @if (Auth::User()->hasAnyPermission(['VIP','CREAR_ALUMNOS']))
                    <a href="{{route('alumnos.create')}}" class="btn btn-info btn-sm" title="Agregar alumno">
                        <i class="fas fa-user-plus" style="font-size:20px"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table" id="tabla-alumnos">
            <thead>
            <th>ID</th>
            <th>Numero de Control</th>
            <th>Nombre</th>
            <th>Carrera</th>
            <th>Estatus</th>
            @if (Auth::User()->hasAnyPermission(['VIP','ELIMINAR_ALUMNOS','MODIFICAR_ALUMNOS']))
                <th>Acciónes</th>
            @endif
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div style="margin-bottom: 200px;"></div>
    
    <!--Modal para mensajes del sistema-->
    <div class="modal" id="myModalMsg">
        <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Mensaje</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" id="uno">
                ¿Estas seguro que deseas eliminar el alumno?
                <input type="hidden" id="e_id" name="id"  readonly style="border: none">
                <input type="text" id="e_name" readonly onFocus="this.blur()" style="border: none">
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <a  class="btn btn-danger" id="prueba">Aceptar</a>
                <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
        </div>
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
                        {data: 'status', orderable: true, searchable: true},
                        {data: 'acciones', orderable: false, searchable: false}
                    ],
                });
            });


            //Script para pasar el id del alumno a eliminar para que se use en el modal
            function undo_alumno(i,n)
            {
                document.getElementById("e_id").value = i;
                document.getElementById("e_name").value = n;
                document.getElementById("prueba").href = "alumnos/"+i+"/destroy";
            }
        </script>
    @endsection
@endsection
