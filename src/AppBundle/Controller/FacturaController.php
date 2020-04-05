<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Factura;
use AppBundle\Form\Type\FacturaType;
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
}