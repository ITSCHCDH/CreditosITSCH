<!-- Tabla para mostrar los partipantes, se hizo de esta manera para posteriormente actualizarla
    con JQuery o Ajax -->
<thead id="mitabla">
    <th>ID</th>
    <th>Numero de Control</th>
    <th>Nombre</th>
    <th>Carrera</th>
    <th>Accion</th>
</thead>
<tbody id="mitabla">
    @foreach($participantes as $par)
    <tr>
        <td>{{$par->id}}</td>
        <td>{{$par->no_control}}</td>
        <td>{{$par->nombre}}</td>
        <td>{{$par->carrera}}</td>
        <td>  
            <a href="{{ route('admin.participantes.destroy',$par->id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
        </td>
    </tr>
    @endforeach
</tbody>