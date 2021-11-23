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
        <table class="table table-striped table-bordered" id="tabla-alumnos">
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
                @foreach($alumno as $alu)
                    <tr>
                        <td>{{$alu->id}}</td>
                        <td>{{$alu->no_control}}</td>
                        <td>{{$alu->nombre}}</td>
                        <td>{{$alu->carrera}}</td>
                        <td>
                            @if($alu->status == "Pendiente" || $alu->status == "pendiente")
                                <span class="label label-danger">Pendiente</span>
                            @else
                                <span class="label label-primary">Liberado</span>
                            @endif
                        </td>
                        <td>
                            @if (Auth::User()->hasAnyPermission(['VIP','MODIFICAR_ALUMNOS']))                            
                                <a href="{{ route('alumnos.edit',[$alu->id]) }}" class="btn btn-warning btn-sm" title="Modificar alumno"><i class="fas fa-user-edit" style="font-size:14px"></i></a>                      
                            @endif
                            @if (Auth::User()->hasAnyPermission(['VIP','ELIMINAR_ALUMNOS']))                            
                                <a  class="btn btn-danger btn-sm" onclick="undo_alumno({{$alu->id}})" data-toggle="modal" data-target="#myModalMsg" title="Eliminar alumno"><i class="far fa-trash-alt" style="font-size:14px"></i></a>                                                     
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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
                <input type="text" id="e_id" name="id"  readonly onFocus="this.blur()" style="border: none">

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
                    "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                }
                });
            });

            //Script para pasasr el id del alumno a eliminar para que se use en el modal
            function undo_alumno(n)
            {	            
                document.getElementById("e_id").value = n;	           					
                document.getElementById("prueba").href = "alumnos/"+n+"/destroy";
            }
        </script>
    @endsection

    
@endsection