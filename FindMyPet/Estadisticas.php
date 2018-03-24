<?php

session_start();
//Incluyo biblioteca Smarty
require_once("libs/Smarty.class.php");
require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");

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
                $datosEncontrados = array();

                //Hallo las diferentes especies
                $sql = "SELECT * FROM PUBLICACION  WHERE Tipo='Encontrada' GROUP By IdEspecie";
                $parametros = array();
                if ($conn->consulta($sql, $parametros)) {
                    $Especies = $conn->restantesRegistros();

                    //Para cada especie me quedo con el nombre
                    $IdEspecie = count($Especies);
                    for ($i = 0; $i < $IdEspecie; $i++) {
                        $sql = "SELECT * FROM ESPECIE WHERE Id='" . $Especies[$i]["IdEspecie"] . "'";
                        $parametros = array();
                        $especie = array();
                        if ($conn->consulta($sql, $parametros)) {
                            $Nombreespecie = $conn->siguienteRegistro();
                            $especie["nombre"] = $Nombreespecie["Nombre"];

                            //Para cada especie hallo el total de publicaciones
                            $sql = "SELECT COUNT(*) TotalEspecie FROM PUBLICACION WHERE IdEspecie='" . $Especies[$i]["IdEspecie"] . "' && Tipo='Encontrada'";
                            $parametros = array();
                            if ($conn->consulta($sql, $parametros)) {
                                $resultado = $conn->siguienteRegistro();
                                $especie["totalEspecie"] = $resultado["TotalEspecie"];

                                //Para cada especie hallo el total de publicaciones CERRADAS
                                $sql = "SELECT COUNT(*) CerradosEspecie FROM PUBLICACION WHERE IdEspecie='" . $Especies[$i]["IdEspecie"] . "' && Estado='1' && Tipo='Encontrada'";
                                $parametros = array();
                                if ($conn->consulta($sql, $parametros)) {
                                    $resultado = $conn->siguienteRegistro();
                                    $cerrados = $resultado["CerradosEspecie"];
                                    $especie["CerradosEspecie"] = $cerrados;
                                    $especie["AbiertosEspecie"] = $especie["totalEspecie"] - $cerrados;

                                    //Para cada especie hallo el total de publicaciones CERRADAS qeu se encontro con el dueño
                                    $sql = "SELECT COUNT(*) CerradosOK FROM PUBLICACION WHERE IdEspecie='" . $Especies[$i]["IdEspecie"] . "' && Estado='1' && Tipo='Encontrada' && Resultado='0'";
                                    $parametros = array();
                                    if ($conn->consulta($sql, $parametros)) {
                                        $resultado = $conn->siguienteRegistro();
                                        $cerradosOK = $resultado["CerradosOK"];
                                        $especie["CerradosOK"] = $cerradosOK;

                                        //Para cada especie hallo el total de publicaciones CERRADAS que NO sencontro con el dueño
                                        $sql = "SELECT COUNT(*) CerradosNOOK FROM PUBLICACION WHERE IdEspecie='" . $Especies[$i]["IdEspecie"] . "' && Estado='1' && Tipo='Encontrada' && Resultado='1'";
                                        $parametros = array();
                                        if ($conn->consulta($sql, $parametros)) {
                                            $resultado = $conn->siguienteRegistro();
                                            $cerradosNOOK = $resultado["CerradosNOOK"];
                                            $especie["CerradosNOOK"] = $cerradosNOOK;
                                            $datosEncontrados[] = $especie;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                $datosPerdidos = array();

                //Hallo las diferentes especies
                $sql = "SELECT * FROM PUBLICACION  WHERE Tipo='Perdida' GROUP By IdEspecie";
                $parametros = array();
                if ($conn->consulta($sql, $parametros)) {
                    $Especies = $conn->restantesRegistros();

                    //Para cada especie me quedo con el nombre
                    $IdEspecie = count($Especies);
                    for ($i = 0; $i < $IdEspecie; $i++) {
                        $sql = "SELECT * FROM ESPECIE WHERE Id='" . $Especies[$i]["IdEspecie"] . "'";
                        $parametros = array();
                        $especie = array();
                        if ($conn->consulta($sql, $parametros)) {
                            $Nombreespecie = $conn->siguienteRegistro();
                            $especie["nombre"] = $Nombreespecie["Nombre"];

                            //Para cada especie hallo el total de publicaciones
                            $sql = "SELECT COUNT(*) TotalEspecie FROM PUBLICACION WHERE IdEspecie='" . $Especies[$i]["IdEspecie"] . "' && Tipo='Perdida'";
                            $parametros = array();
                            if ($conn->consulta($sql, $parametros)) {
                                $resultado = $conn->siguienteRegistro();
                                $especie["totalEspecie"] = $resultado["TotalEspecie"];

                                //Para cada especie hallo el total de publicaciones CERRADAS
                                $sql = "SELECT COUNT(*) CerradosEspecie FROM PUBLICACION WHERE IdEspecie='" . $Especies[$i]["IdEspecie"] . "' && Estado='1' && Tipo='Perdida'";
                                $parametros = array();
                                if ($conn->consulta($sql, $parametros)) {
                                    $resultado = $conn->siguienteRegistro();
                                    $cerrados = $resultado["CerradosEspecie"];
                                    $especie["CerradosEspecie"] = $cerrados;
                                    $especie["AbiertosEspecie"] = $especie["totalEspecie"] - $cerrados;

                                    //Para cada especie hallo el total de publicaciones CERRADAS qeu se encontro con el dueño
                                    $sql = "SELECT COUNT(*) CerradosOK FROM PUBLICACION WHERE IdEspecie='" . $Especies[$i]["IdEspecie"] . "' && Estado='1' && Tipo='Perdida' && Resultado='0'";
                                    $parametros = array();
                                    if ($conn->consulta($sql, $parametros)) {
                                        $resultado = $conn->siguienteRegistro();
                                        $cerradosOK = $resultado["CerradosOK"];
                                        $especie["CerradosOK"] = $cerradosOK;

                                        //Para cada especie hallo el total de publicaciones CERRADAS que NO sencontro con el dueño
                                        $sql = "SELECT COUNT(*) CerradosNOOK FROM PUBLICACION WHERE IdEspecie='" . $Especies[$i]["IdEspecie"] . "' && Estado='1' && Tipo='Perdida' && Resultado='1'";
                                        $parametros = array();
                                        if ($conn->consulta($sql, $parametros)) {
                                            $resultado = $conn->siguienteRegistro();
                                            $cerradosNOOK = $resultado["CerradosNOOK"];
                                            $especie["CerradosNOOK"] = $cerradosNOOK;
                                            $datosPerdidos[] = $especie;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $smarty->assign("datosEncontrados", $datosEncontrados);
                setcookie("Rncontrados", count($datosEncontrados));
                setcookie("Perdidos", count($datosPerdidos));
                $smarty->assign("datosPerdidos", $datosPerdidos);
                $esUsuario = $_SESSION['ingreso'];
                $smarty->assign("ingreso", $esUsuario);
                $smarty->assign("Username", $_COOKIE['usuario']);

                $smarty->display("Estadisticas.tpl");
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
} else {
    $_SESSION['ingreso'] = false;
    $esUsuario = false;
    $smarty->assign("ingreso", $esUsuario);
    $smarty->assign("Username", $_COOKIE['usuario']);
    $smarty->display("Home.tpl");
}
?>

