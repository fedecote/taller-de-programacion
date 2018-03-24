<?php

session_start();
//Incluyo biblioteca Smarty
require_once("libs/Smarty.class.php");
require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");

$pagina = (int) $_GET['pagina'];
$esUsuario = $_SESSION['ingreso'];

$conn = new ConexionBD("mysql", "localhost", "FindMyPet", "root", "root");

if ($conn->conectar()) {
    if (isset($_COOKIE["token"])) {
        $token = $_COOKIE["token"];
        $sql = "SELECT * FROM USUARIO WHERE Token= '" . $token . "'";
        $parametros = array();
        if ($conn->consulta($sql, $parametros)) {
            $usuario = $conn->siguienteRegistro();
            if (empty($usuario)) {
                $_SESSION['ingreso'] = false;
                $esUsuario = false;
                $smarty->assign("ingreso", $esUsuario);
                $smarty->assign("Username", $_COOKIE['usuario']);
                $smarty->display("Home.tpl");
            } else {
                $esUsuario = true;
                $_SESSION['ingreso'] = true;
                setcookie("usuario", $usuario["Email"]);
                $smarty->assign("Username", $_COOKIE['usuario']);
                $sql = "SELECT * FROM ESPECIE ORDER BY Nombre ASC";
                $parametros = array();
                if ($conn->consulta($sql, $parametros)) {
                    $especies = $conn->restantesRegistros();
                    $smarty->assign("especies", $especies);
                }

                $sql = "SELECT * FROM BARRIO ORDER BY Nombre ASC";
                $parametros = array();
                if ($conn->consulta($sql, $parametros)) {
                    $barrios = $conn->restantesRegistros();
                    $smarty->assign("barrios", $barrios);
                }
            }

            $smarty->assign("ingreso", $esUsuario);
            $smarty->assign("Username", $_COOKIE['usuario']);

            $smarty->display("NuevaPublicacion.tpl");
        }
    } else {
        $_SESSION['ingreso'] = false;
        $esUsuario = false;
        $smarty->assign("ingreso", $esUsuario);
        $smarty->assign("Username", $_COOKIE['usuario']);
        $smarty->display("Home.tpl");
    }
} else {
    $_SESSION['ingreso'] = false;
    $esUsuario = false;
    $smarty->assign("ingreso", $esUsuario);
    $smarty->assign("Username", $_COOKIE['usuario']);
    $smarty->display("Home.tpl");
}
?>
