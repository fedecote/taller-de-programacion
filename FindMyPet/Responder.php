<?php

require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");
require_once("libs/Smarty.class.php");

$conn = new ConexionBD("mysql", "localhost", "FindMyPet", "root", "root");

if ($conn->conectar()) {
    $now = new DateTime();
    $fechaRespuesta = date ("Y-m-d H:i:s", $now->getTimestamp());
    $param = array(
        array("Id", $_POST['Id'], int),
        array("respuesta", $_POST["respuesta"], "string"),
        array("fechaRespuesta", $fechaRespuesta)
    );

    $sql = "UPDATE Pregunta SET Respuesta = :respuesta, FechaRespuesta = :fechaRespuesta WHERE Id= :Id";
    if ($conn->consulta($sql, $param)) {
        $respuesta = "OK";
        echo json_encode($respuesta);
    }
}
?>