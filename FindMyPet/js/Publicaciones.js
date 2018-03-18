$(document).ready(inicializo);

function inicializo() {
    $(".myAlert-top").hide();
    $(".btnInfo").click(Publicacion);
    $("#nombrePublicacion").keyup(function (event) {
        irPaginaFiltro();
    });
    $("#filter").click(ShowFilters);
    $("#especie").click(ShowRazas);
    $("#raza").click(irPaginaFiltro);
    $("#estado").click(irPaginaFiltro);
    $("#tipoPublicacion").click(irPaginaFiltro);
    $("#barrio").click(irPaginaFiltro);
    $("#cantPaginado").click(irPaginaFiltro);
    $("#btnFiltros").click(limpiarFiltros);
    irPaginaFiltro();
}

function limpiarFiltros(){
    $("#razas").empty();
    $("#razas").css('display', 'none');
    $("#especie").val('0');
    $("#tipoPublicacion").val("Todas");
    $("#barrio").val("0");
    $("#cantPaginado").val("4");
    $("#estado").val("0");
    irPaginaFiltro();
}

function ShowRazas() {
    if ($("#especie").val() != 0) {
        irPaginaFiltro();
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
    }else{
        $("#razas").css('display', 'none');
        irPaginaFiltro();
    }
}

function LoadRazas(respuesta) {
    razas = respuesta["razas"];
    $("#razas").empty();
    $("#razas").css('display', 'block');
    resultadoRazas = "<label for='raza'>Raza:</label>";
    resultadoRazas += "<select name='raza' id='raza' class='form-control input-md'><option value='0'>Todas</option>";
    if (razas.length > 0) {
        for (pos = 0; pos < razas.length; pos++) {
            raza = razas[pos];
            resultadoRazas += "<option value='" + raza["Id"] + "'>" + raza["Nombre"] + "</option>";
        }
    }
    resultadoRazas += "</select>";
    $("#razas").append(resultadoRazas);
    $("#raza").click(irPaginaFiltro);
}

function ShowFilters() {
    $("#myForm").show();
}

function irPaginaFiltro() {
    //Filtro por tipo de operacion
    data = "&nombrePublicacion=" + $("#nombrePublicacion").val();
    
    data += "&estado=" + $("#estado").val();

    data += "&cantPaginado=" + $("#cantPaginado").val();
    //Filtro por propiedad
    data += "&tipoPublicacion=" + $("#tipoPublicacion").val();

    //Filtro por departamento
    data += "&especie=" + $("#especie").val();

    //Filtro por barrio
    data += "&raza=" + $("#raza").val();

    data += "&barrio=" + $("#barrio").val();

    data += "&pagina=" + $("#paginaActual").val();
    
    $.ajax({
        url: "filtrar.php",
        dataType: "JSON",
        type: "POST",
        data: data,
        success: respuestaPag,
        timeout: 4000,
        error: errorPag
    });
}

function respuestaPag(respuesta) {
    if (respuesta["result"] == "OK") {
        $("#busqueda").empty();
        pagina = respuesta["pagina"];
        fotos = respuesta["fotos"];
        publicaciones = respuesta["publicaciones"];
        cantPaginas = respuesta["cantPaginas"];
        busqueda = "";
        if (publicaciones.length > 0) {
            for (pos = 0; pos < publicaciones.length; pos++) {
                publicacion = publicaciones[pos];

                busqueda += "<div class='container col-sm-6' align='center'  style='padding-top: 3%; width: 35%;";
                if (pos % 2 == 0) {
                    busqueda += "margin-left: 20%;";
                }
                busqueda += "'>";
                busqueda += "<a class='btnInfo' href='#' alt='" + publicacion["Id"] + "'><h2>" + publicacion["Titulo"] + "</h2></a>";
                busqueda += "<div class='card' style='width:350px'>";
                for (i = 0; i < fotos.length; i++){
                    foto = fotos[i];
                    if(foto["IdPublicacion"] == publicacion["Id"]){
                        busqueda += "<img class='card-img-top' src='" + foto["Ruta"] + "' alt='Card image' style='width:75%'>";
                    }
                }
                //busqueda += "<img class='card-img-top' src='img/cat.png' alt='Card image' style='width:75%'>";
                busqueda += "<div class='card-body'>";
                busqueda += "<h4 class='card-title'>" + publicacion["Tipo"] + "</h4>";
                busqueda += "<p class='card-text' style='word-wrap: break-word;'>";
                desc = "";
                cant = 0;
                for (i = 0; i < publicacion["Descripcion"].length && i < 151; i++) {
                    desc += publicacion["Descripcion"].charAt(i);
                    if(i >= 150){
                        desc += "...";
                    }
                }
                busqueda += desc + "</p>";
                busqueda += "</div>";
                busqueda += "</div>";
                busqueda += "</div>";
            }
            
            busqueda += "<div style='position: absolute; bottom: 0; margin-left: 50%; width: 50%; margin-bottom: 1%;' id='paginaActual' alt='" + pagina +"'>";
            if(pagina > 1){
                busqueda += "<img class='card-img-top' id='anterior' src='img/arrow-back.png' alt='" + (pagina -1) + "' height='30' width='30' style='margin-right: 10%; cursor:pointer;'>";
            }
            if(cantPaginas > pagina){
                busqueda += "<img class='card-img-top' id='siguiente' src='img/arrow-next.png' alt='" + (pagina +1) + "' height='30' width='30' style='cursor:pointer;'>";
            }
            busqueda += "</div>";
            busqueda += "</div>";
            $("#busqueda").append(busqueda);
            $(".btnInfo").click(Publicacion);
            $("#anterior").click(PaginaAnterior);
            $("#siguiente").click(PaginaSiguiente);
        } else {
            busqueda += "<p style='    text-align: center; margin-top: 15%; font-size: 150%;'><b> No se han encontrado resultados</b></p>"
            $("#busqueda").append(busqueda);
        }
    } else {
        alert("ERROR " + respuesta["result"]);
    }
}

function PaginaAnterior(){
    //Filtro por tipo de operacion
    data = "&nombrePublicacion=" + $("#nombrePublicacion").val();

    //Filtro por propiedad
    data += "&tipoPublicacion=" + $("#tipoPublicacion").val();

    //Filtro por departamento
    data += "&especie=" + $("#especie").val();

    //Filtro por barrio
    data += "&raza=" + $("#raza").val();

    data += "&barrio=" + $("#barrio").val();

    data += "&pagina=" + $("#anterior").attr("alt");
    
    $.ajax({
        url: "filtrar.php",
        dataType: "JSON",
        type: "POST",
        data: data,
        success: respuestaPag,
        timeout: 4000,
        error: errorPag
    });
}

function PaginaSiguiente(){
    //Filtro por tipo de operacion
    data = "&nombrePublicacion=" + $("#nombrePublicacion").val();

    //Filtro por propiedad
    data += "&tipoPublicacion=" + $("#tipoPublicacion").val();

    //Filtro por departamento
    data += "&especie=" + $("#especie").val();

    //Filtro por barrio
    data += "&raza=" + $("#raza").val();

    data += "&barrio=" + $("#barrio").val();

    data += "&pagina=" + $("#siguiente").attr("alt");
    
    $.ajax({
        url: "filtrar.php",
        dataType: "JSON",
        type: "POST",
        data: data,
        success: respuestaPag,
        timeout: 4000,
        error: errorPag
    });
}

function Publicacion() {
    var id = $(this).attr("alt");
    window.open("ViewPublication.php?id=" + id + "&esConsulta=0");
}

function errorPag() {
    alert("ERROR");
}