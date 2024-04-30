/******************** Crear Cita *************************/
(() => {
    "use strict";
    const forms = document.querySelectorAll(".needs-validation-form");
    Array.from(forms).forEach((form) => {
      form.addEventListener(
        "submit",
        (event) => {
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
          } else {
            crearCita();
          }
          form.classList.add("was-validated");
        },
        false
      );
    });
  })();
  
  function crearCita() {
    const especialidad = document.getElementById("validationCustom01").value;
    const doctor = document.getElementById("validationCustom02").value;
    const hora = document.getElementById("validationCustom03").value;
    const fechaInput = document.getElementById("validationCustom04").value;
    const sede = document.getElementById("validationCustom05").value;

    const fecha = new Date(fechaInput);
    fecha.setDate(fecha.getDate() + 1);
    const formattedFecha =
      fecha.getFullYear() +
      "-" +
      ("0" + (fecha.getMonth() + 1)).slice(-2) +
      "-" +
      ("0" + fecha.getDate()).slice(-2);
  
    var requestData = {
      fecha: formattedFecha,
      especialidad: especialidad,
      doctor:doctor,
      hora:hora,
      sede:sede,
      actions: "crear_cita",
    };
  
    $.ajax({
      url: "app/controller/citas_controlador.php",
      method: "POST",
      data: requestData,
      success: function (response) {
        limpiarCampos();
        response > 0
      ? alertSuccess("Cita creada exitosamente.")
      : alertDanger("No fue posible crear la cita");
      },
      error: function (xhr, status, error) {
        console.error(error);
      },
    });
  }
  
  function alertWarning($message) {
    $.smkAlert({
      text: $message,
      type: "warning",
    });
  }

  function alertSuccess($message) {
    $.smkAlert({
      text: $message,
      type: "success",
    });
  }

  function limpiarCampos(){
    $('.needs-validation-form').trigger("reset");
  }

/****************** Citas Sin agendar ********************/
function realizarConsulta() {
  
    var requestData = {
      actions: "citas_sin _agendar",
    };
  
    $.ajax({
      url: "app/controller/citas_controlador.php",
      method: "POST",
      data: requestData,
      dataType: "json",
    
    success: function (response) {
        response !== null && response.length > 0
          ? mostrarResultados(response)
          : alertWarning();
      },
      error: function (xhr, status, error) {
        console.error(error);
      },
    });
  }
  
  function alertWarning() {
    $.smkAlert({
      text: "No existen Citas disponibles a la fecha",
      type: "warning",
    });
  }
  
  function mostrarResultados(citas) {
    const tablaResultados = document.getElementById("tablaResultadosBusqueda");
    tablaResultados.innerHTML = "";
  
    citas.forEach((cita, index) => {
      const fila = `
          <tr>
              <td>${cita.codigo_cita}</td>
              <td>${cita.especialista_cita}</td>
              <td>${cita.fecha_cita}</td>
              <td>${cita.hora_cita}</td>
          </tr>
      `;
      tablaResultados.innerHTML += fila;
    });
  }