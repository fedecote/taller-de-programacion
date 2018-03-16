<?php

require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");
require_once("libs/Smarty.class.php");

$foto = (int) $_POST['foto'];
$IdPublicacion = $_POST['IdPublicacion'];

$conn = new ConexionBD("mysql", "localhost", "FindMyPet", "root", "root");

if ($conn->conectar()) {
    $sql = "SELECT * FROM IMAGEN WHERE IdPublicacion='" . $IdPublicacion . "'";
    $parametros = array();
    if ($conn->consulta($sql, $parametros)) {
        $fotoAMostrar = $conn->restantesRegistros();
        $respuesta["foto"] = $fotoAMostrar;
        $respuesta["numeroFoto"] = $foto;
    }
    echo json_encode($respuesta);
}
?>