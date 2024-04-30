<?php

require_once("../model/crud_usuarios.php");
require_once("../model/valida_usuario.php");
require_once("../model/datos_codigo.php");
require_once("../model/datos_usuario.php");

$verifica= new ValidaUsuario();
$validar= new Usuario();
$datos = new codigos();
$crud = new DatosUsuario();

	if (isset($_POST['ingresar'])){ //&& $_POST['validar_ingreso'] == 1 
    $validar->setNombre(htmlentities(addslashes($_POST['usuario'])));
    $validar->setClave(htmlentities(addslashes($_POST['clave'])));
    /* $_SESSION['usuario']=htmlentities(addslashes($_POST['usuario'])); */
    $verifica->valida($validar);
    }

    if (isset($_POST['modificaAcceso']) && $_POST['modificaAcceso'] == 1) {
        $validar->setNombre(htmlentities(addslashes($_POST['usuarios'])));
        $validar->setClave(htmlentities(addslashes($_POST['claves'])));
        $verifica->validar($validar); 
    }

    if(isset($_POST['buscar_rol']) && $_POST['buscar_rol'] == 1){
        $validar->setNombre(htmlentities(addslashes($_POST['usuario'])));
        $rol = $crud->rol_usuario($validar);
        echo $rol;
    }

    if ((isset($_POST ['x']))){
        $datos->setId_Usuario($_SESSION['usuario']);
        $respuesta = $verifica->validacionAlCo($datos);
        echo $respuesta;
    }

    if(isset($_POST['tipoval']) && $_POST['tipoval'] == 1){
        $validar->setNombre($_POST['usuario']);
        $verifica->traerTipoValidacion($validar);
    }

    if(isset($_POST['valUserxPass']) && $_POST['valUserxPass'] == 1){
        $validar->setNombre($_POST['nombre_a']);
        $validar->setClave($_POST['pass_a']);
        $verifica->verificarContrasena($validar);
    }

    if(isset($_POST['consultaU']) && $_POST['consultaU'] == 1){
        $validar->setIDusuario($_POST['id_usuario']);
        $verifica->traerUsuario($validar);
    }

    if(isset($_POST['valUserxPass']) && $_POST['valUserxPass'] == 2){
        $validar->setNombre($_POST['nombre_u']);
        $validar->setClave($_POST['pass_u']);
        $verifica->verificarContrasenaU($validar);
    }

    if (isset($_POST['enviarClaveU']) || (isset($_POST['enviarClaveU'] ) == 1 )){
        $validar->setNombre($_POST['usuario']);
        $validar->setClave($_POST['firstPass']);
        $verifica->cambioContrasenaUsuario($validar);
    }


?>
