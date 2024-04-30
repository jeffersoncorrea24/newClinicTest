<?php

    session_start();
    
    $_SESSION['usuario'];
    $_SESSION['id_roles'];

    session_destroy();
    
    header('location:../../login.php')


?>