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

?>
