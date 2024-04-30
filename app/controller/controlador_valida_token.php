<?php
session_start();
   
require("../model/valida_usuario.php");
require("../model/datos_usuario.php");
require("../model/crud_usuarios.php");
require("../model/crud_funcionarios.php");
require("../model/datos_funcionarios.php");

$verifica= new ValidaUsuario();
$validar= new Usuario();
$datosFun = new Funcionario();
$crudF =  new CrudFuncionarios();

if(isset($_POST['token'])){
    $validar->setNombre($_SESSION['usuario']);
    $validar->setTicket($_POST['token']);
    $verifica->validacionUsuario($validar);
} 

if(isset($_POST['tokenF'])){
    $datosFun->setF_usuario($_SESSION['usuario']);
    $datosFun->setF_ticket($_POST['tokenF']);
    $crudF->validacionFuncionario($datosFun);
}
?>