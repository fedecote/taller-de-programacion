$(document).ready(inicializo);

function inicializo() {
    $("#especie").click(ShowRazas);
    $("#agregarImagenPrincipal").click(OpenWindowsExplorer);
    $("#agregarImagenPrincipal").mouseenter(focusGained);
    $("#inputUpload").change(function () {
        readURL(this);
    });
    //$("#btnGuardar").click(upload);
    //$("inputUpload").click(upload)
    ShowRazas();
}

function focusGained() {
    $("#imagenPrincipal").empty();
    imagen = "<img id='agregarImagenPrincipal' class='card-img-top' src='img/addFocused.png' alt='0' style='margin-left: 31%; width: 50%; cursor: pointer;'>"
    $("#imagenPrincipal").append(imagen);
    $("#agregarImagenPrincipal").click(OpenWindowsExplorer);
    $("#agregarImagenPrincipal").mouseleave(focusLost);
}

function focusLost() {
    $("#imagenPrincipal").empty();
    imagen = "<img id='agregarImagenPrincipal' class='card-img-top' src='img/add.png' alt='0' style='margin-left: 31%; width: 50%; cursor: pointer;'>"
    $("#imagenPrincipal").append(imagen);
    $("#agregarImagenPrincipal").click(OpenWindowsExplorer);
    $("#agregarImagenPrincipal").mouseenter(focusGained);
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $("#imagenPrincipal").empty();
            imagen = "<img id='agregarImagenPrincipal' class='card-img-top' src='" + e.target.result + "' alt='0' style='margin-left: 31%; width: 70%; cursor: pointer;'>"
            $("#imagenPrincipal").append(imagen);
            $("#agregarImagenPrincipal").click(OpenWindowsExplorer);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function OpenWindowsExplorer() {
    $("#inputUpload").trigger("click");
}

function upload() {
     data = "&imagen=" + 
             $("#agregarImagenPrincipal").attr("src");
    $.ajax({
        url: "upload.php", // point to server-side PHP script 
        dataType: "JSON",
        data: data,
        type: "POST",
        timeout: 4000,
        success: SeguirGuardando,
        error: errorPag
    });
}

function errorPag(){
    
}

function SeguirGuardando(respuesta) {
    if(respuesta == "OK"){
        
    }
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


