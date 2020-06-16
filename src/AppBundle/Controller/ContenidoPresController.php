<?php


namespace AppBundle\Controller;


use AppBundle\Entity\ContenidoPresupuesto;
use AppBundle\Entity\Presupuesto;
use AppBundle\Entity\Producto;
use AppBundle\Form\Type\ContenidoPresupuestoType;
use AppBundle\Form\Type\ContenidoType;
use AppBundle\Repository\ContenidoPresRepository;
use AppBundle\Repository\ProductoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ContenidoPresController extends Controller
{

    /**
     * @Route("/contenido_presupuesto/{id}", name = "contenido_presupuesto_Listar")
     */

    public function contenidoAction(ContenidoPresRepository $contenidoPresRepository, Presupuesto $presupuesto){

        $contenido = $contenidoPresRepository->obtenerContenido($presupuesto);

        return $this->render('contenidoPresupuesto/listar.html.twig',[

            'contenido'=> $contenido,
            'presupuesto'=>$presupuesto
        ]);
    }


    /**
     * @Route("/contenido_presupuesto/{id}/alta", name="altas_contenido_presupuesto",requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function nuevaAction(Request $request,Presupuesto $presupuesto,ProductoRepository $productoRepository){

        $contendio = new ContenidoPresupuesto();
        $this->getDoctrine()->getManager()->persist($contendio);
        return $this->formAction($request,$presupuesto,$contendio,$productoRepository);
    }


    /**
     * @Route("/contenido_presupuesto/{presupuesto}/{id}",name="contenido_presupuesto_form", methods={"GET","POST"})
     */

    public function formAction(Request $request,Presupuesto $presupuesto,ContenidoPresupuesto $contenidoPresupuesto, ProductoRepository $productoRepository){

        $form = $this->createForm(ContenidoPresupuestoType::class,$contenidoPresupuesto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $contenidoPresupuesto->setPresupuesto($presupuesto);

            $total =  ($contenidoPresupuesto->getProducto()->getPrecio() * $form->getData()->getCantidad());

            $contenidoPresupuesto->setTotal($total);
            /** @var Producto $producto */
            $producto = $productoRepository->obtenerProducto($form->get('producto')->getData()->getId());

            if($producto[0]->getCantidad() == 0 ||  $form->get('cantidad')->getData() > $producto[0]->getCantidad() ){

                $this->addFlash('error','Error: no hay stock de ese producto');
                return $this->redirectToRoute('contenido_presupuesto_Listar',['id'=> $presupuesto->getId()]);

            }
            else{
                $stock = $producto[0]->getCantidad();
                $producto[0]->setCantidad($stock - $form->get('cantidad')->getData());
            }

            try {

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success','Se han guardado los datos con éxito');
                return $this->redirectToRoute('contenido_presupuesto_Listar',['id'=> $presupuesto->getId()]);

            }catch (\Exception $ex){

                $this->addFlash('error', 'Error: no se ha podido guardar los cambios');
            }

        }

        return $this->render('contenidoPresupuesto/form.html.twig',[

            'form' => $form->createView(),
            'contenido'=> $contenidoPresupuesto,
            'presupuesto'=>$presupuesto
        ]);
    }

    /**
     * @Route("/contenido_presupuesto/eliminar/{presupuesto}/{id}", name="contenido_presupuesto_eliminar", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function eliminarAction(Request $request, ContenidoPresupuesto $contenidoPresupuesto,Presupuesto $presupuesto){

        if ($request->getMethod() == 'POST'){


            try {

                $cli = $this->getDoctrine()->getManager();
                $cli->remove($contenidoPresupuesto);
                $cli->flush();
                $this->addFlash('success','producto borrado con éxito');
                return $this->redirectToRoute('presupuestos_Listar');

            }catch (\Exception $ex){

                $this->addFlash('error','Error: no se ha podido borrar este producto del presupuesto');
            }

        }

        return $this->render('contenidoPresupuesto/eliminar.html.twig',[

            'contenido' => $contenidoPresupuesto,
            'presupuesto'=> $presupuesto

        ]);

    }

}