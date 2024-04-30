

<!DOCTYPE html>
<html lang="es" style="background: #b1b1b1">

 <?php
       session_start();
        if(!isset($_SESSION['usuario'])|| empty($_SESSION['usuario'])){
        header('location:../../login.php');
            }
            ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>NEW CLINIC TEST</title>
    <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/dashboard.css" media="screen" type="text/css">
    <link rel="stylesheet" href="../../public/css/daterangepicker.css" media="screen" type="text/css">
    <link rel="icon" type="image/png" href="../../public/img/ico.png" />
</head>

<body>
    <header class="container-fluid">
        <div class="row" style="background: #00000045">
            <div class="col-md-10 align-self-center">
                <img src="../../public/img/logo.png" alt="">
            </div>
            <div class="col-md-2 col d-flex justify-content-end">
                <a href="#" data-toggle="modal" data-target="#datos-usuario" data-backdrop="static"><img src="../../public/img/configura.png" alt=""></a>
                <a href="#"><img src="../../public/img/salir.png" alt=""></a>
            </div>

        </div>
    </header>

        <div class="modal-body" style="background: #00000045">
                <div class="container-fluid">
                    
                                            <div class="row" style="margin: 0% 32%">
                                                <div class="col-12 mt-2" style="text-align: center; background: #f1f0f0; border-radius: 40px; padding: 20px 0px; box-shadow: 0px 0px 20px #8a8888; border: 1px solid #de3b9b;">
                                                    <form action="../../app/controller/encriptar_contrasena.php" method="post" class="form-group">

                                                        <div class="row">
                                                         <div class="col-12">
                                                           <p style="text-align: center; width: 74%; margin: 1% 0% 4% 13%;">Para iniciar sesión tendrá que actualizar la información de su cuenta, en este momento se le solicita que actualice su Contraseña de Seguridad.</p>
                                                        </div> 

                                                       </div>

                                                    <div class="row">
                                                        <div class="col-12 mt-1">
                                                          <label for="" style="font-weight: bold;">Nueva contraseña</label>
                                                            <div><input type="password" name="contrasena" id="contrasena" class="crea_data" maxlength="29" autocomplete="off" autofocus style="border-radius:  5px; padding: 3px 4px;
                                                                margin: 1px 0px 10px 0px;" ></div>
                                                        </div>
                                                    </div>


                                                     <div class="row">
                                                          <div class="col-12 mt-1">
                                                           <label for="" style="font-weight: bold;">Confirmación de Contrasena</label>
                                                             <div><input type="password" name="nuevaContrasena" id="nuevaContrasena" class="crea_data" maxlength="29" autocomplete="off" autofocus required style="border-radius:  5px; padding: 3px 4px;">
                                                        </div>
                                                    </div>


                                                         <div class="col-12">
                                                        <label class="mt-2" id="valida"></label>
                                                        </div>
                                                        </div>
                                                       
                                                            <input type=submit value="Guardar" id="guardar" name="guardar" class="mt-2 btn btn-primary btn-guardar" disabled>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

  

   
    <script src="../../public/js/moment.min.js"></script>
    <script src="../../public/js/daterangepicker.js"></script>
    <script src="../../public/js/popper.js"></script>
    <script src="../../public/js/bootstrap.min.js"></script>
    <script src="../../public/js/jquery-3.3.1.min.js"></script>
    <script src="../../public/js/encriptacion_contrasena.js"></script>
    <script src="../../public/js/bloqueoTeclas.js"></script>

</body>
</html>