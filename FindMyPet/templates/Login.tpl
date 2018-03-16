<!DOCTYPE html>
<html> 
    <head>
    </head>
    <body>
        <div class="container">
            <!-- Modal -->
            <div class="modal fade" id="LoginModal" role="dialog" style="padding-top: 3%;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Login</h4>
                        </div>
                        <div class="modal-body">
                            <div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input id="usuario" name="usuario" type="text" placeholder="Email" class="form-control">
                                </div>
                                <div  class="form-group">
                                    <label>Password</label>
                                    <input id="password" name="password" type="password" placeholder="Password" class="form-control">
                                </div>
                                <div  class="form-group">
                                    <input type="checkbox" name="remember" value="true" id="remember">
                                    <label for="remember">Remember me</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="accion" value="login" />
                                <button id="btnLogin" type="submit" class="btn btn-primary" >Login</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>