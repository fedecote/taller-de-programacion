<?php

require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");
require_once("libs/Smarty.class.php");

try {
    $IdEspecie = $_POST['IdEspecie'];

    $conn = new ConexionBD("mysql", "localhost", "FindMyPet", "root", "root");

    if ($conn->conectar()) {
        $sql = "SELECT COUNT(*) total FROM RAZA WHERE IdEspecie =" . $IdEspecie;
        $parametros = array();
        if ($conn->consulta($sql, $parametros)) {
            $res = $conn->siguienteRegistro();
            if ($res["total"] == 0) {
                $respuesta["status"] = "NO OK";
                $respuesta["mensaje"] = "No hay razas registradas para esta especie";
                echo json_encode($respuesta);
            } else {

                $sql = "SELECT * FROM RAZA WHERE IdEspecie =" . $IdEspecie;
                $parametros = array();
                if ($conn->consulta($sql, $parametros)) {
                    $razas = $conn->restantesRegistros();
                    $respuesta = array();
                    $respuesta["razas"] = $razas;
                    $respuesta["status"] = "OK";
                    echo json_encode($respuesta);
                } else {
                    $respuesta["status"] = "NO OK";
                    $respuesta["mensaje"] = "Ha ocurrido un error al conectarse con el servidor";
                    echo json_encode($respuesta);
                }
            }
        } else {
            $respuesta["status"] = "NO OK";
            $respuesta["mensaje"] = "La pagina se encuentra en mantenimiento, por favor reintente mas tarde. Disculpe las molestias";
            echo json_encode($respuesta);
        }
    } else {
        $respuesta["status"] = "NO OK";
        $respuesta["mensaje"] = "La pagina se encuentra en mantenimiento, por favor reintente mas tarde. Disculpe las molestias";
        echo json_encode($respuesta);
    }
} catch (Excpetion $e) {
    $respuesta["status"] = "NO OK";
    $respuesta["mensaje"] = "La pagina se encuentra en mantenimiento, por favor reintente mas tarde. Disculpe las molestias";
    echo json_encode($respuesta);
}
?>