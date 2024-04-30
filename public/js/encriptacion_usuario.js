$('input[type="password"]').not('#contrasena').keyup(function () {
    var clave = $('#clave').val();
    var nuevaClave = $('#nuevaClave').val();
    var restringir = /^\s+|\s+$/;
    if (restringir.test(clave) || !nuevaClave || !clave) {
        $('#valida').removeClass('text-success').addClass('text-danger').text('Las contraseñas no coinciden');
        document.getElementById("guardar").disabled = true;
    } else {
        if (clave != nuevaClave) {
            $('#valida').removeClass('text-success').addClass('text-danger').text('Las contraseñas no coinciden');
            document.getElementById("guardar").disabled = true;
        } else {
            $('#valida').removeClass('text-danger').addClass('text-success').text('');
            document.getElementById("guardar").disabled = false;
        }
    }
});
