<?php


namespace AppBundle\Form\Model;


class InformePartesModel
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
     * @var bool
     */

    private $estado;

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

    /**
     * @return bool
     */
    public function isEstado()
    {
        return $this->estado;
    }

    /**
     * @param bool $estado
     */
    public function setEstado(bool $estado)
    {
        $this->estado = $estado;
    }


}