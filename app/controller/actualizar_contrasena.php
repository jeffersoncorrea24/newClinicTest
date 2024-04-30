<?php
session_start();
require_once('../../public/lib/password.php');
require_once("../model/crud_usuarios.php");
require_once("../model/datos_usuario.php");
require_once("../model/valida_usuario.php");

$actualiza= new DatosUsuario();
$modifica= new Usuario();
$verifica= new Usuario();
$valida = new ValidaUsuario();

if (isset($_POST['enviar'])) {
    $modifica->setClave($_POST['clave']);
    $modifica->setNombre($_SESSION['usuario']);
    
    $actualiza->actualizar_contrasena($modifica);
   header('Location:../../dashboard.php');
}else if (isset($_POST['verificarContrasena']) && ($_POST['verificarContrasena'] == 1)){
    $verifica->setClave($_POST['clave']);
    $verifica->setNombre($_SESSION['usuario']);

    $valida->validar($verifica);
}
?>