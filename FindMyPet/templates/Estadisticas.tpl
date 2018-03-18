
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=1024">
        <title>Example 3 - Animated Bar Chart via jQuery</title>
        <link rel="stylesheet" href="css/common.css">
        <link rel="stylesheet" href="css/03.css">
        <!-- JavaScript at the bottom for fast page loading -->

        <!-- Grab jQuery from Google -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

        <!-- Example JavaScript -->
        <script src="js/Estadisticas.js"></script>
    </head>
    <body>
        <div class="toggles">
            <p><a href="#" id="reset-graph-button">Reset graph</a><a href="http://coding.smashingmagazine.com/?p=106408" id="return-button">Back to Article</a> Mouse over the bars to display information.</p>
        </div>
        <div id="wrapper">
            <div class="chart">
                <h2>Population of endangered species from 2012 &ndash; 2016</h2>
                <table id="data-table" border="1" cellpadding="10" cellspacing="0" summary="The effects of the zombie outbreak on the populations of endangered species from 2012 to 2016">
                    <caption>Population in thousands</caption>
                    <thead>
                        <tr>
                            <td>&nbsp;</td>
                            {foreach from=$datos item=Especie}  
                                <th scope="col">{$Especie.nombre}</th>
                                {/foreach}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Abiertos</th>
                                {foreach from=$datos item=Especie}  
                                <td>{$Especie.AbiertosEspecie}</td>
                            {/foreach}
                        </tr>
                        <tr>
                            <th scope="row">Cerrados</th>
                                {foreach from=$datos item=Especie}  
                                <td>{$Especie.CerradosEspecie}</td>
                            {/foreach}
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>