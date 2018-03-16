<?php

require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");
require_once("libs/Smarty.class.php");

$conn = new ConexionBD("mysql", "localhost", "FindMyPet", "root", "root");

if ($conn->conectar()) {
    $param = array(
        array("Id", $_POST['Id'], int),
        array("respuesta", $_POST["respuesta"], "string"),
    );

    $sql = "UPDATE Pregunta SET Respuesta = :respuesta WHERE Id= :Id";
    if ($conn->consulta($sql, $param)) {
        $respuesta = "OK";
        echo json_encode($respuesta);
    }
}
?>