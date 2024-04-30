
<?php
session_start();
//Se crea sesion tiempo para que a los 30 segundos se dañe esta sesion
if (!isset($_SESSION['tiempo'])) {
    $_SESSION['tiempo']=time();
}
if (time() - $_SESSION['tiempo'] > 25) {
    session_unset();
    session_destroy();
    //Aquí redireccionas a la url especifica
    header("Location: ../../login.php");
    die();  
} 
require "Authenticator.php";
$Authenticator = new Authenticator();

if (!isset($_SESSION['auth_secret'])) {
    $secret = $Authenticator->generateRandomSecret();
    $_SESSION['auth_secret'] = $secret;
}


if(!isset($_SESSION['usuario'])){
    
    header('location:./../../login.php');
}
 //RANDOM
if (!isset($_SESSION['failed'])) {
    $_SESSION['failed'] = false;
} 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Autenticaci&oacute;n de Usuario</title>
    <link rel="stylesheet" href="../../public/css/smoke.min.css">
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <meta name="description" content="Implement Google like Time-Based Authentication into your existing PHP application. And learn How to Build it? How it Works? and Why is it Necessary these days."/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <link rel='shortcut icon' href='/favicon.ico'  />
    <link href="https://fonts.googleapis.com/css2?family=Comforter+Brush&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="../../public/img/ico.png" />
    <link rel="stylesheet" href="../../public/css/validacionCodigo.css">

</head>
<body  class="bg">
    <div class="container">
        <div class="row">
                <img class="logo" src="../../public/img/logo.png">
                <h1>Autenticación de Codigo de Google</h1>
        </div>   
    </div>
    <div class="container1 center">
        <div class="row">
            <div class="col">
    </br>
                <p style="font-family: Constantia;">1. Ingrese a la App.</p>
                <p style="font-family: Constantia;">2. Por favor ingrese el codigo que le indica el aplicativo de "Google Authenticator". </p>
                <p style="font-family: Constantia;">3. Click en el botón "Validar con Google". </p>
                <p style="font-family: Constantia;">4. Este código se actualiza cada 30 segundos. </p>
                                               
            </div>
        
            <div class="col">
                <form action="check.php" method="post">
                    <div style="text-align: center;">
                        <?php if ($_SESSION['failed']): ?>
                        <div class="alert alert-danger" role="alert">
                            Revise su c&oacute;digo, es incorrecto!
                        </div>
                        <?php   
                            $_SESSION['failed'] = false;
                        ?>
                        <?php endif ?>
                        <div class="qr">
                            <input type="hidden" id="noQR" name="noQR" value="1">
                            <input type="text" class="form-control" id="code" name="code" placeholder="Google Authenticator" style="width: 200px;border-radius: 10px;text-align: center;display: inline;color:black;background: white; border-color: #36956E; border-radius:10px;"><br> <br>
                            &nbsp&nbsp&nbsp  &nbsp&nbsp&nbsp    
                            <button type="submit" name="btnCode" id="btnCode" class="btn btn-outline-primary" style="width: 200px;border-radius: 10px; color: black; border-color: #0275d8;"><strong>Validar con Google</strong></button>
                        </div>                           
                    </div>
                </form>
                <br></br>
                <br></br>
            </div>
        </div>
    </div>
    <script src="../../public/js/jquery-3.3.1.min.js"></script>
    <script src="../../public/js/smoke.min.js"></script>
    <script>
        
        document.getElementById('code').value = '';
        $('#code').val('');
    </script>
</body>
</html>

