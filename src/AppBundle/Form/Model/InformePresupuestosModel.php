<?php


namespace AppBundle\Form\Model;


class InformePresupuestosModel
{
    /**
     * @var \DateTime
     */
    private $fechaInicial;

    /**
     * @var \DateTime
     */
    private $fechaFinal;


    /**
     * @return \DateTime
     */
    public function getFechaInicial()
    {
        return $this->fechaInicial;
    }

    /**
     * @param \DateTime $fechaInicial
     */
    public function setFechaInicial(\DateTime $fechaInicial)
    {
        $this->fechaInicial = $fechaInicial;
    }

    /**
     * @return \DateTime
     */
    public function getFechaFinal()
    {
        return $this->fechaFinal;
    }

    /**
     * @param \DateTime $fechaFinal
     */
    public function setFechaFinal(\DateTime $fechaFinal)
    {
        $this->fechaFinal = $fechaFinal;
    }

}