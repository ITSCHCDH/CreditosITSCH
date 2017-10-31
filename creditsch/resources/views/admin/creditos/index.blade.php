@extends('template.molde')

@section('title','Creditos')

@section('ruta')
    <label class="label label-success"> Creditos</label>
@endsection

@section('contenido')

    <a href="{{route('creditos.create')}}" class="btn btn-info">Registrar nuevo credito</a>
    <table class="table table-striped">
        <thead>
        <th>ID</th>
        <th>Nombre</th>
        <th>Acción</th>
        </thead>
        <tbody>
        @foreach($credito as $cred)
            <tr>
                <td>{{$cred->id}}</td>
                <td>{{$cred->nombre}}</td>
                <td>
                    <a href="{{ route('creditos.edit',[$cred->id]) }}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>
                    <a href="{{ route('cred.creditos.destroy',$cred->id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {!! $credito->render() !!}
@endsection