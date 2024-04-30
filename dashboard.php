<?php
ini_set("session.cookie_lifetime", 180000);
ini_set("session.gc_maxlifetime", 180000);


session_start();
if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    header('location:login.php');
}
if (!isset($_SESSION['id_roles'])) {
    header('location:login.php');
}
if (!isset($_SESSION['status_connect'])) {
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hospital | NewClinic</title>
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/smoke.min.css">
    <link rel="stylesheet" href="public/css/dashboard.css" media="screen" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/v4-shims.css">
    <link rel="icon" type="image/png" href="public/img/ico.png" />
</head>

<body>
    <header class="container-fluid">
        <div class="row">
            <div class="col-md-10 align-self-center">
                <img src="public/img/" alt="">
            </div>
            <div class="col-md-2 col d-flex justify-content-end">
                <span>
                    <?= $_SESSION['usuario']; ?>
                </span>
                <a href="app/controller/cerrar.php"><img src="public/img/salir.png" alt=""></a>
            </div>
        </div>
    </header>
    <main class="container-fluid">
        <div class="row">
            <div class="col-2 mt-3 navega">
                <nav>
                    <?php if ($_SESSION['id_roles'] == 1 || $_SESSION['id_roles'] == 5) {
                        echo '<a href="#" id="administracion_citas"><img src="public/img/soporte.png" alt="" class="ml-3" onclick:>Administración</a>';
                    } ?>

                    <?php if ($_SESSION['id_roles'] == 1 || $_SESSION['id_roles'] == 5) {
                        echo '<a href="#" id="gestionar_citas"><img src="public/img/soporte.png" alt="" class="ml-3" onclick:>Citas</a>';
                    } ?>

                    <?php if ($_SESSION['id_roles'] == 1 || $_SESSION['id_roles'] == 5) {
                        echo '<a href="#" id="atencion_citas"><img src="public/img/soporte.png" alt="" class="ml-3" onclick:>Atención de Citas</a>';
                    } ?>
                </nav>
            </div>

            <div class="col-10" id="contenido">
                <div class="container mt-5">
                    <div class="row">

                        <?php require_once ('app/view/contenido_board.php') ?>

                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="public/js/jquery-3.3.1.min.js"></script>
    <script src="public/js/smoke.min.js"></script>
    <script src="public/js/moment.min.js"></script>
    <script src="public/js/popper.js"></script>
    <script src="public/js/navega.js"></script>
    <script src="public/js/valida_usuario.js?jk"></script>
</body>

</html>