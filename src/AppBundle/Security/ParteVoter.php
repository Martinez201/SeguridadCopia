<?php


namespace AppBundle\Security;


use AppBundle\Entity\Empleado;
use AppBundle\Entity\Parte;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ParteVoter extends Voter
{
    const PARTE_MOSTRAR = 'PARTE_MOSTRAR';

    private $accessDecisionManager;

    public function __construct(AccessDecisionManagerInterface $accessDecisionManager)
    {
        $this->accessDecisionManager = $accessDecisionManager;
    }

    /**
     * @inheritDoc
     */

    protected function supports($attribute, $subject)
    {
        if ($attribute == self::PARTE_MOSTRAR){

            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $usuario = $token->getUser();

        if(!$usuario instanceof  Empleado){

            return false;
        }

        if (!$subject instanceof  Parte){

            return false;
        }

        if ($attribute == self::PARTE_MOSTRAR){

            if ($this->accessDecisionManager->decide($token,['ROLE_COMERCIAL'])){

                return true;
            }

            if($subject->getDelegacion() === $usuario->getDelegacion() && $this->accessDecisionManager->decide($token,['ROLE_INSTALADOR'])){


                    return  true;

            }
        }

        return false;
    }

}