<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Empleado;
use AppBundle\Form\Type\InformeEmpleadoDelegacionType;
use AppBundle\Form\Type\InformeFacturaType;
use AppBundle\Repository\ClienteRepository;
use AppBundle\Repository\EmpleadoRepository;
use AppBundle\Repository\FacturaRepository;
use AppBundle\Repository\ParteRepository;
use AppBundle\Repository\PresupuestoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use TFox\MpdfPortBundle\Service\MpdfService;
use Twig\Environment;

/**
 * @Security("is_granted('ROLE_USER')")
 */

class InformesController extends Controller
{
    /**
     * @Route("/informes", name="portada_informes")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('portadas/portadaInformes.html.twig');
    }

    /**
     *  @Route("/informes/factura", name="facturas_informes", methods={"GET","POST"})
     * @Security("is_granted('ROLE_GESTOR')")
     */

    public function informesAction(Request $request, FacturaRepository $facturaRepository, Environment $twig){

        $form = $this->createForm(InformeFacturaType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $buscar = $form->get('cliente')->getData();
            $fechaInicial = $form->get('fechaPrincipio')->getData();
            $fechaFinal = $form->get('fechaFinal')->getData();

            if(!$buscar){

                $facturas = $facturaRepository->obtenerFacturasPorFechas($fechaInicial, $fechaFinal);
            }
            else{

                $facturas = $facturaRepository->obtenerFacturasPorFechasCliente($fechaInicial, $fechaFinal,$buscar);

            }

            $cantidadFacturas = $facturaRepository->obtenerFacturasPorFechasCantidad($fechaInicial,$fechaFinal);

            if($fechaInicial > $fechaFinal || $fechaInicial->diff($fechaFinal)->invert){

                $this->addFlash('error','La fecha inicial debe de ser menor  que la fecha final');
                return $this->redirectToRoute('facturas_informes');
            }
           if($fechaInicial->diff($fechaFinal)->format('%a') > 93){

                $this->addFlash('error','No se puede generar un informe de mas de un trimestre');
                return $this->redirectToRoute('facturas_informes');
            }

            if(!$cantidadFacturas){

                $this->addFlash('error','Error: no se han encontrado facturas en esas fechas');
                return $this->redirectToRoute('facturas_informes');
            }


            $mpdfService = new MpdfService();
            $html = $twig->render('informes/iformeTotal.htm.twig',[

                'facturas'=> $facturas

            ]);

           return $mpdfService->generatePdfResponse($html);
        }

        return  $this->render('informes/informeFacturasForm.html.twig',[

            'form'=> $form->createView()
        ]);

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

    /**
     * @Route("/informes/presupuestos", name="presupuestos_informe", methods={"GET"})
     * @Security("is_granted('ROLE_COMERCIAL')")
     */

    public function  informePresupuestosAction(Request $request, PresupuestoRepository $presupuestoRepository, Environment $twig){


        $presupuestos = $presupuestoRepository->obtenerPresupuestosOrdenados();
        $mpdfService = new MpdfService();
        $html = $twig->render('informes/informe_presupuestos.html.twig',[

            'presupuestos'=> $presupuestos

        ]);

        return $mpdfService->generatePdfResponse($html);
    }

    /**
     * @Route("/informes/partes", name="partes_informe", methods={"GET"})
     * @Security("is_granted('ROLE_INSTALADOR')")
     */

    public function  informePartesAction(Request $request, ParteRepository $parteRepository, Environment $twig){

        /**@var Empleado */
        $usuario = $this->getUser();
        $partes = $parteRepository->obtenerPartesOrdenados(1);

        $mpdfService = new MpdfService();
        $html = $twig->render('informes/informe_partes.html.twig',[

            'partes'=> $partes

        ]);

        $html = $twig->render('informes/informe_partes.html.twig',[

            'partes'=> $partes

        ]);

        return $mpdfService->generatePdfResponse($html);
    }

    /**
     * @Route("/infome/empleados", name="empleado_informe", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */

    public function empleadosDelegacionAction(Request $request, EmpleadoRepository $empleadoRepository, Environment $twig){

        $form = $this->createForm(InformeEmpleadoDelegacionType::class);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()){

            $delegacion = $form->get('delegacion')->getData();

            if(!$delegacion){

                $empleados = $empleadoRepository->obtenerEmpleadosOrdenados();

            }
            else{

                $empleados = $empleadoRepository->obtenerEmpleadosDelegacion($delegacion);

            }

            $mpdfService = new MpdfService();
            $html = $twig->render('informes/informe.html.twig',[

                'empleados'=> $empleados
            ]);

            return $mpdfService->generatePdfResponse($html);

        }

        return $this->render('informes/empleadoDelgeacion.html.twig',[

            'form'=> $form->createView()
        ]);
    }
}