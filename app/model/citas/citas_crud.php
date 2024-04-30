<?php
require_once ('../model/vinculo.php');
class Citas_crud
{
    public function agendarCita($cita)
    {

        $db = Conectar::acceso();
        $update = $db->prepare('UPDATE citas SET afiliado=:afiliado, estado_cita=:estado_cita WHERE codigo_cita=:id AND estado_cita=:estado');
        $update->bindValue('estado_cita',2);
        $update->bindValue('id', $cita->getCodigoCita());
        $update->bindValue('afiliado', $cita->getAfiliado());
        $update->bindValue('estado', 1);
        $update->execute();
        
        $numFilasActualizadas = $update->rowCount();
        echo $numFilasActualizadas > 0 ? 1 : 0;
    }

    public function finalizarCita($cita)
    {

        $db = Conectar::acceso();
        $update = $db->prepare('UPDATE citas SET observaciones_cita=:observaciones, conclusiones_cita=:conclusiones, estado_cita=:estado_cita WHERE codigo_cita=:id');
        $update->bindValue('estado_cita',3);
        $update->bindValue('id', $cita->getCodigoCita());
        $update->bindValue('observaciones', $cita->getObservacionesCita());
        $update->bindValue('conclusiones', $cita->getConclusionesCita());
        $update->execute();
        
        $numFilasActualizadas = $update->rowCount();
        echo $numFilasActualizadas > 0 ? 1 : 0;
    }

    public function crearCita($cita)
    {
        $db = Conectar::acceso();
        $create = $db->prepare('INSERT INTO citas(especialista_cita, fecha_cita, hora_cita, especialidad_cita, estado_cita, sede_cita)
        VALUES(:doctor, :fecha, :hora, :especialidad, :estado, :sede)');
        $create->bindValue('doctor',$cita->getEspecialistaCita());
        $create->bindValue('fecha', $cita->getFechaCita());
        $create->bindValue('hora', $cita->getHoraCita());
        $create->bindValue('especialidad', $cita->getEspecialidadCita());
        $create->bindValue('estado', 1);
        $create->bindValue('sede', $cita->getSedeCita());
        $create->execute();
        
        $numFilasActualizadas = $create->rowCount();
        echo $numFilasActualizadas > 0 ? 1 : 0;
    }

    public function consultarCitasSinAgendar($data)
    {

        $db = Conectar::acceso();
        $consultAll = $db->prepare('SELECT * FROM citas WHERE fecha_cita=:fecha AND especialidad_cita=:especialidad AND estado_cita=:estado');
        $consultAll->bindValue('estado', 1);
        $consultAll->bindValue('fecha', $data->getFechaCita());
        $consultAll->bindValue('especialidad', $data->getEspecialidadCita());
        $consultAll->execute();

        $results = $consultAll->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($results);

    }

    public function consultaCitasAgendadasxEspecialista($especialista)
    {
        $db = Conectar::acceso();
        $consultAll = $db->prepare('SELECT * FROM citas WHERE estado_cita=:estado AND especialista_cita=:especialista ORDER BY fecha_cita ASC, hora_cita ASC ');
        $consultAll->bindValue('estado', 2);
        $consultAll->bindValue('especialista', $especialista->getEspecialistaCita());
        $consultAll->execute();

        $results = $consultAll->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($results);
    }

    public function consultarCitasSinAgendarGeneral()
    {

        $db = Conectar::acceso();
        $consultAll = $db->prepare('SELECT * FROM citas WHERE estado_cita=:estado');
        $consultAll->bindValue('estado', 1);
        $consultAll->execute();

        $results = $consultAll->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($results);

    }

    public function consultarCitasPorUsuario($afiliado)
    {

        $db = Conectar::acceso();
        $consult = $db->prepare('SELECT * FROM citas WHERE afiliado=:afiliado AND estado_cita=:estado');
        $consult->bindValue('estado', 2);
        $consult->bindValue('afiliado', $afiliado->getAfiliado());
        $consult->execute();

        $results = $consult->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($results);

    }

    public function cancelarCita($cita){
        $db = Conectar::acceso();
        $update = $db->prepare('UPDATE citas SET afiliado=:afiliado, estado_cita=:estado_cita WHERE codigo_cita=:id AND estado_cita=:estado');
        $update->bindValue('estado_cita',1);
        $update->bindValue('id', $cita->getCodigoCita());
        $update->bindValue('afiliado', null);
        $update->bindValue('estado', 2);
        $update->execute();
        
        $numFilasActualizadas = $update->rowCount();
        echo $numFilasActualizadas > 0 ? 1 : 0;
    }
}
?>