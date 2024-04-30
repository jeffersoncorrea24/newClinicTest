<?php
    require_once    ("../model/vinculo.php");
  
    class ValidaUsuario{

        public function valida($verifica){
            $claveLogin=$_POST['clave'];                                 
            $db=conectar::acceso();
            $confirma_usuario=$db->prepare('SELECT usuario, id_usuario, clave, validacion,estado.id_estado,timestampdiff(day, fecha_registro , now()) as dias, tipo_validacion, id_roles,correo, intentos FROM usuarios LEFT JOIN estado ON uestado=id_estado WHERE usuario=:usuario ');
            $confirma_usuario->bindValue('usuario',$verifica->getNombre()); 
            $confirma_usuario->execute();

            if($confirma_usuario->rowCount() == 0){//si no existe el usuario
                header("location:../../login.php");
                return 0;
            }

            if($confirma_usuario->rowCount() != 0){
                $dataUsuario=$confirma_usuario->fetch(PDO::FETCH_ASSOC);
                $id_usuario = $dataUsuario['id_usuario'];
                $codigoEstado=$dataUsuario['id_estado'];
                $usuario = $dataUsuario['usuario'];
                $baseClave=$dataUsuario['clave'];
                $validar=$dataUsuario['validacion'];
                $dias=$dataUsuario['dias'];
                $tipo_validacion = $dataUsuario['tipo_validacion'];
                $correo=$dataUsuario['correo'];
                $id_roles=$dataUsuario['id_roles'];
                $intentos = $dataUsuario['intentos'];
                $actual = date("Y-m-d H:i:s");
                $passwordLogin = password_verify($claveLogin,$baseClave);
                
                if($validar==0  && ($codigoEstado != 6)){
                    session_start();
                    $_SESSION['usuario'] = $usuario;
                    $_SESSION['id_roles'] = $id_roles;
                    header("location:../view/view_encriptar_usuario.php");

                } else {
                    if ($dias >= 90 || $dias  <= -90) {

                        if ($passwordLogin && ($codigoEstado != 6) ){
                            if (session_status() !== PHP_SESSION_ACTIVE){
                                session_start();
                            }
                            $_SESSION['usuario']=$usuario;
                            $_SESSION['id_roles']=$id_roles;

                            $this->intentos($usuario,0);
                            header("location:../view/cambio_contrasena_obligatorio.php");

                        } else {
                            if($intentos <= 3){
                                $this->intentos($usuario,++$intentos);
                                header("location:../../login.php?vrTx2e/:fgtyjf45yTsdbbgh=ghtyn%4/tSQ34&cty6Dd54=1&val=ghtf43&valrtv675474");
                            } else {
                                $this->intentos($usuario,++$intentos);
                                header("location:../../login.php?vrTx2e/:fgtyjf45yTsdbbgh=ghtyn%gtSQ34&cty6Dd54=2&val=ghtf43&valrtv675474");
                                $this->inactivaxIntentos($usuario);
                            }
                        }
                    }else{
                        if ($passwordLogin && ($codigoEstado != 6) ){
                            if (session_status() !== PHP_SESSION_ACTIVE){
                                session_start();
                            }
                            $_SESSION['usuario']=$usuario;
                            $_SESSION['id_roles']=$id_roles;

                            $this->intentos($usuario,0);
    
                            if($tipo_validacion == 1){
                                $clase = new ValidaUsuario();
                                $validacionGoogle = $clase->qrBD($usuario);
                                echo $validacionGoogle;
                            }else if($tipo_validacion == 2){
                                $validacionCorreo = $this->enviaCorreoToken($usuario,$correo,$actual);
                                echo $validacionCorreo;
                            }
                            //header("location:../../dashboard.php");

                        } else {                
                            if($intentos <= 3){
                                $this->intentos($usuario,++$intentos);
                                header("location:../../login.php?vrTx2e/:fgtyjf45yTsdbbgh=ghtyn%4/tSQ34&cty6Dd54=1&val=ghtf43&valrtv675474");

                            } else {
                                $this->intentos($usuario,++$intentos); 
                                $this->inactivaxIntentos($usuario);
                                header("location:../../login.php?vrTx2e/:fgtyjf45yTsdbbgh=ghtyn%gtSQ34&cty6Dd54=2&val=ghtf43&valrtv675474");
                            }                            
                        }                            
                    }                            
                }
            }
        }
        
        

        /* public function validacion($valida){

            session_start(); 
    
            if(!isset($_SESSION['intentos'])){
                $_SESSION['intentos'] = 0;

            }else {
                $_SESSION['intentos'] ++ ; 


                if ($_SESSION['intentos'] <= 3 ) {                   
                    $claveLogin=$_POST['claves'];

                    $db=conectar::acceso();
                    $confirma_usuario=$db->prepare('SELECT usuario, clave FROM usuarios WHERE usuario=:usuario');
                    $confirma_usuario->bindValue('usuario',$valida->getNombre());
                    $confirma_usuario->execute();
                    $existe_usuario=$confirma_usuario->rowCount();
                    $dataUsuario=$confirma_usuario->fetch(PDO::FETCH_ASSOC);
                    $baseClave=$dataUsuario['clave'];  
                    $passwordLogin=password_verify($claveLogin, $baseClave); 
                        if ($passwordLogin && (!empty($dataUsuario['usuario'])) ){
                            echo 1;
                        }else{
                            echo 0;
                        }
                }else{
                    $_SESSION['intentos'] = 0; 

                    echo 2;
                }    
            }
        } */
            /* valida unicamente la contraseña del usuario con la contraseña ingresada (proceso modificar contraseña) */
        public function validar($usuario){
                $db=conectar::acceso();

                $confirmarUsuario = $db->prepare('SELECT usuario,clave FROM usuarios WHERE usuario =:usuario');
                $confirmarUsuario->bindValue('usuario',$usuario->getNombre());
                $confirmarUsuario->execute();
                $dataUsuario = $confirmarUsuario->fetch(PDO::FETCH_ASSOC);
                $usuarioClave = $dataUsuario['clave'];

                $verificacionContrasena = password_verify($usuario->getClave(),$usuarioClave);
                
                if($verificacionContrasena){
                    echo 1;
                }else{
                    echo 0;
                }

        }

            //VALIDACIONES DE GOOGLE Y TOKEN
        public function validacionUsuario($validaT){
            $db=conectar::acceso();
            $codigoUsuario = $db ->prepare("SELECT usuario FROM usuarios WHERE usuario=:usuario");
            $codigoUsuario->bindValue('usuario',$validaT->getNombre());
            $codigoUsuario->execute();
            $codUsuario=$codigoUsuario->fetch(PDO::FETCH_ASSOC);
            $codigo = $codUsuario['usuario'];
            if($codigoUsuario){
                $validacion = $db->prepare('SELECT token,fecha_token FROM validacion_token WHERE id_usuario=:id_usuarioX ORDER by id DESC limit 1');             
                $validacion->bindValue('id_usuarioX',$codigo);
                $validacion->execute();
                $arraytokenBD = $validacion -> fetch(PDO::FETCH_ASSOC);
                $tokenBD = $arraytokenBD['token'];                                
                date_default_timezone_set('America/Bogota');   
                $fecha_registro = $arraytokenBD['fecha_token'];
                $actual = date("Y-m-d H:i:s");
                $mas = date("Y-m-d H:i:s", strtotime("+1 minutes", strtotime($fecha_registro)));                         
                $tokenIngresado = $validaT->getTicket();                      
                if($actual < $mas && $tokenIngresado==$tokenBD){
                    $borrarToken = $db->prepare('DELETE FROM validacion_token WHERE id_usuario=:usuario');
                    $borrarToken->bindValue('usuario',$codigo);
                    $borrarToken->execute();
                    $_SESSION['status_connect']=$codigo;
                    $_SESSION['code']=$codigo;
                    header("location:../../dashboard.php");
                }else{
                    session_unset();
                    session_destroy();
                    header("location:../../login.php");
                }
            }
        }

        public function validacionC($validar){


            if(!isset($_SESSION['intentos'])) 
                $_SESSION['intentos'] = 0; 
            else {      

                $_SESSION['intentos'] ++ ; 

                if ($_SESSION['intentos'] <= 3 ) { 
        
                    $claveLogin=$_POST['clave'];

                    $db=conectar::acceso();

                    $confirma_usuario=$db->prepare('SELECT usuario, clave FROM usuarios WHERE usuario=:usuario');

                    $confirma_usuario->bindValue('usuario',$validar->getNombre());
                    $confirma_usuario->execute();
                    $existe_usuario=$confirma_usuario->rowCount();
                    $dataUsuario=$confirma_usuario->fetch(PDO::FETCH_ASSOC);
                    $baseClave=$dataUsuario['clave'];
            
                    $passwordLogin=password_verify($claveLogin, $baseClave);

                    if ($passwordLogin && (!empty($dataUsuario['usuario'])) ){

                        header("location:../view/validacionGoogle.php");

                    } else{

                        echo 0;
                    }

                } else {
                    $_SESSION['intentos'] = 0; 
                    header("location:../view/validacionCodigo.php");
                }
            }            
        }

        public function validacionAlCo($datos){
            $db=conectar::acceso();
            $validarAlCo=$db->prepare('SELECT id_usuario, codigo, fecha FROM codigosqr WHERE id_usuario=:id_usuario ORDER BY fecha desc limit 1');
            $validarAlCo->bindValue('id_usuario',$datos->getId_Usuario());
            $validarAlCo->execute();
            $usuarioObj=$validarAlCo->fetch(PDO::FETCH_ASSOC);

            if ($usuarioObj['id_usuario']!=NULL && $usuarioObj['codigo']!=NULL){
                return $usuarioObj;
            }else{
                return 'error';
            }
        }

        public function enviaCorreoToken($usuario,$correo,$actual){
            $token = bin2hex(random_bytes(5));
            //CORREO MEDIANTE PHP MAILER
            $mail = new PHPMailer(true);   
        
            try {
                
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'newclinictest2024@outlook.com';                 // SMTP username
            $mail->Password = 'jkO5w6NqsJf7jRCop1X*#*';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
            $mail->setFrom('newclinictest2024@outlook.com');
            $mail->addAddress($correo);
            $mail->isHTML(true); // Set email format to HTML
            $subjects = "Código de autenticacion";
            $cuerpo='<style type="text/css">*{font-size: 14px;} #contenedor{text-align: center;padding: 0% 5%;width: 8%;} #contenedor img:hover {opacity:0.5; margin-top:-10%; transition: all 2s ease-out;} #contenedor a {text-decoration: none;color: #fff;}#div_dos,#div_tres,#div_cuatro,#div_cinco,#div_seis{display:flex;} </style>';
            $cuerpo .="<div>
            </div>";
            $cuerpo.= "<p>Señor(a) su código es el siguiente: " .$token. ".</p>";
            $cuerpo.= "<p>Este código tendrá una duración de 1 minuto, después de este tiempo, se borrara y tendra que ingresar nuevamente a la plataforma.</p>";
            $cuerpo.= "<p></p>";
            $cuerpo.= "<p></p>";
            $cuerpo.= "<p>Cada vez que ingrese mediante Token, se actualizará el código, por lo que si intenta agregar un token antiguo o incorrecto, sera llevado de vuelta al login.</p>";
            $cuerpo.= "<div id='div_dos'>";
            $body = utf8_decode($cuerpo);
            $subject = utf8_decode($subjects);
            $mail->Subject = $subject;      
            $mail->MsgHTML($body);
            $mail->send();
        
            }catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            }
            $db=conectar::acceso();
            $saveToken=$db->prepare("INSERT INTO validacion_token (id_usuario, fecha_token, token) VALUES (:id_usuario, :fecha, :token)");
            $saveToken->bindValue('id_usuario',$usuario);
            $saveToken->bindValue('fecha',$actual);
            $saveToken->bindValue('token',$token);
            $saveToken->execute();
            header("location:../view/validacionToken.php");
        }

        public function qrBD($usuario){
            $db=conectar::acceso();
            $validarAlCo=$db->prepare('SELECT codigo, fecha FROM codigosqr WHERE id_usuario=:id_usuario ORDER BY fecha desc limit 1');
            $validarAlCo->bindValue('id_usuario',$usuario);
            $validarAlCo->execute();
            $conteo=$validarAlCo->rowCount();
            
            if($conteo!=0){
                $usuarioObj=$validarAlCo->fetch(PDO::FETCH_ASSOC);
                $_SESSION['auth_secret'] = $usuarioObj["codigo"];
                $seleccion=("SELECT intentos FROM usuarios WHERE usuario='$usuario'");
                
                $resultado=$db->query($seleccion);
                $data=$resultado->fetch(PDO::FETCH_ASSOC);   
                $intentos=$data['intentos'];
                $_SESSION['intentos']=$intentos; 

                $actualizar_intentos = $db->prepare('UPDATE usuarios SET intentos=:intento WHERE usuario=:usuario');             
                $actualizar_intentos->bindValue('intento',0);
                $actualizar_intentos->bindValue('usuario',$usuario);
                $actualizar_intentos->execute();

                $intentos = $db->prepare('INSERT INTO intentos_usuarios(usuario,fecha,cantidad_exitos,IP) VALUES(:user,:data,:success,:ip)');
                $intentos->bindValue('user',$usuario);
                date_default_timezone_set('America/Bogota');
                $intentos->bindValue('data',date('Y-m-d H:i:s'));
                $intentos->bindValue('success',1);
                $intentos->bindValue('ip', $_SERVER['REMOTE_ADDR']);
                $intentos->execute();
                            
                header("location:../view/validacionCodigo.php");
            }else{
                $seleccion=("SELECT intentos FROM usuarios WHERE usuario='$usuario'");
                
                $resultado=$db->query($seleccion);
                $data=$resultado->fetch(PDO::FETCH_ASSOC);   
                $intentos=$data['intentos'];
                $_SESSION['intentos']=$intentos; 

                $actualizar_intentos = $db->prepare('UPDATE usuarios SET intentos=:intento WHERE usuario=:usuario');             
                $actualizar_intentos->bindValue('intento',0);
                $actualizar_intentos->bindValue('usuario',$usuario);
                $actualizar_intentos->execute();

                $intentos = $db->prepare('INSERT INTO intentos_usuarios(usuario,fecha,cantidad_exitos,IP) VALUES(:user,:data,:success,:ip)');
                $intentos->bindValue('user',$usuario);
                date_default_timezone_set('America/Bogota');
                $intentos->bindValue('data',date('Y-m-d H:i:s'));
                $intentos->bindValue('success',1);
                $intentos->bindValue('ip', $_SERVER['REMOTE_ADDR']);
                $intentos->execute();
                            
                header("location:../view/validacionGoogle.php");
            }
        }

        public function intentos($usuario,$intentos){
            $db=conectar::acceso();
            $actualizar_intentos = $db->prepare('UPDATE usuarios SET intentos=:intento WHERE usuario=:user');                      
            $actualizar_intentos->bindValue('intento',$intentos);
            $actualizar_intentos->bindValue('user',$usuario);
            $actualizar_intentos->execute();

            if($intentos == 0){
                $succes = 1;
                $failed = 0;
            }else{
                $succes = 0;
                $failed = 1;
            }

            $intentos = $db->prepare('INSERT INTO intentos_usuarios(usuario,fecha,cantidad_exitos,cantidad_fallidos,IP) VALUES(:user,:data,:success,:failed,:ip)');
            $intentos->bindValue('user',$usuario);
            date_default_timezone_set('America/Bogota');
            $intentos->bindValue('data',date('Y-m-d H:i:s'));
            $intentos->bindValue('success',$succes);
            $intentos->bindValue('failed',$failed);
            $intentos->bindValue('ip', $_SERVER['REMOTE_ADDR']);
            $intentos->execute();
        }

        public function inactivaxIntentos($usuario){
            echo 'conecatdo a funcion';
            $db=conectar::acceso();
            $Inactivar=$db->prepare('UPDATE usuarios SET ufecha_inactivacion = :ufecha_inactivacion, descripcion = :descripcion, ufecha_sistema = :ufecha_sistema, usuario_inactiva=:usuario_inactiva, uestado = :uestado WHERE usuario = :usuario');
            $bloqueo = 'Usuario inactivado por maximo de intentos fallidos al intentar entrar a la plataforma';
            date_default_timezone_set('America/Bogota');
            $Inactivar->bindValue('usuario', $usuario);
            $Inactivar->bindValue('ufecha_inactivacion', date('Y-m-d H:i:s'));
            $Inactivar->bindValue('descripcion', $bloqueo);                                         
            $Inactivar->bindValue('ufecha_sistema', date('Y-m-d H:i:s'));
            $Inactivar->bindValue('uestado',6);
            $Inactivar->bindValue('usuario_inactiva', 'Proceso de inactivacion');
            $Inactivar->execute();

            header("location:../../login.php?vrTx2e/:fgtyjf45yTsdbbgh=ghtyn%gtSQ34&cty6Dd54=2&val=ghtf43&valrtv675474");
        }

        public function traerTipoValidacion($usuario){
            $db = Conectar::acceso();
            $consultar_tipoval=$db->prepare("SELECT tipo_validacion FROM usuarios WHERE usuario=:usuario");
            $consultar_tipoval->bindValue('usuario', $usuario->getNombre());
            $consultar_tipoval->execute();
            $resultado = $consultar_tipoval->fetch(PDO::FETCH_ASSOC);
            if ($resultado['tipo_validacion'] != 2){
                echo 1;
            }else{
                echo 2;
            }
        }

        public function verificarContrasena($validar){
            $claveIngresada = $validar->getClave();
            $db=conectar::acceso();
            $verificar=$db->prepare('SELECT clave FROM usuarios WHERE usuario=:usuario');
            $verificar->bindValue('usuario',$validar->getNombre());
            $verificar->execute();
            $resultado = $verificar->fetch(PDO::FETCH_ASSOC);
            $claveBase = $resultado['clave'];
            $passwordLogin = password_verify($claveIngresada,$claveBase);
            if($passwordLogin == true){
                echo 1;
            }else{
                echo 2;
            }
        }
        public function traerUsuario($validar){
            $db=conectar::acceso();
            $verificar=$db->prepare('SELECT usuario FROM usuarios WHERE id_usuario=:id_usuario');
            $verificar->bindValue('id_usuario',$validar->getIDusuario());
            $verificar->execute();
            $resultado = $verificar->fetch(PDO::FETCH_ASSOC);
            $usuario = $resultado['usuario'];
            if($resultado['usuario']){
                echo $resultado['usuario'];
            }else{
                echo 2;
            }
        }

        public function verificarContrasenaU($validar){
            $claveIngresada = $validar->getClave();
            $db=conectar::acceso();
            $verificar=$db->prepare('SELECT clave FROM usuarios WHERE usuario=:usuario');
            $verificar->bindValue('usuario',$validar->getNombre());
            $verificar->execute();
            $resultado = $verificar->fetch(PDO::FETCH_ASSOC);
            $claveBase = $resultado['clave'];
            $passwordLogin = password_verify($claveIngresada,$claveBase);
            if($passwordLogin == true){
                echo 1;
            }else{
                echo 2;
            }
        }

        public function cambioContrasenaUsuario($usuario){
            $db=Conectar::acceso();
            $cambioPass =$db->prepare("UPDATE usuarios SET clave=:clave, validacion=:validacion WHERE usuario=:usuario");
            $password=password_hash($usuario->getClave(), PASSWORD_DEFAULT, ["cost" => 15]);
            $cambioPass->bindValue('clave',$password);
            $cambioPass->bindValue('validacion','0');
            $cambioPass->bindValue('usuario',$usuario->getNombre());
            $cambioPass->execute();
            $row = $cambioPass->rowCount();
            if($row !=0){
                echo 1;
            }else{
                echo 2;
            }
        }
    }
    
