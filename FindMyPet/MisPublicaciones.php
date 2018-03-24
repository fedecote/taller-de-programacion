<?php
session_start();
//Incluyo biblioteca Smarty
require_once("includes/class.Conexion.BD.php");
require_once("libs/Smarty.class.php");
require_once("config/configuracion.php");

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
                setcookie("usuario", "", time() - 3600);
                setcookie("token", "", time() - 3600);
            } else {
                $esUsuario = true;
                $_SESSION['ingreso'] = true;
                setcookie("usuario", $usuario["Email"]);
                $smarty->assign("Username", $_COOKIE['usuario']);
            }
        } else {
            $_SESSION['ingreso'] = false;
            $esUsuario = false;
            setcookie("usuario", "", time() - 3600);
            setcookie("token", "", time() - 3600);
        }
    } else {
        $_SESSION['ingreso'] = false;
        $esUsuario = false;
        setcookie("usuario", "", time() - 3600);
        setcookie("token", "", time() - 3600);
    }

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
$smarty->display("MisAvisos.tpl");
?>