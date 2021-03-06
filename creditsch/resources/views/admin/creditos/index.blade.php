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
        <div class="toltip pull-right">
            <a href="{{route('creditos.create')}}" class="btn btn-success btn-sm">
                <i class='fas fa-plus-circle' style='font-size:22px'></i>
            </a>
            <span class="toltiptext">Crear un nuevo crédito</span>
        </div>
    @endif
    <br>
        <div class="table-responsive">
            <br>
            <table class="table">
                <thead class="thead-dark">
                    <th>ID</th>
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
                        <td>{{$cred->id}}</td>
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
                                <div class="toltip">
                                    <a href="{{ route('creditos.edit',[$cred->id]) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>
                                    <span class="toltiptext">Editar crédito</span>
                                </div>
                            @endif
                            
                            @if (Auth::User()->can('ELIMINAR_CREDITOS') || Auth::User()->can('VIP'))
                                <div class="toltip">
                                    <a href="{{ route('admin.creditos.destroy',$cred->id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
                                    <span class="toltiptext">Eliminar crédito</span>
                                </div>
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
</div>    
@endsection
