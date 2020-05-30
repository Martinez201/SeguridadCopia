<?php


namespace AppBundle\Form\Model;


class CambioClaveRecoveryModel
{
    /**
     * @var string
     */
    private $nuevaClave;


    /**
     * @return string
     */
    public function getNuevaClave()
    {
        return $this->nuevaClave;
    }

    /**
     * @param string $nuevaClave
     * @return CambioClave
     */
    public function setNuevaClave($nuevaClave)
    {
        $this->nuevaClave = $nuevaClave;
    }


}