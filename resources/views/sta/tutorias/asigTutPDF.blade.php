<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Asignación de tutores</title>   
    <style>
        p {
            font-family: serif, sans-serif;
            font-size: 12px;
            text-align: justify;
        }
       
        html {
            min-height: 100%;
            position: relative;
        }
        body {
            margin: 0;
            margin-bottom: 40px;
        }
        footer {           
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 40px;                
        }
       
    </style>
</head>
<body style="margin-left: 25px; margin-right: 25px">
    <head> 
         <table>
            <tbody>
                <tr>
                    <td style="width: 150px"></td>
                    <td><img src="{{ asset('images/itsch.jpg') }}" alt="ISTCH" style="max-width: 40px;"></td>
                    <td><h6>INSTITUTO TECNOLÓGICO SUPERIOR DE CIUDAD HIDALGO</h6></td>
                    <td></td>
                </tr>
            </tbody>
         </table>
    </head>
   
    <h5>{{strtoupper($data->name)  }} <br>PERSONA TUTORA <br>PRESENTE</h5> 
    <p>Por medio de la presente reciba un cordial saludo, así mismo le hago entrega
        de su nombramiento como persona tutora de <b>{{ $data->gtu_Tipo }}</b> del grupo <b>{{ $data->gpo_Nombre }}</b> de la carrera
        de <b>{{ strtoupper($data->car_Nombre) }}</b>, para el semestre <b>{{  $data->gtu_Semestre }} {{ $data->gtu_Año }}</b>. Dentro del programa Institucional de Tutorías del Instituto
        Tecnológico Superior De Ciudad Hidalgo (ITSCH). </p>

    <p>Le exhorto amablemente a brindar un servicio de calidad a través de la tutoría, que contribuya al cumplimiento de sus objetivos como son: el reducir los
        índices de reprobación y deserción, potenciar las competencias del estudiante mediante acciones preventivas y correctivas, asi como apoyar al estudiante en el
        proceso de toma de decisiones relativas a la construcción de su trayectoria formativa, de acuerdo con su vocación, intereses y competencias, mediante la
        atención personalizada y/o grupal en donde se apoye la formación de la persona tutorada. </p>    

    <p>Sin más por el momento me despido deseándole éxito en su encomienda y reiterando mi salud o afectuoso . </p>
    <div style="height: 200px"></div>
    <b>ATENTAMENTE</b>
    <p>"Exelencia en educación tecnologica"</p>
    <p>"Educación herencia para el exito"</p>
    <br>
    <br>
    <br>
    <br>
    <b>DR en D. JAIME PÉREZ TORRES</b>
    <p>DIRECTOR GENERAL</p>
    <p>INSTITUTO TECNOLÓGICO SUPERIOR DE CIUDAD HIDALGO</p>
    <br>
    <p><small>C.C.P LPE. María de Lourdes Sanchez Mora, Jefa del departamento de Tutorías y Servicios Psicopedagógicos</small></p>
    <p><small>C.C.P Para el archivo</small></p>

    <footer class="footer"><p style="text-align: right">Julio 2023</p></footer>
    
</body>
</html>