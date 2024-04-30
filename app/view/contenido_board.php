<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {

    header('url:../login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Calendario</title>

</head>

<body>
    <div class="container" id="infoServicios">
        <h3>Citas Agendadas</h3>
        <div id="calendar"></div>
    </div>
    
</body>

</html>