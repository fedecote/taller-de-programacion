<?php

session_start();
require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");

$respuesta = array();

try {
    $usuario = $_POST['usuario'];

    $conn = new ConexionBD("mysql", "localhost", "FindMyPet", "root", "root");

    if ($conn->conectar()) {
        $email = $_POST["usuario"];
        $password = $_POST["password"];
        $name = $_POST["name"];
        $surname = $_POST["surname"];

        $sql = "SELECT COUNT(*) existe FROM USUARIO WHERE Email='" . $email . "'";
        $param = array();
        if ($conn->consulta($sql, $param)) {
            $yaExistia = $conn->siguienteRegistro();
            if ($yaExistia['existe'] > 0) {
                $respuesta['estado'] = "NO OK";
                $respuesta['mensaje'] = "El nombre de usuario ingresado ya existe";
                echo json_encode($respuesta);
            }
        } else {
            $param = array(
                array("usuario", $email, "string"),
                array("password", $password, "string"),
                array("name", $name, "string"),
                array("surname", $surname, "string"),
            );
            $sql = "insert USUARIO (Email, Nombre, Apellido, Password) "
                    . "values( :usuario, :name, :surname, :password)";
            if ($conn->consulta($sql, $param)) {
                if ($conn->ultimoIdInsert() > 0) {
                    $_SESSION['ingreso'] = true;
                    setcookie("usuario", $usuario);
                    $respuesta['usuario'] = $usuario;
                    $respuesta['estado'] = "OK";
                } else {
                    $respuesta['estado'] = "NO OK";
                    $respuesta['mensaje'] = "Ocurrio un problema inesperado, por favor reintente mas tarde";
                }
                echo json_encode($respuesta);
            } else {
                $respuesta['estado'] = "NO OK";
                $respuesta['mensaje'] = "Ocurrio un problema inesperado, por favor reintente mas tarde";
                echo json_encode($respuesta);
            }
        }
    } else {
        $respuesta['estado'] = "NO OK";
        $respuesta['mensaje'] = "La pagina se encuentra en mantenimiento, por favor reintente mas tarde. Disculpe las molestias";
        echo json_encode($respuesta);
    }
} catch (Exception $e) {
    $respuesta['estado'] = "NO OK";
    $respuesta['mensaje'] = "La pagina se encuentra en mantenimiento, por favor reintente mas tarde. Disculpe las molestias";
    echo json_encode($respuesta);
}
?>