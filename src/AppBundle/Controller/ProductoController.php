<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Producto;
use AppBundle\Form\Type\ProductoType;
use AppBundle\Repository\ProductoRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductoController extends Controller
{

    /**
     * @Route("/productos/{page}", name = "productos_Listar")
     */

    public function productosAction(ProductoRepository $productoRepository, $page = 1){

        $productos= $productoRepository->obtenerProductosQueryBuilder();
        $adaptador = new DoctrineORMAdapter($productos, false);
        $pager = new Pagerfanta($adaptador);
        try {

            $pager
                ->setMaxPerPage(8)
                ->setCurrentPage($page);

        }catch (OutOfRangeCurrentPageException $ex){

            $pager->setCurrentPage(1);

        }


        return $this->render('productos/listarProductos.html.twig',[

            'productos' => $productos,
            'paginador'=> $pager
        ]);

    }
    /**
     * @Route("/producto/alta", name="altas_productos", methods={"GET","POST"})
     */

    public function nuevaAction(Request $request){

        $producto = new Producto();
        $this->getDoctrine()->getManager()->persist($producto);
        return $this->formAction($request,$producto);
    }


    /**
     * @Route("/producto/{id}", name="productos_form",requirements={"id" = "\d+"}, methods={"GET","POST"})
     */
    public function formAction(Request $request, Producto $producto){

        $form = $this->createForm(ProductoType::class,$producto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $imagen = $form->get('imagen')->getData();

            if($imagen){

                $nombreOriginal = pathinfo($imagen->getClientOriginalName(),PATHINFO_FILENAME);
                $guardarNuevo = $nombreOriginal.'-'.uniqid().'.'.$imagen->guessExtension();
                $imagen->move($this->getParameter('directorioImagenes'),$guardarNuevo);
                $producto->setImagen($guardarNuevo);
            }
            try {

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success','Se han guardado los datos con éxito');
                return $this->redirectToRoute('productos_Listar');

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
     * @Route("/producto/eliminar/{id}", name="productos_eliminar", requirements={"id" = "\d+"}, methods={"GET","POST"})
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