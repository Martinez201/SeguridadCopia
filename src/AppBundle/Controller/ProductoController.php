<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Producto;
use AppBundle\Form\Type\ProductoType;
use AppBundle\Repository\ProductoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductoController extends Controller
{

    /**
     * @Route("/productos", name = "productos_Listar")
     */

    public function productosAction(ProductoRepository $productoRepository){

        $productos= $productoRepository->obtenerProductos();


        return $this->render('productos/listarProductos.html.twig',[

            'productos' => $productos
        ]);

    }
    /**
     * @Route("/productos/alta", name="altas_productos", methods={"GET","POST"})
     */

    public function nuevaAction(Request $request){

        $producto = new Producto();
        $this->getDoctrine()->getManager()->persist($producto);
        return $this->formAction($request,$producto);
    }


    /**
     * @Route("/productos/{id}", name="productos_form",requirements={"id" = "\d+"}, methods={"GET","POST"})
     */
    public function formAction(Request $request, Producto $producto){

        $form = $this->createForm(ProductoType::class,$producto);
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

        return $this->render('productos/form.html.twig',[

            'form' => $form->createView(),
            'producto'=> $producto
        ]);
    }


    /**
     * @Route("/productos/eliminar/{id}", name="productos_eliminar", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function eliminarAction(Request $request, Producto $producto){

        if ($request->getMethod() == 'POST'){


            try {

                $cli = $this->getDoctrine()->getManager();
                $cli->remove($producto);
                $cli->flush();
                $this->addFlash('success','producto borrado con éxito');
                return $this->redirectToRoute('productos_Listar');

            }catch (\Exception $ex){

                $this->addFlash('error','Error: no se ha podido borrar producto');
            }

        }

        return $this->render('productos/eliminar.html.twig',[

            'producto' => $producto

        ]);

    }
}