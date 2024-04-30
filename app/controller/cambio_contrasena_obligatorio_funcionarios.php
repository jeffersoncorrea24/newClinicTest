<?php
session_start();
require_once('../../public/lib/password.php');
require_once("../model/crud_funcionarios.php");
require_once("../model/datos_funcionarios.php");

$actualiza= new CrudFuncionarios();
$modifica= new Funcionario();

if (isset($_POST['enviar']) || $_POST['enviar'] == 1 ) {
    $modifica->setF_contrasena($_POST['clave']);
    $modifica->setF_usuario($_SESSION['usuario']);
    
    $actualiza->actualizar_contrasena_obligatorio($modifica);
}

?>