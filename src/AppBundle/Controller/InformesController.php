<?php


namespace AppBundle\Controller;


use AppBundle\Repository\ClienteRepository;
use AppBundle\Repository\EmpleadoRepository;
use AppBundle\Repository\FacturaRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
     * @Security("is_granted('ROLE_GESTOR')")
     */

    public function informesAction(Request $request, FacturaRepository $facturaRepository, Environment $twig){

        $facturas = $facturaRepository->obtenerFacturasOrdenadas();
        $mpdfService = new MpdfService();
        $html = $twig->render('informes/iformeTotal.htm.twig',[

            'facturas'=> $facturas

        ]);

        return $mpdfService->generatePdfResponse($html);

    }

    /**
     * @Route("/informes/empleados", name="empleado_informe", methods={"GET"})
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */

    public function  informeAction(Request $request, EmpleadoRepository $empleadoRepository, Environment $twig){

        $empleados = $empleadoRepository->obtenerEmpleadosOrdenados();
        $mpdfService = new MpdfService();
        $html = $twig->render('informes/informe.html.twig',[

            'empleados'=> $empleados
        ]);

        return $mpdfService->generatePdfResponse($html);
    }

    /**
     * @Route("/informes/clientes", name="cliente_informe", methods={"GET"})
     * @Security("is_granted('ROLE_GESTOR')")
     */

    public function  informeClientesAction(Request $request, ClienteRepository $clienteRepository, Environment $twig){

        $clientes = $clienteRepository->obtenerClientesOrdenados();
        $mpdfService = new MpdfService();
        $html = $twig->render('informes/informe_clientes.html.twig',[

            'clientes'=> $clientes
        ]);

        return $mpdfService->generatePdfResponse($html);
    }
}