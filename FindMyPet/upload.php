<?php

require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");
require_once("libs/Smarty.class.php");

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

//$newName = generateRandomString() + ".png";
$newName = "a.png";
//if they DID upload a file...
if ($_FILES['agregarImagenPrincipal']['name']) {
    //if no errors...
    if (!$_FILES['agregarImagenPrincipal']['error']) {
        //now is the time to modify the future file name and validate the file
        $new_file_name = strtolower($_FILES['agregarImagenPrincipal']['tmp_name']); //rename file
        $valid_file = true;
        if ($_FILES['agregarImagenPrincipal']['size'] > (1024000)) { //can't be larger than 1 MB
            $valid_file = false;
            $message = 'Oops!  Your file\'s size is to large.';
        }

        //if the file has passed the test
        if ($valid_file) {
            //move it to where we want it to be
            move_uploaded_file($_FILES['agregarImagenPrincipal']['tmp_name'], 'img/' . $newName);
            $message = 'Congratulations!  Your file was accepted.';

            $respuesta = "img/" + $newName;
            if ($conn->conectar()) {
                $param = array();

                $sql = "insert IMAGEN (IdPublicacion, Ruta)values('" . 1 . "' , '" . $respuesta . "')";
                setcookie("RESPUESTA", $respuesta);
                if ($conn->consulta($sql, $param)) {
                    if ($conn->ultimoIdInsert() > 0) {
                        $resultado = "OK";
                        //echo json_encode($resultado);
                    }
                }
            }
        }
    }
    //if there is an error...
    else {
        //set that to be the returned message
        $message = 'Ooops!  Your upload triggered the following error:  ' . $_FILES['agregarImagenPrincipal']['error'];
    }
}
?>