<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>NEW CLINIC TEST</title>
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/login.css" media="screen" type="text/css">
    <link rel="stylesheet" href="public/css/contenido.css?n=1" media="screen" type="text/css">
    <link rel="icon" type="image/png" href="public/img/ico.png" />

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
    <?php if(isset($_GET['cty6Dd54'] )!= 1 && isset($_GET['cty6Dd54'] )!= 2): ?>
    <div class="modal fade" id="importante" tabindex="-1" role="dialog" aria-labelledby="basicModal" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-md">
           <div class="modal-content">
                <div class="modal-header">        
                    <h6>¡IMPORTANTE!</h6>
                </div>
                <div class="modal-body">  
                <p>El ingreso a la plataforma es solo para usuarios autorizados, se solicita no suministrar los datos de acceso a terceros.</p>                
                </div>   
                <div class="modal-footer" style="">
                    <input type="button" style=" " value="Continuar" id="alerta" name="alerta" class=" btn btn-primary alerta" >       
                 </div>                
            </div>
        </div>
    </div>

     <?php endif; ?>     

         <div id="medidas"></div>
        <div class="row align-items-center">
            <div class="col-md-4 mt-1 offset-2">
                <img src="public/img/www.png" alt="">
            </div>
            <div class="col-md-6 mt-5" id="formulario">
                <form class="form-group" action="app/controller/control_usuario.php" method="post">
                    <div class="form-group"><input type="text" class="form-control" placeholder="Usuario" id="usuario" name="usuario" required autofocus autocomplete="off"></div>
                    <div class="form-group"><input type="password" class="form-control" placeholder="Contrase&ntilde;a" id="clave" name="clave" required></div>                                      
                    <div style="margin-bottom: 2%">
                        <a href="app/view/correo_contraseña.php">¿Olvido su contrase&ntilde;a?</a>
                    </div>            
                    <input type="submit" class="btn btn-info" value="Ingresar" id="ingresar" name="ingresar">
                </form>
            </div>
        </div>
        <?php if(isset($_GET['cty6Dd54']) && $_GET['cty6Dd54'] == 2): ?>
        <div id="invalido">
             <p>Su cuenta ha sido bloqueada, por favor restablezca contraseña</p>
       </div>          
    
      <?php endif; ?>
    </div>
    <script src="public/js/jquery-3.3.1.min.js"></script>
    <script src="public/js/popper.js"></script>
    <script src="public/js/bootstrap.min.js"></script>
    <script src="public/js/live.js"></script>
    <script src="public/js/bloqueoTeclas.js"></script>
</body>

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
