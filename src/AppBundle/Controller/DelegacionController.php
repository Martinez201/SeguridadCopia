<?php


namespace AppBundle\Controller;


use AppBundle\Repository\DelegacionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DelegacionController extends Controller
{

    /**
     * @Route("/delegaciones", name="delegaciones_listar")
     */

    public function delegacionesAction(DelegacionRepository $delegacionRepository){

        $delegaciones = $delegacionRepository->obtenerDelegaciones();

        return $this->render('delegaciones/listar.html.twig',[

            'delegaciones' => $delegaciones
        ]);
    }
}