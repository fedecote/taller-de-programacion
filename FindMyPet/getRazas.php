<?php

require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");
require_once("libs/Smarty.class.php");

$IdEspecie = $_POST['IdEspecie'];

$conn = new ConexionBD("mysql", "localhost", "FindMyPet", "root", "root");

if ($conn->conectar()) {
    $sql = "SELECT * FROM RAZA WHERE IdEspecie =" . $IdEspecie;
    $parametros = array();
    if ($conn->consulta($sql, $parametros)) {
        $razas = $conn->restantesRegistros();
        $respuesta = array();
        $respuesta["razas"] = $razas;
        $respuesta["result"] = "OK";
        echo json_encode($respuesta);
    }else{
        setcookie("consulta", "fallo");
    }
} else {
    echo json_encode(array("result" => "ERROR CONEXION"));
}
?>