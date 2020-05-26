<?php


namespace AppBundle\Form\Model;


class InformeEmpleadosModel
{
    /**
     * @var int
     */
    private $delegacion;

    /**
     * @return int
     */
    public function getDelegacion()
    {
        return $this->delegacion;
    }

    /**
     * @param int $delegacion
     * @return informeEmpleadosModel
     */
    public function setDelegacion($delegacion)
    {
        $this->delegacion = $delegacion;
        return $this;
    }



}