$(document).ready(inicializo);

function inicializo() {
    $(".myAlert-top").hide();
    $("#cerrar").click(closePublication);
    $("#siguiente").click(NextPhoto);
    $("#btnPregunta").click(NuevaPregunta);
    $('#btnClose').click(ShowCloseTab);
    $('#btnCancel').click(HideCloseTab);
    HideCloseTab();
    LoadPhoto();
}

function HideCloseTab(){
    $('#closeTab').hide();
}

function ShowCloseTab(){
    $('#closeTab').show();
}

function Responder() {
    data = "&Id=" + $(this).attr('alt');
    value = $(this).attr('alt');
    data += "&respuesta=" + $("#" + value).val();
    $.ajax({
        url: "Responder.php",
        dataType: "JSON",
        type: "POST",
        data: data,
        success: pregunta,
        timeout: 4000,
        error: errorPag
    });
}

function NuevaPregunta() {
    data = "&IdPublicacion=" + $("#pub").attr("alt");
    data += "&pregunta=" + $("#nuevaPregunta").val();
    $.ajax({
        url: "Preguntar.php",
        dataType: "JSON",
        type: "POST",
        data: data,
        success: pregunta,
        timeout: 4000,
        error: errorPag
    });
}

function pregunta(respuesta) {
    if (respuesta == 'OK') {
        location.reload();
    }
}

function LoadPhoto() {
    data = "&IdPublicacion=" + $("#pub").attr("alt");
    numeroFoto = 0;
    data += "&foto=" + numeroFoto;
    $.ajax({
        url: "ChangePhoto.php",
        dataType: "JSON",
        type: "POST",
        data: data,
        success: respuestaPag,
        timeout: 4000,
        error: errorPag
    });
}

function NextPhoto() {
    data = "&IdPublicacion=" + $("#pub").attr("alt");
    var numeroFoto = parseInt($("#imagen").attr("alt"));
    numeroFoto += 1;
    data += "&foto=" + numeroFoto;
    $.ajax({
        url: "ChangePhoto.php",
        dataType: "JSON",
        type: "POST",
        data: data,
        success: respuestaPag,
        timeout: 4000,
        error: errorPag
    });
}

function PreviousPhoto() {
    data = "&IdPublicacion=" + $("#pub").attr("alt");
    var numeroFoto = parseInt($("#imagen").attr("alt"));
    numeroFoto -= 1;
    data += "&foto=" + numeroFoto;
    $.ajax({
        url: "ChangePhoto.php",
        dataType: "JSON",
        type: "POST",
        data: data,
        success: respuestaPag,
        timeout: 4000,
        error: errorPag
    });
}

function respuestaPag(respuesta) {
    $("#imagen1").empty();
    fotoAMostrar = respuesta["foto"];
    numeroFoto = respuesta["numeroFoto"];
    imagen = "<img id='imagen' class='card-img-top' src='" + fotoAMostrar[numeroFoto]["Ruta"] + "' alt=" + numeroFoto + " style='width: 120%; height:250px;'>";
    imagen += "<div style='margin-left: 16%; margin-top:2%;'>";
    if (numeroFoto > 0) {
        imagen += "<img class='card-img-top' id='anterior' src='img/arrow-back.png' alt='Back' height='30' width='30' style='cursor:pointer;'>";
    }
    if (parseInt($("#imagen1").attr("alt")) > numeroFoto + 1) {
        imagen += "<img class='card-img-top' id='siguiente' src='img/arrow-next.png' alt='Next' height='30' width='30' style='cursor:pointer; margin-left: 20px;'>";
    }
    imagen += "</div>";
    $("#imagen1").append(imagen);
    $("#anterior").click(PreviousPhoto);
    $("#siguiente").click(NextPhoto);
}

function errorPag() {
    alert("ERROR");
}

function close(respuesta) {
    if (respuesta == "OK") {
        $("#containerClose").empty();
        button = "<button id='closed' alignment='right' class='btn btn-danger' style='cursor: default; float: right; margin-top: 3%;'>Publicacion Cerrada</button>"
        $("#containerClose").append(button);
        HideCloseTab();
    }
}

function closePublication() {
    data = "&IdPublicacion=" + $("#pub").attr("alt");
    data += "&resultado=" + $("#resultado").val();
    $.ajax({
        url: "cerrarPublicacion.php",
        dataType: "JSON",
        type: "POST",
        data: data,
        success: close,
        timeout: 4000,
        error: errorPag
    });
}
