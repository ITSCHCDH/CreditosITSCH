@extends('template.molde')

@section('title','Alumnos')

@section('ruta')
    <label class="label label-success"> Alumnos</label>
@endsection

@section('contenido')

    @if (Auth::User()->hasAnyPermission(['VIP','CREAR_ALUMNOS']))
        <a href="{{route('alumnos.create')}}" class="btn btn-primary">Registrar nuevo alumno</a>
    @endif
    
    <!--Fin del boton de busqueda  -->
    <table class="table table-striped" id="tabla-alumnos">
        <thead>
        <th>ID</th>
        <th>Numero de Control</th>
        <th>Nombre</th>
        <th>Carrera</th>
        <th>Estatus</th>
        @if (Auth::User()->hasAnyPermission(['VIP','ELIMINAR_ALUMNOS','MODIFICAR_ALUMNOS']))
            <th>Acción</th>
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
                    @if($alu->status=="Pendiente")
                        <span class="label label-danger">{{$alu->status}}</span>
                    @else
                        <span class="label label-primary">{{$alu->status}}</span>
                    @endif
                </td>
                <td>
                    @if (Auth::User()->hasAnyPermission(['VIP','MODIFICAR_ALUMNOS']))
                        <a href="{{ route('alumnos.edit',[$alu->id]) }}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>
                    @endif
                    @if (Auth::User()->hasAnyPermission(['VIP','ELIMINAR_ALUMNOS']))
                        <a href="{{ route('admin.alumnos.destroy',$alu->id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div style="margin-bottom: 50px;"></div>
    @section('js')
        <script type="text/javascript">
            $(document).ready(function() {
                $('#tabla-alumnos').DataTable( {
                    "pagingType": "full_numbers"
                } );
            });
        </script>
    @endsection
@endsection