<?php 
require_once('../model/crud_encriptar_usuario.php');
require_once('../model/datos_usuario.php');


$datos= new Usuario();
$crud = new CrudEncriptarUsuario();

if(isset($_POST['guardar'])){
	session_start();
	$datos->setNombre($_SESSION['usuario']);
	$datos->setClave(htmlentities(addslashes($_POST['nuevaClave'])));
	$crud-> encriptarUsuario($datos);

	echo $_SESSION['usuario'];

} 


 ?>