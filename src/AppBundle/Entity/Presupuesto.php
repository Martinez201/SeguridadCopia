<?php


namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="presupuesto")
 */
class Presupuesto
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
     * @Assert\NotBlank()
     * @Assert\Date
     * @var \DateTime
     */
    private $fecha;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min=10,max=50)
     * @var string
     */
    private $instalacion;
    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @var float
     */
    private $precioSinIva;
    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @var float
     */
    private $precioConIva;

    ////////////////////////////

    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="presupuestos")
     * @var Cliente
     */
    private $cliente;

    /**
     * @ORM\ManyToOne(targetEntity="Empleado", inversedBy="presupuestos")
     * @var Empleado
     */
    private $empleado;

    /**
     * @ORM\ManyToMany(targetEntity="Producto")
     * @var Producto[]
     */
    private $productos;

    //////////////////////////

    /**
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param \DateTime $fecha
     * @return Presupuesto
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
        return $this;
    }

    /**
     * @return string
     */
    public function getInstalacion()
    {
        return $this->instalacion;
    }

    /**
     * @param string $instalacion
     * @return Presupuesto
     */
    public function setInstalacion($instalacion)
    {
        $this->instalacion = $instalacion;
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
     * @return Presupuesto
     */
    public function setPrecioSinIva($precioSinIva)
    {
        $this->precioSinIva = $precioSinIva;
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
     * @return Presupuesto
     */
    public function setPrecioConIva($precioConIva)
    {
        $this->precioConIva = $precioConIva;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * @param Cliente $cliente
     * @return Presupuesto
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
        return $this;
    }

    /**
     * @return Empleado
     */
    public function getEmpleado()
    {
        return $this->empleado;
    }

    /**
     * @param Empleado $empleado
     * @return Presupuesto
     */
    public function setEmpleado($empleado)
    {
        $this->empleado = $empleado;
        return $this;
    }

    /**
     * @return Producto[]
     */
    public function getProductos()
    {
        return $this->productos;
    }

    /**
     * @param Producto[] $productos
     * @return Presupuesto
     */
    public function setProductos($productos)
    {
        $this->productos = $productos;
        return $this;
    }




}