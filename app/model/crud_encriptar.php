<?php
  require_once('../../public/lib/password.php');
require_once('../model/vinculo.php');

 class CrudEncriptar {

	public function encriptar($update){
    $db = conectar::acceso();

    $contrasena=$_POST['nuevaContrasena'];
    $confirmaContrasena=$_POST['contrasena'];    

    echo $_POST['nuevaContrasena'];
    echo $_POST['contrasena'];    

    if( $contrasena == $confirmaContrasena){

   $password=password_hash($update->getF_contrasena(), PASSWORD_DEFAULT, ["cost" => 15]);

   $actualizar=$db->prepare('UPDATE funcionarios SET contrasena= :nuevaContrasena,validacion=:valida WHERE usuario=:usuarioA');
   $actualizar->bindValue('usuarioA',$update->getF_usuario());
   $actualizar->bindValue('nuevaContrasena',$password);
   $actualizar->bindValue('valida',1);
   $actualizar->execute();
      
   header('location:../../login_peticiones.php');

    } else {
    	header('location:../../app/view/view_encriptar_contrasena.php');
    }

 
 	}

}


 ?>