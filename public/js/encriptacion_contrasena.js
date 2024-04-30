$('input[type="password"]').not('#contrasena').keyup(function () {
    var contrasena = $('#contrasena').val();
    var nuevaContrasena = $('#nuevaContrasena').val();
    var restringir = /^\s+|\s+$/;
    if (restringir.test(contrasena) || !nuevaContrasena || !contrasena) {
        $('#valida').removeClass('text-success').addClass('text-danger').text('Las contraseñas no coinciden');
        document.getElementById("guardar").disabled = true;
    } else {
        if (contrasena != nuevaContrasena) {
            $('#valida').removeClass('text-success').addClass('text-danger').text('Las contraseñas no coinciden');
            document.getElementById("guardar").disabled = true;
        } else {
            $('#valida').removeClass('text-danger').addClass('text-success').text('');
            document.getElementById("guardar").disabled = false;
        }
    }
});
