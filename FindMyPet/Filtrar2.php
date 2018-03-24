<?php

require_once("includes/class.Conexion.BD.php");
require_once("config/configuracion.php");
require_once("libs/Smarty.class.php");

$respuesta = array();

try {
    $pagina = (int) $_POST['pagina'];
    if ($pagina == 0) {
        $pagina = 1;
    }
    $nombrePublicacion = $_POST['nombrePublicacion'];
    $tipoPublicacion = $_POST['tipoPublicacion'];
    $especie = $_POST['especie'];
    $raza = $_POST['raza'];
    $barrio = $_POST['barrio'];
    $cantPaginado = (int) $_POST['cantPaginado'];
    $estado = $_POST['estado'];
    $token = $_POST['token'];
    $desde = $_POST['desde'];
    $hasta = $_POST['hasta'];


    $conn = new ConexionBD("mysql", "localhost", "FindMyPet", "root", "root");

    if ($conn->conectar()) {
        $sql = "SELECT * FROM USUARIO WHERE Token='" . $token . "'";
        $parametros = array();
        if ($conn->consulta($sql, $parametros)) {
            $Usuario = $conn->siguienteRegistro();
            $IdUsuario = $Usuario['Id'];
            
            $sql = "SELECT COUNT(*) Total FROM PUBLICACION";
            $sql .= " WHERE IdUsuario='" . $IdUsuario . "'";

            if($desde != null){
                $sql .= "&& Fecha >= '" . date('Y-m-d', strtotime($desde)) ."'";
            }
            
            if($hasta != null){
                $sql .= "&& Fecha <= '" . date('Y-m-d', strtotime($hasta)) ."'";
            }
            
            if($estado != 2){
                $sql .= " && Estado='" . $estado . "'";
            }
            
            if ($nombrePublicacion != '') {
                $sql .= " && (Titulo like'%" . $nombrePublicacion . "%' || Descripcion like '%" . $nombrePublicacion . "%')";
            }

            if ($tipoPublicacion != "Todas") {
                $sql .= " && Tipo='" . $tipoPublicacion . "'";
            }

            if ($especie != 0) {
                $sql .= " && IdEspecie =" . $especie;
            }
            if ($raza != 0) {
                $sql .= " && IdRaza =" . $raza;
            }

            if ($barrio != 0) {
                $sql .= " && IdBarrio ='" . $barrio . "'";
            }

            $parametros = array();
            if ($conn->consulta($sql, $parametros)) {
                $result = $conn->siguienteRegistro();
                $cantPaginas = ceil($result["Total"] / $cantPaginado);
            }
            $sql = "SELECT * FROM PUBLICACION";

            $sql .= " WHERE IdUsuario='" . $IdUsuario . "'";
            
            if($desde != null){
                $sql .= "&& Fecha >= '" . date('Y-m-d', strtotime($desde)) ."'";
            }
            
            if($hasta != null){
                $sql .= "&& Fecha <= '" . date('Y-m-d', strtotime($hasta)) ."'";
            }
            
            if($estado != 2){
                $sql .= " && Estado='" . $estado . "'";
            }
            if ($nombrePublicacion != '') {
                $sql .= " && (Titulo like'%" . $nombrePublicacion . "%' || Descripcion like '%" . $nombrePublicacion . "%')";
            }
            if ($tipoPublicacion != "Todas") {
                $sql .= " && Tipo='" . $tipoPublicacion . "'";
            }

            if ($especie != 0) {
                $sql .= " && IdEspecie =" . $especie;
            }
            if ($raza != 0) {
                $sql .= " && IdRaza =" . $raza;
            }

            if ($barrio != 0) {
                $sql .= " && IdBarrio ='" . $barrio . "'";
            }

            $sql .= " ORDER BY Id DESC";

            if ($cantPaginado === 0) {
                $parametros = array();
            } else {
                $sql .= " LIMIT :inicio,:cantidad";
                $parametros = array(
                    array("inicio", (($pagina - 1) * $cantPaginado), "int", 0),
                    array("cantidad", $cantPaginado, "int", 0),
                );
            }

            if ($conn->consulta($sql, $parametros)) {
                $publicaciones = $conn->restantesRegistros();
                $respuesta["publicaciones"] = $publicaciones;
                $respuesta["result"] = "OK";
                $respuesta["pagina"] = $pagina;
                $respuesta["cantPaginas"] = $cantPaginas;
                $respuesta["paginaAntFiltro"] = $pagina - 1;
                $respuesta["paginaSigFiltro"] = $pagina + 1;

                $sql2 = "SELECT * FROM IMAGEN  Group By IdPublicacion";
                $parametros = array();
                if ($conn->consulta($sql2, $parametros)) {
                    $fotos = $conn->restantesRegistros();
                    $respuesta["fotos"] = $fotos;
                }
                echo json_encode($respuesta);
            } else {
                $respuesta["result"] = "NO OK";
                $respuesta["mensaje"] = "Ha ocurrido un error al obtener las publicaciones";
                echo json_encode($respuesta);
            }
        } else {
            $respuesta["result"] = "NO OK";
            $respuesta["mensaje"] = "La pagina se encuentra en mantenimiento, por favor reintente mas tarde. Disculpe las molestias";
            echo json_encode($respuesta);
        }
    } else {
        $respuesta["result"] = "NO OK";
        $respuesta["mensaje"] = "Ha ocurrido un error al obtener las publicaciones";
        echo json_encode($respuesta);
    }
} catch (Exception $e) {
    $respuesta["result"] = "NO OK";
    $respuesta["mensaje"] = "La pagina se encuentra en mantenimiento, por favor reintente mas tarde. Disculpe las molestias";
    echo json_encode($respuesta);
}
?>