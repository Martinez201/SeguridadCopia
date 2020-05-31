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


    /**
     * @Route("/presupuesto/portada", name="presupuesto_portada")
     */

    public function portadaAction(){

        return $this->render('portadas/portadaPrespuestos.html.twig');

    }

    /**
     * @Route("/presupuesto/documentacion", name="presupuesto_documentacion")
     */

    public function portadaDocumentacionAction(){

        return $this->render('presupuestos/documentacion.html.twig');

    }


    /**
     * @Route("/factura/portada", name="factura_portada")
     */

    public function portadaFacturas(){

        return $this->render('portadas/facturaPortada.html.twig');

    }


    /**
     * @Route("/cliente/portada", name="cliente_portada")
     */

    public function portadaClientes(){

        return $this->render('portadas/clientePortada.html.twig');

    }

    /**
     * @Route("/parte/portada", name="parte_portada")
     */

    public function portadaPartes(){

        return $this->render('portadas/partesPortada.html.twig');

    }



}
