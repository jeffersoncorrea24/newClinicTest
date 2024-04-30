<?php 
  require_once('../../public/lib/password.php');
require_once('../model/crud_encriptar.php');
require_once('../model/datos_funcionarios.php');


$datos= new Funcionario();
$crud = new CrudEncriptar();

if(isset($_POST['guardar'])){
	session_start();
	$datos->setF_usuario($_SESSION['usuario']);
	$datos->setF_contrasena(htmlentities(addslashes($_POST['nuevaContrasena'])));
	$crud-> encriptar($datos);

	echo $_SESSION['usuario'];

} 


 ?>