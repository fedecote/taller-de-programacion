$(document).ready(inicializo);

function inicializo() {
    $("#especie").click(ShowRazas);
    $("#agregarImagenPrincipal").click(OpenWindowsExplorer);
    $("#agregarImagenPrincipal").mouseenter(focusGained);
    $("#inputUpload").change(function () {
        readURL(this);
    });
    $("#btnGuardar").click(upload);
    $(".myAlert-top").hide();
    $("#textAgregar").click(OpenWindowsExplorer2);
    $("#holder").click(OpenWindowsExplorer2);
    $('#holder').on({
        'dragover dragenter': function (e) {
            e.preventDefault();
            e.stopPropagation();
        },
        'drop': function (e) {
            //console.log(e.originalEvent instanceof DragEvent);
            var dataTransfer = e.originalEvent.dataTransfer;
            if (dataTransfer && dataTransfer.files.length) {
                e.preventDefault();
                e.stopPropagation();
                $.each(dataTransfer.files, function (i, file) {
                    var reader = new FileReader();
                    reader.onload = $.proxy(function (file, $fileList, event) {
                        var img = file.type.match('image.*') ? "<img src='" + event.target.result + "' /> " : "";
                        $fileList.prepend($("<li>").append(img + file.name));
                    }, this, file, $("#fileList"));
                    reader.readAsDataURL(file);
                });
            }
        }
    });
    ShowRazas();
}

$(function () {
    $("[data-hide]").on("click", function () {
        $(this).closest("." + $(this).attr("data-hide")).hide();
    });
});

function focusGained() {
    $("#imagenPrincipal").empty();
    imagen = "<img id='agregarImagenPrincipal' class='card-img-top' src='img/addFocused.png' alt='Imagen' style='margin-left: 31%; width: 50%; cursor: pointer;'>"
    $("#imagenPrincipal").append(imagen);
    $("#agregarImagenPrincipal").click(OpenWindowsExplorer);
    $("#agregarImagenPrincipal").mouseleave(focusLost);
}

function focusLost() {
    $("#imagenPrincipal").empty();
    imagen = "<img id='agregarImagenPrincipal' class='card-img-top' src='img/add.png' alt='Imagen' style='margin-left: 31%; width: 50%; cursor: pointer;'>"
    $("#imagenPrincipal").append(imagen);
    $("#agregarImagenPrincipal").click(OpenWindowsExplorer);
    $("#agregarImagenPrincipal").mouseenter(focusGained);
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $("#imagenPrincipal").empty();
            imagen = "<img id='agregarImagenPrincipal' class='card-img-top' src='" + e.target.result + "' alt='Imagen' style='margin-left: 31%; width: 70%; cursor: pointer;'>"
            $("#imagenPrincipal").append(imagen);
            $("#agregarImagenPrincipal").click(OpenWindowsExplorer);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function OpenWindowsExplorer() {
    $("#inputUpload").trigger("click");
}

function OpenWindowsExplorer2() {
    $("#uploadManyFiles").trigger("click");
}


function upload() {
    var fileName = $("#inputUpload").val();
    var idxDot = fileName.lastIndexOf(".") + 1;
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
    if (extFile == "jpg" || extFile == "jpeg" || extFile == "png" || extFile == "gif") {
        var file_data = $('#inputUpload').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        alert(form_data);
        $.ajax({
            url: 'upload.php', // point to server-side PHP script 
            dataType: 'JSON', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: response,
            error: errorAlert// display response from the PHP script, if any

        });
    } else {
        myAlertTop('El archivo subido no es valido');
    }
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
    alert(respuesta);
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


