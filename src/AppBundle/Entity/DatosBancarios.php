<?php


namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="datos_bancarios")
 */
class DatosBancarios
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
     * @Assert\Iban()
     * @var string
     */
    private $iban;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min=3,max=10)
     * @var string
     */
    private $moneda;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min=3,max=50)
     * @var string
     */
    private $entidad;
    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @var int
     */
    private $sucursal;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Bic()
     * @var string
     */
    private $bic;

    /**
     * @return string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * @param string $iban
     * @return DatosBancarios
     */
    public function setIban($iban)
    {
        $this->iban = $iban;
        return $this;
    }

    /**
     * @return string
     */
    public function getMoneda()
    {
        return $this->moneda;
    }

    /**
     * @param string $moneda
     * @return DatosBancarios
     */
    public function setMoneda($moneda)
    {
        $this->moneda = $moneda;
        return $this;
    }

    /**
     * @return string
     */
    public function getEntidad()
    {
        return $this->entidad;
    }

    /**
     * @param string $entidad
     * @return DatosBancarios
     */
    public function setEntidad($entidad)
    {
        $this->entidad = $entidad;
        return $this;
    }

    /**
     * @return int
     */
    public function getSucursal()
    {
        return $this->sucursal;
    }

    /**
     * @param int $sucursal
     * @return DatosBancarios
     */
    public function setSucursal($sucursal)
    {
        $this->sucursal = $sucursal;
        return $this;
    }

    /**
     * @return string
     */
    public function getBic()
    {
        return $this->bic;
    }

    /**
     * @param string $bic
     * @return DatosBancarios
     */
    public function setBic($bic)
    {
        $this->bic = $bic;
        return $this;
    }

///////

    /**
     * @ORM\OneToOne(targetEntity="Cliente", inversedBy="datosBancarios")
     * @var Cliente
     */
        private $cliente;

    /**
     * @return Cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * @param Cliente $cliente
     * @return DatosBancarios
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
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