<!DOCTYPE html>
<html> 
    <head>
        <script  type="text/javascript" src="js/Register.js"></script>
    </head>
    <body>
        <div class="container">
            <!-- Modal -->
            <div class="modal fade" id="RegisterModal" role="dialog" style="padding-top: 3%;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Registrar</h4>
                        </div>
                        <div class="modal-body">
                            <div>
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input id="name" name="name" type="name" placeholder="Nombre" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Apellido</label>
                                    <input id="surname" name="surname" type="surname" placeholder="Apellido" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input id="username" name="usuario" type="text" placeholder="Email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <input id="pass" name="password" type="password" placeholder="Contraseña" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Repetir contraseña</label>
                                    <input id="repeatPassword" name="repeatPassword" type="password" placeholder="Repetir contraseña" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="accion" value="register" />
                                <button id="btnRegister" type="submit" class="btn btn-primary">Registrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>