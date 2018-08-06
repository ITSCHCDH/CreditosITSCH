@extends('template.molde')

@section('title','Responsables')

@section('ruta')
    <a href="{{route('actividades.index')}}">Actividades</a>
    /
    <label class="label label-success">Responsables</label>
@endsection

@section('contenido')
    @if ($actividad!=null)
        <a href="{{route('responsables.index',$actividad->id)}}" class="btn btn-info">Asignar Responsables</a>
    @endif
    <table class="table table-striped" id="tabla-responsables">
        <thead>
            <th>Nombre</th>
            <th>Area</th>
            <th>Accion</th>
        </thead>
        <tbody>
            @if($responsables!=null)
                @foreach($responsables as $res)
                    <tr>
                        <td>
                            {{$res->name}}
                        </td>
                        <td>
                            {{$res->area}} 
                        </td>
                        <td>
                          <a href="{{ route('actividad_evidencias.destroy',$res->actividad_evidencia_id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
                        </td>
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