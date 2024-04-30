/****************** Citas Sin agendar ********************/
function realizarConsultaxEspecialista() {
  var requestData = {
    especialista: 1,
    actions: "citas_agendas_especialista",
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
  const tablaResultados = document.getElementById(
    "tablaResultadosBusquedaxEspecialista"
  );
  tablaResultados.innerHTML = "";

  citas.forEach((cita, index) => {
    const fila = `
          <tr>
              <td>${cita.codigo_cita}</td>
              <td>${cita.afiliado}</td>
              <td>${cita.fecha_cita}</td>
              <td>${cita.hora_cita}</td>
              <td>
                <button 
                    id="btnAtender" 
                    class="btn btn-primary" 
                    type="button" 
                    data-param1=${cita.codigo_cita}
                    data-param2=${cita.fecha_cita}
                    data-param3=${cita.hora_cita}
                    data-param4=${cita.especialidad_cita}
                    data-param5=${cita.afiliado}
                    onclick="modalAtenderCita(event)"
                >
                    Atender cita
                </button>
            </td>
          </tr>
      `;
    tablaResultados.innerHTML += fila;
  });
}

/***** Modal de Agendamiento de cita *****/
function modalAtenderCita(event) {
  document.getElementById("modal-content").innerHTML = "";
  const param1 = event.target.getAttribute("data-param1");
  const param2 = event.target.getAttribute("data-param2");
  const param3 = event.target.getAttribute("data-param3");
  const param4 = event.target.getAttribute("data-param4");
  const param5 = event.target.getAttribute("data-param5");

  document.getElementById("modal-content").innerHTML = `
  <form>
  <fieldset disabled>
      <div class="row">
          <div class="form-group col-4">
              <label for="codigo_cita_atendida">Codigo Cita</label>
                      <input type="text" id="codigo_cita_atendida" class="form-control"
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
                      <label for="paciente">Doctor</label>
                      <input type="text" id="paciente" class="form-control"
                          placeholder="No hay Información" value="${param5}">
                  </div>
              </div>
          </fieldset>
                <div class="row">
                  <div class="form-group">
                      <label for="observaciones_cita_atendida">Observaciones de la Cita</label>
                      <textarea class="form-control" id="observaciones_cita_atendida" rows="3"></textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group">
                      <label for="conclusiones_cita_atendida">Conclusiones de la Cita</label>
                      <textarea class="form-control" id="conclusiones_cita_atendida" rows="3"></textarea>
                  </div>
                </div>
      </form>`;
  $("#modalAtenderCita").modal("show");
}

function guardarCambiosCitaAtendida() {
  $("#exampleModal").modal("hide");
  let codigo_cita = document.getElementById("codigo_cita_atendida").value;
  let observaciones_cita = document.getElementById("observaciones_cita_atendida").value;
  let conclusiones_cita = document.getElementById("conclusiones_cita_atendida").value;
  
  document.getElementById("modal-content").innerHTML = "";
  var requestData = {
    codigo_cita: codigo_cita,
    observaciones: observaciones_cita,
    conclusiones: conclusiones_cita,
    actions: "finalizar_cita",
  };

  $.ajax({
    url: "app/controller/citas_controlador.php",
    method: "POST",
    data: requestData,
  }).done(function (data) {
    data > 0
      ? alertSuccess("Cita se finalizo con exito")
      : alertDanger("La cita ya no se puede finalizar");
  });
}

function alertSuccess(tittle) {
  $.smkAlert({
    text: tittle,
    type: "success",
  });
  setInterval(window.location.reload(), 5000);
}

function alertDanger(tittle) {
  $.smkAlert({
    text: tittle,
    type: "danger",
  });
}
