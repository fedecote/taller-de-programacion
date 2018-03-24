<?php

require_once("libs/Smarty.class.php");
require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");

$conn = new ConexionBD("mysql", "localhost", "FindMyPet", "root", "root");

$titulo = $_POST['titulo'];
$tipoPublicacion = $_POST['tipoPublicacion'];
$especie = $_POST['especie'];
$raza = $_POST['raza'];
$barrio = $_POST['barrio'];
$descripcion = $_POST['descripcion'];
$email = $_POST['usuario'];
$latitud = $_POST['latitud'];
$longitud = $_POST['longitud'];

$respuesta = array();

if ($conn->conectar()) {
    $token = $_COOKIE["token"];
    $sql = "SELECT * FROM USUARIO WHERE Token = '" . $token . "'";
    $parametros = array();
    if ($conn->consulta($sql, $parametros)) {
        $result = $conn->siguienteRegistro();
        $IdUsuario = $result["Id"];

        $now = new DateTime();
        $fecha = date("Y-m-d H:i:s", $now->getTimestamp());
        $newdate = date('Y-m-d', strtotime($fecha));
        
        $sql = "INSERT PUBLICACION(IdUsuario, Tipo, IdEspecie, IdRaza, IdBarrio, Titulo, Descripcion, Latitud, Longitud, Fecha)VALUES('" . $IdUsuario . "', '";
        $sql .= $tipoPublicacion . "', '" . $especie . "', '" . $raza . "', '" . $barrio . "', '" . $titulo . "', '" . $descripcion . "', '" . $latitud . "', '" . $longitud . "','" . $newdate . "')";
        $parametros = array();
        if ($conn->consulta($sql, $parametros)) {
            if ($conn->ultimoIdInsert() > 0) {
                $resultado = $conn->ultimoIdInsert();
                $respuesta['status'] = "OK";
                $respuesta['IdPublicacion'] = $resultado;
                setcookie("publicacion", $resultado);
                echo json_encode($respuesta);
            } else {
                $respuesta['status'] = "Error";
                $respuesta['mensaje'] = "Hubo un error al crear la publicacion";
                echo json_encode($respuesta);
            }
        } else {
            $respuesta['status'] = "Error";
            $respuesta['mensaje'] = "Hubo un error al crear la publicacion";
            echo json_encode($respuesta);
        }
    } else {
        $respuesta['status'] = "Error";
        $respuesta['mensaje'] = "Hubo un error al crear la publicacion";
        echo json_encode($respuesta);
    }
} else {
    $respuesta['status'] = "Error";
    $respuesta['mensaje'] = "El servidor no se encuentra disponible en este momento. Por favor intente mas tarde";
    echo json_encode($respuesta);
}
?>

