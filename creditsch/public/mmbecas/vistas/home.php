<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="width=device-width, initial-scale=1.0"; charset=UTF-8">

        <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
        <script type="text/javascript" src="js/cambiarPestanna.js"></script>
        <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
        <title></title>
    </head>
    <body>
         <div id="menu">
        <ul>
            <li>Home</li>
            <li class="cerrar-sesion"><a href="includes/logout.php">Cerrar sesión</a></li>
        </ul>
    </div>

        
        <div class="contenedor">
            <div id="pestanas">
                <ul id=lista>
                    <li id="pestana1"><a href='javascript:cambiarPestanna(pestanas,pestana1);'>Datos Personales</a></li>
                    <li id="pestana2"><a href='javascript:cambiarPestanna(pestanas,pestana2);'>Información Personal</a></li>
                    <li id="pestana3"><a href='javascript:cambiarPestanna(pestanas,pestana3);'>Información del Hogar</a></li>
                    <li id="pestana4"><a href='javascript:cambiarPestanna(pestanas,pestana4);'>Datos Familiares</a></li> 
                </ul>
            </div>
            
            <body onload="javascript:cambiarPestanna(pestanas,pestana1);">
       
            <section id="contenidopestanas">
                <section id="cpestana1">
                   <?php 
                  include_once 'datos/datos_personales.php';
                    ?>
                </section>
                <section id="cpestana2">
                    <?php 
                     include_once 'datos/info_personal.php';
                    ?>
                </section>
                <section id="cpestana3">
                    <?php
                    include_once 'datos/info_hogar.php'
                     ?>
                      </section>
                <section id="cpestana4">
                    <?php
                    include_once 'datos/datos_familiares.php'
                     ?>
                </section>
               
            </section>
        </div>
       <div id="Footer">
             <p>Instituto Tecnológico Superior de Ciudad Hidalgo</p>
             <p>Tel. 01(786) 1549000</p>
             <p>Todos los derechos reservados © Centro de Desarrollo de Software ITSUR</p>
        </div>
    </body>
</html>
