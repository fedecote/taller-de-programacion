$(document).ready(inicializo);

function inicializo() {
    $(".myAlert-top").hide();
}

function estadistica() {
    window.location = "estadisticas.php";
}

function inicio() {
    window.location = "index.php";
}

function myAlertTop(mensaje) {
    $(".myAlert-top").show();
    setTimeout(function () {
        $(".myAlert-top").hide();
    }, 20000);
    $("#error").html(mensaje);
}

$(function () {
    $("[data-hide]").on("click", function () {
        $(this).closest("." + $(this).attr("data-hide")).hide();
    });
});
