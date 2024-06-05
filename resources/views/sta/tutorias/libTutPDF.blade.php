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
                    <td style="width: 50px;"></td>
                    <td style="width: 100px;"><img src="{{ asset('images/itsch.jpg') }}" alt="ISTCH" style="max-width: 40px;"></td>
                    <td><h6>INSTITUTO TECNOLÓGICO SUPERIOR DE CIUDAD HIDALGO</h6></td>
                    <td style="width: 100px; text-align:right;"><img src="{{ asset('images/LogoTecNM.png') }}" alt="TECNM" style="max-width: 80px;"></td>
                </tr>
            </tbody>
         </table>
    </head>
    <h5>A QUIEN CORRESPONDA: </h5>
    <p style="line-height:3;">LOS QUE SUSCRIBEN, LA MTRA. MARIA DE LOURDES SÁNCHEZ MORA. JEFA DEL DEPARTAMENTO DE TUTORIAS Y SERVICIOS PSICOPEDAGÓGICOS Y EL ISC. OSCAR DELGADO CAMACHO, ENCARGADO DE LA SUBDIRECCIÓN ACADÉMICA DEL INSTITUTO TECNOLÓGICO NACIONAL DE MÉXICO CAMPUS CIUDAD HIDALGO: </p>
    <div style="text-align: center;">
        <b>HACEN CONSTAR</b>
    </div>
    <p style="line-height:3;">
        QUE <b>{{ strtoupper($data->name) }}</b> CONCLUYÓ SATISFACTORIAMENTE CON EL PROGRAMA INSTITUCIONAL DE TUTORÍAS EN EL SEMESTRE <b>{{  strtoupper($data->gtu_Semestre) }} {{ $data->gtu_Año }}</b> 
        EN EL INSTITUTO TECNOLÓGICO SUPERIOR DE CIUDAD HIDALGO, CUMPLIENDO CON LA MODALIDAD DE  <b>{{strtoupper($data->gtu_Tipo) }}</b>
        EN EL GRUPO <b>{{ strtoupper($data->gpo_Nombre) }}</b> DE LA CARRERA DE <b>{{ strtoupper($data->car_Nombre) }}</b>. 
    </p>

    <p style="line-height:3;">
        A SOLICITUD DEL INTERESADO(A), SE EMITE LA PRESENTE PARA LOS FINES QUE ÉL(ELLA) JUZGUE CONVENIENTES. EN CIUDAD HIDALGO, MICHOACÁN A
        {{ strtoupper(\Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM YYYY')) }}        
    </p>
    
    
    <div style="height: 100px"></div>

    <table>
        <tbody>
            <tr>                
                <td>
                    <b>ATENTAMENTE</b>
                    <p>"Exelencia en educación tecnologica"</p>
                    <p>"Educación herencia para el exito"</p>
                    <br>
                    <br>
                    <br>
                    <br>
                    <b><small>MTRA. MARÍA DE LOURDES SÁNCHEZ MORA</small></b>
                    <p><small>JEFA DEL DEPARTAMENTO DE TUTORIAS Y SERV. PSICO.</small></p>
                    <p><small>INSTITUTO TECNOLÓGICO SUPERIOR DE CIUDAD HIDALGO</small></p>
                </td>
                <td style="width: 40px;"></td>
                <td>
                    <b>Vo.Bo.</b>
                    <p>"Exelencia en educación tecnologica"</p>
                    <p>"Educación herencia para el exito"</p>
                    <br>
                    <br>
                    <br>
                    <br>
                    <b><small>ISC. OSCAR DELGADO CAMACHO</small></b>
                    <p><small>ENCARGADO DE LA SUBDIRECCIÓN ACADÉMICA</small></p>
                    <p><small>INSTITUTO TECNOLÓGICO SUPERIOR DE CIUDAD HIDALGO</small></p>
                </td>               
            </tr>
        </tbody>
    </table> 
    
    <p><small>C.C.P Para el archivo</small></p>

    <footer class="footer"><p style="text-align: right">Julio 2023</p></footer>
    
</body>
</html>