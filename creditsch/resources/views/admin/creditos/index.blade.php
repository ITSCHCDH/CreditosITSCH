@extends('template.molde')

@section('title','Creditos')

@section('ruta')
    <label class="label label-success"> Creditos</label>
@endsection

@section('contenido')
    @if (Auth::User()->can('VIP') || Auth::User()->can('CREAR_CREDITOS'))
        <a href="{{route('creditos.create')}}" class="btn btn-primary">Registrar nuevo credito</a>
    @endif
    <section id="main">
        <aside id="horizontal-scroll">
            <table class="table table-striped">
                <thead>
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
                                <a href="{{ route('creditos.edit',[$cred->id]) }}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>
                            @endif
                            
                            @if (Auth::User()->can('ELIMINAR_CREDITOS') || Auth::User()->can('VIP'))
                                <a href="{{ route('admin.creditos.destroy',$cred->id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </aside>
    </section>  

    {!! $credito->render() !!}
@endsection
