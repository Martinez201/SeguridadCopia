<?php


namespace AppBundle\Form\Model;


class RecuperarClaveModel
{
    /**
     * @var string
     */
    private $email;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return RecuperarClaveModel
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }



}