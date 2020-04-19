<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="parte")
 */
class Parte
{
///ATRIBUTOS
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
     * @Assert\Length(min=10,max=150)
     * @var string
     */
    private $observaciones;
    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $estado;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $tipo;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $detalle;

    /////////////////RELACIONES//////////////////////////////////

    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="partes")
     * @var Cliente;
     */
    private $cliente;

    /**
     * @ORM\ManyToOne(targetEntity="Delegacion", inversedBy="partes")
     * @var Delegacion
     */
    private $delegacion;

    /**
     * @ORM\ManyToOne(targetEntity="Empleado" , inversedBy="partes")
     * @var Empleado
     */
    private $empleado;

//GETTERS Y SETTERS////////////////////////////////////////////////

    /**
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param \DateTime $fecha
     * @return Parte
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
        return $this;
    }

    /**
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * @param string $observaciones
     * @return Parte
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
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
     * @return Parte
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
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
     * @return Parte
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
        return $this;
    }



    /**
     * @return Delegacion
     */
    public function getDelegacion()
    {
        return $this->delegacion;
    }

    /**
     * @param Delegacion $delegacion
     * @return Parte
     */
    public function setDelegacion($delegacion)
    {
        $this->delegacion = $delegacion;
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
     * @return Parte
     */
    public function setEmpleado($empleado)
    {
        $this->empleado = $empleado;
        return $this;
    }

    /**
     * @return int
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param int $tipo
     * @return Parte
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * @return string
     */
    public function getDetalle()
    {
        return $this->detalle;
    }

    /**
     * @param string $detalle
     * @return Parte
     */
    public function setDetalle($detalle)
    {
        $this->detalle = $detalle;
        return $this;
    }



}