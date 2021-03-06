<!DOCTYPE>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script type="text/javascript"  src="js/Publicaciones.js"></script>
    </head>
    <body>
        <div align="center" style="padding-top: 2%; ">
            <input id="nombrePublicacion" type="text" placeholder="Buscar.." style="width: 30%;">
        </div>
        <div id="filtros" class="filter">
            <div>
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
                <br>
                <input type="hidden" name="accion" value="filter" />
                <button id="btnFiltros" type="button" class="btn btn-primary">Limpiar filtros</button>
            </div>
        </div>
        <div id="busqueda">
        </div>
    </body>
</html>