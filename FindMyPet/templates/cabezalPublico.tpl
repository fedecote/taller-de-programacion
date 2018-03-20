<!DOCTYPE html>
<html class="no-js" lang=""> 
    <head>
        <script src="js/jquery.elevatezoom.js" type="text/javascript"></script>
        <script  type="text/javascript" src="js/jquery.js"></script>
        <script  type="text/javascript" src="js/jquery.elevatezoom.js"></script>
        <script  type="text/javascript" src="js/cabezalPublico.js"></script>
        <link rel="stylesheet" href="includes/jAlert-master/dist/jAlert.css" />
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>

    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a  id="home" class="navbar-brand" href="index.php">Find my pet</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <div class="navbar-form navbar-right" style="padding-left: 2px;">
                        <button id="btnDisplayRegister" class="btn btn-primary" data-toggle="modal" data-target="#RegisterModal">Registrarse</button>
                    </div>
                    <div class="navbar-form navbar-right" style="padding-right: 2px;" >
                        <button id="btnDisplayLogin" class="btn btn-success" data-toggle="modal" data-target="#LoginModal">Iniciar sesion</button>
                    </div>
                </div><!--/.navbar-collapse -->
            </div>
        </nav>
        <div id="errorBox" class="myAlert-top alert alert-danger">
            <a href="#" class="close" data-hide="alert" aria-label="close" >&times;</a>
            <label id="error"></label>
        </div>
        {include file="Login.tpl"}
        {include file="Register.tpl"}
    </body>
</html>