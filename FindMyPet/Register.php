<?php

session_start();
require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");

$usuario = $_POST['usuario'];

$conn = new ConexionBD("mysql", "localhost", "FindMyPet", "root", "root");

if ($conn->conectar()) {
    $param = array(
        array("usuario", $_POST["usuario"], "string"),
        array("password", $_POST["password"], "string"),
        array("name", $_POST["name"], "string"),
        array("surname", $_POST["surname"], "string"),
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
        }
        echo json_encode($respuesta);
    } else {
        echo json_encode(array("result" => "ERROR SQL"));
    }
} else {
    echo json_encode(array("result" => "ERROR CONEXION"));
}
?>