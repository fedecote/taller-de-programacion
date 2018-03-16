<?php

require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");
require_once("libs/Smarty.class.php");

$IdPublicacion = $_POST['IdPublicacion'];
$resultado = $_POST["resultado"];

$conn = new ConexionBD("mysql", "localhost", "FindMyPet", "root", "root");

if ($conn->conectar()) {
    $sql = "UPDATE PUBLICACION SET Resultado ='" . $resultado ."' , Estado = 1  WHERE Id= '" . $IdPublicacion . "'";
    $parametros = array();
    if ($conn->consulta($sql, $parametros)) {
        $respuesta = "OK";
        echo json_encode($respuesta);
    }
}
?>
