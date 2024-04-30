<div class="modal fade bd-example-modal-sm" id="datos-usuario" tabindex="-1" role="dialog" aria-labelledby="datos-usuario" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Modificar Contraseña</h6>
                <button class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <form action="app/controller/actualizar_contrasena.php" method="post" class="form-group">
                                <div class="row">
                                    <div class="col-12 mt-1"><label for="">Usuario</label>
                                    </div>
                                    <div class="col-12"><input type="text" id="usuario" name="usuario" placeholder="<?php echo $_SESSION['usuario']?>" class="crea_data form-control" readonly></div>
                                </div>
                                
                                <!-- -----------valida  la contraseña actual para posterior modificacion -->
                                <div class="row" id="ValidarcontrasenaActualU-Div">
                                    <div class="col-12 mt-1">
                                        <label for="">Contrase&ntilde;a Actual</label>
                                    </div>
                                    <div class="col-12">
                                        <input type="password" id="contrasenaActualU" name="contrasenaActualU" class="form-control" maxlength="45" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="mt-2" id="validaU"></label>
                                    </div>
                                </div>
                                <input type="button" value="Continuar" id="validarContrasenaActualU" name="validarContrasenaActualU" class="mt-4 btn btn-primary btn-sm btn-cambiar_contrasena" disabled> 
                                <!-- ----------------------------------------------------------------------- -->

                                <div id="continuarActualizacionU" style="display:none;"> <!-- se avilita si la contraseña es correcta -->
                                <div class="row">
                                    <div class="col-12 mt-1">
                                        <label for="">Nueva Contrase&ntilde;a</label></div>
                                    <div class="col-12"><input type="password" id="clave" name="clave" class="crea_data form-control" maxlength="20" required></div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-1">
                                        <label for="">Confirmar Contrase&ntilde;a</label>
                                    </div>
                                    <div class="col-12">
                                        <input type="password" id="confirma" name="confirma" class="crea_data form-control" maxlength="20" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="mt-2" id="valida"></label>
                                    </div>
                                    <div class="col-12" id="valida-div" style="width: 22%;text-align: center;float: right;margin: 5% 12% -1% -10%;   border: 1px solid #d9007f;padding: 13px;border-radius: 16px;box-shadow: 0px 0px 5px #bfbfbf;display: none; position: relative;left: 10%;">
                                    <label class="mt-2" id="valida2" style="color: #000000!important;font-weight: 100;"></label>
                                   </div>      
                                </div>

                                <input type="submit" value="Guardar" id="enviar" name="enviar" class="mt-4 btn btn-primary btn-sm btn-guardar" disabled>
                                </div>
                            </form>
                            
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
