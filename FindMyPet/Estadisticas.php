<?php

session_start();
//Incluyo biblioteca Smarty
require_once("libs/Smarty.class.php");
require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");

$esUsuario = $_SESSION['ingreso'];

$conn = new ConexionBD("mysql", "localhost", "FindMyPet", "root", "root");

if ($conn->conectar()) {
    $sql = "SELECT COUNT(*) Total FROM PUBLICACION";
    $parametros = array();
    if ($conn->consulta($sql, $parametros)) {
        $resultado = $conn->siguienteRegistro();
        $total = $resultado["Total"];
        $smarty->assign("total", $total);

        $datos = array();
        
        $sql = "SELECT * FROM PUBLICACION GROUP By IdEspecie";
        $parametros = array();
        if ($conn->consulta($sql, $parametros)) {
            $Especies = $conn->restantesRegistros();
            foreach ($Especies as $i => $IdEspecie) {
                $sql = "SELECT NOMBRE FROM ESPECIE WHERE Id='" . $IdEspecie["Id"][$i] . "'";
                $parametros = array();
                if ($conn->consulta($sql, $parametros)) {
                    $Nombreespecie = $conn->siguienteRegistro();
                    $especie["nombre"] = $Nombreespecie;

                    $sql = "SELECT COUNT(*) TotalEspecie FROM PUBLICACION WHERE IdEspecie='" . $IdEspecie["Id"][$i] . "'";
                    $parametros = array();
                    if ($conn->consulta($sql, $parametros)) {
                        $resultado = $conn->siguienteRegistro();
                        $especie["totalEspecie"] = $resultado;
                        
                        $sql = "SELECT COUNT(*) CerradosEspecie FROM PUBLICACION WHERE IdEspecie='" . $IdEspecie["Id"][$i] . "'";
                        $parametros = array();
                        if ($conn->consulta($sql, $parametros)) {
                            $resultado = $conn->siguienteRegistro();
                            $especie["CerradosEspecie"] = $resultado;
                            $especie["AbiertosEspecie"] = $especie["totalEspecie"] - $resultado;
                            array_push($datos, $especie); 
                        }
                    }
                }
            }
            $smarty->assign("total", $total);
        }
    }
}

$esUsuario = $_SESSION['ingreso'];
$smarty->assign("ingreso", $esUsuario);
$smarty->assign("Username", $_COOKIE['usuario']);

$smarty->display("Estadisticas.tpl");
?>

