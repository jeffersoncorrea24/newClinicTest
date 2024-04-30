<?php
session_start();
require_once('../../public/lib/password.php');
require_once("../model/crud_usuarios.php");
require_once("../model/datos_usuario.php");

$actualiza= new DatosUsuario();
$modifica= new Usuario();

if (isset($_POST['enviar'])) {
    $modifica->setClave($_POST['clave']);
    $modifica->setNombre($_SESSION['usuario']);
    
    $actualiza->actualizar_contrasena_obligatorio($modifica);
}

?>