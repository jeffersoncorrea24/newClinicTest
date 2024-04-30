<?php
require_once('../../public/lib/password.php');
require_once('../model/vinculo.php');

 class CrudEncriptarUsuario {

	public function encriptarUsuario($update){
    $db = conectar::acceso();

    $clave=$_POST['nuevaClave'];
    $confirmaClave=$_POST['clave'];    

      if( $clave == $confirmaClave){

   $password=password_hash($update->getClave(), PASSWORD_DEFAULT, ["cost" => 15]);

   $actualizar=$db->prepare('UPDATE usuarios SET clave= :nuevaClave,validacion=:valida WHERE usuario=:usuarioA');
   $actualizar->bindValue('usuarioA',$update->getNombre());
   $actualizar->bindValue('nuevaClave',$password);
   $actualizar->bindValue('valida',1);
   $actualizar->execute();

      
   header('location:../../login.php');

    } else {
    	header('location:../../app/view/view_encriptar_usuario.php');
    }
 	}
}
 ?>