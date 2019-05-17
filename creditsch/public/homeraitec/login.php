<?php
require_once 'libs/database.php';
require_once 'libs/jwt.php';

if ($_SERVER['REQUEST_METHOD']=='GET') {
    if (isset($_GET['user']) && isset($_GET['pass'])) {
        $nombre = "";
        $usuarios = new DataBase('usuarios');
        $hash = sha1($_GET['pass']);
        $res = $usuarios->read(array('user'=>$_GET['user'], 'pass'=>$hash));
        if ($res) {
            $nombre = $res['nombre'].' '.$res['paterno'].' '.$res['materno'];
            $datos = array('user'=>$res['user'], 'nombre'=> $nombre, 'rol' => $res['rol']);
            $token = JWT::create($datos, Config::SECRET_KEY_JWT);
            $auth = "true";
        } else {
            $token = "Error de usuario o contraseña";
            $auth = "false";
        }
        $result = array('auth'=>$auth, 'token'=>$token);
        header("HTTP/1.1 200 OK");
        echo json_encode($result);
    }elseif(isset($_GET['control']) && isset($_GET['pass'])){
        $alumnos = new DataBase('alumnos');
        $hash = $alumnos->encrypt($_GET['pass']);
        $ra = $alumnos->read(array('no_control'=>$_GET['control'], 'pass'=>$hash));
        $result = array('result'=>'false','nombre'=>'No existe el alumno');
        if($ra)
            $result = array('result'=>'true','nombre'=>$ra['nombre']." ".$ra['a_paterno']." ".$ra['a_materno']);
        header("HTTP/1.1 200 OK");
        echo json_encode($result);
    } else {
        header("HTTP/1.1 400 Bad Request");
    }
} elseif ($_SERVER['REQUEST_METHOD']=='POST') {
    if (isset($_POST['control']) && isset($_POST['pass']) && isset($_POST['email']) && isset($_POST['cel'])) {
        $alumnos = new DataBase('alumnos');
        $usuarios = new DataBase('usuarios');
        $hash = $alumnos->encrypt($_POST['pass']);
        $ra = $alumnos->read(array('no_control'=>$_POST['control'], 'pass'=>$hash));
        $result = array('result'=>'false','msg'=>'El número de control o contraseña no existe, favor de comunicarse con el administrador');
        if ($ra) {

            $ru = $usuarios->read(array('user'=>$_POST['control'], 'pass'=>sha1($_POST['pass'])));
            if ($ru) {
                $result = array('result'=>'false','msg'=>'El usuario ya se había registrado anteriormente');
            } else {
                $data = array(
                'user'=>$_POST['control'],
                'pass'=>sha1($_POST['pass']),
                'email'=>$_POST['email'],
                'cel'=>$_POST['cel'],
                'nombre'=>$ra['nombre'],
                'paterno'=>$ra['a_paterno'],
                'materno'=>$ra['a_materno'],
                'rol'=>'U');
                $id = $usuarios->create($data);
                $result = array('result'=>'true','msg'=>'Se realizó exitosamente el registro del usuario');
            }
        }
        header("HTTP/1.1 200 OK");
        echo json_encode($result);
    } else {
        header("HTTP/1.1 400 Bad Request");
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
}
