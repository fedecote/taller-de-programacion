<!DOCTYPE html>

<html>
    <head>
        <title>Pantalla inicio</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="js/jquery.elevatezoom.js" type="text/javascript"></script>
        <script  type="text/javascript" src="js/jquery.js"></script>
        <script  type="text/javascript" src="js/cabezalPublico.js"></script>
	<link rel="stylesheet" type="text/css" href="css/estiloCabezalPublico.css">
        <link rel="stylesheet" href="includes/jAlert-master/dist/jAlert.css" />
    </head>
    <body>
        <div id = "botonera">
            <div id = "img" > <img id = "laImagen"src =".//imagenes/logoComproCasas.png"> </div>
            
            <div id="botones"> <input class = "btn" type ="button" id = "btnInicio" value = "Inicio">
                               <input class = "btn" type ="button" id = "btnEstadistica" value = "Estadísticas">
            </div> 
            	
            <!-- Button to open the modal login form -->
            <button onclick="document.getElementById('id01').style.display='block'" id="btnLogin">Login</button>

            <!-- The Modal -->
            <div id="id01" class="modal">
                <span onclick="document.getElementById('id01').style.display='none'" 
                class="close" title="Close Modal">&times;</span>

                <!-- Modal Content -->
                <div class="modal-content animate">
                    <div class="imgcontainer">
                        <img src="imagenes/img_avatar2.png" alt="Avatar" class="avatar" >
                    </div>

                    <div class="container">
                        <label><b>Usuario</b></label><br>
                        <input type="text" placeholder="Ingrese Usuario" name="uname" id ="usuario" required>

                        <label><b>Contraseña</b></label><br>
                        <input type="password" placeholder="Ingrese Contraseña" id ="contra" name="psw" required><br>

                        <br><button id = "btnIniciarSesion">Ingresar</button><br>
                    </div>
                    
                    <div id="error"> </div>
                </div>
                
                
            </div>
        
        </div>
        
    </body>
</html>