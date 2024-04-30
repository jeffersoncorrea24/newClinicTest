$('input[type="password"]').not('#contrasenas').keyup(function() {
    var clave = $('#contrasena').val();
    var confirma = $('#contrasena-validar').val();

    var regExPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&_.])[A-Za-z\d$@$!%*?&_.]{8,10}/
    var restringir = /^\s+|\s+$/

    if (!regExPattern.test(clave)) {

        document.getElementById("valida-div").style.display = "block";
        $('#valida').removeClass('text-success').addClass('text-info').text('La contraseña debe incluir mayúsculas,minúsculas,caracteres y números.Debe tener como mínimo 10 caracteres.');
        document.getElementById("restablecer-cuenta").disabled = true;

    } else if (restringir.test(clave) || !confirma || !clave) {

        document.getElementById("valida-div").style.display = "block";
        $('#valida').removeClass('text-success').addClass('text-info').text('Las contraseñas no coinciden');
        document.getElementById("restablecer-cuenta").disabled = true;

    } else if (clave != confirma) {

        document.getElementById("valida-div").style.display = "block";
        $('#valida').removeClass('text-success').addClass('text-info').text('Las contraseñas no coinciden');
        document.getElementById("restablecer-cuenta").disabled = true;

    } else {

        document.getElementById("valida-div").style.display = "none";
        $('#valida').removeClass('text-success').addClass('text-success').text('');
        document.getElementById("restablecer-cuenta").disabled = false;
    }


});