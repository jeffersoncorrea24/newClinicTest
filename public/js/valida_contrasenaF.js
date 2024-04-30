$('#restablecer-cuenta').click(function(){
       
		var datosClave = 'contrasena='+$('#contrasena').val()+
		'&usuario='+$('#usuario').val()+				
		'&validar_contrasenaF=1';

		$.ajax({
			type: 'POST',
			url: '../controller/controlador_funcionarios.php',
			data: datosClave

		}).done(function(data){
			if (data==1){
			window.location="../../login_peticiones.php";			
			}else if (data == 2) {
			location.reload();
			}else{
				$.smkAlert({
					text: 'error',
					type: 'danger'
				});
			}
		});
});