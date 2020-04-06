<?php


namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="albaran")
 */
class Albaran
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
     * @ORM\Column(type="string")
     * @var string
     */
    private $proveedor;

    ///////////////////////
    /**
     * @ORM\ManyToOne(targetEntity="Empleado", inversedBy="albaranes")
     * @var Empleado
     */
    private $empleado;

    /**
     * @ORM\OneToMany(targetEntity="ContenidoAlbaran",mappedBy="albaran")
     * @var ContenidoAlbaran[]
     */
    private $contenido;

    //////////////////////
    ///
    /**
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param \DateTime $fecha
     * @return Albaran
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
        return $this;
    }

    /**
     * @return string
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }

    /**
     * @param string $proveedor
     * @return Albaran
     */
    public function setProveedor($proveedor)
    {
        $this->proveedor = $proveedor;
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
     * @return Empleado
     */
    public function getEmpleado()
    {
        return $this->empleado;
    }

    /**
     * @param Empleado $empleado
     * @return Albaran
     */
    public function setEmpleado($empleado)
    {
        $this->empleado = $empleado;
        return $this;
    }

    /**
     * @return ContenidoAlbaran[]
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * @param ContenidoAlbaran[] $contenido
     * @return Albaran
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;
        return $this;
    }




}