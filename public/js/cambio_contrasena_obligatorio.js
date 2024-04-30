$('#enviar').click(function(){
		var datosUsuario = 'usuario='+$('#usuario').val()+
		'&clave='+$('#clave').val()+
		'&enviar=1';
		$.ajax({ 
			type: 'POST',
			url: '../controller/cambio_contrasena_obligatorio.php',
			data: datosUsuario
		}).done(function(data){
			if (data==1){
			 $.smkAlert({
					text: 'Esta contraseña no puede ser la misma que tiene actualmente',
					type: 'warning'
				});
			}else if (data == 2) {
			window.location="../../dashboard.php";
			}
		});
});