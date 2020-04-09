<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Factura;
use AppBundle\Form\Type\FacturaType;
use AppBundle\Repository\ClienteRepository;
use AppBundle\Repository\FacturaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use TFox\MpdfPortBundle\Service\MpdfService;
use Twig\Environment;

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

    /**
     * @Route("/facturas/alta", name="altas_facturas", methods={"GET","POST"})
     */

    public function nuevaAction(Request $request){

        $factura = new Factura();
        $this->getDoctrine()->getManager()->persist($factura);
        return $this->formAction($request,$factura);
    }


    /**
     * @Route("/facturas/{id}", name="facturas_form",requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function formAction(Request $request, Factura $factura){

        $form = $this->createForm(FacturaType::class,$factura);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $precioConIva = $form->get('precioSinIva')->getData() * 0.21;
            $factura->setPrecioConIva($form->get('precioSinIva')->getData()+$precioConIva);

            try {

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success','Se han guardado los datos con éxito');

            }catch (\Exception $ex){

                $this->addFlash('error', 'Error: no se ha podido guardar los cambios');
            }

        }

        return $this->render('facturas/form.html.twig',[

            'form' => $form->createView(),
            'factura'=> $factura
        ]);
    }

    /**
     * @Route("/facturas/eliminar/{id}", name="facturas_eliminar", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function eliminarAction(Request $request, Factura $factura){

        if ($request->getMethod() == 'POST'){


            try {

                $cli = $this->getDoctrine()->getManager();
                $cli->remove($factura);
                $cli->flush();
                $this->addFlash('success','factura borrado con éxito');
                return $this->redirectToRoute('facturas_Listar');

            }catch (\Exception $ex){

                $this->addFlash('error','Error: no se ha podido borrar la factura');
            }

        }

        return $this->render('facturas/eliminar.html.twig',[

            'factura' => $factura

        ]);

    }

    /**
     * @Route("facturas/informe/{id}", name="facturas_informe", methods={"GET"})
     */

    public function informeAction(Request $request, FacturaRepository $facturaRepository, Environment $twig, ClienteRepository $clienteRepository,Factura $factura){

        $facturas = $facturaRepository->obtenerFactura($factura);
        $mpdfService = new MpdfService();
        $nombre = $factura->getCliente()->getNombre()." ".$factura->getCliente()->getApellidos();
        $direccion = $factura->getCliente()->getDireccion()." ".$factura->getCliente()->getCiudad()." ".$factura->getCliente()->getProvincia().",".$factura->getCliente()->getCPostal();
        $email = $factura->getCliente()->getEmail();
        $telefono = $factura->getCliente()->getTelefono();
        $html = $twig->render('facturas/informe.html.twig',[

            'factura'=> $factura,
            'nombre' => $nombre,
            'telefono'=> $telefono,
            'email'=> $email,
            'direccion'=> $direccion
        ]);

        return $mpdfService->generatePdfResponse($html);
    }

    /**
     *  @Route("facturas/informes", name="facturas_informes", methods={"GET"})
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