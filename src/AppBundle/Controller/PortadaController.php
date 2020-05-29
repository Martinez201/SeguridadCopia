<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PortadaController extends Controller
{
    /**
     * @Route("/", name="portada")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('portadas/portada.html.twig');
    }
}
