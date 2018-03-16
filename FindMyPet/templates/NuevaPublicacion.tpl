<!DOCTYPE html>
<html>
    <!doctype html>
    <html class="no-js" lang=""> 
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
            <script src="js/NuevaPublicacion.js"></script>
            <link rel="shortcut icon" href="favicon.ico" />
        </head>
        <body>
            {* INCLUYO EL CABEZAL *}
            {if ($ingreso)}
                {include file = "cabezalPrivado.tpl"}
            {else}
                {include file = "cabezalPublico.tpl"}
            {/if}
            <div id="pub" align="center">
                <div style="padding-top: 2%;">
                    <div style="width:30%; float:left; padding-left: 10%;">
                        <div id="imagenPrincipal" style="width: 120%; margin-top: 20%;">
                            <img id="agregarImagenPrincipal" name="agregarImagenPrincipal" class="card-img-top" src="img/add.png" alt="0" style="margin-left: 31%; width: 50%; cursor: pointer;">
                        </div>
                    </div>
                    <div class="card-body" style="float: left; padding-left: 6%;  width: 50%">
                        <p style="text-align: left"><b>Titulo:</b><input id="titulo" type="text" placeholder="Titulo publicacion..." style="width: 70%; margin-left: 3%"></p>
                        <p style="text-align: left"><b>Tipo de publicacion:</b>
                            <select name="tipoPublicacion" id="tipoPublicacion" class="form-control input-md" style="display: inline; width: 25%;">
                                <option value="Perdida">Perdida</option>
                                <option value="Perdida">Encontrada</option>
                            </select> 
                        </p>

                        <p style="text-align: left"><b>Especie:
                                <select name="especie" id="especie" class="form-control input-md" style="display: inline; width: 25%;">
                                    {foreach from=$especies item=nombreEspecie}  
                                        <option value="{$nombreEspecie.Id}">{$nombreEspecie.Nombre}</option>
                                    {/foreach}
                                </select>    
                        </p>
                        <div id="razas">
                            <p  style="text-align: left"><b>Raza:
                                    <select name="raza" id="raza" class="form-control input-md" style="display: inline; width: 25%;">
                                    </select>
                            </p>
                        </div>
                        <p style="text-align: left"><b>Barrio:
                                <select name="barrio" id="barrio" class="form-control input-md" style="display: inline; width: 25%;">
                                    {foreach from=$barrios item=nombreBarrio}  
                                        <option value="{$nombreBarrio.Id}">{$nombreBarrio.Nombre}</option>
                                    {/foreach}
                                </select>    
                        </p>
                        <input id="inputUpload" type="file" accept="image/x-png,image/gif,image/jpeg" style="display:none"/>​
                        <input id="uploadManyFiles" multiple="multiple" type="file" accept="image/x-png,image/gif,image/jpeg" style="display:none"/>​
                               <p style="text-align: left;"><b>Descripcion:</b></p>
                        <textarea rows="6" cols="50" type="text" placeholder="Descripcion..." style="float: left;"></textarea>
                        <div id="holder" style="position: absolute;margin-top: 160px; width: 732px; margin-left: -156px; height: 100px; height: 200px; cursor: pointer">
                            <p id="textAgregar" style="position: absolute;margin-left: 38%;margin-top: 12%;font-size: 100%;color: lightslategrey; cursor: pointer">Arrastra imagenes aqui</p>
                        </div>
                        <div style="position: absolute; margin-top: 250px; width: 35%;">
                            <button type="submit" id="btnGuardar" class="btn btn-success" style="float: right; margin-top: 30%; margin-bottom: 2%">Guardar</button>
                            <button id="btnGuardar" class="btn btn-default" style="float: left; margin-top: 30%; margin-bottom: 2%">Cancelar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>