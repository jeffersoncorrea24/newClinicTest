<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="public/css/contenido.css" media="screen" type="text/css">
    <link rel="icon" type="image/png" href="../../public/img/ico.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <?php
    ini_set("session.cookie_lifetime", "18000");
    ini_set("session.gc_maxlifetime", "18000");

    session_start();

    if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {

        header('location:../../login.php');
    }

    ?>
</head>

<body>
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            /* 3 columnas de tamaño igual */
            grid-gap: 10px;
            /* Espacio entre celdas */
        }

        .item {
            border: 1px solid #ccc;
            padding: 20px;
            text-align: center;
        }
    </style>
    <div class="card">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">

                <button class="nav-link active" id="nav-schedulling-tab" data-bs-toggle="tab"
                    data-bs-target="#appointment-scheduling" type="button" role="tab" aria-controls="nav-schedulling"
                    aria-selected="true">Agendar Cita</button>
                <button class="nav-link " id="nav-calendar-tab" data-bs-toggle="tab"
                    data-bs-target="#appointment-calendar" type="button" role="tab" aria-controls="nav-calendar"
                    aria-selected="true" onclick="obtenerData()">Citas Agendadas</button>
            </div>
        </nav>
        <div id="contenido">
            <div class="tab-content" id="nav-tabContent">
                <section class="tab-pane fade show active" id="appointment-scheduling" role="tabpanel"
                    aria-labelledby="nav-schedulling-tab" tabindex="0">
                    <article>
                        <form class="row needs-validation" novalidate>
                            <div class="row">
                                <div class="col-4">
                                    <label for="validationCustom04" class="form-label">Especialidad</label>
                                    <select class="form-select" id="validationCustom04" required>
                                        <option selected disabled value="">Seleccione especialidad</option>
                                        <option value="1">Medicina General</option>
                                        <option value="2">Cardiologia</option>
                                        <option value="3">Optometria</option>
                                        <option value="4">Fisioterapia</option>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please select a valid specialty.
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="validationCustom01" class="form-label">Fecha</label>
                                    <input type="date" class="form-control" id="validationCustom01" value="Mark"
                                        required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please select a valid date.
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <button class="btn btn-primary" type="submit">Consultar Citas</button>
                            </div>
                        </form>
                    </article>

                    <article>
                        <div class="row mt-4">
                            <div class="col">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre del Especialista</th>
                                            <th>Fecha de Cita</th>
                                            <th>Hora de Cita</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablaResultados">
                                        <!-- Aquí se insertarán los resultados -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </article>
                </section>

                <section class="tab-pane fade " id="appointment-calendar" role="tabpanel"
                    aria-labelledby="nav-calendar-tab" tabindex="0">
                    <article class="grid-container" id="citas-container">

                    </article>
                </section>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmación de Agendamiento</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modal-content">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarCambios()">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <script>


    </script>
    <script src="public/js/gestionar_citas.js"></script>
</body>

</html>