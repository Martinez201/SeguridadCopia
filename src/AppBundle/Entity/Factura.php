<?php


namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="factura")
 */
class Factura
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;
    /**
     * @ORM\Column(type="date")
     * @var \DateTime
     */
    private $fecha;
    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $precioConIva;
    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $precioSinIva;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $concepto;

    ///////////////////////



    ///////////////////////

    /**
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param \DateTime $fecha
     * @return Factura
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrecioConIva()
    {
        return $this->precioConIva;
    }

    /**
     * @param float $precioConIva
     * @return Factura
     */
    public function setPrecioConIva($precioConIva)
    {
        $this->precioConIva = $precioConIva;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrecioSinIva()
    {
        return $this->precioSinIva;
    }

    /**
     * @param float $precioSinIva
     * @return Factura
     */
    public function setPrecioSinIva($precioSinIva)
    {
        $this->precioSinIva = $precioSinIva;
        return $this;
    }

    /**
     * @return string
     */
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * @param string $concepto
     * @return Factura
     */
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }



}