$(document).ready(inicializo);

function inicializo() {
    imagesFiles = [];
    $("#especie").click(ShowRazas);
    $("#agregarImagenPrincipal").click(OpenWindowsExplorer);
    $(window).on('resize', resizeImage);
    $("#agregarImagenPrincipal").mouseenter(focusGained);
    $("#agregarImagenPrincipal").mouseleave(focusLost);
    $("#holder").mouseenter(dragEnter);
    $("#holder").mouseleave(dragLeave);
    $("#textAgregar").mouseenter(dragEnter);
    $("#inputUpload").change(previewMainImage);
    $("#uploadManyFiles").change(previewImage);
    resizeImage();
    $("#btnGuardar").click(checkFields);
    $("#titulo").focusout(cleanInvalidFields);
    $(".myAlert-top").hide();
    $("#textAgregar").click(OpenWindowsExplorer2);
    $("#holder").click(function (event) {
        if (event.target.nodeName !== "SPAN") {
            OpenWindowsExplorer2();
        } else {
            WantToQuitImage(event);
        }
    });
    $("#textAgregar").on('dragenter', dragEnter);
    $("#holder").on('dragenter', dragEnter);
    $("#holder").on('dragleave', dragLeave);
    ShowRazas();
    myMap();
    gmarkers = [];
}
function myMap() {
    var mapCanvas = document.getElementById("map");
    var myCenter = new google.maps.LatLng(-34.8826933, -56.1600915);
    var mapOptions = {center: myCenter, zoom: 12};
    var map = new google.maps.Map(mapCanvas, mapOptions);
    google.maps.event.addListener(map, 'click', function (event) {
        placeMarker(map, event.latLng);
    });
}

function placeMarker(map, location) {
    removeMarkers();
    gmarkers = [];
    marker = new google.maps.Marker({
        position: location,
        map: map
    });
    gmarkers.push(marker);
}

function removeMarkers() {
    for (i = 0; i < gmarkers.length; i++) {
        gmarkers[i].setMap(null);
    }
}

function WantToQuitImage(event) {
    var id = event.target.id;
    var cant = $("#" + id).attr("alt");
    imagesFiles.splice(cant, 1);
    $("#imagen" + cant).fadeOut().detach();
    var holder = ($("#holder").attr("alt") - 1);
    $("#holder").attr("alt", holder);
    if (holder === 0) {
        $("#textAgregar").css({"display": "block"});
    }
}

function resizeImage() {
    width = $("#agregarImagenPrincipal").width();
    $("#agregarImagenPrincipal").height(width * 0.8);
}

function dragEnter() {
    $("#holder").css({"background": "lightgray"});
}

function dragLeave() {
    $("#holder").css({"background": "none"});
}

$(function () {
    $("[data-hide]").on("click", function () {
        $(this).closest("." + $(this).attr("data-hide")).hide();
    });
});

function focusGained() {
    $("#agregarImagenPrincipal").css({"background-color": "lightgray"});
}

function focusLost() {
    $("#agregarImagenPrincipal").css({"background-color": "white"});
}

function cleanInvalidFields() {
    if ($("#titulo").val()) {
        $("#titulo").removeClass("invalido");
    }
}

function previewImage() {
    if (this.files && this.files[0]) {
        var fileName = $("#uploadManyFiles").val();
        var cantImagenes = parseInt($("#holder").attr("alt"));
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile == "jpg" || extFile == "jpeg" || extFile == "png" || extFile == "gif") {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#textAgregar").css({"display": "none"});
                imagen = "";
                imagen += "<div id='imagen" + (cantImagenes + 1) + "' alt='" + (cantImagenes + 1) + "' name='" + fileName + "' style='display:inline;position: relative;'><img class='card-img-top' src='" + e.target.result + "' alt='Imagen' style='width: 35%;height: 170px;cursor: pointer;float: left;margin-right: 5%;margin-left: 5%; max-height: 180px;margin-top:2%;'><span id='close" + (cantImagenes + 1) + "' class='close' alt='" + (cantImagenes + 1) + "'>X</span></div>";
                if (cantImagenes >= 2) {
                    $("#holder").css({"overflow-y": "auto"});
                }
                $("#holder").append(imagen);
            }
            imagesFiles.push($('#uploadManyFiles').prop('files')[0]);
            reader.readAsDataURL(this.files[0]);
            $("#holder").attr("alt", (cantImagenes + 1));
        } else {
            myAlertTop('El archivo subido no es valido');
        }
    }
}

function previewMainImage() {
    if (this.files && this.files[0]) {
        var fileName = $("#inputUpload").val();
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile == "jpg" || extFile == "jpeg" || extFile == "png" || extFile == "gif") {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#agregarImagenPrincipal").empty();
                imagen = "<img id='agregarImagenPrincipal' class='card-img-top' src='" + e.target.result + "' alt='Imagen' style='width: 100%; height:100%; cursor: pointer;'>"
                $("#agregarImagenPrincipal").append(imagen);
            }
            reader.readAsDataURL(this.files[0]);
        } else {
            myAlertTop('El archivo subido no es valido');
        }
        focusLost();
    }
}

