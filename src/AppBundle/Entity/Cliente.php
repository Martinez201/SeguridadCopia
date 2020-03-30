<?php


namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cliente")
 */
class Cliente
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
    private $fechaNacimiento;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $direccion;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $CPostal;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $ciudad;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $provincia;
    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $estado;
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
//////////////////////////////////////////////////////////////////
    /**
     * @ORM\ManyToOne(targetEntity="Parte",inversedBy="cliente")
     * @var Parte[]
     */
    private $partes;

    /**
     * @ORM\OneToMany(targetEntity="Factura",mappedBy="cliente")
     * @var Factura[]
     */
    private $facturas;
////////////////////////////////////////////////////////////////
    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     * @return Cliente
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
     * @return Cliente
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
     * @return Cliente
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * @param \DateTime $fechaNacimiento
     * @return Cliente
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;
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
     * @return Cliente
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
        return $this->CPostal;
    }

    /**
     * @param string $CPostal
     * @return Cliente
     */
    public function setCPostal($CPostal)
    {
        $this->CPostal = $CPostal;
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
     * @return Cliente
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;
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
     * @return Cliente
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;
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
     * @return Cliente
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
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
     * @return Cliente
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
     * @return Cliente
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
     * @return Cliente
     */
    public function setPartes($partes)
    {
        $this->partes = $partes;
        return $this;
    }

    /**
     * @return Factura[]
     */
    public function getFacturas()
    {
        return $this->facturas;
    }

    /**
     * @param Factura[] $facturas
     * @return Cliente
     */
    public function setFacturas($facturas)
    {
        $this->facturas = $facturas;
        return $this;
    }



}