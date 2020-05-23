<?php


namespace AppBundle\Form\Model;


use Doctrine\ORM\Mapping as ORM;

class SepaModel
{

    /**
     * @var \DateTime
     */
    private $fechaInicial;

    /**
     * @var \DateTime
     */
    private  $fechaFinal;

    /**
     * @return \DateTime
     */
    public function getFechaInicial()
    {
        return $this->fechaInicial;
    }

    /**
     * @param \DateTime $fechaInicial
     * @return SepaModel
     */
    public function setFechaInicial($fechaInicial)
    {
        $this->fechaInicial = $fechaInicial;
        return $this;
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
     * @return SepaModel
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fechaFinal = $fechaFinal;
        return $this;
    }




}