$(document).ready(function () {
  $("#gestionar_citas").click(function () {
    $("#contenido").load("app/view/gestionar_citas.php");
  });

  $("#administracion_citas").click(function () {
    $("#contenido").load("app/view/administracion_citas.php");
  });

  $("#atencion_citas").click(function () {
    $("#contenido").load("app/view/atencion_citas.php");
  });
});
