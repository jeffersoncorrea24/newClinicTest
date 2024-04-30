<?php
ini_set('display_errors', 1);
ini_set('dispplay_startup_errors', 1);
error_reporting(E_ALL);

require_once("../model/datos_codigo.php");
require_once("../model/crud_codigo.php");
require_once("../model/datos_funcionarios.php");
require_once("../model/datos_usuario.php");

$codigo = new datosCodigo();
$datos = new codigos();
$datosF = new Funcionario();
$datosU= new Usuario();


if (isset($_SESSION['auth_secret'])){
    $datos->setCodigo($_SESSION['auth_secret']);
    date_default_timezone_set('America/Bogota');
    $datos->setFecha(date('Y-m-d H:i:s')); 
    $datos->setId_Usuario($_SESSION['usuario']);
    $codigo->insercionCodigoQR($datos);
}

if (isset($_SESSION['auth_secretF'])){
    $datosF->setF_codigo($_SESSION['auth_secretF']);
    date_default_timezone_set('America/Bogota');
    $datosF->setF_fecha(date('Y-m-d H:i:s')); 
    $datosF->setF_usuario($_SESSION['usuario']);
    $codigo->insercionCodigoQRFuncionarios($datosF);
}

//ELIMINAR CODIGO QR PARA FUNCIONARIOS

if(isset($_POST['limpiar_codigoF'])&&($_POST['limpiar_codigoF']==1)){
    $datosF->setF_usuario($_POST['f_usuario']);
    echo $codigo->eliminarCodigoFuncionarios($datosF);
}

if(isset($_POST['limpiar_codigo'])&&($_POST['limpiar_codigo']==1)){
    $datos->setId_Usuario($_POST['usuario']);
    echo $codigo->eliminarCodigoUsuarios($datos);
}

?>