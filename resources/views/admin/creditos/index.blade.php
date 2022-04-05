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
            <a title="Agregar crédito" href="{{route('creditos.create')}}" class="btn btn-success btn-sm">
                <i class="fas fa-plus" style='font-size:14px'></i>
            </a>           
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
                                <a title="Modificar crédito" href="{{ route('creditos.edit',[$cred->id]) }}" class="btn btn-warning btn-sm"><i class="far fa-edit" style='font-size:14px'></i></a>                          
                            @endif
                            
                            @if (Auth::User()->can('ELIMINAR_CREDITOS') || Auth::User()->can('VIP'))                                
                                <a title="Eliminar crédito" href="{{ route('admin.creditos.destroy',$cred->id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger btn-sm"><i class="far fa-trash-alt" style='font-size:14px'></i></a>                          
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
<br>
<br>
<br>
<br>
<br>
@endsection
