<?php


namespace AppBundle\Controller;

use AppBundle\Repository\FacturaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class FacturaController extends Controller
{
    /**
     * @Route("/facturas", name = "facturas_Listar")
     */

    public function clientesAction(FacturaRepository $facturaRepository){

        $facturas = $facturaRepository->obtenerFacturasOrdenadas();


        return $this->render('facturas/listarFacturas.html.twig',[

            'facturas' => $facturas
        ]);

    }
}