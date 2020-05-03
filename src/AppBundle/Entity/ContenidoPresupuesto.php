<?php


namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="contenido_presupuesto")
 */
class ContenidoPresupuesto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $cantidad;
    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $total;

    ////////////////////////////

    /**
     * @ORM\ManyToOne(targetEntity="Producto")
     * @var Producto
     */
    private $producto;

    /**
     * @ORM\ManyToOne(targetEntity="Presupuesto",inversedBy="contenido")
     * @var Presupuesto
     */
    private $presupuesto;

    ///////////////////////////


    /**
     * @return int
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param int $cantidad
     * @return ContenidoPresupuesto
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param float $total
     * @return ContenidoPresupuesto
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return Producto
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * @param Producto $producto
     * @return ContenidoPresupuesto
     */
    public function setProducto($producto)
    {
        $this->producto = $producto;
        return $this;
    }

    /**
     * @return Presupuesto
     */
    public function getPresupuesto()
    {
        return $this->presupuesto;
    }

    /**
     * @param Presupuesto $presupuesto
     * @return ContenidoPresupuesto
     */
    public function setPresupuesto($presupuesto)
    {
        $this->presupuesto = $presupuesto;
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