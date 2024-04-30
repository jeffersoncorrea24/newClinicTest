$('#crearUsuario').click(function(){
	if( $('#formularioUsuarios').smkValidate()) {
		var datosUsuario = 'usuario='+$('#usuario').val()+
		'&contrasena='+$('#contrasena').val()+
		'&id_roles='+$('#id_roles').val()+
		'&correo='+$('#correo').val()+
		'&crear=1';

		$.ajax({
			type: 'POST',
			url: '../controller/control_crea_usuario.php',
			data: datosUsuario
		}).done(function(data){
			if (data==1){
				$.smkAlert({
					text: 'Usuario Creado Con Exito',
					type: 'success'
				});
				$('#formularioUsuarios').smkClear();
			}else if (data == 3) {
				$.smkAlert({
					text: 'EL usuario ya existe',
					type: 'warning'
				});
			}else{
				$.smkAlert({
					text: 'error',
					type: 'danger'
				});
			}
		});

	}
});