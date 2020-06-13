<?php


namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Monolog\Handler\IFTTTHandler;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="empleado")
 */
class Empleado implements UserInterface
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
     * @Assert\NotBlank()
     * @Assert\Length(min=3,max=50)
     * @var string
     */
    private $nombre;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min=3,max=50)
     * @var string
     */
    private $apellidos;
    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(min=9,max=12)
     * @var string
     */
    private $dni;
    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     * @Assert\Date
     * @var \DateTime
     */
    private $edad;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min=5,max=15)
     * @var string
     */
    private $telefono;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min=3,max=30)
     * @var string
     */
    private $ciudad;
    /**
     * @ORM\Column(type="string")
     * @Assert\Length(min=5,max=9)
     * @Assert\NotBlank()
     * @var string
     */
    private $cPostal;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min=3,max=30)
     * @var string
     */
    private $provincia;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min=10,max=40)
     * @var string
     */
    private $email;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min=10,max=50)
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

    /**
     * @ORM\Column(type="string",nullable=true)
     * @var string
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(min=5,max="20")
     * @var string
     */
    private $usuario;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min=5)
     * @var string
     */
    private $clave;

    /**
     * @ORM\Column(type="string", nullable= true)
     * @var string
     */
    private $token;

    /**
     * @ORM\Column(type="string", nullable= true)
     * @var string
     */
    private $tokenType;

    /**
     * @ORM\Column(type="datetime", nullable= true)
     * @var \DateTime
     */
    private $ExpireToken;

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

    /**
     * @ORM\OneToMany(targetEntity="Factura",mappedBy="empleado")
     * @var Factura[]
     */
private $facturasEmitidas;

    /**
     * @ORM\OneToMany(targetEntity="Presupuesto",mappedBy="empleado")
     * @var Presupuesto[]
     */
private $presupuestos;

    /**
     * @ORM\OneToMany(targetEntity="Albaran", mappedBy="empleado")
     * @var Albaran[]
     */
private $albaranes;

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

    /**
     * @return Factura[]
     */
    public function getFacturasEmitidas()
    {
        return $this->facturasEmitidas;
    }

    /**
     * @param Factura[] $facturasEmitidas
     * @return Empleado
     */
    public function setFacturasEmitidas($facturasEmitidas)
    {
        $this->facturasEmitidas = $facturasEmitidas;
        return $this;
    }

    /**
     * @return Presupuesto[]
     */
    public function getPresupuestos()
    {
        return $this->presupuestos;
    }

    /**
     * @param Presupuesto[] $presupuestos
     * @return Empleado
     */
    public function setPresupuestos($presupuestos)
    {
        $this->presupuestos = $presupuestos;
        return $this;
    }

    /**
     * @return Albaran[]
     */
    public function getAlbaranes()
    {
        return $this->albaranes;
    }

    /**
     * @param Albaran[] $albaranes
     * @return Empleado
     */
    public function setAlbaranes($albaranes)
    {
        $this->albaranes = $albaranes;
        return $this;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     * @return Empleado
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
        return $this;
    }

    public function __toString()
    {
        return $this->getNombre()." ".$this->getApellidos();
    }

    /**
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param string $usuario
     * @return Empleado
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
        return $this;
    }

    /**
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * @param string $clave
     * @return Empleado
     */
    public function setClave($clave)
    {
        $this->clave = $clave;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return Empleado
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }

    /**
     * @param string $tokenType
     * @return Empleado
     */
    public function setTokenType($tokenType)
    {
        $this->tokenType = $tokenType;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpireToken()
    {
        return $this->ExpireToken;
    }

    /**
     * @param \DateTime $ExpireToken
     * @return Empleado
     */
    public function setExpireToken($ExpireToken)
    {
        $this->ExpireToken = $ExpireToken;
        return $this;
    }





    public function getRoles()
    {
        $roles = ['ROLE_USER'];

       if ($this->isAdministrador()){

           $roles[] = 'ROLE_ADMINISTRADOR';

       }

       if($this->isComercial()){

           $roles[] = 'ROLE_COMERCIAL';
       }

       if($this->isGestor()){

           $roles[] = 'ROLE_GESTOR';

       }

       if($this->isInstalador()){

           $roles[] = 'ROLE_INSTALADOR';
       }

       return $roles;
    }

    public function getPassword()
    {
        return $this->getClave();
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        return $this->getUsuario();
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}