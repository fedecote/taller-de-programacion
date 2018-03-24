<?php

require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");
require_once("libs/Smarty.class.php");

$conn = new ConexionBD("mysql", "localhost", "FindMyPet", "root", "root");

if ($conn->conectar()) {
    $now = new DateTime();
    $fechaPregunta = date ("Y-m-d H:i:s", $now->getTimestamp());
    $sql = "insert Pregunta (IdPublicacion, Pregunta, FechaPregunta) "
            . "values( :IdPublicacion, :pregunta, :fechaPregunta)";
    $param = array(
        array("IdPublicacion", $_POST['IdPublicacion'], int),
        array("pregunta", $_POST["pregunta"], "string"),
        array("fechaPregunta", $fechaPregunta)
    );
    if ($conn->consulta($sql, $param)) {
        if ($conn->ultimoIdInsert() > 0) {
            $respuesta = "OK";
            echo json_encode($respuesta);
        }
    }
}
?>