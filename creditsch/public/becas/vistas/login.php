<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sesiones</title>

    <link rel="stylesheet" type="text/css" href="main.css"/>
</head>
<body>
    <div id="Header">
                <div id="Logo">
                    <h2>Beca ITSCH</h2>
                </div>
         </div>
    <form class="login" action="" method="POST">
        <?php
            if(isset($errorLogin)){
                echo $errorLogin;
            }
        ?>
        
        <p>Nombre de usuario: <br>
        <input type="text" name="username" ></p>
        <p>Password: <br>
        <input type="password" name="password" label="contraseña"></p>
        <p class="center"><input type="submit" value="Iniciar Sesión"></p>
    </form>
    <div id="Footer">
                <p>Instituto Tecnológico Superior de Ciudad Hidalgo</p>
                <p>Tel. 01(786) 1549000</p>
                <p>Todos los derechos reservados © Centro de Desarrollo de Software ITSUR</p>
            <br>
        </div>
    
</body>

 
</html>