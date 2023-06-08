@extends('template.molde')

@section('title','Tutorias')

@section('ruta')
    <label class="label label-success"> <a href="#">STA</a> / <a href="{{ route('tutores.index') }}"> Tutor </a> /Grupo: {{ $grupo[0]->gpo_Nombre }} </label> 
@endsection

@section('contenido')
    <div class="row">
        <div class="col-sm-3"><h5>TUTOR: {{ $grupo[0]->nomTutor }}</h5></div>
        <div class="col-sm-4"><h5>CARRERA: {{ $grupo[0]->car_Nombre }}</h5></div>
        <div class="col-sm-3"></div>
        <div class="col-sm-2"></div>
    </div>
    <hr>
    <table class="table" id="tabGrupoTut">
        <thead>
            <th>Número</th>
            <th>No. Control</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            @foreach($alumnos as $alu)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $alu->alu_NumControl }}</td>
                    <td>{{ $alu->alu_Nombre }} {{ $alu->alu_ApePaterno }} {{ $alu->alu_ApeMaterno }}</td>
                    <td>
                        <a href="" class="btn btn-primary">Ver</a>
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
        $('#tabGrupoTut').DataTable({
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