<?php
session_start();
//Se crea sesion tiempo para que a los 30 segundos se dañe esta sesion
if (!isset($_SESSION['time'])) {
    $_SESSION['time'] = time();
} else if (time() - $_SESSION['time'] > 25) {
    session_unset();
    session_destroy();

    echo "<script> history.back();</script>";
    die();
}

if (!isset($_SESSION['usuario'])) {

    echo "<script> history.back();</script>";
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
    <meta name="description" content="Implement Google like Time-Based Authentication into your existing PHP application. And learn How to Build it? How it Works? and Why is it Necessary these days." />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <link rel='shortcut icon' href='/favicon.ico' />
    <link href="https://fonts.googleapis.com/css2?family=Comforter+Brush&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="../../img/ico.png" />
    <link rel="stylesheet" href="../../public/css/validacionToken.css">
</head>
<body class="bg">
    <div class="container">
        <div class="row">
            <img class="logo" src="../../public/img/logo.png">
            <h1>Autenticación por Token</h1>
        </div>
    </div>
    <div class="container1 center">
        <div class="row">
            <div class="col">
                </br>
                <p style="font-family: Constantia;">1. Ingrese a su correo corporativo.</p>
                <p style="font-family: Constantia;">2. Por favor ingrese el codigo que le indica el correo que recibió". </p>
                <p style="font-family: Constantia;">3. Click en el botón "Validar con Token". </p>

                <br></br>
            </div>
            <div class="col">
                <br></br>
                <br></br>
                <div class="row">
                    <div class="col">
                        <div style="text-align: center;">
                            <br>
                            <form method="POST" action="../controller/controlador_valida_token.php">
                                <div class="qr">
                                    <input type="text" class="form-control" id="token" name="token" placeholder="Token Correo" required style="width: 200px;border-radius: 10px;text-align: center;display: inline;color:black;background: white; border-color: #458B99; border-radius:10px;"><br> <br>
                                    &nbsp&nbsp&nbsp
                                    <button type="submit" name="btnValToken" id="btnValToken" class="btn btn-outline-primary" style="width: 200px;border-radius: 10px; color: black; border-color: #0275d8;"><strong>Validar con Token</strong></button>
                                    <br></br>
                                    <br></br>
                                    &nbsp&nbsp
                                    <input type="hidden" id="" value="<?= $_SESSION['usuario'] ?>">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../public/js/jquery-3.3.1.min.js"></script>
    <script src="../../public/js/smoke.min.js"></script>
</body>
</html>