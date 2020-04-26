<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Albaran;
use AppBundle\Entity\ContenidoAlbaran;
use AppBundle\Form\Type\ContenidoType;
use AppBundle\Repository\ContenidoRepository;
use AppBundle\Repository\ProductoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("is_granted('ROLE_GESTOR')")
 */



class ContenidoController extends Controller
{
    /**
     * @Route("/contenido/{id}", name = "contenido_Listar")
     */

    public function contenidoAction(ContenidoRepository $contenidoRepository, Albaran $albaran){

        $contenido = $contenidoRepository->obtenerContenido($albaran);

        return $this->render('contenido/listar.html.twig',[

            'contenido'=> $contenido,
            'albaran'=>$albaran
        ]);
    }

    /**
     * @Route("/contendio/{id}/alta", name="altas_contenido",requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function nuevaAction(Request $request,Albaran $albaran){

        $contendio = new ContenidoAlbaran();
        $this->getDoctrine()->getManager()->persist($contendio);
        return $this->formAction($request,$albaran,$contendio);
    }


    /**
     * @Route("/contenido/{albaran}/{id}",name="contenido_form",requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function formAction(Request $request,Albaran $albaran,ContenidoAlbaran $contenidoAlbaran){

        $form = $this->createForm(ContenidoType::class,$contenidoAlbaran);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $contenidoAlbaran->setAlbaran($albaran);
            $total =  $contenidoAlbaran->getProducto()->getPrecio() * $form->getData()->getCantidad();
            $contenidoAlbaran->setTotal($total);
            try {

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success','Se han guardado los datos con éxito');
                return $this->redirectToRoute('albaranes_Listar');

            }catch (\Exception $ex){

                $this->addFlash('error', 'Error: no se ha podido guardar los cambios');
            }

        }

        return $this->render('contenido/form.html.twig',[

            'form' => $form->createView(),
            'contenido'=> $contenidoAlbaran,
            'albaran'=>$albaran
        ]);
    }

    /**
     * @Route("/contenido/eliminar/{albaran}/{id}", name="contenido_eliminar", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function eliminarAction(Request $request, ContenidoAlbaran $contenidoAlbaran,Albaran $albaran){

        if ($request->getMethod() == 'POST'){


            try {

                $cli = $this->getDoctrine()->getManager();
                $cli->remove($contenidoAlbaran);
                $cli->flush();
                $this->addFlash('success','producto borrado con éxito');
                return $this->redirectToRoute('albaranes_Listar');

            }catch (\Exception $ex){

                $this->addFlash('error','Error: no se ha podido borrar este producto del albarán');
            }

        }

        return $this->render('contenido/eliminar.html.twig',[

            'contenido' => $contenidoAlbaran,
            'albaran'=> $albaran

        ]);

    }

}

