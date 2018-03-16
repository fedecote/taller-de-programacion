<?php

session_start();
require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");

$usuario = $_POST['usuario'];
$contra = $_POST['password'];

$conn = new ConexionBD("mysql", "localhost", "FindMyPet", "root", "root");

if ($conn->conectar()) {
    $sql = "SELECT * FROM USUARIO";

    $sql .= " WHERE Email LIKE '" . $usuario . "'";

    $sql .= " && Password LIKE '" . $contra . "'";

    $parametros = array();

    if ($conn->consulta($sql, $parametros)) {
        $usuario = $conn->siguienteRegistro();
        $respuesta = array();
        if (empty($usuario)) {
            $respuesta['estado'] = "NO OK";
        } else {
            $_SESSION['ingreso'] = true;
            setcookie("usuario", $usuario['Email']);
            $respuesta['usuario'] = $usuario;
            $respuesta['estado'] = "OK";
        }

        echo json_encode($respuesta);
    } else {
        echo json_encode(array("result" => "ERROR SQL"));
    }
} else {
    echo json_encode(array("result" => "ERROR CONEXION"));
}
?>