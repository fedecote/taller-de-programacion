<?php

session_start();
require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");

$respuesta = array();

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

try {
    $conn = new ConexionBD("mysql", "localhost", "FindMyPet", "root", "root");

    if ($conn->conectar()) {
        $email = $_POST["usuario"];
        $password = $_POST["password"];
        $name = $_POST["name"];
        $surname = $_POST["surname"];

        $sql = "SELECT * FROM USUARIO WHERE Email='" . $email . "'";
        $param = array();
        if ($conn->consulta($sql, $param)) {
            $result = $conn->restantesRegistros();
            if (count($result) > 0) {
                $respuesta['estado'] = "NO OK";
                $respuesta['mensaje'] = "El nombre de usuario ingresado ya existe";
                echo json_encode($respuesta);
                return;
            } else {
                $token = generateRandomString();
                $sql = "SELECT * FROM USUARIO WHERE Token='" . $token . "'";
                if ($conn->consulta($sql, $param)) {
                    $result = $conn->restantesRegistros();
                    while (count($result) > 0) {
                        $token = generateRandomString();
                        $sql = "SELECT * FROM USUARIO WHERE Token='" . $token . "'";
                        if ($conn->consulta($sql, $param)) {
                            $result = $conn->restantesRegistros();
                        }
                    }
                    $param = array(
                        array("usuario", $email, "string"),
                        array("password", $password, "string"),
                        array("name", $name, "string"),
                        array("surname", $surname, "string"),
                        array("token", $token, "string"),
                    );
                    $sql = "insert USUARIO (Email, Nombre, Apellido, Password, Token) "
                            . "values( :usuario, :name, :surname, :password, :token)";
                    if ($conn->consulta($sql, $param)) {
                        if ($conn->ultimoIdInsert() > 0) {
                            $_SESSION['ingreso'] = true;
                            setcookie("usuario", $email);
                            setcookie("token", $token);
                            $respuesta['usuario'] = $email;
                            $respuesta['estado'] = "OK";
                        } else {
                            $respuesta['estado'] = "NO OK";
                            $respuesta['mensaje'] = "Ocurrio un problema inesperado, por favor reintente mas tarde";
                        }
                        echo json_encode($respuesta);
                        return;
                    } else {
                        $respuesta['estado'] = "NO OK";
                        $respuesta['mensaje'] = "Ocurrio un problema inesperado, por favor reintente mas tarde";
                        echo json_encode($respuesta);
                        return;
                    }
                }
            }
        } else {
            $respuesta['estado'] = "NO OK";
            $respuesta['mensaje'] = "Ocurrio un problema inesperado, por favor reintente mas tarde";
            echo json_encode($respuesta);
            return;
        }
    } else {
        $respuesta['estado'] = "NO OK";
        $respuesta['mensaje'] = "La pagina se encuentra en mantenimiento, por favor reintente mas tarde. Disculpe las molestias";
        echo json_encode($respuesta);
        return;
    }
} catch (Exception $e) {
    $respuesta['estado'] = "NO OK";
    $respuesta['mensaje'] = "La pagina se encuentra en mantenimiento, por favor reintente mas tarde. Disculpe las molestias";
    echo json_encode($respuesta);
    return;
}
?>