<?php

require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");
require_once("libs/Smarty.class.php");

$IdPublicacion = $_POST['IdPublicacion'];

$conn = new ConexionBD("mysql", "localhost", "FindMyPet", "root", "root");

if ($conn->conectar()) {
    $sql = "DELETE FROM PUBLICACION WHERE Id='" . $IdPublicacion . "'";
    $parametros = array();
    $conn->consulta($sql, $parametros);
}
?>
