<?php
class Citas
{
    private $codigo_cita;
    private $especialista_cita;
    private $fecha_cita;
    private $hora_cita;
    private $especialidad_cita;
    private $estado_cita;
    private $afiliado;
    private $sede_cita;
    private $observaciones_cita;
    private $conclusiones_cita;

    public function getCodigoCita()
    {
        return $this->codigo_cita;
    }

    public function setCodigoCita($codigo_cita): self
    {
        $this->codigo_cita = $codigo_cita;

        return $this;
    }

    public function getEspecialistaCita()
    {
        return $this->especialista_cita;
    }

    public function setEspecialistaCita($especialista_cita): self
    {
        $this->especialista_cita = $especialista_cita;

        return $this;
    }

    public function getFechaCita()
    {
        return $this->fecha_cita;
    }

    public function setFechaCita($fecha_cita): self
    {
        $this->fecha_cita = $fecha_cita;

        return $this;
    }

    public function getHoraCita()
    {
        return $this->hora_cita;
    }

    public function setHoraCita($hora_cita): self
    {
        $this->hora_cita = $hora_cita;

        return $this;
    }

    public function getEspecialidadCita()
    {
        return $this->especialidad_cita;
    }

    public function setEspecialidadCita($especialidad_cita): self
    {
        $this->especialidad_cita = $especialidad_cita;

        return $this;
    }

    public function getEstadoCita()
    {
        return $this->estado_cita;
    }

    public function setEstadoCita($estado_cita): self
    {
        $this->estado_cita = $estado_cita;

        return $this;
    }

    public function getAfiliado()
    {
        return $this->afiliado;
    }

    public function setAfiliado($afiliado): self
    {
        $this->afiliado = $afiliado;

        return $this;
    }

    public function getSedeCita()
    {
        return $this->sede_cita;
    }

    public function setSedeCita($sede_cita): self
    {
        $this->sede_cita = $sede_cita;

        return $this;
    }

    public function getObservacionesCita()
    {
        return $this->observaciones_cita;
    }

    public function setObservacionesCita($observaciones_cita): self
    {
        $this->observaciones_cita = $observaciones_cita;

        return $this;
    }

    public function getConclusionesCita()
    {
        return $this->conclusiones_cita;
    }

    public function setConclusionesCita($conclusiones_cita): self
    {
        $this->conclusiones_cita = $conclusiones_cita;

        return $this;
    }
}
?>