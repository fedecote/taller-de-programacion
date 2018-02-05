<?php

/*
 * CONFIGURACION DE SMARTY  
 */
require_once('libs/Smarty.class.php');

define('TEMPLATE_DIR', $_SERVER['DOCUMENT_ROOT'].'/pruebaSmarty/templates/');
define('COMPILER_DIR', $_SERVER['DOCUMENT_ROOT'].'/pruebaSmarty/tmp/templates_c/');
define('CONFIG_DIR', $_SERVER['DOCUMENT_ROOT'].'/pruebaSmarty/tmp/configs/');
define('CACHE_DIR', $_SERVER['DOCUMENT_ROOT'].'/pruebaSmarty/tmp/cache/');

?>