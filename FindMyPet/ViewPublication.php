<?php

session_start();
//Incluyo biblioteca Smarty
require_once("libs/Smarty.class.php");
require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");

$id = (int) $_GET['id'];
$foto = (int) $_POST['foto'];
$esUsuario = $_SESSION['ingreso'];

$conn = new ConexionBD("mysql", "localhost", "FindMyPet", "root", "root");

if ($conn->conectar()) {
    $sql = "SELECT * FROM PUBLICACION WHERE Id = :id";

    $parametros = array(
        array("id", $id, "int", 0)
    );

    if ($conn->consulta($sql, $parametros)) {
        $publicacion = $conn->siguienteRegistro();
        $smarty->assign("id", $publicacion['Id']);
        $smarty->assign("tipo", $publicacion['Tipo']);
        $smarty->assign("usuario", $publicacion['IdUsuario']);
        $smarty->assign("titulo", $publicacion['Titulo']);
        $smarty->assign("descripcion", $publicacion['Descripcion']);
        $smarty->assign("estado", $publicacion['Estado']);
        $smarty->assign("latitud", $publicacion['Latitud']);
        $smarty->assign("longitud", $publicacion['Longitud']);

        $sql = "SELECT * FROM IMAGEN WHERE IdPublicacion = '" . $publicacion['Id'] . "' Group By IdPublicacion";
        $sql .= " LIMIT :inicio,:cantidad";

        $parametros = array(
            array("inicio", $foto, "int", 0),
            array("cantidad", 1, "int", 0)
        );
        if ($conn->consulta($sql, $parametros)) {
            $foto = $conn->siguienteRegistro();
            $smarty->assign("foto", $foto);
        }

        $sql = "SELECT * FROM IMAGEN WHERE IdPublicacion = '" . $publicacion['Id'] . "'";
        $parametros = array();
        if ($conn->consulta($sql, $parametros)) {
            $fotos = $conn->restantesRegistros();
            $smarty->assign("fotos", $fotos);
        }

        $sql = "SELECT COUNT(*) Total FROM IMAGEN WHERE IdPublicacion = '" . $publicacion['Id'] . "'";
        $parametros = array();
        if ($conn->consulta($sql, $parametros)) {
            $resultado = $conn->siguienteRegistro();
            $cantFotos = $resultado["Total"];
            $smarty->assign("cantFotos", $cantFotos);
        }

        $sql = "SELECT * FROM ESPECIE";
        $sql .= " WHERE Id=" . $publicacion['IdEspecie'];
        $parametros = array();
        if ($conn->consulta($sql, $parametros)) {
            $especie = $conn->siguienteRegistro();
            $smarty->assign("especie", $especie['Nombre']);

            $sql = "SELECT * FROM RAZA";
            $sql .= " WHERE Id=" . $publicacion['IdRaza'];
            $parametros = array();
            if ($conn->consulta($sql, $parametros)) {
                $raza = $conn->siguienteRegistro();
                $smarty->assign("raza", $raza['Nombre']);
            }
        }
        $sql = "SELECT * FROM BARRIO";
        $sql .= " WHERE Id=" . $publicacion['IdBarrio'];
        $parametros = array();
        if ($conn->consulta($sql, $parametros)) {
            $barrio = $conn->siguienteRegistro();
            $smarty->assign("barrio", $barrio['Nombre']);
        }
        
        $sql = "SELECT * FROM USUARIO";
        $sql .= " WHERE Id=" . $publicacion['IdUsuario'];
        $parametros = array();
        if ($conn->consulta($sql, $parametros)) {
            $user = $conn->siguienteRegistro();
            $smarty->assign("email", $user['Email']);

            $sql = "SELECT * FROM Pregunta";
            $sql .= " WHERE IdPublicacion=" . $publicacion['Id'];
            $parametros = array();
            if ($conn->consulta($sql, $parametros)) {
                $preguntas = $conn->restantesRegistros();
                $smarty->assign("preguntas", $preguntas);
            }
        }
    }
}
$smarty->assign("ingreso", $esUsuario);
$smarty->assign("Username", $_COOKIE['usuario']);

$smarty->display("ViewPublication.tpl");
?>
