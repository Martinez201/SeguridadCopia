<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var \DateTime
     */
    private $fecha;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $observaciones;
    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $estado;

    //RELACIONES

    /**
     * @ORM\OneToMany(targetEntity="Cliente", mappedBy="partes")
     * @var Cliente;
     */
    private $cliente;

//GETTERS Y SETTERS

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



}