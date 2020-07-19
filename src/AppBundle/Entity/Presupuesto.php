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
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $estado;

    /**
     * @ORM\Column(type="string" , nullable= true)
     * @var string
     */
    private $contrato;

    ////////////////////////////
    ///
    /**
     * @ORM\ManyToOne(targetEntity="Empleado", inversedBy="presupuestos")
     * @var Empleado
     */
    private $empleado;

    /**
     * @ORM\OneToMany(targetEntity="ContenidoPresupuesto",mappedBy="presupuesto")
     * @var ContenidoPresupuesto[]
     */
    private $contenido;

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
     * @return Presupuesto
     */
    public function setEmpleado($empleado)
    {
        $this->empleado = $empleado;
        return $this;
    }

    /**
     * @return ContenidoPresupuesto[]
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * @param ContenidoPresupuesto[] $contenido
     * @return Presupuesto
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;
        return $this;
    }

    /**
     * @return string
     */
    public function getContrato()
    {
        return $this->contrato;
    }

    /**
     * @param string $contrato
     * @return Presupuesto
     */
    public function setContrato($contrato)
    {
        $this->contrato = $contrato;
        return $this;
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
     * @return Presupuesto
     */
    public function setEstado(bool $estado)
    {
        $this->estado = $estado;
        return $this;
    }






}