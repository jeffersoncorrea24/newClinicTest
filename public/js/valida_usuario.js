$('input[type="password"]').not('#contrasena' && '#contrasenaActualU').keyup(function () {
    var clave = $('#clave').val();
    var confirma = $('#confirma').val();
    var regExPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,10}/
    var restringir = /^\s+|\s+$/

   if (!regExPattern.test(clave)) {

        document.getElementById("valida-div").style.display = "block";
        $('#valida2').removeClass('text-success').addClass('text-info').text('La contraseña debe incluir mayúsculas,minúsculas,caracteres y números.Debe tener como mínimo 10 caracteres.');
        document.getElementById("enviar").disabled = true;

    }else if (restringir.test(clave) || !confirma || !clave) {
        document.getElementById("valida-div").style.display = "none";
    $('#valida2').removeClass('text-danger').addClass('text-success').text('');
        $('#valida').removeClass('text-success').addClass('text-danger').text('Las contraseñas no coinciden');
        document.getElementById("enviar").disabled = true;

    } else if (clave != confirma) {
    document.getElementById("valida-div").style.display = "none";
    $('#valida2').removeClass('text-danger').addClass('text-success').text('');
    $('#valida').removeClass('text-success').addClass('text-danger').text('Las contraseñas no coinciden');
            document.getElementById("enviar").disabled = true;

    } else {
    document.getElementById("valida-div").style.display = "none";
    $('#valida2').removeClass('text-danger').addClass('text-success').text('');
    $('#valida').removeClass('text-danger').addClass('text-success').text('');
     document.getElementById("enviar").disabled = false;
     
    }
    
});


$('#contrasenaActualU').keyup(function(){
    var contrasenaActual = $('#contrasenaActualU').val();

    if(contrasenaActual != ''){
        document.getElementById("validarContrasenaActualU").disabled = false;
    }else{
        document.getElementById("validarContrasenaActualU").disabled = true;
    }
})

$('#validarContrasenaActualU').click(function(){
    var contrasenaActual = $('#contrasenaActualU').val();
        var validar = new FormData();
        validar.append('clave',contrasenaActual);
        validar.append('verificarContrasena','1');
        $('#validaU').removeClass('text-danger').addClass('text-secondary').text('procesando...');
        $.ajax({
            type: 'POST',
            url: 'app/controller/actualizar_contrasena.php',
            data: validar,
            processData: false,
            contentType: false,
        }).done(function(data){
            if(data == 1){
                $('#ValidarcontrasenaActualU-Div').css('display','none');
                $('#validarContrasenaActualU').css('display','none');
                $('#continuarActualizacionU').css('display','block');
            }else{
                $('#validaU').removeClass('text-secondary').addClass('text-danger').text('Contraseña Incorrecta');
            }
        })

})
