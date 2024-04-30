<?php
require_once ('../../public/lib/password.php');
require_once ('../model/vinculo.php');
require __DIR__ . '/vendor/autoload.php';

class CrudFuncionarios
{

	public function consultarsolicitudesPendientes($identificacion)
	{
		$db = Conectar::acceso();
		$consulta = $db->prepare('SELECT count(*) FROM traslados WHERE funcionario_final=:id AND estado_traslado=:estado');
		$consulta->bindValue('id', $identificacion);
		$consulta->bindValue('estado', 3);
		$consulta->execute();

		$conteo = $consulta->fetchColumn();

		echo $conteo > 0 ? 1 : 0;
	}

	//**********************************************************************************************//
//********************************SQL PARA CREAR FUNCIONARIO************************************//
//**********************************************************************************************//

	public function crearFuncionario($create)
	{
		$db = Conectar::acceso();
		$validar_funcionario = $db->prepare('SELECT identificacion, usuario FROM funcionarios WHERE identificacion=:identidad OR usuario=:user');
		$validar_funcionario->bindValue('identidad', $create->getF_identificacion());
		$validar_funcionario->bindValue('user', $create->getF_usuario());
		$validar_funcionario->execute();
		$conteoFuncionarios = $validar_funcionario->rowCount();

		if ($conteoFuncionarios != 0) {
			echo 3;
		} else {
			$db = Conectar::acceso();
			$crea_funcionario = $db->prepare('INSERT INTO funcionarios(identificacion,nombre,mail,mail2,departamento_interno,area,cargo,extension,rol,usuario,
			contrasena,validacion, festado,fecha_registro,centro_de_costos, fecha_sistema)
			VALUES(:f_identificacion, :f_nombre, :f_email, :f_email2, :f_departamentoInterno, :f_area, :f_cargo, :f_extension, :f_rol, :f_usuario, 
			:f_contrasena, :f_validacion, :f_estado, curdate(), :f_centroCostos, :fecha_sistema)');

			$password = password_hash($create->getF_contrasena(), PASSWORD_DEFAULT, ["cost" => 15]);

			$crea_funcionario->bindValue('f_identificacion', $create->getF_identificacion());
			$crea_funcionario->bindValue('f_nombre', $create->getF_nombre());
			$crea_funcionario->bindValue('f_email', $create->getF_email());
			$crea_funcionario->bindValue('f_email2', $create->getF_email2());
			$crea_funcionario->bindValue('f_area', $create->getF_area());
			$crea_funcionario->bindValue('f_cargo', $create->getF_cargo());
			$crea_funcionario->bindValue('f_extension', $create->getF_extension());
			$crea_funcionario->bindValue('f_rol', $create->getF_rol());
			$crea_funcionario->bindValue('f_usuario', $this->eliminar_acentos($create->getF_usuario()));
			$crea_funcionario->bindValue('f_contrasena', $password);
			$crea_funcionario->bindValue('f_validacion', $create->getF_validacion());
			$crea_funcionario->bindValue('f_estado', $create->getF_estado());
			$crea_funcionario->bindValue('f_centroCostos', $create->getCentroCostos());
			$crea_funcionario->bindValue('f_departamentoInterno', $create->getDepartamentoInterno());
			$crea_funcionario->bindValue('fecha_sistema', date('Y-m-d H:i:s'));
			$crea_funcionario->execute();

			if ($crea_funcionario) {
				echo 1;
			} else {
				echo 0;
			}
		}

	}

	//**********************************************************************************************//
//******************************* SQL PARA MODIFICAR FUNCIONARIO *******************************//
//**********************************************************************************************//


	public function modificarFuncionario($update)
	{
		$db = conectar::acceso();
		$validaCargo = $db->prepare('SELECT cargo FROM funcionarios WHERE identificacion = :identificacion LIMIT 1');
		$validaCargo->bindValue('identificacion', $update->getF_identificacion());
		$validaCargo->execute();
		$validacionCargo = $validaCargo->fetch(PDO::FETCH_ASSOC);
		$cargoActual = $validacionCargo['cargo'];

		$modificar_funcionario = $db->prepare('UPDATE funcionarios SET  tipo_validacion=:f_tipoValidacion, nombre= :f_nombre, mail= :f_email, mail2 = :f_email2, area= :f_area, cargo= :f_cargo, extension= :f_extension, rol= :f_rol, usuario= :f_usuario, validacion= :f_validacion, fecha_sistema= :f_fecha_sistema, centro_de_costos = :centroCostos, intentos=:f_intento WHERE identificacion= :f_identificacion');
		$modificar_funcionario->bindValue('f_identificacion', $update->getF_identificacion());
		$modificar_funcionario->bindValue('f_tipoValidacion', $update->getTipoValidacion());
		$modificar_funcionario->bindValue('f_nombre', $update->getF_nombre());
		$modificar_funcionario->bindValue('f_email', $update->getF_email());
		$modificar_funcionario->bindValue('f_email2', $update->getF_email2());
		$modificar_funcionario->bindValue('f_area', $update->getF_area());
		$modificar_funcionario->bindValue('f_cargo', $update->getF_cargo());
		$modificar_funcionario->bindValue('f_extension', $update->getF_extension());
		$modificar_funcionario->bindValue('f_rol', $update->getF_rol());
		$modificar_funcionario->bindValue('f_usuario', $update->getF_usuario());
		$modificar_funcionario->bindValue('f_validacion', $update->getF_validacion());
		$modificar_funcionario->bindValue('f_fecha_sistema', $update->getF_fecha_sistema());
		$modificar_funcionario->bindValue('f_intento', 0);
		$modificar_funcionario->bindValue('centroCostos', $update->getCentroCostos());
		$modificar_funcionario->execute();
		$row = $modificar_funcionario->rowCount();
		if ($row != 0) {
			echo 3;
		} else {
			echo 4;
		}
		if ($modificar_funcionario) {

			if ($update->getF_estado() == 16) {
				$inactivacionFuncionario = $db->prepare("UPDATE funcionarios SET festado= :f_estado, usuario_inactivacion = :f_usuario_inactivacion, fecha_inactivacion = :f_fecha_inactivacion, descripcion = :descripcion WHERE  identificacion= :f_identificacion");
				$inactivacionFuncionario->bindValue('f_usuario_inactivacion', $update->getF_usuario_inactivacion());
				$inactivacionFuncionario->bindValue('f_fecha_inactivacion', $update->getF_fecha_inactivacion());
				$inactivacionFuncionario->bindValue('f_estado', $update->getF_estado());
				$inactivacionFuncionario->bindValue('descripcion', $update->getDescripcionFinal());
				$inactivacionFuncionario->bindValue('f_identificacion', $update->getF_identificacion());
				$inactivacionFuncionario->execute();
				$rowInac = $inactivacionFuncionario->rowCount();
				if ($rowInac != 0) {
					echo 5;
				} else {
					echo 6;
				}

				$activos = $db->prepare("SELECT id_activo FROM activos_internos WHERE responsable_activo=:identificacion");
				$activos->bindValue('identificacion', $update->getF_identificacion());
				$activos->execute();
				$conteoActivos = $activos->rowCount();

				if ($conteoActivos != 0) {
					$idproxifun = $_POST['funcionario_Transpaso'];
					$arreglo = [];
					$arreglo = $activos->fetchAll(PDO::FETCH_COLUMN);
					for ($i = 0; $i < $conteoActivos; $i++) {
						$crearTraslado = $db->prepare('INSERT INTO traslados(funcionario_inicial, fecha_asignado, funcionario_final, fecha_traslado, activo_traslado, descripcion_traslado, estado_traslado )VALUES(:t_funcionarioI, :t_fechaA, :t_funcionarioF, :t_fechaT, :t_activo, :t_descripcion, :t_estado_traslado)');
						$crearTraslado->bindValue('t_funcionarioI', $update->getF_identificacion());
						$crearTraslado->bindValue('t_fechaA', $update->getF_fecha_inactivacion());
						$crearTraslado->bindValue('t_funcionarioF', $idproxifun);
						$crearTraslado->bindValue('t_fechaT', $update->getF_fecha_sistema());
						$crearTraslado->bindValue('t_activo', $arreglo[$i]);
						$crearTraslado->bindValue('t_descripcion', 'Retiro Empleado');
						$crearTraslado->bindValue('t_estado_traslado', 3);
						$crearTraslado->execute();

						$acepta_traslado = $db->prepare('UPDATE traslados SET estado_traslado=6 WHERE funcionario_final =:usuario_inicial AND activo_traslado=:id_activo ORDER BY id_traslado DESC LIMIT 1');
						$acepta_traslado->bindValue('usuario_inicial', $update->getF_identificacion());
						$acepta_traslado->bindValue('id_activo', $arreglo[$i]);
						$acepta_traslado->execute();


					}
				}

				//validates the modification of the official's position
			} else if ($cargoActual != $update->getF_cargo()) {

				echo 8;
			}
		} else {
			echo 9;
		}
		$db = null;
	}

