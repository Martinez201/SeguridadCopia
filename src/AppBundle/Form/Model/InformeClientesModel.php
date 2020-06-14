<?php


namespace AppBundle\Form\Model;


class InformeClientesModel
{
    /**
     * @var bool
     */
    private $estado;

    /**
     * @return bool
     */
    public function isEstado()
    {
        return $this->estado;
    }

    /**
     * @param bool $estado
     */
    public function setEstado(bool $estado)
    {
        $this->estado = $estado;
    }


}