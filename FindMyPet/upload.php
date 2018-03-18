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

$IdPublicacion = $_COOKIE["publicacion"];

foreach ($_FILES as $index => $file) {
    $random = generateRandomString();
    if (empty($file['error'][$index])) {
        $fileName = $file['name'];
        $fileTempName = $file['tmp_name'];
        $ruta = "img/" . $random . $fileName;
        $ext = end(explode(".", $ruta));
        if (move_uploaded_file($fileTempName, $ruta)) {
            if ($conn->conectar()) {
                $sql = "INSERT IMAGEN(IdPublicacion, Ruta)VALUES('" . $IdPublicacion . "', '" . $ruta . "')";
                $parametros = array();
                $conn->consulta($sql, $parametros);
                $respuesta = "OK";
                echo json_encode($respuesta);
            } else {
                $respuesta = "Error al conectar con el servidor";
                echo json_encode($respuesta);
            }
        } else {
            $respuesta = "Error al subir la foto";
            echo json_encode($respuesta);
        }
    } else {
        $respuesta = "Error al obtener usuario";
        echo json_encode($respuesta);
    }
}
?>