<?php

require_once("../model/crud_usuarios.php");
require_once("../model/datos_usuario.php");

$borra= new DatosUsuario();
$usuario= new Usuario();

if (isset($_POST['eliminar'])) {
    
    
    
    $usuario->setNombre(htmlentities(addslashes($_POST['alias'])));
    
    
    $borra->eliminaUsuario($usuario);
    header('Location: ../../dashboard.php');
    
}
?>
