/****** Validación del formulario y ejecución de la consulta *****/
(() => {
  "use strict";

  const forms = document.querySelectorAll(".needs-validation");

  Array.from(forms).forEach((form) => {
    form.addEventListener(
      "submit",
      (event) => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        } else {
          realizarConsulta();
        }
        form.classList.add("was-validated");
      },
      false
    );
  });
})();

function realizarConsulta() {
  const especialidad = document.getElementById("validationCustom04").value;
  const fechaInput = document.getElementById("validationCustom01").value;

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
    actions: "agenda_disponible",
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
    text: "No existen Citas disponibles en la fecha seleccionada",
    type: "warning",
  });
}

function mostrarResultados(citas) {
  const tablaResultados = document.getElementById("tablaResultados");
  tablaResultados.innerHTML = "";

  citas.forEach((cita, index) => {
    const fila = `
        <tr>
            <td>${cita.codigo_cita}</td>
            <td>${cita.especialista_cita}</td>
            <td>${cita.fecha_cita}</td>
            <td>${cita.hora_cita}</td>
            <td>
                <button 
                    id="btnAgendar" 
                    class="btn btn-primary" 
                    type="button" 
                    data-param1=${cita.codigo_cita}
                    data-param2=${cita.fecha_cita}
                    data-param3=${cita.hora_cita}
                    data-param4=${cita.especialidad_cita}
                    data-param5=${cita.especialista_cita}
                    onclick="abrirModal(event)"
                >
                    Agendar cita
                </button>
            </td>
        </tr>
    `;
    tablaResultados.innerHTML += fila;
  });
}

/***** Modal de Agendamiento de cita *****/
function abrirModal(event) {
  document.getElementById("modal-content").innerHTML = "";
  const param1 = event.target.getAttribute("data-param1");
  const param2 = event.target.getAttribute("data-param2");
  const param3 = event.target.getAttribute("data-param3");
  const param4 = event.target.getAttribute("data-param4");
  const param5 = event.target.getAttribute("data-param5");
  const param6 =
    "¡Para confirmar el agendamiento de la cita medica por favor de clic en el boton aceptar!";

  document.getElementById("modal-content").innerHTML = `<form>
                    <fieldset disabled>
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="codigo_cita">Codigo Cita</label>
                                        <input type="text" id="codigo_cita" class="form-control"
                                            placeholder="No hay Información" value="${param1}">
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="fecha_cita">Fecha</label>
                                        <input type="text" id="fecha_cita" class="form-control"
                                            placeholder="No hay Información" value="${param2}">
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="hora_cita">Hora</label>
                                        <input type="text" id="hora_cita" class="form-control"
                                            placeholder="No hay Información" value="${param3}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="especialidad">Especialidad</label>
                                        <input type="text" id="especialidad" class="form-control"
                                            placeholder="No hay Información" value="${param4}">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="doctor">Doctor</label>
                                        <input type="text" id="doctor" class="form-control"
                                            placeholder="No hay Información" value="${param5}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="observaciones">Observaciones</label>
                                        <p class="form-control">${param6}</p>
                                    </div>
                                </div>
                            </fieldset>
                        </form>`;
  $("#exampleModal").modal("show");
}

function guardarCambios() {
  $("#exampleModal").modal("hide");
  let codigo_cita = document.getElementById("codigo_cita").value;
  let codigo_afiliado = 12345;
  document.getElementById("modal-content").innerHTML = "";

  var requestData = {
    codigo_cita: codigo_cita,
    codigo_afiliado: codigo_afiliado,
    actions: "asignar_cita",
  };

  $.ajax({
    url: "app/controller/citas_controlador.php",
    method: "POST",
    data: requestData,
  }).done(function (data) {
    data > 0
      ? alertSuccess("Cita Agendada con exito")
      : alertDanger("La cita ya no se encuentra disponible");
  });
}

function alertSuccess(tittle) {
  
    $.smkAlert({
      text: tittle,
      type: "success",
    });
  setInterval(window.location.reload(),5000);
}

function alertDanger(tittle) {
  $.smkAlert({
    text: tittle,
    type: "danger",
  });
}

document.addEventListener("DOMContentLoaded", function () {
  obtenerData();
});

/****** Citas agendadas por el usuario *****/
function obtenerData() {
  const citasContainer = document.getElementById("citas-container");
  citasContainer.innerHTML = "";

  var requestData = {
    identificacion: 12345,
    actions: "citas_agendadas",
  };

  $.ajax({
    url: "app/controller/citas_controlador.php",
    method: "POST",
    data: requestData,
    dataType: "json",
    success: function (response) {
      muestraCard(response);
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });

  function muestraCard(citas_agendadas) {
    citas_agendadas.forEach((cita) => {
      const tarjeta = document.createElement("div");
      tarjeta.classList.add("cita");
      tarjeta.innerHTML = `
                    <div class="card border-success ">
                        <div class="card-header bg-transparent border-success"><h5>${cita.especialidad_cita} Especialidad <h5></div>
                        <div class="card-body text-success">
                            <p>ID: ${cita.codigo_cita}</p>
                            <p>Especialista: ${cita.especialista_cita}</p>
                            <p>Fecha: ${cita.fecha_cita}</p>
                            <p>Hora: ${cita.hora_cita}</p>
                        </div>
                        <div class="card-footer bg-transparent border-success">
                          <button class="btn btn-danger" type="button" onClick=cancelarCita(${cita.codigo_cita})>
                            Cancelar Cita
                          </button>
                        </div>
                    </div>
            `;
      citasContainer.appendChild(tarjeta);
    });
  }
}

function cancelarCita(id_cita) {
  var requestData = {
    id_cita: id_cita,
    actions: "cancelar_cita",
  };

  $.ajax({
    url: "app/controller/citas_controlador.php",
    method: "POST",
    data: requestData,
  }).done(function (data) {
    data > 0
      ? alertSuccess("Su cita a sido Cancelada")
      : alertDanger("No es posible cancelar su cita");
  });
}
