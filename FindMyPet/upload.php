<?php

require_once("libs/Smarty.class.php");
require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");

$respuesta = array();

try {
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
    $cant = 0;
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
                    if ($conn->consulta($sql, $parametros)) {
                        if ($conn->ultimoIdInsert() > 0) {
                            $respuesta["status"] = "OK";
                        } else {
                            $respuesta["status"] = "NO OK";
                            $respuesta = "Ocurrio un error al subir la imagen " . $fileName;
                            if ($cant == 0) {
                                echo json_encode($respuesta);
                                return;
                            }
                        }
                    } else {
                        $respuesta["status"] = "NO OK";
                        $respuesta = "Ocurrio un error al subir la imagen " . $fileName;
                        if ($cant == 0) {
                            echo json_encode($respuesta);
                            return;
                        }
                    }
                } else {
                    $respuesta["status"] = "NO OK";
                    $respuesta = "Ocurrio un error al subir la imagen " . $fileName;
                    if ($cant == 0) {
                        echo json_encode($respuesta);
                        return;
                    }
                }
            } else {
                $respuesta["status"] = "NO OK";
                $respuesta = "Ocurrio un error al subir la imagen " . $fileName;
                if ($cant == 0) {
                    echo json_encode($respuesta);
                    return;
                }
            }
        } else {
            $respuesta["status"] = "NO OK";
            $respuesta = "Ocurrio un problema al intentar subir las imagenes";
            if ($cant == 0) {
                echo json_encode($respuesta);
                return;
            }
        }
        $cant += 1;
    }
    $respuesta["status"] = "OK";
    echo json_encode($respuesta);
} catch (Exception $e) {
    $respuesta["status"] = "NO OK";
    $respuesta = "Ocurrio un problema al intentar subir las imagenes";
    echo json_encode($respuesta);
}
?>