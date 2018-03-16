
<?php
session_start();
//Incluyo biblioteca Smarty
require_once("libs/Smarty.class.php");
require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");

$pagina = (int) $_GET['pagina'];
$esUsuario = $_SESSION['ingreso'];

if ($pagina == 0) {
    $pagina = 1;
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

    $sql = "SELECT count(*) Total FROM PUBLICACION WHERE Estado = 0";

    $parametros = array();

    if ($conn->consulta($sql, $parametros)) {
        $result = $conn->siguienteRegistro();
        $cantPaginas = ceil($result["Total"] / CANTXPAG);
        
        $sql =
                "SELECT * FROM PUBLICACION WHERE Estado = 0";
        $sql .= " "
                . "LIMIT :inicio,:cantidad";

        $parametros = array(
            array("inicio", (($pagina - 1) * CANTXPAG),
                "int", 0),
            array("cantidad", CANTXPAG, "int", 0)
        );
            
        if ($conn->consulta($sql, $parametros)) {
            $listadoPublicaciones = $conn->restantesRegistros();
            $result = $conn->siguienteRegistro();

            $smarty->assign("listado", $listadoPublicaciones);
            $smarty->assign("pagina", $pagina);
            $smarty->assign("cantPaginas", $cantPaginas);
        }
    }
    
}
$smarty->assign("ingreso", $esUsuario);
$smarty->assign("Username", $_COOKIE['usuario']);

$smarty->display("Home.tpl");
?>


