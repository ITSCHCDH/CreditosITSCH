@extends('template.molde')

@section('title','Analisis del grupo')

@section('ruta')
    <label class="label label-success"> <a href="#">STA</a> / <a href="{{ route('tutores.index') }}"> Tutor </a> /Analisis: Grupo {{ $grupo[0]->gpo_Nombre }} </label> 
@endsection

@section('contenido')
    <table class="table" id="tabGrupoTut">
        <thead>
            <tr>
                <th>Número</th>
                <th>No. Control</th>
                <th>Nombre</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alumnosGrupo as $alumno)
                <tr>
                    <td><strong style="font-size: 1.2em;">{{ $loop->iteration }}</strong></td>
                    <td><strong style="font-size: 1.2em;">{{ $alumno->no_Control }}</strong></td>
                    <td><strong style="font-size: 1.2em;">{{ $alumno->alu_Nombre }}</strong></td>
                </tr>
                <tr>
                    <td colspan="3">
                        @php
                            $unidades = [];

                            // Obtener todas las unidades disponibles
                            foreach ($alumno->materias as $materia) {
                                $unidades[$materia->lsc_NumUnidad] = true;
                            }

                            $unidades = array_keys($unidades);
                            sort($unidades); // Ordenar las unidades de manera ascendente
                        @endphp

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Materia</th>
                                    <!-- Aquí puedes agregar más encabezados según las unidades o lo que necesites -->
                                    @foreach ($unidades as $unidad)
                                        <th>Unidad {{ $unidad }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $materias = [];

                                    // Obtener todas las materias del alumno
                                    foreach ($alumno->materias as $materia) {
                                        if (!in_array($materia->ret_NomCorto, $materias)) {
                                            $materias[] = $materia->ret_NomCorto;
                                        }
                                    }

                                    sort($materias); // Ordenar las materias alfabéticamente
                                @endphp

                                <!-- Generar filas para cada materia -->
                                @foreach ($materias as $materia)
                                    <tr>
                                        <td>{{ $materia }}</td>
                                        @foreach ($unidades as $unidad)
                                            @php
                                                $calificacion = '_';
                                                foreach ($alumno->materias as $m) {
                                                    if ($m->ret_NomCorto === $materia && $m->lsc_NumUnidad == $unidad) {
                                                        $calificacion = $m->lsc_Calificacion;
                                                        break;
                                                    }
                                                }
                                            @endphp
                                            <td style="color: 
                                                @if($calificacion < 70) red
                                                @elseif($calificacion >= 70 && $calificacion <= 79) orange
                                                @elseif($calificacion == '_') black
                                                @else green
                                                @endif">
                                                {{ $calificacion }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

