<?php
//unset($_COOKIE['usuario']);
setcookie ("usuario", "", time() - 3600);
session_destroy();
header("Location: index.php");
?>

