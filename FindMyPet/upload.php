<?php

require_once("libs/Smarty.class.php");
require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");


$conn = new ConexionBD("mysql", "localhost", "FindMyPet", "root", "root");

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$random = generateRandomString();


if (0 < $_FILES['file']['error']) {
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
} else {
    $path = $_FILES['file']['tmp_name'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $ruta = "img/" . $random . $_FILES['file']['name'];
    $ext = end(explode(".", $ruta));
    if (move_uploaded_file($_FILES['file']['tmp_name'], $ruta)) {
        if ($conn->conectar()) {
            $sql = "INSERT IMAGEN(IdPublicacion, Ruta)VALUES('1', '" . $ruta . "')";
            $parametros = array();
            $conn->consulta($sql, $parametros);
            $respuesta = $ext;
            echo json_encode($respuesta);
        }
    } else {
        $respuesta = "Error";
        echo json_encode($respuesta);
    }
}
?>