
<?php

session_start();
//Incluyo biblioteca Smarty
require_once("includes/class.Conexion.BD.php");
require_once("libs/Smarty.class.php");
require_once("config/configuracion.php");

if (isset($_COOKIE["usuario"])) {
    $_SESSION['ingreso'] = true;
    $esUsuario = true;
} else {
    $_SESSION['ingreso'] = false;
    $esUsuario = false;
}

$conn = new ConexionBD("mysql", "localhost", "FindMyPet", "root", "root");

if ($conn->conectar()) {
    $sql = "SELECT * FROM ESPECIE";
    $parametros = array();
    if ($conn->consulta($sql, $parametros)) {
        $especies = $conn->restantesRegistros();
        $smarty->assign("especies", $especies);
    }
    $sql = "SELECT * FROM BARRIO";
    $parametros = array();
    if ($conn->consulta($sql, $parametros)) {
        $barrios = $conn->restantesRegistros();
        $smarty->assign("barrios", $barrios);
    }
}
$smarty->assign("ingreso", $esUsuario);
$smarty->assign("Username", $_COOKIE['usuario']);
$smarty->display("Home.tpl");
?>