	private function peticionCancelacionAccesos($identificacion, $usuario, $tema)
	{
		$db = conectar::acceso();
		$consultarAccesosPlataformas = $db->prepare("SELECT plataforma FROM accesos_plataformas WHERE id_usuario = :identificacion && estado = 5");
		$consultarAccesosPlataformas->bindValue("identificacion", $identificacion);
		$consultarAccesosPlataformas->execute();

		$cantidadAccesosPlataforma = $consultarAccesosPlataformas->rowcount();
		if ($cantidadAccesosPlataforma > 0) {
			$plataformas = "";
			foreach ($consultarAccesosPlataformas->fetchall() as $listado) {
				$plataformas = $plataformas . $listado['plataforma'] . ',';
			}

			date_default_timezone_set('America/Bogota');

			$creaPeticionAcceso = $db->prepare("INSERT INTO peticiones_accesos(descripcion, tipo, plataformas, usuario_creacion, fecha_creacion, estado,conclusiones,  aprobacion)
			VALUES(:descripcion, :tipo, :plataformas, :usuario_creacion, :fecha_creacion, :estado, :conclusiones,  :aprobacion)");
			$creaPeticionAcceso->bindValue('descripcion', 'Inactivacion de caracter Urgente por ' . $tema);
			$creaPeticionAcceso->bindValue('tipo', 2);
			$creaPeticionAcceso->bindValue('plataformas', substr($plataformas, 0, -1));
			$creaPeticionAcceso->bindValue('usuario_creacion', $usuario);
			$creaPeticionAcceso->bindValue('fecha_creacion', date('Y-m-d H:i:s'));
			$creaPeticionAcceso->bindValue('estado', 1);
			$creaPeticionAcceso->bindValue('conclusiones', 'Inactivacion de caracter Urgente por ' . $tema);
			$creaPeticionAcceso->bindValue('aprobacion', 12);
			$creaPeticionAcceso->execute();
		}
	}

	//**********************************************************************************************//
//******************************* SQL PARA MODIFICAR FUNCIONARIOS INACTIVOS *******************************//
//**********************************************************************************************//

	public function modificarFuncionarioInactivo($update)
	{
		$db = conectar::acceso();
		$modificar_funcionarioInactivo = $db->prepare('UPDATE funcionarios SET  nombre= :f_nombre, mail= :f_email, area= :f_area, cargo= :f_cargo, festado= :f_estado, extension= :f_extension, rol= :f_rol, usuario= :f_usuario, contrasena= :f_contrasena, validacion= :f_validacion, fecha_activacion = :f_fecha_activacion, usuario_activacion = :f_usuario_activacion, descripcion = :descripcion, intentos = :intentos WHERE identificacion= :f_identificacion');


		$modificar_funcionarioInactivo->bindValue('f_identificacion', $update->getF_identificacion());
		$modificar_funcionarioInactivo->bindValue('f_nombre', $update->getF_nombre());
		$modificar_funcionarioInactivo->bindValue('f_email', $update->getF_email());
		$modificar_funcionarioInactivo->bindValue('f_area', $update->getF_area());
		$modificar_funcionarioInactivo->bindValue('f_cargo', $update->getF_cargo());
		$modificar_funcionarioInactivo->bindValue('f_estado', $update->getF_estado());
		$modificar_funcionarioInactivo->bindValue('f_extension', $update->getF_extension());
		$modificar_funcionarioInactivo->bindValue('f_rol', $update->getF_rol());
		$modificar_funcionarioInactivo->bindValue('f_usuario', $update->getF_usuario());
		$modificar_funcionarioInactivo->bindValue('f_contrasena', $update->getF_contrasena());
		$modificar_funcionarioInactivo->bindValue('f_validacion', $update->getF_validacion());
		$modificar_funcionarioInactivo->bindValue('f_fecha_activacion', $update->getF_fecha_activacion());
		$modificar_funcionarioInactivo->bindValue('f_usuario_activacion', $update->getF_usuario_activacion());
		$modificar_funcionarioInactivo->bindValue('descripcion', $update->getDescripcionFinal());
		$modificar_funcionarioInactivo->bindValue('intentos', 0);

		$modificar_funcionarioInactivo->execute();
	}





	//**********************************************************************************************//
//******************************** SQL PARA CONSULTAR FUNCIONARIOS ACTIVOS *****************************//
//**********************************************************************************************//

	public function consultarFuncionarios()
	{
		$db = conectar::acceso();
		$lista_funcionarios = [];
		$consultar_funcionario = $db->prepare('SELECT  identificacion, nombre, mail, mail2, departamento_interno, area, cargo, extension, rol, roles.descripcion AS nombre_rol, usuario, contrasena, validacion, areas.descripcion AS descripcion1, cargos.descripcion AS descripcion2, centro_de_costos 
			FROM funcionarios 
			LEFT JOIN areas ON id_area= area 
			LEFT JOIN cargos ON id_cargo=cargo 
			LEFT JOIN roles ON id_roles=funcionarios.rol 
			WHERE festado=:estadoA');

		$consultar_funcionario->bindValue('estadoA', '5');
		$consultar_funcionario->execute();

		foreach ($consultar_funcionario->fetchAll() as $listado) {
			$consulta = new Funcionario();
			$consulta->setF_identificacion($listado['identificacion']);
			$consulta->setF_nombre($listado['nombre']);
			$consulta->setF_email($listado['mail']);
			$consulta->setF_email2($listado['mail2']);
			$consulta->setF_area($listado['descripcion1']);
			$consulta->setF_cargo($listado['descripcion2']);
			$consulta->setF_extension($listado['extension']);
			$consulta->setF_rol($listado['rol']);
			$consulta->setF_nombre_rol($listado['nombre_rol']);

			$consulta->setF_usuario($listado['usuario']);
			$consulta->setF_contrasena($listado['contrasena']);
			$consulta->setF_validacion($listado['validacion']);
			$consulta->setCentroCostos($listado['centro_de_costos']);
			$consulta->setDepartamentoInterno($listado['departamento_interno']);

			$lista_funcionarios[] = $consulta;
		}
		return $lista_funcionarios;
	}




	//**********************************************************************************************//
//************* SQL PARA CONSULTAR TODOS LOS FUNCIONARIOS INACTIVOS Y RETIRADOS ****************//
//**********************************************************************************************//

	public function consultarFuncionariosInactivos()
	{
		$db = conectar::acceso();
		$lista_funcionariosInactivos = [];

		$consultar_funcionarioInactivo = $db->prepare('SELECT  identificacion, nombre, mail, area, cargo, extension, rol, usuario, contrasena, validacion,fecha_inactivacion, areas.descripcion AS descripcion1, cargos.descripcion AS descripcion2, funcionarios.descripcion as descripcionFinal FROM funcionarios LEFT JOIN areas ON id_area=area LEFT JOIN cargos ON id_cargo=cargo WHERE festado=:estadoI || festado=:estadoII');
		$consultar_funcionarioInactivo->bindValue('estadoII', '16');
		$consultar_funcionarioInactivo->bindValue('estadoI', '6');
		$consultar_funcionarioInactivo->execute();


		foreach ($consultar_funcionarioInactivo->fetchAll() as $listado) {
			$consulta = new Funcionario();
			$consulta->setF_identificacion($listado['identificacion']);
			$consulta->setF_nombre($listado['nombre']);
			$consulta->setF_email($listado['mail']);
			$consulta->setF_area($listado['descripcion1']);
			$consulta->setF_cargo($listado['descripcion2']);
			$consulta->setF_extension($listado['extension']);
			//$consulta->setF_rol($listado['rol']);	
			$consulta->setF_usuario($listado['usuario']);
			$consulta->setF_contrasena($listado['contrasena']);
			$consulta->setF_validacion($listado['validacion']);
			$consulta->setF_fecha_inactivacion($listado['fecha_inactivacion']);
			$consulta->setDescripcionFinal($listado['descripcionFinal']);

			$lista_funcionariosInactivos[] = $consulta;
		}
		return $lista_funcionariosInactivos;
	}



	//**********************************************************************************************//
//******************************** SQL PARA ELIMINAR FUNCIONARIOS ******************************//
//**********************************************************************************************//

	public function eliminarFuncionario($delete)
	{

		$db = conectar::acceso();
		$eliminar_funcionario = $db->prepare('DELETE FROM funcionarios WHERE identificacion=:f_identificacion');

		$eliminar_funcionario->bindValue('f_identificacion', $delete->getF_identificacion());

		$eliminar_funcionario->execute();
	}


	//**********************************************************************************************//
//**************************** SQL PARA VALIDACION LOGIN FUNCIONARIOS **************************//
//**********************************************************************************************//
	public function validaLoginFuncionario($validate)
	{

		$contrasenaLogin = $_POST['f_password'];
		$usuarioLogin = $validate->getF_usuario();

		$usuarioValidacion = strtolower($usuarioLogin);

		$db = conectar::acceso();
		$validar_funcionario = $db->prepare('SELECT usuario,festado,contrasena,validacion,timestampdiff(day, fecha_sistema , now()) as dias, rol, intentos, tipo_validacion, mail FROM funcionarios WHERE usuario= :f_usuario');
		$validar_funcionario->bindValue('f_usuario', $usuarioValidacion);
		$validar_funcionario->execute();
		$existe_funcionario = $validar_funcionario->rowCount();

		if ($existe_funcionario != 0) {

			$datosFuncionario = $validar_funcionario->fetch(PDO::FETCH_ASSOC);
			$codigoEstados = $datosFuncionario['festado'];
			$contrasenaUsuario = $datosFuncionario['contrasena'];
			$validar = $datosFuncionario['validacion'];
			$dias = $datosFuncionario['dias'];
			$rol = $datosFuncionario['rol'];
			$intentos = $datosFuncionario['intentos'];
			$usuario = $datosFuncionario['usuario'];
			$tipo_validacion = $datosFuncionario['tipo_validacion'];
			$correo = $datosFuncionario['mail'];
			$actual = date("Y-m-d H:i:s");
			$passwordLogin = password_verify($contrasenaLogin, $contrasenaUsuario);

			if ($datosFuncionario['festado'] != 16) {

				if ($validar == 0 && ($codigoEstados != 6 && $codigoEstados != 16)) {
					session_start();
					$_SESSION['usuario'] = $usuario;
					header("location:../view/view_encriptar_contrasena.php");

				} else {

					if ($dias >= 90) {
						if ($passwordLogin && (!empty($usuario)) && ($codigoEstados != 6 && $codigoEstados != 16)) {
							if (session_status() !== PHP_SESSION_ACTIVE) {
								session_start();
							}
							$_SESSION['usuario'] = $usuario;
							$_SESSION['rol'] = $rol;

							$this->modificarIntentos($usuario, 0);
							$this->registrarIntento($usuario, 1);
							header("location:../view/cambio_contrasena_obligatorio_funcionarios.php");

						} else {
							$intentos++;
							if ($intentos <= 3) {
								$this->modificarIntentos($usuario, $intentos);
								$this->registrarIntento($usuario, 0);
								header("location:../../login_peticiones.php?rTx2eFg76fgtyjf45yTsdbbgh=ghtyn%gtSQ34&V4ll@/y874c=1&val=ghtf43&val=rtv675474");

							} else {
								$this->registrarIntento($usuario, 0);
								$this->inactivarFuncionarioxIntentos($usuario);
								header("location:../../login_peticiones.php?rTx2e/:fgtyjf45yTsdbbgh=ghtyn%gtSQ34&V4ll@/y874c=2&val=ghtf43&val=rtv675474");
							}
						}

					} else {
						if ($passwordLogin && (!empty($datosFuncionario['usuario'])) && ($codigoEstados != 6)) {
							if (session_status() !== PHP_SESSION_ACTIVE) {
								session_start();
							}
							$_SESSION['usuario'] = $datosFuncionario['usuario'];
							$_SESSION['rol'] = $rol;

							$this->modificarIntentos($usuario, 0);
							$this->registrarIntento($usuario, 1);

							if ($tipo_validacion == 1) {
								$clase = new CrudFuncionarios();
								$validacionGoogle = $clase->qrBD($usuario);
								echo $validacionGoogle;
							} else if ($tipo_validacion == 2) {
								$validacionCorreo = $this->enviaCorreoToken($usuario, $correo, $actual);
								echo $validacionCorreo;
							}

							//header("location:../../dashboard_funcionarios.php");

						} else {
							$intentos++;
							if ($intentos <= 3) {
								$this->modificarIntentos($usuario, $intentos);
								$this->registrarIntento($usuario, 0);
								header("location:../../login_peticiones.php?rTx2eFg76fgtyjf45yTsdbbgh=ghtyn%gtSQ34&V4ll@/y874c=1&val=ghtf43&val=rtv675474");

							} else {
								$this->registrarIntento($usuario, 0);
								$this->inactivarFuncionarioxIntentos($usuario);
								header("location:../../login_peticiones.php?rTx2e/:fgtyjf45yTsdbbgh=ghtyn%gtSQ34&V4ll@/y874c=2&val=ghtf43&val=rtv675474");
							}
						}
					}
				}

			} else {
				header("location:../../login_peticiones.php");
			}
		} else {
			header("location:../../login_peticiones.php");
		}
	}

	//*********************************************************************************************//
//*******************************AUTENTICACIÒN DE GOOGLE Y TOKEN*******************************//
//*********************************************************************************************//
	public function validacionC($validar)
	{


		if (!isset($_SESSION['intentos']))
			$_SESSION['intentos'] = 0;
		else {

			$_SESSION['intentos']++;

			if ($_SESSION['intentos'] <= 3) {

				$contrasenaLogin = $_POST['f_password'];

				$db = conectar::acceso();

				$confirma_usuario = $db->prepare('SELECT usuario, contrasena FROM funcionarios WHERE usuario=:usuario');

				$confirma_usuario->bindValue('usuario', $validar->getF_usuario());
				$confirma_usuario->execute();
				$existe_usuario = $confirma_usuario->rowCount();
				$datosFuncionario = $confirma_usuario->fetch(PDO::FETCH_ASSOC);
				$contrasenaUsuario = $datosFuncionario['contrasena'];

				$passwordLogin = password_verify($contrasenaLogin, $contrasenaUsuario);

				if ($passwordLogin && (!empty($datosFuncionario['usuario']))) {

					header("location:../view/validacionGoogleFuncionarios.php");

				} else {

					echo 0;
				}

			} else {
				$_SESSION['intentos'] = 0;
				header("location:../view/validacionCodigoFuncionarios.php");
			}
		}
	}

	public function validacionAlCo($funcionario)
	{
		$db = conectar::acceso();
		$validarAlCo = $db->prepare('SELECT id_usuario, codigo, fecha FROM codigosqr_funcionarios WHERE id_usuario=:id_usuario ORDER BY fecha desc limit 1');
		$validarAlCo->bindValue('id_usuario', $funcionario->getF_usuario());
		$validarAlCo->execute();
		$usuarioObj = $validarAlCo->fetch(PDO::FETCH_ASSOC);

		if ($usuarioObj['id_usuario'] != NULL && $usuarioObj['codigo'] != NULL) {
			return $usuarioObj;
		} else {
			return 'error';
		}
	}

	public function validacionFuncionario($datosFun)
	{
		$db = conectar::acceso();
		$codigoUsuario = $db->prepare("SELECT usuario FROM funcionarios WHERE usuario=:usuario");
		$codigoUsuario->bindValue('usuario', $datosFun->getF_usuario());
		$codigoUsuario->execute();
		$codUsuario = $codigoUsuario->fetch(PDO::FETCH_ASSOC);
		$codigo = $codUsuario['usuario'];
		if ($codigoUsuario) {
			$validacion = $db->prepare('SELECT token,fecha_token FROM validacion_token WHERE id_usuario=:id_usuarioX ORDER by id DESC limit 1');
			$validacion->bindValue('id_usuarioX', $codigo);
			$validacion->execute();
			$arraytokenBD = $validacion->fetch(PDO::FETCH_ASSOC);
			$tokenBD = $arraytokenBD['token'];
			date_default_timezone_set('America/Bogota');
			$fecha_registro = $arraytokenBD['fecha_token'];
			$actual = date("Y-m-d H:i:s");
			$mas = date("Y-m-d H:i:s", strtotime("+1 minutes", strtotime($fecha_registro)));
			$tokenIngresado = $datosFun->getF_ticket();
			if ($actual < $mas && $tokenIngresado == $tokenBD) {
				$borrarToken = $db->prepare('DELETE FROM validacion_token WHERE id_usuario=:usuario');
				$borrarToken->bindValue('usuario', $codigo);
				$borrarToken->execute();
				$_SESSION['status_connect'] = $codigo;
				$_SESSION['code'] = $codigo;
				header("location:../../dashboard_funcionarios.php");
			} else {
				session_unset();
				session_destroy();
				header("location:../../login_peticiones.php");
			}
		}
	}

	public function enviaCorreoToken($usuario, $correo, $actual)
	{
		$token = bin2hex(random_bytes(5));
		//CORREO MEDIANTE PHP MAILER
		$mail = new PHPMailer(true);

		try {

			$mail->SMTPDebug = 0;                                 // Enable verbose debug output
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'newclinictest2024@outlook.com';                 // SMTP username
            $mail->Password = 'jkO5w6NqsJf7jRCop1X*#*';  
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;                                    // TCP port to connect to
			$mail->setFrom('newclinictest2024@outlook.com');
			$mail->addAddress($correo);
			$mail->isHTML(true); // Set email format to HTML
			$subjects = "Código de autenticacion Soporte Interno ";
			$cuerpo = '<style type="text/css">*{font-size: 14px;} #contenedor{text-align: center;padding: 0% 5%;width: 8%;} #contenedor img:hover {opacity:0.5; margin-top:-10%; transition: all 2s ease-out;} #contenedor a {text-decoration: none;color: #fff;}#div_dos,#div_tres,#div_cuatro,#div_cinco,#div_seis{display:flex;} </style>';
			$cuerpo .= "<div>
		</div>";
			$cuerpo .= "<p>Señor(a) su código es el siguiente: " . $token . ".</p>";
			$cuerpo .= "<p>Este código tendrá una duración de 1 minuto, después de este tiempo, se borrara y tendra que ingresar nuevamente a la plataforma.</p>";
			$cuerpo .= "<p></p>";
			$cuerpo .= "<p></p>";
			$cuerpo .= "<p>Cada vez que ingrese mediante Token, se actualizará el código, por lo que si intenta agregar un token antiguo o incorrecto, sera llevado de vuelta al login.</p>";
			$cuerpo .= "<div id='div_dos'>";
			$body = utf8_decode($cuerpo);
			$subject = utf8_decode($subjects);
			$mail->Subject = $subject;
			$mail->MsgHTML($body);
			$mail->send();

		} catch (Exception $e) {
			echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}
		$db = conectar::acceso();
		$saveToken = $db->prepare("INSERT INTO validacion_token (id_usuario, fecha_token, token) VALUES (:id_usuario, :fecha, :token)");
		$saveToken->bindValue('id_usuario', $usuario);
		$saveToken->bindValue('fecha', $actual);
		$saveToken->bindValue('token', $token);
		$saveToken->execute();
		header("location:../view/validacionTokenFuncionarios.php");
		return true;
	}

	public function qrBD($usuario)
	{
		$db = conectar::acceso();
		$validarAlCo = $db->prepare('SELECT codigo, fecha FROM codigosqr_funcionarios WHERE id_usuario=:id_usuario ORDER BY fecha desc limit 1');
		$validarAlCo->bindValue('id_usuario', $usuario);
		$validarAlCo->execute();
		$conteo = $validarAlCo->rowCount();

		if ($conteo != 0) {
			$usuarioObj = $validarAlCo->fetch(PDO::FETCH_ASSOC);
			$_SESSION['auth_secretF'] = $usuarioObj["codigo"];
			$seleccion = ("SELECT intentos FROM usuarios WHERE usuario='$usuario'");

			$resultado = $db->query($seleccion);
			$data = $resultado->fetch(PDO::FETCH_ASSOC);
			$intentos = $data['intentos'];
			$_SESSION['intentos'] = $intentos;

			$actualizar_intentos = $db->prepare('UPDATE funcionarios SET intentos=:intento WHERE usuario=:usuario');
			$actualizar_intentos->bindValue('intento', 0);
			$actualizar_intentos->bindValue('usuario', $usuario);
			$actualizar_intentos->execute();

			$intentos = $db->prepare('INSERT INTO intentos_funcionarios(usuario,fecha,cantidad_exitos,IP) VALUES(:user,:data,:success,:ip)');
			$intentos->bindValue('user', $usuario);
			date_default_timezone_set('America/Bogota');
			$intentos->bindValue('data', date('Y-m-d H:i:s'));
			$intentos->bindValue('success', 1);
			$intentos->bindValue('ip', $_SERVER['REMOTE_ADDR']);
			$intentos->execute();

			header("location:../view/validacionCodigoFuncionarios.php");
			return true;
		} else {
			$seleccion = ("SELECT intentos FROM funcionarios WHERE usuario='$usuario'");

			$resultado = $db->query($seleccion);
			$data = $resultado->fetch(PDO::FETCH_ASSOC);
			$intentos = $data['intentos'];
			$_SESSION['intentos'] = $intentos;

			$actualizar_intentos = $db->prepare('UPDATE funcionarios SET intentos=:intento WHERE usuario=:usuario');
			$actualizar_intentos->bindValue('intento', 0);
			$actualizar_intentos->bindValue('usuario', $usuario);
			$actualizar_intentos->execute();

			$intentos = $db->prepare('INSERT INTO intentos_funcionarios(usuario,fecha,cantidad_exitos,IP) VALUES(:user,:data,:success,:ip)');
			$intentos->bindValue('user', $usuario);
			date_default_timezone_set('America/Bogota');
			$intentos->bindValue('data', date('Y-m-d H:i:s'));
			$intentos->bindValue('success', 1);
			$intentos->bindValue('ip', $_SERVER['REMOTE_ADDR']);
			$intentos->execute();

			header("location:../view/validacionGoogleFuncionarios.php");
			return true;
		}

	}


	public function modificarIntentos($usuario, $intentos)
	{
		$db = conectar::acceso();
		$modificar = $db->prepare("UPDATE funcionarios SET intentos = :intentos WHERE usuario = :usuario");
		$modificar->bindValue('intentos', $intentos);
		$modificar->bindValue('usuario', $usuario);
		$modificar->execute();

	}

	public function registrarIntento($usuario, $tipo)
	{

		if ($tipo == 1) {
			$tipo_cantidad = 'cantidad_exitos';
		} else {
			$tipo_cantidad = 'cantidad_fallidos';
		}

		$db = conectar::acceso();
		$intentos = $db->prepare("INSERT INTO intentos_funcionarios(usuario,fecha," . $tipo_cantidad . ",IP) VALUES(:user,:fecha,:success,:ip)");
		$intentos->bindValue('user', $usuario);
		date_default_timezone_set('America/Bogota');
		$intentos->bindValue('fecha', date('Y-m-d H:i:s'));
		$intentos->bindValue('success', 1);
		$intentos->bindValue('ip', $_SERVER['REMOTE_ADDR']);
		$intentos->execute();
	}

	public function inactivarFuncionarioxIntentos($usuario)
	{
		$db = conectar::acceso();
		$Inactivar = $db->prepare('UPDATE funcionarios SET fecha_inactivacion = :fecha_inactiva, usuario_inactivacion=:usuario_inactiva, festado = :estado, descripcion=:descripcion WHERE usuario = :usuario');
		date_default_timezone_set('America/Bogota');
		$Inactivar->bindValue('usuario', $usuario);
		$Inactivar->bindValue('fecha_inactiva', date('Y-m-d H:i:s'));
		$Inactivar->bindValue('estado', 6);
		$Inactivar->bindValue('descripcion', 'Inactivacion por superar el maximo de intentos permitidos al tratar ingresar en plataforma');
		$Inactivar->bindValue('usuario_inactiva', $usuario);
		$Inactivar->execute();
	}


	//**********************************************************************************************//
//******************** SQL PARA CAMBIAR LA contrasena DEL FUNCIONARIO **************************//
//**********************************************************************************************//

	public function cambioContrasena($update)
	{

		$db = conectar::acceso();
		$modificar_funcionario = $db->prepare('UPDATE hinfraestructura.funcionarios SET contrasena= :f_contrasena WHERE usuario=:f_usuario');

		$password = password_hash($update->getF_contrasena(), PASSWORD_DEFAULT, ["cost" => 15]);

		$modificar_funcionario->bindValue('f_usuario', $update->getF_usuario());
		$modificar_funcionario->bindValue('f_contrasena', $password);
		$modificar_funcionario->execute();
	}

	//**********************************************************************************************//
//************************* SQL PARA CONSULTAR CARGOS, ESTADOS Y AREAS ********************************//
//********************************************************************************************//

	public function consultaModificar()
	{

		$db = conectar::acceso();
		$consultaModificar = $db->prepare('SELECT identificacion, areas.id_area, areas.descripcion AS descripcion1,cargos.id_cargo,cargos.descripcion AS descripcion2, estado.id_estado, estado.descripcion AS descripcion3, departamentos_internos.id_departamento AS id_departamento, departamentos_internos.descripcion AS descripcionDepartamentoInt, centro_de_costos.id_centroCostos AS id_centroCostos, centro_de_costos.descripcion AS descripcion_centroCostos FROM funcionarios LEFT JOIN cargos ON cargo = id_cargo LEFT JOIN areas ON cargos.id_area = areas.id_area LEFT JOIN departamentos_internos ON areas.id_departamento = departamentos_internos.id_departamento LEFT JOIN estado ON festado=id_estado LEFT JOIN centro_de_costos ON centro_de_costos = centro_de_costos.id_centroCostos WHERE identificacion =:f_identificacion');
		$consultaModificar->bindValue('f_identificacion', $_POST['f_identificacion']);
		$consultaModificar->execute();
		$datosConsulta = $consultaModificar->fetch(PDO::FETCH_ASSOC);
		return $datosConsulta;

	}

	//**********************************************************************************************//
//******************************** SQL PARA CONSULTAR ACCESOS *****************************//
//**********************************************************************************************//

	public function consultarAccesos()
	{
		$db = conectar::acceso();
		$consultaModificarAcceso = $db->prepare('SELECT estado, tipo_accesos, tipos_accesos.descripcion AS descripcionAcceso, estado.descripcion AS descripcionEstado FROM accesos LEFT JOIN estdo ON id_estado=estado LEFT JOIN tipos_accesos ON id_accesos=tipo_accesos WHERE id_acceso=:codAcceso');

		$consultaModificarAcceso->bindValue('codAcceso', $_POST['codigos']);
		$consultaModificarAcceso->execute();
		$datosConsulta = $consultaModificarAcceso->fetch(PDO::FETCH_ASSOC);
		return $datosConsulta;

	}




	//************************************************************************//
//*************** SQL PARA MATRIZ DEL RESPONSABLE DEL ACTIVO *************//
//************************************************************************//

	public function mostrarFuncionarios()
	{

		$db = conectar::acceso();
		$funcionarios = [];

		$consultar_funcionarios = $db->prepare('SELECT identificacion, nombre FROM funcionarios WHERE festado=:estadoI  ORDER BY nombre');

		$consultar_funcionarios->bindValue('estadoI', '5');
		$consultar_funcionarios->execute();

		while ($listado_funcionarios = $consultar_funcionarios->fetch(PDO::FETCH_ASSOC)) {
			$funcionarios[] = $listado_funcionarios;
		}
		return $funcionarios;
	}

	//************************************************************************//
//*************** SQL PARA ACTUALIZAR LOS ACCESOS ************************//
//************************************************************************//

	public function actualizarAcceso($actualizar)
	{

		$estadoAcceso = $_POST['estadoA'];

		if ($estadoAcceso != 6) {
			$db = conectar::acceso();
			$actualizarAccesos = $db->prepare("UPDATE accesos SET tipo_acceso=:tipo_accesosA,
		usuario=:nombreUsuario, clave=:claves,estado=:estadoA, fecha_registro=:fechas
		WHERE id_acceso=:codigos");

			$actualizarAccesos->bindValue('codigos', $actualizar->getIdAcceso());
			$actualizarAccesos->bindValue('nombreUsuario', $actualizar->getUsuario());
			$actualizarAccesos->bindValue('claves', $actualizar->getClave());
			$actualizarAccesos->bindValue('fechas', $actualizar->getFechaRegistro());
			$actualizarAccesos->bindValue('tipo_accesosA', $actualizar->getTipoAcceso());
			$actualizarAccesos->bindValue('estadoA', $actualizar->getEstadosA());
			$actualizarAccesos->execute();

		} else {
			$db = conectar::acceso();
			$actualizarAccesos = $db->prepare("UPDATE accesos SET tipo_acceso=:tipo_accesosA, usuario=:nombreUsuario, clave=:claves,estado=:estadoA, fecha_registro=:fechas, fecha_inactivacion=:fechaI WHERE id_acceso=:codigos");

			$actualizarAccesos->bindValue('codigos', $actualizar->getIdAcceso());
			$actualizarAccesos->bindValue('nombreUsuario', $actualizar->getUsuario());
			$actualizarAccesos->bindValue('claves', $actualizar->getClave());
			$actualizarAccesos->bindValue('fechas', $actualizar->getFechaRegistro());
			$actualizarAccesos->bindValue('tipo_accesosA', $actualizar->getTipoAcceso());
			$actualizarAccesos->bindValue('estadoA', $actualizar->getEstadosA());
			$actualizarAccesos->bindValue('fechaI', $actualizar->getFechaInactivacion());
			$actualizarAccesos->execute();
		}


		if ($actualizarAccesos) {
			echo 1;
		} else {
			echo 0;
		}

	}

	//**********************************************************************************************//
//*************** SQL PARA ENVIAR CORREO ************************//
//**********************************************************************************************//

	public function restablecerCuentaF($restablecer)
	{
		$db = conectar::acceso();
		$validar = $db->prepare('SELECT festado,mail,intentos FROM funcionarios WHERE usuario =:user');
		$validar->bindValue('user', $restablecer->getF_usuario());
		$validar->execute();
		$filtro = $validar->fetch(PDO::FETCH_ASSOC);
		$correo = $filtro['mail'];
		$estado = $filtro['festado'];
		$intento = $filtro['intentos'];
		if ($estado == 5 || ($estado == 6 && $intento == 3)) {
			$user = $restablecer->getF_usuario();

			date_default_timezone_set('America/Bogota');
			$hoy = date('Y-m-d H:i:s');
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
				$body = "<div class='container' style='background: rgb(243,243,243);text-align: center;width: 60%;margin: 0% 14% 11%;border-bottom: 15px solid #ca0c7f;'>";
				$body .= "<div style='width: 100%;background: rgb(210, 6, 124);'>";
				$body .= "<h1 style='color:rgb(210, 6, 124);'>.</h1>";
				$body .= "</div>";
				$subject = utf8_decode($subject);
				$body = utf8_decode($body);
				$mail->Subject = $subject;                             // Set email format to HTML      
				$mail->Body = $body;
				$mail->send();

			} catch (Exception $e) {
				echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
			}
		}
	}



	public function restablecerContrasenaF($update)
	{
		$db = conectar::acceso();
		$consulta = $db->prepare('SELECT contrasena FROM funcionarios WHERE usuario=:user');
		$consulta->bindValue('user', $update->getF_usuario());
		$consulta->execute();
		$filtro = $consulta->fetch(PDO::FETCH_ASSOC);
		$contrasena = $filtro['contrasena'];
		$password = $update->getF_contrasena();
		$passwordLogin = password_verify($password, $contrasena);

		if ($passwordLogin) {

			echo 2;

		} else {
			$db = conectar::acceso();
			$modificar = $db->prepare('UPDATE funcionarios SET contrasena=:passwords,festado=:estado,intentos=:intento  WHERE usuario=:user');

			$password = password_hash($password, PASSWORD_DEFAULT, ["cost" => 15]);

			$modificar->bindValue('user', $update->getF_usuario());
			$modificar->bindValue('passwords', $password);
			$modificar->bindValue('estado', 5);
			$modificar->bindValue('intento', 0);
			$modificar->execute();

			if ($modificar) {
				echo 1;
				//echo $update->getCorreo();
			}
		}

	}
	public function consultar_todos_Funcionarios()
	{
		$db = conectar::acceso();
		$lista_funcionarios = [];
		$consultar_funcionario = $db->prepare('SELECT  identificacion, nombre, mail, area, cargo, extension, rol, usuario, contrasena, validacion FROM funcionarios');
		$consultar_funcionario->execute();

		foreach ($consultar_funcionario->fetchAll() as $listado) {
			$consulta = new Funcionario();
			$consulta->setF_identificacion($listado['identificacion']);
			$consulta->setF_nombre($listado['nombre']);
			$consulta->setF_email($listado['mail']);
			$consulta->setF_extension($listado['extension']);
			$consulta->setF_usuario($listado['usuario']);
			$consulta->setF_validacion($listado['validacion']);

			$lista_funcionarios[] = $consulta;
		}
		return $lista_funcionarios;
	}

	public function actualizar_contrasena_obligatorio($modifica)
	{

		$db = conectar::acceso();
		$list_case = array();
		$colsultar_usuario = $db->prepare('SELECT contrasena from funcionarios where usuario =:usuario');
		$colsultar_usuario->bindValue('usuario', $modifica->getF_usuario());
		$colsultar_usuario->execute();
		$row = $colsultar_usuario->fetch(PDO::FETCH_ASSOC);
		$passwordLogin = password_verify($modifica->getF_contrasena(), $row['contrasena']);
		if ($passwordLogin) {
			echo 1;
		} else {
			$password = password_hash($modifica->getF_contrasena(), PASSWORD_DEFAULT, ["cost" => 15]);
			$modificar_usuario = $db->prepare('UPDATE funcionarios SET contrasena=:contrasena, fecha_sistema = :fecha_sistema WHERE usuario=:usuario');
			$modificar_usuario->bindValue('usuario', $modifica->getF_usuario());
			$modificar_usuario->bindValue('contrasena', $password);
			date_default_timezone_set('America/Bogota');
			$modificar_usuario->bindValue('fecha_sistema', date('Y-m-d H:i:s'));
			$modificar_usuario->execute();

			/* $colsultar_usuario=$db->prepare('SELECT id_usuario from usuarios where usuario =:usuario');
				$colsultar_usuario->bindValue('usuario',$modifica->getNombre());
				$colsultar_usuario->execute();
				$filtro=$colsultar_usuario->fetch(PDO::FETCH_ASSOC);
				$id_usuario=$filtro['id_usuario'];
				 $funcion_realizada = "El usuario Realizo una Actualizacion de contraseña obligatoria";
				 $inserta_funcion=$db->prepare("INSERT INTO funciones (codigo, id_usuario, fecha_registro, funcion_realizada,IP) VALUES (0, :id_usuario , curdate() , :funcion_realizada ,:ip )");
				 $inserta_funcion->bindValue('id_usuario',$id_usuario);
				 $inserta_funcion->bindValue('funcion_realizada',$funcion_realizada);
				 $inserta_funcion->bindValue('ip', $_SERVER['REMOTE_ADDR']);                 
				 $inserta_funcion->execute();*/
			echo 2;
		}
	}

	public function creaAccesosBoveda($create)
	{
		$db = conectar::acceso();
		$user = $db->prepare("SELECT identificacion FROM funcionarios WHERE usuario=:user");
		$user->bindValue('user', $create->getF_usuario());
		$user->execute();
		$consult = $user->fetch(PDO::FETCH_ASSOC);
		$id = $consult['identificacion'];
		if ($_POST['cantidad'] != 0) {

			for ($i = 1; $i <= $_POST['cantidad']; $i++) {
				$create->setTipoAcceso($_POST['tipo_acceso' . $i]);
				$create->setUsuario($_POST['usuario' . $i]);
				$create->setClave($_POST['clave' . $i]);
				$create->setFechaRegistro($_POST['fechaRegistro' . $i]);

				$inserta_acceso = $db->prepare('INSERT INTO accesos_boveda(funcionario,tipo_acceso,usuario,clave,fecha_registro) VALUES(:funci,:tipo_acceso,:usuario,:clave,:fecha_registro)');

				$inserta_acceso->bindValue('funci', $id);
				$inserta_acceso->bindValue('tipo_acceso', $create->getTipoAcceso());
				$inserta_acceso->bindValue('usuario', $create->getUsuario());
				$inserta_acceso->bindValue('clave', $create->getClave());
				$inserta_acceso->bindValue('fecha_registro', $create->getFechaRegistro());

				$inserta_acceso->execute();
			}

		}
		echo 1;
	}


	public function detalleAccesoBoveda()
	{
		$db = conectar::acceso();
		$listadoAcceso = [];

		$user = $db->prepare("SELECT identificacion FROM funcionarios WHERE usuario=:user");
		$user->bindValue('user', $_SESSION['usuario']);
		$user->execute();
		$consult = $user->fetch(PDO::FETCH_ASSOC);
		$id = $consult['identificacion'];

		$detalleAcceso = $db->prepare('SELECT a.id_accesos_boveda,a.tipo_acceso,t.descripcion AS descripcionAccesos,a.usuario,a.clave,a.fecha_registro FROM accesos_boveda a LEFT JOIN tipos_accesos t ON t.id_accesos = a.tipo_acceso  WHERE a.funcionario=:identidad');

		$detalleAcceso->bindValue('identidad', $id);
		$detalleAcceso->execute();

		foreach ($detalleAcceso->fetchAll() as $listado) {

			$consulta = new Funcionario();
			$consulta->setIdAcceso($listado['id_accesos_boveda']);
			$consulta->setTipoAcceso($listado['tipo_acceso']);
			$consulta->setDescripcion($listado['descripcionAccesos']);
			$consulta->setUsuario($listado['usuario']);
			$consulta->setClave($listado['clave']);
			$consulta->setFechaRegistro($listado['fecha_registro']);

			$listadoAcceso[] = $consulta;

		}

		return $listadoAcceso;

	}

	public function actualizarBoveda($modify)
	{
		$db = conectar::acceso();
		$actualizarAccesos = $db->prepare("UPDATE accesos_boveda SET usuario=:nombreUsuario,fecha_registro=:fechas WHERE id_accesos_boveda=:codigos");

		$actualizarAccesos->bindValue('codigos', $modify->getIdAcceso());
		$actualizarAccesos->bindValue('nombreUsuario', $modify->getUsuario());
		$actualizarAccesos->bindValue('fechas', $modify->getFechaRegistro());
		$actualizarAccesos->execute();
		if ($actualizarAccesos) {
			echo 1;
		}
	}

	public function eliminarBoveda($delete)
	{
		$db = conectar::acceso();
		$eliminarAccesos = $db->prepare("DELETE FROM accesos_boveda WHERE id_accesos_boveda=:codigos");
		$eliminarAccesos->bindValue('codigos', $delete->getIdAcceso());
		$eliminarAccesos->execute();
		if ($eliminarAccesos) {
			echo 1;
		}
	}

	public function verBoveda($consult)
	{
		$db = conectar::acceso();

		$user = $db->prepare("SELECT contrasena FROM funcionarios WHERE usuario=:user");
		$user->bindValue('user', $consult->getUsuario());
		$user->execute();
		$consults = $user->fetch(PDO::FETCH_ASSOC);
		$id = $consults['contrasena'];

		/*$consult_passowrd=$db->prepare("SELECT clave FROM boveda WHERE funcionario=:functionary");
				 $consult_passowrd->bindValue('functionary',$id);
				 $consult_passowrd->execute();
				 $search = $consult_passowrd->fetch(PDO::FETCH_ASSOC);			
				 $claveBd = $search['clave'];*/

		$passwordLogin = password_verify($consult->getF_contrasena(), $id);

		if ($passwordLogin) {
			echo 1;
		} else {
			echo 0;
		}
	}

	public function modificarBoveda($modify)
	{
		$db = conectar::acceso();
		$actualizarAccesos = $db->prepare("UPDATE accesos_boveda SET clave=:claves WHERE id_accesos_boveda=:codigos");

		$actualizarAccesos->bindValue('codigos', $modify->getIdAcceso());
		$actualizarAccesos->bindValue('claves', $modify->getF_contrasena());
		$actualizarAccesos->execute();
		if ($actualizarAccesos) {
			echo 1;
		}
	}

	public function verificacionBoveda()
	{
		$db = conectar::acceso();

		$user = $db->prepare("SELECT identificacion FROM funcionarios WHERE usuario=:user");
		$user->bindValue('user', $_SESSION['usuario']);
		$user->execute();
		$consults = $user->fetch(PDO::FETCH_ASSOC);
		$id = $consults['identificacion'];

		$verificar = $db->prepare("SELECT id_boveda FROM boveda WHERE funcionario=:functionary");
		$verificar->bindValue('functionary', $id);
		$verificar->execute();
		$search = $verificar->rowCount();
		if ($search > 0)
			return 1;
		else
			return 0;
	}

	public function clavePrimeraBoveda($insert)
	{
		$db = conectar::acceso();
		$user = $db->prepare("SELECT identificacion FROM funcionarios WHERE usuario=:user");
		$user->bindValue('user', $insert->getF_usuario());
		$user->execute();
		$consults = $user->fetch(PDO::FETCH_ASSOC);
		$id = $consults['identificacion'];
		$password = password_hash($insert->getF_contrasena(), PASSWORD_DEFAULT, ["cost" => 15]);
		$insert_vault = $db->prepare("INSERT INTO boveda(funcionario,clave) VALUES(:functionary,:passwrd)");
		$insert_vault->bindValue('functionary', $id);
		$insert_vault->bindValue('passwrd', $password);
		$insert_vault->execute();
		echo 1;
	}


	public function detallePassword($id)
	{
		$db = conectar::acceso();

		$detalleAcceso = $db->prepare('SELECT clave FROM accesos_boveda  WHERE id_accesos_boveda=:idAccesos');
		$detalleAcceso->bindValue('idAccesos', $id->getIdAcceso());
		$detalleAcceso->execute();
		$passResult = $detalleAcceso->fetch(PDO::FETCH_ASSOC);
		$responseValue = $passResult['clave'];
		echo $responseValue;
	}


	//**********************************************************************************************//
//********************SQL PARA CONSULTAR FUNCIONARIOS INACTIVOS POR RETIRO *********************//
//**********************************************************************************************//

	public function consultarFuncionariosRetiro()
	{
		$db = conectar::acceso();
		$lista_funcionariosInactivos = [];

		$consultar_funcionarioInactivo = $db->prepare('SELECT  identificacion, nombre, mail, area, cargo, extension, rol, usuario, contrasena, funcionarios.descripcion as descripcionFinal, validacion,fecha_inactivacion, areas.descripcion AS descripcion1, cargos.descripcion AS descripcion2 FROM funcionarios LEFT JOIN areas ON id_area=area LEFT JOIN cargos ON id_cargo=cargo WHERE festado=:estadoI');

		$consultar_funcionarioInactivo->bindValue('estadoI', '16');
		$consultar_funcionarioInactivo->execute();


		foreach ($consultar_funcionarioInactivo->fetchAll() as $listado) {
			$consulta = new Funcionario();
			$consulta->setF_identificacion($listado['identificacion']);
			$consulta->setF_nombre($listado['nombre']);
			$consulta->setF_email($listado['mail']);
			$consulta->setF_area($listado['descripcion1']);
			$consulta->setF_cargo($listado['descripcion2']);
			$consulta->setF_extension($listado['extension']);
			//$consulta->setF_rol($listado['rol']);	
			$consulta->setF_usuario($listado['usuario']);
			$consulta->setF_contrasena($listado['contrasena']);
			$consulta->setF_validacion($listado['validacion']);
			$consulta->setF_fecha_inactivacion($listado['fecha_inactivacion']);
			$consulta->setDescripcionFinal($listado['descripcionFinal']);

			$lista_funcionariosInactivos[] = $consulta;
		}
		return $lista_funcionariosInactivos;
	}


	//**********************************************************************************************//
//********************* SQL PARA CONSULTAR FUNCIONARIOS INACTIVOS POR BLOQUEO ******************//
//**********************************************************************************************//

	public function consultarFuncionariosInactivosC()
	{
		$db = conectar::acceso();
		$lista_funcionariosInactivos = [];

		$consultar_funcionarioInactivo = $db->prepare('SELECT  identificacion, nombre, mail, area, cargo, extension, rol, usuario, contrasena, validacion,fecha_inactivacion, areas.descripcion AS descripcion1, cargos.descripcion AS descripcion2, funcionarios.descripcion as descripcionFinal FROM funcionarios LEFT JOIN areas ON id_area=area LEFT JOIN cargos ON id_cargo=cargo WHERE festado=:estadoI');

		$consultar_funcionarioInactivo->bindValue('estadoI', '6');
		$consultar_funcionarioInactivo->execute();


		foreach ($consultar_funcionarioInactivo->fetchAll() as $listado) {
			$consulta = new Funcionario();
			$consulta->setF_identificacion($listado['identificacion']);
			$consulta->setF_nombre($listado['nombre']);
			$consulta->setF_email($listado['mail']);
			$consulta->setF_area($listado['descripcion1']);
			$consulta->setF_cargo($listado['descripcion2']);
			$consulta->setF_extension($listado['extension']);
			//$consulta->setF_rol($listado['rol']);	
			$consulta->setF_usuario($listado['usuario']);
			$consulta->setF_contrasena($listado['contrasena']);
			$consulta->setF_validacion($listado['validacion']);
			$consulta->setF_fecha_inactivacion($listado['fecha_inactivacion']);
			$consulta->setDescripcionFinal($listado['descripcionFinal']);

			$lista_funcionariosInactivos[] = $consulta;
		}
		return $lista_funcionariosInactivos;
	}

	//**********************************************************************************************//
//*************** SQL PARA VISUALIZAR DATOS DEL FUNCIONARIO ************************************//
//**********************************************************************************************//

	public function consultarFuncionarioxUsuario($usuario)
	{
		$db = Conectar::acceso();
		$datosFuncionario = array();

		$consulta = $db->prepare("SELECT identificacion, mail, fecha_registro, nombre, mail2 FROM funcionarios WHERE usuario = :usuario");
		$consulta->bindValue('usuario', $usuario);
		$consulta->execute();


		if ($consulta) {
			foreach ($consulta->fetchAll() as $listado) {
				$funcionario = new Funcionario();
				$funcionario->setF_identificacion($listado['identificacion']);
				$funcionario->setF_email($listado['mail']);
				$funcionario->setF_email2($listado['mail2']);
				$funcionario->setFechaRegistro($listado['fecha_registro']);
				$funcionario->setF_nombre($listado['nombre']);

				$datosFuncionario[] = $funcionario;
			}
			return $datosFuncionario;
		} else {
			return 0;
		}

	}




	//**********************************************************************************************//
//******************** Consulta de datos Glovales por funcionario ******************************//
//************************** (datos,accesos,activos ********************************************//
//**********************************************************************************************//

	public function consultarDatosFuncionario($usuario)
	{
		$db = Conectar::acceso();
		$consulta = $db->prepare('SELECT identificacion,nombre,mail,C.descripcion as cargo,A.descripcion as area,DP.descripcion as departamentoInterno, CC.descripcion as centroCostos, CC.codigo as centroCodigo,festado,usuario, fecha_registro
			FROM funcionarios LEFT JOIN cargos C ON C.id_cargo = cargo
			LEFT JOIN areas A ON A.id_area = C.id_area
			LEFT JOIN departamentos_internos DP ON DP.id_departamento = A.id_departamento
			LEFT JOIN centro_de_costos CC ON CC.id_centroCostos = centro_de_costos 
			WHERE usuario = :usuario');
		$consulta->bindValue('usuario', $usuario);
		$consulta->execute();
		$registro = array();

		if ($consulta) {
			foreach ($consulta->fetchAll() as $listado) {
				$funcionario = new funcionario();
				$funcionario->setF_identificacion($listado['identificacion']);
				$funcionario->setF_nombre($listado['nombre']);
				$funcionario->setF_email($listado['mail']);
				$funcionario->setF_cargo($listado['cargo']);
				$funcionario->setF_area($listado['area']);
				$funcionario->setDepartamentoInterno($listado['departamentoInterno']);
				$funcionario->setF_usuario($listado['usuario']);
				$funcionario->setF_estado($listado['festado']);
				$funcionario->setCentroCostos($listado['centroCostos']);
				$funcionario->setClave($listado['centroCodigo']);
				$funcionario->setFechaRegistro($listado['fecha_registro']);
				$registro[] = $funcionario;
			}
		}

		return $registro;

	}

	public function eliminar_acentos($cadena)
	{

		//Reemplazamos la A y a
		$cadena = str_replace(
			array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
			array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
			$cadena
		);

		//Reemplazamos la E y e
		$cadena = str_replace(
			array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
			array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
			$cadena
		);

		//Reemplazamos la I y i
		$cadena = str_replace(
			array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
			array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
			$cadena
		);

		//Reemplazamos la O y o
		$cadena = str_replace(
			array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
			array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
			$cadena
		);

		//Reemplazamos la U y u
		$cadena = str_replace(
			array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
			array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
			$cadena
		);

		//Reemplazamos la N, n, C y c
		$cadena = str_replace(
			array('Ñ', 'ñ', 'Ç', 'ç'),
			array('N', 'n', 'C', 'c'),
			$cadena
		);

		return $cadena;
	}

	public function traerTipoValidacion($funcionario)
	{
		$db = Conectar::acceso();
		$consultar_tipoval = $db->prepare("SELECT tipo_validacion FROM funcionarios WHERE usuario=:usuario");
		$consultar_tipoval->bindValue('usuario', $funcionario->getF_usuario());
		$consultar_tipoval->execute();
		$resultado = $consultar_tipoval->fetch(PDO::FETCH_ASSOC);
		if ($resultado['tipo_validacion'] != 2) {
			echo 1;
		} else {
			echo 2;
		}
	}

	public function traerFuncionario($documento)
	{
		$db = Conectar::acceso();
		$traerFuncionario = $db->prepare("SELECT usuario FROM funcionarios WHERE identificacion=:identificacion");
		$traerFuncionario->bindValue('identificacion', $documento->getF_identificacion());
		$traerFuncionario->execute();
		$funcionarioUser = $traerFuncionario->fetch(PDO::FETCH_ASSOC);
		if ($funcionarioUser['usuario']) {
			echo $funcionarioUser['usuario'];
		} else {
			echo 2;
		}
	}

	public function cambioContrasenaFuncionario($funcionario)
	{
		$db = Conectar::acceso();
		$cambioPass = $db->prepare("UPDATE funcionarios SET contrasena=:clave, validacion=:validacion WHERE usuario=:usuario");
		$password = password_hash($funcionario->getClave(), PASSWORD_DEFAULT, ["cost" => 15]);
		$cambioPass->bindValue('clave', $password);
		$cambioPass->bindValue('validacion', '0');
		$cambioPass->bindValue('usuario', $funcionario->getF_usuario());
		$cambioPass->execute();
		$row = $cambioPass->rowCount();
		if ($row != 0) {
			echo 1;
		} else {
			echo 2;
		}
	}
}
