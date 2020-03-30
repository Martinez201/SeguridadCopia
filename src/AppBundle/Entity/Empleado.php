<?php


namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="empleado")
 */
class Empleado
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
    private $apellidos;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $dni;
    /**
     * @ORM\Column(type="date")
     * @var \DateTime
     */
    private $edad;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $telefono;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $ciudad;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $cPostal;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $provincia;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $email;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $direccion;
    /**
     * @ORM\Column(type="boolean")
     * @var  bool
     */
    private $Administrador;
    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $instalador;
    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $gestor;
    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $comercial;

////////////////////////////////////
    /**
     * @ORM\ManyToOne(targetEntity="Delegacion",inversedBy="empleados")
     * @var Delegacion
     */
private $delegacion;

    /**
     * @ORM\OneToMany(targetEntity="Parte", mappedBy="empleado")
     * @var Parte[]
     */

private $partes;


///////////////////////////////////
    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     * @return Empleado
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param string $apellidos
     * @return Empleado
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
        return $this;
    }

    /**
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * @param string $dni
     * @return Empleado
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * @param \DateTime $edad
     * @return Empleado
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;
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
     * @return Empleado
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
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
     * @return Empleado
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;
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
     * @return Empleado
     */
    public function setCPostal($cPostal)
    {
        $this->cPostal = $cPostal;
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
     * @return Empleado
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;
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
     * @return Empleado
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * @return Empleado
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAdministrador()
    {
        return $this->Administrador;
    }

    /**
     * @param bool $Administrador
     * @return Empleado
     */
    public function setAdministrador($Administrador)
    {
        $this->Administrador = $Administrador;
        return $this;
    }

    /**
     * @return bool
     */
    public function isInstalador()
    {
        return $this->instalador;
    }

    /**
     * @param bool $instalador
     * @return Empleado
     */
    public function setInstalador($instalador)
    {
        $this->instalador = $instalador;
        return $this;
    }

    /**
     * @return bool
     */
    public function isGestor()
    {
        return $this->gestor;
    }

    /**
     * @param bool $gestor
     * @return Empleado
     */
    public function setGestor($gestor)
    {
        $this->gestor = $gestor;
        return $this;
    }

    /**
     * @return bool
     */
    public function isComercial()
    {
        return $this->comercial;
    }

    /**
     * @param bool $comercial
     * @return Empleado
     */
    public function setComercial($comercial)
    {
        $this->comercial = $comercial;
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
     * @return Delegacion
     */
    public function getDelegacion()
    {
        return $this->delegacion;
    }

    /**
     * @param Delegacion $delegacion
     * @return Empleado
     */
    public function setDelegacion($delegacion)
    {
        $this->delegacion = $delegacion;
        return $this;
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
     * @return Empleado
     */
    public function setPartes($partes)
    {
        $this->partes = $partes;
        return $this;
    }





}