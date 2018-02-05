<?php
session_start();

$accion = isset($_POST["accion"]) ? $_POST["accion"] : $_GET["accion"];

$logins = array(
    "root" => "root",
    "usuario" => "pass123",
    "guest" => "guest",
    "fede" => "fede123"
);

if ($accion == "login") {
    if (isset($logins[$_POST["usuario"]]) && $_POST["password"] == $logins[$_POST["usuario"]]) {
        $_SESSION["usuario"] = array("nombre" => $_POST["usuario"]);?>
        <script>$myFunction();</script>
    <?php } else {
        $mensaje = "El usuario". $_SESSION["usuario"]." o contraseña ingresados son incorrectos";
    }
} else if ($accion == "logout") {
    unset($_SESSION["usuario"]);
    session_destroy();
    header("location: " . $_SERVER["PHP_SELF"]);
    die();
    ?>
    <script>$myFunction();</script>
<?php }?>

<script>
function myFunction() {
    var x = document.getElementById("login");
    var y = document.getElementById("logout");
    if (x.style.display === "none") {
        x.style.display = "block";
        y.style.display = "none";
    } else {
        x.style.display = "none";
        y.style.display = "block";
    }
    x = document.getElementById("username");
    var y = document.getElementById("loggedInUsername");
    if (x.style.display === "none") {
        x.style.display = "block";
        y.style.display = "none";
    } else {
        x.style.display = "none";
        y.style.display = "block";
    }
    x = document.getElementById("password");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

</script>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
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
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
            
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Find my pet</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <?php if (isset($_SESSION["usuario"])) { ?>
            <form class="navbar-form navbar-right" role="form" action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST">
            <div id="loggedInUsername" class="form-group">
                <a style="color:white;">Bienvenido <strong><?php echo $_SESSION["usuario"]["nombre"];?></strong></a>
            </div>
            <div id="logout">    
                <a  href="?accion=logout">Logout</a>
            </div>
        </form>
            
        <?php } else {?>
            <?php  if (strlen($mensaje) > 0) { ?>
            <div class="alert alert-danger fade in">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <?php echo $mensaje;?>
            </div>
        <?php } ?>
          <form class="navbar-form navbar-right" role="form" action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST">
            <div class="form-group">
                <input id="username" name="usuario" type="text" placeholder="Email" class="form-control" value="<?php echo $_POST["usuario"]; ?>">
            </div>
            <div id="password" class="form-group">
              <input   name="password" type="password" placeholder="Password" class="form-control">
            </div>
            <input type="hidden" name="accion" value="login" />
            <button id="login" type="submit" class="btn btn-success">Sign in</button>
            <!--input type="hidden" name="accion" value="login" />
            <button id="login" type="submit" class="btn btn-primary">Register</button-->
          </form>
        <?php } ?>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>Hello, world!</h1>
        <p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
        <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>Heading</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div>
      </div>

      <hr>

      <footer>
        <p>&copy; Company 2015</p>
      </footer>
    </div> <!-- /container -->        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>
    </body>
</html>