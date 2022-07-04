<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Control Escolar</title>
        
        <!-- Bootstrap -->
        <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="./public/css/login.css">

    </head>
    <body>
        <div id="myModal">
            <div class="modal-dialog modal-login">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="avatar">
                            <img src="./public/images/avatar.png" alt="Avatar">
                        </div>				
                        <h4 class="modal-title">Control Escolar</h4>	
                    </div>
                    <div class="modal-body">
                        <form action="${pageContext.request.contextPath}/ServletUsuario?accion=ingresar" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" name="username" placeholder="Username" required="required" autofocus>		
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Password" required="required">	
                            </div>        
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block login-btn">Ingresar</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <a href="#">¿Olvidó su contraseña?</a>
                        <p>UAC - Programación de Aplicaciones Web</p>
                    </div>
                </div>
            </div>
        </div>     
    </body>
</html>
