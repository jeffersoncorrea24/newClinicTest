<!--- Ventana modal para ingresar la clave y mostrar la contraseña del tipo de acceso creado en la boveda --->
<div class="modal fade mt-4" id="claveInicial" tabindex="-1" role="dialog" aria-labelledby="claveInicial" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Ingrese la clave de la bovedamm</h6>
                <button class="close" data-dismiss="modal" id="btn-cancelarVerificacion1" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <form id="form-pass" >                                
                                <div class="form-group">
                                    <div>
                                        <label for="">Clave</label>
                                    </div>
                                    <div>
                                        <input type="hidden" id="idacceso" name="idacceso" class="idacceso">
                                        <input type="password" id="claveBoveda" name="claveBoveda" class="form-control info" required>
                                    </div>
                                </div>                                                              
                              
                                <div class="modal-footer">
                                    <button type="button" id="btn-cancelarVerificacion" class="btn btn-secondary btn-sm"  data-dismiss="modal">Cancelar</button>
                                    <?php if(sizeof($consultaAccesosBoveda) != 0): ?>
                                        <button type="button" class="btn btn-primary btn-sm" id="btn-verificarClave" >Aceptar</button>                                    
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
