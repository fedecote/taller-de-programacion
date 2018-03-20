$(document).ready(inicializo);

function inicializo() {
    $("#btnLogin").click(validarUsuario);
}

function validarUsuario() {
    var usuario = $("#usuario").val();
    var password = $("#password").val();
    var remember = $("#remember").prop("checked");
    $.ajax({
        url: "Login.php",
        dataType: "JSON",
        type: "POST",
        data: "usuario=" + usuario + "&password=" + password + "&remember=" + remember,
        success: validoUsuario,
        timeout: 4000,
        error: errorLogin
    });
}

function validoUsuario(respuesta) {
    esUsuario = respuesta;
    if (esUsuario['estado'] == "NO OK") {
        myAlertTop(respuesta["mensaje"]);
    } else {
        location.reload();
    }
}

function errorLogin(respuesta) {
    myAlertTop(respuesta["mensaje"]);
}

function myAlertTop(mensaje) {
    $(".myAlert-top").show();
    setTimeout(function () {
        $(".myAlert-top").hide();
    }, 8000);
    $("#error").html(mensaje);
    $(".myAlert-top").css({"display":"visible"});
}

$(function () {
    $("[data-hide]").on("click", function () {
        $(this).closest("." + $(this).attr("data-hide")).hide();
    });
});

