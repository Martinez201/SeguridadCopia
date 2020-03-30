<?php


namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="delegacion")
 */
class Delegacion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $nombre;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $provincia;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $direccion;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $cPostal;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $ciudad;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $telefono;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $email;
/////////////////////////////////////////
    /**
     * @ORM\OneToMany(targetEntity="Parte", mappedBy="delegacion")
     * @var Parte[]
     */
    private $partes;

    /**
     * @ORM\OneToMany(targetEntity="Empleado",mappedBy="delegacion")
     * @var Empleado[]
     */
    private $empleados;
///////////////////////////////////////
    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     * @return Delegacion
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return string
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * @param string $provincia
     * @return Delegacion
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;
        return $this;
    }

    /**
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param string $direccion
     * @return Delegacion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
        return $this;
    }

    /**
     * @return string
     */
    public function getCPostal()
    {
        return $this->cPostal;
    }

    /**
     * @param string $cPostal
     * @return Delegacion
     */
    public function setCPostal($cPostal)
    {
        $this->cPostal = $cPostal;
        return $this;
    }

    /**
     * @return string
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * @param string $ciudad
     * @return Delegacion
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param string $telefono
     * @return Delegacion
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Delegacion
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * @return Parte[]
     */
    public function getPartes()
    {
        return $this->partes;
    }

    /**
     * @param Parte[] $partes
     * @return Delegacion
     */
    public function setPartes($partes)
    {
        $this->partes = $partes;
        return $this;
    }

    /**
     * @return Empleado[]
     */
    public function getEmpleados()
    {
        return $this->empleados;
    }

    /**
     * @param Empleado[] $empleados
     * @return Delegacion
     */
    public function setEmpleados($empleados)
    {
        $this->empleados = $empleados;
        return $this;
    }






}