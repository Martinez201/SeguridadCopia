<?php


namespace AppBundle\Form\Model;


class MensajeModel
{
    /**
     * @var string
     */
    private $asunto;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $mensaje;

    /**
     * @return string
     */
    public function getAsunto()
    {
        return $this->asunto;
    }

    /**
     * @param string $asunto
     * @return MensajeModel
     */
    public function setAsunto(string $asunto)
    {
        $this->asunto = $asunto;
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
     * @return MensajeModel
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * @param string $mensaje
     * @return MensajeModel
     */
    public function setMensaje(string $mensaje)
    {
        $this->mensaje = $mensaje;
        return $this;
    }

}