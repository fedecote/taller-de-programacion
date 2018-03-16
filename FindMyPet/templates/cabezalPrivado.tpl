<!doctype html>
<html class="no-js" lang="">
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">Find my pet</a>
                </div>
                <ul class="nav navbar-nav">
                    <li>
                        <div class="vl" style="border-left: 1px solid darkslategrey;
                             height: 57px;"></div>
                    </li>
                    <li><a href="#">Statics</a></li>
                    <li>
                        <div class="vl" style="border-left: 1px solid darkslategrey;
                             height: 57px;"></div>
                    </li>
                    <li><a href="IrANuevaPublicacion.php">New Publication</a></li>
                    <li>
                        <div class="vl" style="border-left: 1px solid darkslategrey;
                             height: 57px;"></div>
                    </li>
                </ul>
                <div>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <form class="navbar-form navbar-right" role="form" action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST">
                          <div id="loggedInUsername" class="form-group">
                            <a style="color:white;">Bienvenido <strong>{$Username}</strong></a>
                        </div>
                        <div id="logout" style="text-align: -webkit-right;">    
                            <a  href="Logout.php">Logout</a>
                        </div>
                    </form>
                </div><!--/.navbar-collapse -->
            </div>
        </nav>
    </body>
</html>