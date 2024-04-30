<?php
       if(!isset($_SESSION['usuario']) || ($_SESSION['id_roles']!=1 && $_SESSION['id_roles']!=7)){
        header('location:../../login.php');
            }
?>
   <div class="modal fade bd-example-modal-sm" id="crear-usuario" tabindex="-1" role="dialog" aria-labelledby="crear-usuario" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Crear Usuario</h6>
                <button class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <form action="app/controller/control_crea_usuario.php" method="post" class="form-group" id="formularioUsuarios">
                                <div class="row">
                                    <div class="col-12 mt-1"><label for="">Usuario</label>
                                    </div>
                                    <div class="col-12"><input type="text" id="usuario" name="usuario"  class="crea_data form-control" autofocus required autocomplete="off"></div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-1">
                                        <label for="">Contrase&ntilde;a</label></div>
                                    <div class="col-12"><input type="password" id="contrasena" name="contrasena" class="crea_data form-control" maxlength="20" required autocomplete="off"></div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-1">
                                        <label for="">Rol</label></div>
                                    <div class="col-12"><select class="custom-select" name="id_roles" id="id_roles" required>
                                            <option value=""></option>
                                            <?php

                                                        foreach($matriz_roles as $rol){
                                                        echo "<option value='".$rol["id_roles"]."'>".$rol["descripcion"] ."</option>" ;
 
                                                          }  

                                                        ?>
                                        </select></div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-1">
                                        <label for="">Correo</label>
                                    </div>
                                    <div class="col-12">
                                        <input type="email" id="correo" name="correo" class="crea_data form-control" maxlength="60" required autocomplete="off">
                                    </div>
                                    
                                </div>
                                <input type="hidden" id="usuario_sesion" name="usuario_sesion" value="<?php echo $_SESSION['usuario'] ?>">
                                <input type="submit" value="Crear" id="crearUsuario" name="crearUsuario" class="mt-4 btn btn-primary btn-sm btn-guardar">
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>