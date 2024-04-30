<?php

require_once("../model/crud_usuarios.php");
require_once("../model/datos_usuario.php");

$crea= new DatosUsuario();
$usuario= new Usuario();

if (isset($_POST['crearUsuario'])) {
    
    
    
    $usuario->setNombre(htmlentities(addslashes($_POST['usuario'])));
    $usuario->setClave(htmlentities(addslashes($_POST['contrasena'])));
    $usuario->setCorreo(htmlentities(addslashes($_POST['correo'])));
    $usuario->setRoles($_POST['id_roles']);
    $usuario->setIDusuarios(htmlentities(addslashes($_POST['usuario_sesion'])));

    $crea->insertaUsuario($usuario);
    header('Location: ../../dashboard.php');
    
}
?>
