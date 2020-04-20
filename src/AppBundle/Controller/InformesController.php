<?php


namespace AppBundle\Controller;


use AppBundle\Repository\FacturaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use TFox\MpdfPortBundle\Service\MpdfService;
use Twig\Environment;

class InformesController extends Controller
{
    /**
     * @Route("/informes", name="portada_informes")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('portadaInformes.html.twig');
    }

    /**
     *  @Route("/informes/factura", name="facturas_informes", methods={"GET"})
     */

    public function informesAction(Request $request, FacturaRepository $facturaRepository, Environment $twig){

        $facturas = $facturaRepository->obtenerFacturasOrdenadas();
        $mpdfService = new MpdfService();
        $html = $twig->render('facturas/iformeTotal.htm.twig',[

            'facturas'=> $facturas

        ]);

        return $mpdfService->generatePdfResponse($html);

    }
}