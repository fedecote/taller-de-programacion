$(document).ready(inicializo);

function inicializo(){
    $("#btnAlta").click(ventanaAlta);
    $("#btnInicio").click(inicio);
    $("#btnConsulta").click(consulta);
}

function ventanaAlta(){
    window.location = "alta.php";
}

function inicio(){
    window.location = "index.php";
}

function consulta(){
    window.location = "consulta.php";
}