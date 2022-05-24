@extends('template.molde')

@section('title','Creditos')

@section('ruta')
    <label class="label label-success"> Creditos</label>
@endsection

@section('contenido')
<div>
    @if ($faltan_jefes)
        <div class="alert-info" role="alert" style="padding:1rem;">
            <p style="font-size:large; text-align: center !important;">
                Se encuentran créditos sin jefe asignado, lo cual no permitirá la impresión de constancias
            </p>
        </div>
    @endif
    <br>
    @if (Auth::User()->can('VIP') || Auth::User()->can('CREAR_CREDITOS'))
        <div class="pull-right">
            <a title="Agregar crédito" href="{{route('creditos.create')}}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus" style='font-size:14px'></i>
            </a>           
        </div>
    @endif
    <br>
        <div class="table-responsive">
            <br>
            <table class="table">
                <thead class="thead-dark">
                    <th>No</th>
                    <th>Nombre</th>
                    <th>Jefe</th>
                    <th>Vigente</th>
                    @if (Auth::User()->can('VIP'))
                        <th>Acción</th>
                    @endif
                </thead>
                <tbody>
                @foreach($credito as $cred)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$cred->nombre}}</td>
                        <td>
                            @if( $cred->jefe_nombre==null)
                                {{ "Ninguno" }}
                            @else
                                {{ $cred->jefe_nombre }}
                            @endif
                        </td>
                        <td>
                            @if($cred->vigente=="true")
                                {{ "SI" }}
                            @else
                                {{ "NO" }}
                            @endif
                        </td>
                        <td>
                            @if (Auth::User()->can('MODIFICAR_CREDITOS') || Auth::User()->can('VIP'))                               
                                <a title="Modificar crédito" href="{{ route('creditos.edit',[$cred->id]) }}" class="btn btn-warning btn-sm"><i class="far fa-edit" style='font-size:14px'></i></a>                          
                            @endif
                            
                            @if (Auth::User()->can('ELIMINAR_CREDITOS') || Auth::User()->can('VIP'))                                
                                <a title="Eliminar crédito" data-mdb-toggle="modal" data-mdb-target="#myModalMsg" onclick="undoCredito({{ $cred->id}},'{{ $cred->nombre }}')" class="btn btn-danger btn-sm"><i class="far fa-trash-alt" style='font-size:14px'></i></a>                          
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>                
            </table>
        </div>                
    <div style="text-align:center;"> 
        {!! $credito->render() !!}
    </div> 
    

    <!-- Modal -->
    <div class="modal fade" id="myModalMsg" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Eliminar crédito</h5>
            <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estas seguro que deseas eliminar el crédito?
                <input type="hidden" id="e_id" name="id"  readonly style="border: none">
                <input type="text" id="e_name" readonly onFocus="this.blur()" style="border: none">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
            <a type="button" class="btn btn-primary" id="eliminar">Eliminar</a>            
            </div>
        </div>
        </div>
    </div>   
</div>  
<div style="padding: 200px;"></div>
    @section('js')
        <script>
             //Script para pasar el id del alumno a eliminar para que se use en el modal
            function undoCredito(i,n)
            {
                document.getElementById("e_id").value = i;
                document.getElementById("e_name").value = n;
                document.getElementById("eliminar").href = i+"/destroy";
            }
        </script>   
    @endsection
@endsection
