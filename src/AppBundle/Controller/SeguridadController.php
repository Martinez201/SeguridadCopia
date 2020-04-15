<?php


namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SeguridadController extends Controller
{

    /**
     * @Route("/entrar", name= "usuario_entrar")
     */

    public function entrarAction(AuthenticationUtils $authenticationUtils){

        $error = $authenticationUtils->getLastAuthenticationError();
        $ultimoUsuario = $authenticationUtils->getLastUsername();

        return $this->render('seguridad/entrar.html.twig',[

            'error'=> $error,
            'ultimo_usuario'=> $ultimoUsuario

        ]);

    }

    /**
     * @Route("/salir", name="usuario_salir")
     */

    public function salirAction(){

    }

}