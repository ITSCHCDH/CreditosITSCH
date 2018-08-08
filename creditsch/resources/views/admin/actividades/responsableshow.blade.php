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
            <a href="{{route('responsables.index',$actividad->id)}}" class="btn btn-primary">Asignar Responsables</a>
        @endif
    @elseif(Auth::User()->hasAllPermissions(['AGREGAR_RESPONSABLES','ELIMINAR_RESPONSABLES']))
        @if ($actividad!=null)
            @if ($actividad->id_user==Auth::User()->id)
                <a href="{{route('responsables.index',$actividad->id)}}" class="btn btn-primary">Asignar Responsables</a>
            @endif
        @endif
    @endif
    <table class="table table-striped" id="tabla-responsables">
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
                                <td>
                                  <a href="{{ route('actividad_evidencias.destroy',$res->actividad_evidencia_id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
                                </td>
                            @elseif($actividad->id_user==Auth::User()->id)
                                <td>
                                  <a href="{{ route('actividad_evidencias.destroy',$res->actividad_evidencia_id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
                                </td>
                            @endif
                        @endif
                        
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div style="margin-bottom: 50px;"></div>
    @section('js')
        <script type="text/javascript">

            $(document).ready(function(){
                $('#tabla-responsables').DataTable({
                    "pagingType":"full_numbers"
                });
            });
        </script>
    @endsection
@endsection