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
    $("#btnGuardar").click(guardar);
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
    $('#holder').on({
        'dragover dragenter': function (e) {
            e.preventDefault();
            e.stopPropagation();
        },
        'drop': function (e) {
            var reader = new FileReader();
            reader.onload = function (event) {
                $("#holder").empty();
                imagen = "<img id='1' class='card-img-top' src='" + e.target.result + "' alt='Imagen' style='width: 20%; height:50%; cursor: pointer;'>"
                $("#holder").append(imagen);
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
    ShowRazas();
}

function WantToQuitImage(event) {
    var id = event.target.id;
    var cant = $("#" + id).attr("alt");
    imagesFiles.splice(cant, 1);
    $("#imagen" + cant).fadeOut().detach();
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

function guardar() {
    data = "&titulo=" + $("#titulo").val();
    data += "&tipoPublicacion=" + $("#tipoPublicacion").val();
    data += "&especie=" + $("#especie").val();
    data += "&raza=" + $("#raza").val();
    data += "&barrio=" + $("#barrio").val();
    data += "&descripcion=" + $("#descripcion").val();
    data += "&usuario=" + $("#usuario").attr("alt");
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
                    myAlertTop("La imagen " + file + " no ha sido subida porqeu no es del tipo soportado");
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
    }, 20000);
    $("#error").html(mensaje);
}

function errorAlert() {
    alert("error");
}

function response(respuesta) {
    myAlertTop(respuesta);
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

}

function LoadRazas(respuesta) {
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
}


