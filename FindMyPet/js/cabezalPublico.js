$(document).ready(inicializo);

function inicializo(){
    $("#btnIniciarSesion").click(validarUsuario);
    $("#btnEstadistica").click(estadistica);
    $("#btnInicio").click(inicio);
}

function validarUsuario(){
    var usuario = $("#usuario").val();
    var contra = $("#contra").val();
    $.ajax({
            url: "validarUsuario.php",
            dataType: "JSON",
            type: "POST",
            data: "usuario=" + usuario + "&contra=" + contra,
            success: validoUsuario,
            timeout: 4000,
            error: errorPag
            });
}

function validoUsuario(respuesta){
    esUsuario = respuesta;
    if (esUsuario['estado'] == "NO OK"){
        $("#error").html("NO OK");
    }
    else{
        window.location = "index.php";
    }
}

function errorPag(){
    alert("Error");
}

function estadistica(){
    window.location = "estadisticas.php";
}

function inicio(){
    window.location = "index.php";
}

