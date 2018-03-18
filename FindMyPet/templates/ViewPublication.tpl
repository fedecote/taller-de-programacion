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
            <script src="js/ViewPublication.js"></script>
            <link rel="shortcut icon" href="favicon.ico" />
        </head>
        <body>
            {* INCLUYO EL CABEZAL *}
            {if ($ingreso)}
                {include file = "cabezalPrivado.tpl"}
            {else}
                {include file = "cabezalPublico.tpl"}
            {/if}
            <div id="pub" alt="{$id}" align="center">
                <div id="containerClose" style="width: 50%;">
                    {if ($estado == 0)}
                        {if ($ingreso)}
                            {if ($Username == $email)}
                                <button id="btnClose" alignment="right" class="btn" style="float: right; margin-top: 1%;" data-toggle="modal" data-target="#CloseModal">Cerrar publicacion</button>
                            {/if}
                        {/if}
                    {else}
                        <button id="closed" alignment="right" class="btn btn-danger" style="cursor: default; float: right; margin-top: 3%;">Publicacion Cerrada</button>
                    {/if}
                    <p><h2>{$titulo}</h2></p>
                </div>
                <div style="padding-top: 2%;">
                    <div style="width:30%; float:left; padding-left: 10%;">
                        <div id="imagen1" alt="{$cantFotos}">
                            <img id="imagen" class="card-img-top" src="{$foto.Ruta}" alt="0" style="width: 120%;">
                            <img class="card-img-top" id="anterior" src="img/arrow-back.png" alt="Back" height="30" width="30">
                            <img class="card-img-top" id="siguiente" src="img/arrow-next.png" alt="Next" height="30" width="30">
                        </div>
                    </div>
                    <div class="card-body" style="float: left; padding-left: 6%;  width: 50%">
                        <p style="text-align: left"><b>Tipo de publicacion:</b>{$tipo}</p>
                        <p style="text-align: left"><b>Especie:</b>{$especie}</p>
                        <p style="text-align: left"><b>Raza:</b>{$raza}</p>
                        <p style="text-align: left;"><b>Descripcion:</b></p>
                        <p style="text-align: left; width:100%; word-wrap: break-word;">{$descripcion}</p>
                        <div class="question">
                            {$lastElement = end($preguntas)}
                            {foreach from=$preguntas item=pregunta}
                                {if ($pregunta.Respuesta == '' && $pregunta != $lastElement)}
                                    <p class="question" style="margin-bottom: 1%; margin-top: 1%;">{$pregunta.Pregunta}</p>
                                    {if ($Username == $email && $ingreso && $pregunta.Respuesta == '')}
                                        <input id="{$pregunta.Id}" name="nuevaPregunta" alt="{$pregunta.Id}" type="name" placeholder="Responder..." class="form-control" style="margin-bottom: 1%;width: 96%; margin-left: 2%;">
                                        <button id="btnResponder{$pregunta.Id}" class="btn" alignment =" right" alt="{$pregunta.Id}" style="margin-bottom: 1%;margin-left: 80%;">Responder</button>
                                        <script>$("#btnResponder{$pregunta.Id}").click(Responder)</script>
                                    {/if}
                                    <div style="height: 1px; background: #F8F3F3;margin-bottom: 1%"></div>
                                {else}
                                    <p class="question" >{$pregunta.Pregunta}</p>
                                    {if ($Username == $email && $ingreso && $pregunta.Respuesta == '')}
                                        <input id="{$pregunta.Id}" name="nuevaPregunta" alt="{$pregunta.Id}" type="name" placeholder="Responder..." class="form-control" style="margin-bottom: 1%;width: 96%; margin-left: 2%;">
                                        <button id="btnResponder{$pregunta.Id}" class="btn" alignment =" right" alt="{$pregunta.Id}" style="margin-bottom: 1%;margin-left: 80%;">Responder</button>
                                        <script>$("#btnResponder{$pregunta.Id}").click(Responder)</script>
                                    {/if}
                                {/if}

                                {if ($pregunta.Respuesta != '')}
                                    <div class="answer">
                                        <div>
                                            <p>{$pregunta.Respuesta}</p>
                                        </div>
                                    </div>
                                {/if}
                            {/foreach}
                        </div>
                        {if ($ingreso)}
                            {if ($Username !== $email)}
                                <input id="nuevaPregunta" name="nuevaPregunta" type="name" placeholder="Pregunta" class="form-control">
                                <button id="btnPregunta" class="btn" style="float: right; margin-top: 1%; margin-bottom: 2%">Preguntar</button>
                            {/if}
                        {else}
                            <button id="btnLoginToAsk" class="btn" data-toggle="modal" data-target="#LoginModal" style="float: right; margin-top: 1%; margin-bottom: 2%">Login para hacer una nueva pregunta</button>
                        {/if}
                    </div>
                </div>
                <div id="closeTab" style="margin-top: -1%; width: 20%; margin-left: 61%; border-style: groove; border-radius: 5%; position: absolute;">
                    <button id="btnCancel" type="button" class="close" style="margin-right: 4%;">&times;</button>
                    <label for="resultado" style="margin-top: 6%;">Resultado:</label>
                    <select name="resultado" id="resultado" class="form-control input-md" style="width: 94%;">
                        <option selected ="selected" value="0">Se encontro con el dueño</option>
                        <option value="1">No se encontro con el dueño</option>
                    </select>
                    <input type="hidden" name="accion" value="Cerrar" />
                    <button id="cerrar" type="submit" class="btn btn-primary" data-dismiss="modal" style="margin-left: 60%; margin-top: 4%; margin-bottom: 4%;">Cerrar</button>
                </div>    
        </body>
    </html>