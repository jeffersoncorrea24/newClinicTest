<?php
session_start();
//Se crea sesion tiempo para que a los 30 segundos se dañe esta sesion
if (!isset($_SESSION['tiempo'])) {
    $_SESSION['tiempo']=time();
}
else if (time() - $_SESSION['tiempo'] > 25) {
    session_unset();
    session_destroy();
    
    header("Location: ./../../login.php");
    die(); 
}  
/* Atrás redireccionas a la url especifica */


require "Authenticator.php";

$Authenticator = new Authenticator();

if (!isset($_SESSION['auth_secret'])) {
    $secret = $Authenticator->generateRandomSecret();
    $_SESSION['auth_secret'] = $secret;
}

if(!isset($_SESSION['usuario'])){

    header('location: ./../../login.php');  
} 

$qrCodeUrl = $Authenticator->getQR('DSLKFJHLKJDSKLFH', $_SESSION['auth_secret']); //RANDOM

if (!isset($_SESSION['failed'])) {
    $_SESSION['failed'] = false;
} 

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Autenticaci&oacute;n de Usuario</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <meta name="description" content="Implement Google like Time-Based Authentication into your existing PHP application. And learn How to Build it? How it Works? and Why is it Necessary these days."/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <link rel='shortcut icon' href='/favicon.ico'  />
    <link href="https://fonts.googleapis.com/css2?family=Comforter+Brush&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/validacionGoogle.css">
    <link rel="icon" type="image/png" href="public/img/ico.png" />
</head>
<body  class="bg">
    <div class="container">
        <div class="row">
                <img class="logo" src="./../../public/img/logo.png">
                <h1>Autenticación de QR</h1>
        </div>   
    </div>
    <div class="container1 center">
        <div class="row">
            <div class="col">
    </br>
                <p style="font-family: Constantia;">1. Por favor descargue la app "Google Authenticator".</p>
                <p style="font-family: Constantia;">2. Ingrese a la App. </p>
                <p style="font-family: Constantia;">3. En la parte inferior derecha, dele click al "+". </p>
                <p style="font-family: Constantia;">4. Luego de ello, de click a la primera opción "Escanear un código QR".</p>
                <p style="font-family: Constantia;">5. Escaneé el código QR. </p>
                <p style="font-family: Constantia;">6. Ingrese el código que le da la app. </p>
                <p style="font-family: Constantia;">7. Click en el botón "Validar con Google". </p>
                </br>
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
                            <img style="text-align: center;" class="img-fluida" src="<?php   echo $qrCodeUrl ?>" alt="Verify this Google Authenticator">       
                            &nbsp&nbsp&nbsp
                        <br></br>
                            <input type="text" class="form-control" id="code" name="code" placeholder="Dígite su código" style="width: 200px;border-radius: 10px;text-align: center;display: inline;color:white;background: black; border-color: white; border-radius:10px;"><br> <br>
                            &nbsp&nbsp&nbsp    
                            <button type="submit" name="btnCode" id="btnCode" class="btn btn-outline-primary" style="width: 200px;border-radius: 10px; color: black; border-color: #0275d8;"><strong>Validar con Google</strong></button>
                        </div>                          
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>