<?php

require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");
require_once("libs/Smarty.class.php");

$conn = new ConexionBD("mysql", "localhost", "FindMyPet", "root", "root");

if ($conn->conectar()) {
    $param = array(
        array("IdPublicacion", $_POST['IdPublicacion'], int),
        array("pregunta", $_POST["pregunta"], "string"),
    );

    $sql = "insert Pregunta (IdPublicacion, Pregunta) "
            . "values( :IdPublicacion, :pregunta)";
    if ($conn->consulta($sql, $param)) {
        if ($conn->ultimoIdInsert() > 0) {
            $respuesta = "OK";
            echo json_encode($respuesta);
        }
    }
}
?>