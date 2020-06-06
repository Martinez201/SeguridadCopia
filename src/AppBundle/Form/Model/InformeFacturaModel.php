<?php


namespace AppBundle\Form\Model;


class InformeFacturaModel
{
    /**
     * @var \DateTime
     */
    private $fechaPrincipio;
    /**
     * @var \DateTime
     */
    private $fechaFinal;

    /**
     * @var string
     */
    private $cliente;

    /**
     * @return \DateTime
     */
    public function getFechaPrincipio()
    {
        return $this->fechaPrincipio;
    }

    /**
     * @param \DateTime $fechaPrincipio
     * @return InformeFacturaModel
     */
    public function setFechaPrincipio(\DateTime $fechaPrincipio)
    {
        $this->fechaPrincipio = $fechaPrincipio;
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
     * @return InformeFacturaModel
     */
    public function setFechaFinal(\DateTime $fechaFinal)
    {
        $this->fechaFinal = $fechaFinal;
        return $this;
    }

    /**
     * @return string
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * @param string $cliente
     * @return InformeFacturaModel
     */
    public function setCliente(string $cliente)
    {
        $this->cliente = $cliente;
        return $this;
    }



}