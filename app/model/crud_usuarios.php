<?php
    require_once('../../public/lib/password.php');
    require_once("../model/vinculo.php");
    require __DIR__ . '/vendor/autoload.php';


    class DatosUsuario{
        
        public function insertaUsuario($usuario){
           
            /*---------FUNCION PARA INSERTAR DATOS------------*/
                    
            /*----------------------INSERTA DATOS DEL USUARIO------------------*/
            $db=conectar::acceso();
            $valida_usuario=$db->prepare('SELECT usuario FROM usuarios WHERE Usuario=:nombreUsuario');
            $valida_usuario->bindValue('nombreUsuario',$usuario->getNombre());
            $valida_usuario->execute();
            $conteoUsuarios=$valida_usuario->rowCount();
                if ($conteoUsuarios!=0) {
                  echo 3;
                }else{
                    $db=conectar::acceso();
                    $inserta_usuario=$db->prepare("INSERT INTO hinfraestructura.usuarios(usuario, correo, clave, id_roles, uestado, validacion,fecha_registro) VALUES (:usuario, :correo, :contrasena, :id_roles, :uestado, :validacion,curdate())"); 
                     $password=password_hash($usuario->getClave(), PASSWORD_DEFAULT, ["cost" => 15]);

                    $inserta_usuario->bindValue('usuario',$usuario->getNombre());
                    $inserta_usuario->bindValue('correo',$usuario->getCorreo());
                    $inserta_usuario->bindValue('contrasena',$password);
                    $inserta_usuario->bindValue('id_roles',$usuario->getRoles());
                    $inserta_usuario->bindValue('validacion',0);
                    $inserta_usuario->bindValue('uestado',5);
                                       
                    $inserta_usuario->execute();
                    
                    if ($inserta_usuario) {
                        echo 1;
                          $colsultar_usuario=$db->prepare('SELECT id_usuario from usuarios where usuario =:usuario');
                          $colsultar_usuario->bindValue('usuario',$usuario->getIDusuarios());
                          $colsultar_usuario->execute();
                          $filtro=$colsultar_usuario->fetch(PDO::FETCH_ASSOC);
                          $id_usuario=$filtro['id_usuario'];
                           $funcion_realizada = "El usuario Realizo una insersion de un nuevo usuario";
                           $inserta_funcion=$db->prepare("INSERT INTO funciones (codigo, id_usuario, fecha_registro, funcion_realizada,IP) VALUES (0, :id_usuario , curdate() , :funcion_realizada ,:ip )");
                           $inserta_funcion->bindValue('id_usuario',$id_usuario);
                           $inserta_funcion->bindValue('funcion_realizada',$funcion_realizada);
                           $inserta_funcion->bindValue('ip', $_SERVER['REMOTE_ADDR']);                 
                           $inserta_funcion->execute();
                       }else{

                       echo 0;

                       }
                
                }
        }
        
        
        
        public function consultaUsuario(){
            
            /*--------------REALIZA UN QUERY PARA LA CONSULTA DE LOS DATOS---------------*/
                     
           $db=conectar::acceso();
            $listaUsuarios=[];
            $seleccion=$db->prepare('SELECT id_usuario, roles.descripcion AS rol, usuario, correo,clave, uestado, estado.descripcion AS descripcion FROM hinfraestructura.usuarios INNER JOIN roles ON roles.id_roles=usuarios.id_roles LEFT JOIN estado on estado.id_estado=usuarios.uestado WHERE uestado=:estadoA');

            $seleccion->bindValue('estadoA','5');
            $seleccion->execute();

            foreach($seleccion->fetchAll() as $lista){
                $consulta= new Usuario();
                $consulta->setIDusuario($lista['id_usuario']);
                $consulta->setNombre($lista['usuario']);
                $consulta->setCorreo($lista['correo']);
                $consulta->setClave($lista['clave']);
                $consulta->setRoles($lista['rol']);
                $consulta->setUestado($lista['uestado']);
                                            
                $listaUsuarios[]=$consulta;
             
            }
            return $listaUsuarios;
        }


         public function consultaUsuarioInactivo(){
            
            /*--------------REALIZA UN QUERY PARA LA CONSULTA DE LOS DATOS---------------*/
                     
           $db=conectar::acceso();
            $listaUsuarios=[];
            $seleccion=$db->prepare('SELECT id_usuario, roles.descripcion AS rol, usuario, correo,clave, uestado,ufecha_inactivacion, usuarios.descripcion AS observacion, estado.descripcion AS descripcion FROM hinfraestructura.usuarios INNER JOIN roles ON roles.id_roles=usuarios.id_roles LEFT JOIN estado on estado.id_estado=usuarios.uestado WHERE uestado=:estadoI');

            $seleccion->bindValue('estadoI','6');
            $seleccion->execute();

            foreach($seleccion->fetchAll() as $lista){
                $consulta= new Usuario();
                $consulta->setIDusuario($lista['id_usuario']);
                $consulta->setNombre($lista['usuario']);
                $consulta->setCorreo($lista['correo']);
                $consulta->setClave($lista['clave']);
                $consulta->setRoles($lista['rol']);
                $consulta->setUestado($lista['uestado']);
                $consulta->setDescripcion($lista['observacion']);
                $consulta->setUfecha_inactivacion($lista['ufecha_inactivacion']);
                                            
                $listaUsuarios[]=$consulta;
             
            }
            return $listaUsuarios;
        }
        
        
         public function actualizar($modifica){
            /*----------------REALIZA LA MODIFICACION DE LOS DATOS EXISTENTES---------------*/
           
            $db=conectar::acceso();
           /*  $validarContrasena=$db->prepare('SELECT clave FROM usuarios WHERE clave=:claveP');
	          $validarContrasena->bindValue('claveP',$modifica->getClave());
            $validarContrasena->execute();
            $conteo = $validarContrasena->rowCount();

            if($conteo== 0){
              $password = password_hash($modifica->getClave(), PASSWORD_DEFAULT, ["cost" => 15]);
            }else{
              $password = $modifica->getClave();
            } */
            $modificar_usuario=$db->prepare('UPDATE hinfraestructura.usuarios SET correo=:correo, tipo_validacion=:tipo_validacion WHERE id_usuario=:id_usuario');

            /* $password=password_hash($modifica->getClave(), PASSWORD_DEFAULT, ["cost" => 15]); */

            $modificar_usuario->bindValue('id_usuario',$modifica->getIDusuario());
            $modificar_usuario->bindValue('correo',$modifica->getCorreo());
            $modificar_usuario->bindValue('tipo_validacion',$modifica->getTipoValidacion());          
            $modificar_usuario->execute();
            $row = $modificar_usuario->rowCount();
            if($row !=0){
              return 1;
            }else{
              return 2;
            }

            $colsultar_usuario=$db->prepare('SELECT id_usuario from usuarios where usuario =:usuario');
            $colsultar_usuario->bindValue('usuario',$modifica->getIDusuarios());
            $colsultar_usuario->execute();
            $filtro=$colsultar_usuario->fetch(PDO::FETCH_ASSOC);
            $id_usuario=$filtro['id_usuario'];
            $funcion_realizada = "El usuario Realizo una Actualizacion de  usuario";
            $inserta_funcion=$db->prepare("INSERT INTO funciones (codigo, id_usuario, fecha_registro, funcion_realizada,IP) VALUES (0, :id_usuario , curdate() , :funcion_realizada ,:ip )");
            $inserta_funcion->bindValue('id_usuario',$id_usuario);
            $inserta_funcion->bindValue('funcion_realizada',$funcion_realizada);
            $inserta_funcion->bindValue('ip', $_SERVER['REMOTE_ADDR']);                 
            $inserta_funcion->execute();
        }
        
        public function eliminaUsuario($alias){
            
            /*--------------REALIZA LA ELIMINACION DE LOS DATOS---------------*/
                     
            $db=conectar::acceso();
            
            $inserta_usuario=$db->prepare("DELETE FROM hinfraestructura.usuarios WHERE usuario=:alias"); 
        
                   $inserta_usuario->bindValue('alias',$alias->getNombre());
                                                  
                   $inserta_usuario->execute();
            
        }
        
            /*----------------REALIZA LA MODIFICACION DE LOS DATOS EXISTENTES---------------*/
        public function actualizar_contrasena($modifica){
                        
            $db=conectar::acceso();
            $modificar_usuario=$db->prepare('UPDATE hinfraestructura.usuarios SET clave=:clave WHERE usuario=:usuario');

              $password=password_hash($modifica->getClave(), PASSWORD_DEFAULT, ["cost" => 15]);

            $modificar_usuario->bindValue('usuario',$modifica->getNombre());
            $modificar_usuario->bindValue('clave',$password);
            $modificar_usuario->execute();

             $colsultar_usuario=$db->prepare('SELECT id_usuario from usuarios where usuario =:usuario');
                          $colsultar_usuario->bindValue('usuario',$modifica->getNombre());
                          $colsultar_usuario->execute();
                          $filtro=$colsultar_usuario->fetch(PDO::FETCH_ASSOC);
                          $id_usuario=$filtro['id_usuario'];
                           $funcion_realizada = "El usuario Realizo una Actualizacion de  sus datos";
                           $inserta_funcion=$db->prepare("INSERT INTO funciones (codigo, id_usuario, fecha_registro, funcion_realizada,IP) VALUES (0, :id_usuario , curdate() , :funcion_realizada ,:ip )");
                           $inserta_funcion->bindValue('id_usuario',$id_usuario);
                           $inserta_funcion->bindValue('funcion_realizada',$funcion_realizada);
                           $inserta_funcion->bindValue('ip', $_SERVER['REMOTE_ADDR']);                 
                           $inserta_funcion->execute();
        
        }
         public function actualizar_contrasena_obligatorio($modifica){

          $db=conectar::acceso();
              $list_case = array();
              $colsultar_usuario=$db->prepare('SELECT clave from usuarios where usuario =:usuario');
              $colsultar_usuario->bindValue('usuario',$modifica->getNombre());
              $colsultar_usuario->execute();
              $row=$colsultar_usuario->fetch(PDO::FETCH_ASSOC);
              $passwordLogin=password_verify($modifica->getClave(),$row['clave']);  
              if($passwordLogin){
                echo 1;
              }else{
                $password=password_hash($modifica->getClave(), PASSWORD_DEFAULT, ["cost" => 15]);
                $modificar_usuario=$db->prepare('UPDATE usuarios SET clave=:clave ,fecha_registro=curdate() WHERE usuario=:usuario');
                $modificar_usuario->bindValue('usuario',$modifica->getNombre());
                $modificar_usuario->bindValue('clave',$password);
                $modificar_usuario->execute();

                       $colsultar_usuario=$db->prepare('SELECT id_usuario from usuarios where usuario =:usuario');
                          $colsultar_usuario->bindValue('usuario',$modifica->getNombre());
                          $colsultar_usuario->execute();
                echo 2;                       
              }      
        }

//**********************************************************************************************//
//************************* REALIZA LA INACTIVACION DEL USUARIO********************************//
//********************************************************************************************//

    public function InactivaUsuario($update){

        $db=conectar::acceso();
        $Inactivar=$db->prepare('UPDATE usuarios SET ufecha_inactivacion = :ufecha_inactivacion, descripcion = :descripcion, ufecha_sistema = :ufecha_sistema, usuario_inactiva=:usuario_inactiva, uestado = :uestado,intentos =:intento WHERE id_usuario = :id_usuario');

        $Inactivar->bindValue('id_usuario', $update->getIDusuario());
        $Inactivar->bindValue('ufecha_inactivacion', $update->getUfecha_inactivacion());
        $Inactivar->bindValue('descripcion', $update->getDescripcion());
        $Inactivar->bindValue('ufecha_sistema', $update->getUfecha_sistema());
        $Inactivar->bindValue('uestado',6);
        $Inactivar->bindValue('usuario_inactiva', $update->getUsuario_inactiva());
        $Inactivar->bindValue('intento', 0);
        $Inactivar->execute();
                $colsultar_usuario=$db->prepare('SELECT id_usuario from usuarios where usuario =:usuario');
                          $colsultar_usuario->bindValue('usuario',$update->getUsuario_inactiva());
                          $colsultar_usuario->execute();
                          $filtro=$colsultar_usuario->fetch(PDO::FETCH_ASSOC);
                          $id_usuario=$filtro['id_usuario'];
                           $funcion_realizada = "El usuario Realizo una inactivacion de usuario";
                           $inserta_funcion=$db->prepare("INSERT INTO funciones (codigo, id_usuario, fecha_registro, funcion_realizada,IP) VALUES (0, :id_usuario , curdate() , :funcion_realizada ,:ip )");
                           $inserta_funcion->bindValue('id_usuario',$id_usuario);
                           $inserta_funcion->bindValue('funcion_realizada',$funcion_realizada);
                           $inserta_funcion->bindValue('ip', $_SERVER['REMOTE_ADDR']);                 
                           $inserta_funcion->execute();
    }


//**********************************************************************************************//
//************************* REALIZA LA ACTIVACION DEL USUARIO********************************//
//********************************************************************************************//

    public function ActivaUsuario($update){

        $db=conectar::acceso();
        $Activar=$db->prepare('UPDATE usuarios SET ufecha_activa = :ufecha_activa, usuario_activa=:usuario_activa, uestado = :uestado WHERE id_usuario = :id_usuario');

        $Activar->bindValue('id_usuario', $update->getIDusuario());
        $Activar->bindValue('ufecha_activa', $update->getUfecha_activa());
        $Activar->bindValue('uestado',5);
        $Activar->bindValue('usuario_activa', $update->getUsuario_activa());
        $Activar->execute();
          $colsultar_usuario=$db->prepare('SELECT id_usuario from usuarios where usuario =:usuario');
                          $colsultar_usuario->bindValue('usuario', $update->getUsuario_activa());
                          $colsultar_usuario->execute();
                          $filtro=$colsultar_usuario->fetch(PDO::FETCH_ASSOC);
                          $id_usuario=$filtro['id_usuario'];
                           $funcion_realizada = "El usuario Realizo una activacion de usuario";
                           $inserta_funcion=$db->prepare("INSERT INTO funciones (codigo, id_usuario, fecha_registro, funcion_realizada,IP) VALUES (0, :id_usuario , curdate() , :funcion_realizada ,:ip )");
                           $inserta_funcion->bindValue('id_usuario',$id_usuario);
                           $inserta_funcion->bindValue('funcion_realizada',$funcion_realizada);
                           $inserta_funcion->bindValue('ip', $_SERVER['REMOTE_ADDR']);                 
                           $inserta_funcion->execute();
    }

    public function restablecerCuenta($restablecer){

      $db=conectar::acceso();
      $consulta=$db->prepare('SELECT uestado, correo,intentos FROM usuarios WHERE usuario=:user');
      $consulta->bindValue('user',$restablecer->getNombre());
      $consulta->execute();
      $filtro=$consulta->fetch(PDO::FETCH_ASSOC);
      $correo =$filtro['correo'];
      $estado =$filtro['uestado'];
      $intento =$filtro['intentos'];

      if($estado ==5 || ($estado ==6 && $intento == 3)){
        $usuario = $restablecer->getNombre();
      
        date_default_timezone_set('America/Bogota');
        $hoy =  date('Y-m-d H:i:s');    
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {               
    
          $mail->SMTPDebug = 0;                                 // Enable verbose debug output
          $mail->isSMTP();      
          //$mail->SMTPDebug = 2;                                // Set mailer to use SMTP
          $mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
          $mail->SMTPAuth = true;                               // Enable SMTP authentication
          $mail->Username = 'newclinictest2024@outlook.com';                 // SMTP username
          $mail->Password = 'jkO5w6NqsJf7jRCop1X*#*';  
          $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
          $mail->Port = 587;                                    // TCP port to connect to
    

          $mail->setFrom('newclinictest2024@outlook.com');
          $mail->addAddress("$correo");
          $mail->isHTML(true);     
          $subject = "Cambio de contraseña";
          $body = "<div class='container' style='background: rgb(243,243,243);text-align: center;margin-bottom: 6%;border-bottom: 15px solid #ca0c7f;'>";
          $body .= "<div style='width: 100%;background: rgb(210, 6, 124);'>";
          $body .= "<h1 style='color:rgb(210, 6, 124);'>.</h1>";
          $body .= "</div>";
          $subject = utf8_decode($subject);
          $body = utf8_decode($body);     
          $mail->Subject = $subject;                             // Set email format to HTML      
          $mail->Body  =$body;                                                                                                                          
          $mail->send();
                                                
        } catch (Exception $e) {
          echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;      
        }  
      }      
    }


  public function restablecerContrasena($update){       
    $db=conectar::acceso();
    $consulta=$db->prepare('SELECT clave FROM usuarios WHERE usuario=:user');
    $consulta->bindValue('user',$update->getNombre());
    $consulta->execute();
    $filtro=$consulta->fetch(PDO::FETCH_ASSOC);
    $clave=$filtro['clave'];
    $password = $update->getClave();    
    $passwordLogin=password_verify($password, $clave);    
    if($passwordLogin){      

    echo 2;

    }else {

      $modificar=$db->prepare('UPDATE usuarios SET clave=:passwords,uestado=:estado,intentos=:intento,fecha_registro = curdate()  WHERE usuario=:user');

      $password=password_hash($password, PASSWORD_DEFAULT,["cost" => 15]);
    
      $modificar->bindValue('user',$update->getNombre());
      $modificar->bindValue('passwords',$password);
      $modificar->bindValue('estado',5);
      $modificar->bindValue('intento',0);
      $modificar->execute();

      if($modificar){
         $colsultar_usuario=$db->prepare('SELECT id_usuario from usuarios where usuario =:usuario');
                          $colsultar_usuario->bindValue('usuario', $update->getNombre());
                          $colsultar_usuario->execute();
                          $filtro=$colsultar_usuario->fetch(PDO::FETCH_ASSOC);
                          $id_usuario=$filtro['id_usuario'];
                           $funcion_realizada = "El usuario Realizo un restablecimiento de contraseña";
                           $inserta_funcion=$db->prepare("INSERT INTO funciones (codigo, id_usuario, fecha_registro, funcion_realizada,IP) VALUES (0, :id_usuario , curdate() , :funcion_realizada ,:ip )");
                           $inserta_funcion->bindValue('id_usuario',$id_usuario);
                           $inserta_funcion->bindValue('funcion_realizada',$funcion_realizada);
                           $inserta_funcion->bindValue('ip', $_SERVER['REMOTE_ADDR']);                 
                           $inserta_funcion->execute();

        echo 1;       
      }
    }

  }

  public function get_usuarios(){  
    $db=conectar::acceso();

    $consulta_usuario=$db->prepare("SELECT id_usuario, usuario FROM hinfraestructura.usuarios WHERE uestado !=:states ORDER BY usuario ASC");
    $consulta_usuario->bindValue('states',6);
    $consulta_usuario->execute();
            
    while($filas_usuario=$consulta_usuario->fetch(PDO::FETCH_ASSOC)){
                
      $this->usuario[]=$filas_usuario;
    }
    return $this->usuario;
  }

  public function get_funcionarios(){  
    $db=conectar::acceso();

    $consulta_funcionario=$db->prepare("SELECT identificacion, usuario FROM hinfraestructura.funcionarios WHERE festado !=:states ORDER BY usuario ASC");
    $consulta_funcionario->bindValue('states',6);
    $consulta_funcionario->execute();
            
    while($filas_funcionario=$consulta_funcionario->fetch(PDO::FETCH_ASSOC)){
                
      $this->funcionario[]=$filas_funcionario;
    }
    return $this->funcionario;
  }

  public function get_usuariosInfraestructura(){
    $db=conectar::acceso();

    $consulta_usuarioI=$db->prepare("SELECT id_usuario, usuario FROM hinfraestructura.usuarios WHERE id_roles=:roles AND uestado!=:estados ORDER BY usuario ASC");
    $consulta_usuarioI->bindValue('roles',6);
    $consulta_usuarioI->bindValue('estados',6);
    $consulta_usuarioI->execute();
            
    while($filas_usuarioI=$consulta_usuarioI->fetch(PDO::FETCH_ASSOC)){
                
      $this->usuarioInfraestructura[]=$filas_usuarioI;
    }
    return $this->usuarioInfraestructura;
  }

  public function get_usuariosMAI(){
    $db=conectar::acceso();

    $consulta_usuarioM=$db->prepare("SELECT id_usuario,usuario FROM hinfraestructura.usuarios WHERE id_roles = :rol AND uestado!=:estados ORDER BY usuario ASC");
    $consulta_usuarioM->bindValue('rol',9);
    $consulta_usuarioM->bindValue('estados',6);
    $consulta_usuarioM->execute();

    while($filas_usuarioM=$consulta_usuarioM->fetch(PDO::FETCH_ASSOC)){
      $this->usuariosM[]=$filas_usuarioM;
    }
    
    return $this->usuariosM;
  }

  public function get_usuariosAtienden(){
    $db=conectar::acceso();

    $consulta_usuarioA=$db->prepare("SELECT id_usuario,usuario FROM hinfraestructura.usuarios WHERE (id_roles = :rolA || id_roles=:rolB || id_roles=:rolC || id_roles=:rolD) AND uestado!=:estados ORDER BY usuario ASC");
    $consulta_usuarioA->bindValue('rolA',1);
    $consulta_usuarioA->bindValue('rolB',6);
    $consulta_usuarioA->bindValue('rolC',7);
    $consulta_usuarioA->bindValue('rolD',9);
    $consulta_usuarioA->bindValue('estados',6);
    $consulta_usuarioA->execute();

    while($filas_usuarioA=$consulta_usuarioA->fetch(PDO::FETCH_ASSOC)){
      $this->usuariosA[]=$filas_usuarioA;
    }
    
    return $this->usuariosA;
  }



  //*********************************************************************************************//
  //************************* BUSQUED ROL USUARIO ***********************************************//
  //proceso de creacion de activos***************************************************************//

    public function rol_usuario($usuario){  
      $db=conectar::acceso();

      $consulta = $db->prepare("SELECT id_roles FROM hinfraestructura.usuarios WHERE usuario = :usuario");
      $consulta->bindValue('usuario',$usuario->getNombre());
      $consulta->execute();

      if($consulta){
        while($resultado=$consulta->fetch(PDO::FETCH_ASSOC)){
          $this->rol_usuario=$resultado['id_roles'];
        }
        return $this->rol_usuario;
      }else{
        return 300;
      }
      $db=null;
      

    }
     


}


?>
