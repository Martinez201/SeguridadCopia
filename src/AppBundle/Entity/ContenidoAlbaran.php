<?php


namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="contenido_albaran")
 */
class ContenidoAlbaran
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
     * @Assert\NotBlank()
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
     * @ORM\ManyToOne(targetEntity="Albaran",inversedBy="contenido")
     * @var Albaran
     */
    private $albaran;

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
     * @return ContenidoAlbaran
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
     * @return ContenidoAlbaran
     */
    public function setTotal($total)
    {
        $this->total = $total;
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
     * @return Producto
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * @param Producto $producto
     * @return ContenidoAlbaran
     */
    public function setProducto($producto)
    {
        $this->producto = $producto;
        return $this;
    }

    /**
     * @return Albaran
     */
    public function getAlbaran()
    {
        return $this->albaran;
    }

    /**
     * @param Albaran $albaran
     * @return ContenidoAlbaran
     */
    public function setAlbaran($albaran)
    {
        $this->albaran = $albaran;
        return $this;
    }


}