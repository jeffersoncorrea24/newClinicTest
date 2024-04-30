<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>NEW CLINIC TEST</title>
    <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/login.css" media="screen" type="text/css">
    <link rel="stylesheet" href="../../public/css/contenido.css?n=1" media="screen" type="text/css">
    <link rel="stylesheet" href="../../public/css/smoke.min.css" media="screen" type="text/css">
    <link rel="icon" type="image/png" href="../../public/img/ico.png" />

</head>

<style type="text/css">
    #importante .modal-content {
       border-radius: 20px;
    }

    #importante .modal-header {
        padding: 17px 0px 6px 190px;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
    }

    #importante .modal-footer {
        padding: 23px;
    }

    #importante input {
        background: #e6007e !important;
        border-color:#e6007e !important; 
    }

    #medidas {
        float: right;
        width: 13%;
        margin: 2% 17% 0% -16%;
    }


</style>

<body>

    <div class="modal fade" id="importante" tabindex="-1" role="dialog" aria-labelledby="basicModal" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-md">
           <div class="modal-content">
                <div class="modal-header">        
                    <h6>¡IMPORTANTE!</h6>
                </div>
                <div class="modal-body">  
                <p>señor usuario por su seguridad la plataforma le solicita cambio de contraseña nuevamente, le informamos que este proceso se realizara trimestralmente por su seguiridad y que no se puede ingresar la anterior
                contraseña ya que el programa restringe el regitro de una clave anterior.</p>                
                </div>   
                <div class="modal-footer" style="">
                    <input type="button" style=" " value="Continuar" id="alerta" name="alerta" class=" btn btn-primary alerta" >       
                 </div>                
            </div>
        </div>
    </div>  

    <div id="medidas"></div>
        <div class="row align-items-center">
            <div class="col-md-4 mt-1 offset-2">
                <img src="../../public/img/www.png" alt="">
            </div>
            <div class="col-md-6 mt-5" id="formulario">
                <form class="form-group" action="../controller/cambio_contrasena_obligatorio.php" method="post">
                    <div class="form-group"><input type="password" class="form-control" placeholder="Contrase&ntilde;a" id="clave" name="clave" required autofocus autocomplete="off"></div>
                    <div class="form-group"><input type="password" class="form-control" placeholder="Confirmar Contrase&ntilde;a" id="confirma" name="confirma" required>
                    </div>          
                    <div class="col-12">
                        <label class="mt-2" id="valida"></label>
                     </div>
                     <div class="col-12" id="valida-div" style="width: 53%;text-align: center;float: right;margin: 5% 12% -1% -10%;   border: 1px solid #d9007f;padding: 33px;border-radius: 16px;box-shadow: 0px 0px 5px #bfbfbf;display: none; position: relative;left: 10%;">
                                    <label class="mt-2" id="valida2" style="color: #000000!important;font-weight: 100;"></label>
                                   </div>  
                    <input type="button" class="btn btn-info" value="Guardar" id="enviar" name="enviar">
                </form>
            </div>
        </div>
    </div>
    <script src="../../public/js/jquery-3.3.1.min.js"></script>
    <script src="../../public/js/popper.js"></script>
    <script src="../../public/js/bootstrap.min.js"></script>
    <script src="../../public/js/live.js"></script>
</body>
     <script src="../../public/js/valida_usuario.js?ff"></script>
     <script src="../../public/js/cambio_contrasena_obligatorio.js"></script>
     <script src="../../public/js/smoke.min.js"></script>
     <script src="../../public/js/bloqueoTeclas.js"></script>
</html>

<script>
   $(document).ready(function()
   {
      $("#importante").modal("show");
      $("#alerta").on('click',function(){        
      $("#importante").modal("hide");
      });
   });   
</script>
