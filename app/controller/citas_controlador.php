<?php
require_once ("../model/citas/citas.php");
require_once ("../model/citas/citas_crud.php");

$entidad = new Citas();
$crud = new Citas_crud();

if (isset($_POST['actions'])) {
    switch ($_POST['actions']) {
        case 'cancelar_cita':
            $entidad->setCodigoCita($_POST['id_cita']);
            $crud->cancelarCita($entidad);
            break;

        case 'asignar_cita':
            $entidad->setAfiliado($_POST['codigo_afiliado']);
            $entidad->setCodigoCita($_POST['codigo_cita']);
            $crud->agendarCita($entidad);
            break;

        case 'finalizar_cita':
            $entidad->setCodigoCita($_POST['codigo_cita']);
            $entidad->setObservacionesCita($_POST['observaciones']);
            $entidad->setConclusionesCita($_POST['conclusiones']);
            $crud->finalizarCita($entidad);
            break;

        case 'citas_agendadas':
            $entidad->setAfiliado($_POST['identificacion']);
            $jsonResponse = $crud->consultarCitasPorUsuario($entidad);
            header('Content-Type: application/json');
            echo $jsonResponse;
            break;

        case 'agenda_disponible':
            $entidad->setFechaCita($_POST['fecha']);
            $entidad->setEspecialidadCita($_POST['especialidad']);
            $jsonResponse = $crud->consultarCitasSinAgendar($entidad);
            header('Content-Type: application/json');
            echo $jsonResponse;
            break;

        case 'crear_cita':
            $entidad->setFechaCita($_POST['fecha']);
            $entidad->setEspecialidadCita($_POST['especialidad']);
            $entidad->setEspecialistaCita($_POST['doctor']);
            $entidad->setHoraCita($_POST['hora']);
            $entidad->setSedeCita($_POST['sede']);
            $crud->crearCita($entidad);
            break;

        case 'citas_sin _agendar':
            $jsonResponse = $crud->consultarCitasSinAgendarGeneral();
            header('Content-Type: application/json');
            echo $jsonResponse;
            break;

        case 'citas_agendas_especialista':
            $entidad->setEspecialistaCita($_POST['especialista']);
            $jsonResponse = $crud->consultaCitasAgendadasxEspecialista($entidad);
            header('Content-Type: application/json');
            echo $jsonResponse;
            break;
        default:

            break;
    }
}

?>