function OpenWindowsExplorer() {
    $("#inputUpload").trigger("click");
}

function OpenWindowsExplorer2(event) {
    $("#uploadManyFiles").trigger("click");
}

function checkFields() {
    if ($("#titulo").val() === "") {
        myAlertTop("El titulo no puede quedar vacio");
        $("#titulo").addClass("invalido");
    } else {
        if ($("#inputUpload").val() === "") {
            myAlertTop("La publicacion debe tener al menos una imagen de portada");
        } else {
            guardar();
        }
    }
}


function guardar() {
    data = "&titulo=" + $("#titulo").val();
    data += "&tipoPublicacion=" + $("#tipoPublicacion").val();
    data += "&especie=" + $("#especie").val();
    data += "&raza=" + $("#raza").val();
    data += "&barrio=" + $("#barrio").val();
    data += "&descripcion=" + $("#descripcion").val();
    data += "&usuario=" + $("#usuario").attr("alt");
    if (gmarkers.length > 0) {
        data += "&latitud=" + gmarkers[0].getPosition().lat();
        data += "&longitud=" + gmarkers[0].getPosition().lng();
    } else {
        data += "&latitud=" + "null";
        data += "&longitud=" + "null";
    }
    $.ajax({
        url: "CrearPublicacion.php",
        dataType: "JSON",
        type: "POST",
        data: data,
        success: upload,
        timeout: 4000,
        error: error
    });
}

function error(respuesta) {
    myAlertTop(respuesta['mensaje']);
}

function upload(respuesta) {
    if (respuesta['status'] == "OK") {
        IdPublicacion = respuesta["IdPublicacion"];
        var cantImagenes = parseInt($("#holder").attr("alt"));
        var fileName = $("#inputUpload").val();
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile == "jpg" || extFile == "jpeg" || extFile == "png" || extFile == "gif") {
            var file_data = $('#inputUpload').prop('files')[0];
            var form_data = new FormData();
            form_data.append('file0', file_data);
            for (i = 1; i <= cantImagenes; i++) {
                var id = "#imagen" + cantImagenes;
                var fileName2 = $(id).attr("name");
                var idxDot = fileName2.lastIndexOf(".") + 1;
                var extFile = fileName2.substr(idxDot, fileName.length).toLowerCase();
                if (extFile == "jpg" || extFile == "jpeg" || extFile == "png" || extFile == "gif") {
                    var file_data2 = imagesFiles[i - 1];
                    form_data.append('file' + i, file_data2);
                } else {
                    var file = str_replace("\\", '/', fileName2);
                    myAlertTop("La imagen " + file + " no ha sido subida porque no es del tipo soportado");
                }
            }
            $.ajax({
                url: 'upload.php', // point to server-side PHP script 
                dataType: 'JSON', // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: response,
                error: function (request) {
                    myAlertTop(request.responseText);
                }
            });
        } else {
            myAlertTop('El archivo subido no es valido');
        }
    }
}

function errorUpload(respuesta) {
    myAlertTop(respuesta);
}

function myAlertTop(mensaje) {
    $(".myAlert-top").show();
    setTimeout(function () {
        $(".myAlert-top").hide();
    }, 8000);
    $("#error").html(mensaje);
}

function response(respuesta) {
    if (respuesta["status"] != "OK") {
        myAlertTop(respuesta["mensaje"]);
        borrarPublicacion();
    } else {
        window.location = "index.php";
    }
}

function borrarPublicacion(){
    data = "&Id=" + IdPublicacion;
    $.ajax({
        url: "BorrarPublicacion.php",
        dataType: "JSON",
        type: "POST",
        data: data,
        success: reloadPage,
        timeout: 4000,
        error: errorPage
    });
}

function reloadPage(){
    
}

function errorPage(){
    
}

function ShowRazas() {
    if ($("#especie").val() != 0) {
        data = "&IdEspecie=" + $("#especie").val();
        $.ajax({
            url: "getRazas.php",
            dataType: "JSON",
            type: "POST",
            data: data,
            success: LoadRazas,
            timeout: 4000,
            error: errorPag
        });
    }
}

function errorPag() {
    myAlertTop('La especie seleccionada no tiene razas registradas');
}

function LoadRazas(respuesta) {
    if (respuesta["status"] === "OK") {
        razas = respuesta["razas"];
        $("#razas").empty();
        resultadoRazas = "<p  style='text-align: left'><b>Raza:</b>"
        resultadoRazas += "<select name='raza' id='raza' class='form-control input-md' style='display: inline; width: 25%;margin-left: 1%;'>";
        if (razas.length > 0) {
            for (pos = 0; pos < razas.length; pos++) {
                raza = razas[pos];
                resultadoRazas += "<option value='" + raza["Id"] + "'>" + raza["Nombre"] + "</option>";
            }
        }
        resultadoRazas += "</select></p>";
        $("#razas").append(resultadoRazas);
    } else {
        myAlertTop(respuesta["mensaje"]);
    }
}


