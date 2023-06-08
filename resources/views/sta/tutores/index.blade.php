@extends('template.molde')

@section('title','Tutorias')

@section('ruta')
    <label class="label label-success"> <a href="#">STA</a> / Tutor</label> 
@endsection

@section('contenido')
    <table class="table" id="gpoAsignados">
        <thead>
            <th>Número</th>
            <th>Tutor</th>
            <th>Grupo</th>
            <th>Carrera</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            @foreach($grupos as $grupo)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$grupo->name}}</td>
                    <td>{{$grupo->gpo_Nombre}}</td>
                    <td>{{$grupo->car_Nombre}}</td>
                    <td>
                        <a href="{{route('tutores.showGrupo',$grupo->id)}}" class="btn btn-primary">Ver</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('js')
    <script>
        //Codigo para adornar las tablas con datatables
        $(document).ready(function() {
            $('#gpoAsignados').DataTable({
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
                language: {
                    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },            
            });
        });
    </script>
@endsection