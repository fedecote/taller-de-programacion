<!DOCTYPE>
<html>
    <head>
        <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>jQuery UI Datepicker - Default functionality</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $(function () {
                $("#datepickerDesde").datepicker();
            });
            $(function () {
                $("#datepickerHasta").datepicker();
            });
        </script>
        <script type="text/javascript"  src="js/Publicaciones2.js"></script>
    </head>
    <body>
        <div align="center" style="padding-top: 2%; ">
            <input id="nombrePublicacion" type="text" placeholder="Buscar.." style="width: 30%;">
        </div>
        <div id="filtros" class="filter">
            <div>
                <label for="tipo">Estado:</label>
                <select name="tipo" id="estado" class="form-control input-md"><option value="2">Todos</option><option value="0">Abiertos</option><option value="1">Cerrados</option></select>   
                <label for="tipo">Tipo de publicacion:</label>
                <select name="tipo" id="tipoPublicacion" class="form-control input-md"><option value="Todas">Todas</option><option value="Perdida">Perdida</option><option value="Encontrada">Encontrada</option></select>   
                <label for="especie">Especie:</label>
                <select name="especie" id="especie" class="form-control input-md"><option value="0">Todas</option>
                    {foreach from=$especies item=nombreEspecie}  
                        <option value="{$nombreEspecie.Id}">{$nombreEspecie.Nombre}</option>
                    {/foreach}
                </select>    
                <div id="razas" style="display: none">
                </div>
                <label for="barrio">Barrio:</label>
                <select name="barrio" id="barrio" class="form-control input-md"><option value="0">Todos</option>
                    {foreach from=$barrios item=barrio}  
                        <option value="{$barrio.Id}">{$barrio.Nombre}</option>
                    {/foreach}
                </select>
                <label for="cantPaginado">Cantidad de avisos por pagina:</label>
                <select name="cantPaginado" id="cantPaginado" class="form-control input-md">
                    <option selected ="selected" value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="0">Todos</option>
                </select>
                <label for="fecha">Desde:</label>
                <input type="text" placeholder="Fecha desde.." id="datepickerDesde">
                <label for="fecha">Hasta:</label>
                <input type="text" placeholder="Fecha hasta.." id="datepickerHasta">
                <br>
                <input type="hidden" name="accion" value="filter" />
                <button style="margin-top: 10%;" id="btnFiltros" type="button" class="btn btn-primary">Limpiar filtros</button>
            </div>
        </div>
        <div id="busqueda">
        </div>
    </body>
</html>