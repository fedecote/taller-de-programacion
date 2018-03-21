<?php

session_start();
require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");

$respuesta = array();

try {
    $conn = new ConexionBD("mysql", "localhost", "FindMyPet", "root", "root");

    setcookie("paso1", "paso");
    if ($conn->conectar()) {
        setcookie("paso2", "paso");
        $email = $_POST["usuario"];
        $password = $_POST["password"];
        $name = $_POST["name"];
        $surname = $_POST["surname"];

        $sql = "SELECT * FROM USUARIO WHERE Email='" . $email . "'";
        $param = array();
        if ($conn->consulta($sql, $param)) {
            setcookie("paso3", "paso");
            $result = $conn->restantesRegistros();
            if (count($result) > 0) {
                setcookie("paso4", "paso");
                $respuesta['estado'] = "NO OK";
                $respuesta['mensaje'] = "El nombre de usuario ingresado ya existe";
                echo json_encode($respuesta);
                return;
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
                    setcookie("paso5", "paso");
                    if ($conn->ultimoIdInsert() > 0) {
                        setcookie("paso6", "paso");
                        $_SESSION['ingreso'] = true;
                        setcookie("usuario", $email);
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