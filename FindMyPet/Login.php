<?php

session_start();
require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");

try {
    $usuario = $_POST['usuario'];
    $contra = $_POST['password'];
    $remember = $_POST['remember'];
    $respuesta = array();

    $conn = new ConexionBD("mysql", "localhost", "FindMyPet", "root", "root");

    if ($conn->conectar()) {
        $sql = "SELECT * FROM USUARIO";
        $sql .= " WHERE Email LIKE '" . $usuario . "'";
        $sql .= " && Password LIKE '" . $contra . "'";
        $parametros = array();

        if ($conn->consulta($sql, $parametros)) {
            $usuario = $conn->siguienteRegistro();
            if (empty($usuario)) {
                $respuesta['estado'] = "NO OK";
                $respuesta['mensaje'] = "Usuario o contraseña incorrecto";
            } else {
                $_SESSION['ingreso'] = true;
                if ($remember === "true") {
                    setcookie("usuario", $usuario['Email'], time() + (10 * 365 * 24 * 60 * 60));
                    setcookie("token", $usuario['Token'], time() + (10 * 365 * 24 * 60 * 60));
                } else {
                    setcookie("usuario", $usuario['Email']);
                    setcookie("token", $usuario['Token']);
                }
                $respuesta['usuario'] = $usuario;
                $respuesta['estado'] = "OK";
            }
            echo json_encode($respuesta);
        } else {
            $respuesta['estado'] = "NO OK";
            $respuesta['mensaje'] = "Usuario o contraseña incorrecto";
            echo json_encode($respuesta);
        }
    } else {
        $respuesta['estado'] = "NO OK";
        $respuesta['mensaje'] = "La applicacion se encuentra en mantenimiento, por favor reintente mas tarde. Disculpe las molestias";
        echo json_encode($respuesta);
    }
} catch (Exception $e) {
    $respuesta = array();
    $respuesta['estado'] = "NO OK";
    $respuesta['mensaje'] = "La applicacion se encuentra en mantenimiento, por favor reintente mas tarde. Disculpe las molestias";
    echo json_encode($respuesta);
}
?>