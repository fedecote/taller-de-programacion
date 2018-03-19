<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="shortcut icon" href="favicon.ico" />
        <script src="js/Estadisticas.js"></script>
    </head>
    <body>
        {* INCLUYO EL CABEZAL *}
        {if ($ingreso)}
            {include file = "cabezalPrivado.tpl"}
        {else}
            {include file = "cabezalPublico.tpl"}
        {/if}
        <p align="center" style="margin-top: 4%;"><b>ENCONTRADOS</b></p>
        <table align="center" style="width: 50%; margin-top: 1%; margin-bottom: 2%;">
            <tr style="background-color: lightslategrey;">
                <th>Especies</th>
                <th>Abiertas</th>
                <th>Cerradas Positivas</th>
                <th>Cerradas Negativas</th>
                <th>Cerradas Totales</th>
                <th>Total</th>
            </tr>
            {foreach $datosEncontrados item=especie}
                <tr>
                    <td>{$especie.nombre}</td>
                    <td>{$especie.AbiertosEspecie}</td>
                    <td>{$especie.CerradosOK}</td>
                    <td>{$especie.CerradosNOOK}</td>
                    <td>{$especie.CerradosEspecie}</td>
                    <td>{$especie.totalEspecie}</td>
                </tr>
            {/foreach}
        </table>

        <p align="center" style="margin-top: 4%;"><b>PERDIDOS</b></p>
        <table align="center" style="width: 50%; margin-top: 1%; margin-bottom: 2%;">
            <tr style="background-color: lightslategrey;">
                <th>Especies</th>
                <th>Abiertas</th>
                <th>Cerradas Positivas</th>
                <th>Cerradas Negativas</th>
                <th>Cerradas Totales</th>
                <th>Total</th>
            </tr>
            {foreach $datosPerdidos item=especie}
                <tr>
                    <td>{$especie.nombre}</td>
                    <td>{$especie.AbiertosEspecie}</td>
                    <td>{$especie.CerradosOK}</td>
                    <td>{$especie.CerradosNOOK}</td>
                    <td>{$especie.CerradosEspecie}</td>
                    <td>{$especie.totalEspecie}</td>
                </tr>
            {/foreach}
        </table>
    </body>
</html> 