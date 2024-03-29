<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Empleado;
use AppBundle\Entity\Presupuesto;
use AppBundle\Entity\Producto;
use AppBundle\Form\Type\PresupuestoType;
use AppBundle\Repository\ContenidoPresRepository;
use AppBundle\Repository\PresupuestoRepository;
use AppBundle\Repository\ProductoRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use TFox\MpdfPortBundle\Service\MpdfService;
use Twig\Environment;

/**
 * @Security("is_granted('ROLE_COMERCIAL')")
 */

class PresupuestoController extends Controller
{
    /**
     * @Route("/presupuestos/{page}",name="presupuestos_Listar")
     */

    public function partesAction(PresupuestoRepository $presupuestoRepository,$page = 1){
        /** @var Empleado $usuario */
        $usuario = $this->getUser();
        if(!$usuario->isAdministrador()){

            $presupuestos = $presupuestoRepository->obtenerPresupuestosOrdenadosQueryBuilder($usuario);
        }
        else{
            $presupuestos = $presupuestoRepository->obtenerPresupuestosOrdenadosQueryBuilder();
        }

        $adaptador = new DoctrineORMAdapter($presupuestos, false);
        $pager = new Pagerfanta($adaptador);
        try {

            $pager
                ->setMaxPerPage(8)
                ->setCurrentPage($page);

        }catch (OutOfRangeCurrentPageException $ex){

            $pager->setCurrentPage(1);

        }

        return $this->render('presupuestos/listarPresupuestos.html.twig',[

            'presupuestos'=> $presupuestos,
            'paginador'=> $pager
        ]);
    }

    /**
     * @Route("/presupuesto/alta", name="altas_presupuestos", methods={"GET","POST"})
     */

    public function nuevaAction(Request $request, ContenidoPresRepository $contenidoPresRepository,ProductoRepository $productoRepository){

        /**
         * @var Empleado $empleado
         */
        $empleado = $this->getUser();
        $presupuesto = new Presupuesto();
        $presupuesto->setFecha(new \DateTime());
        $presupuesto->setEmpleado($empleado);
        $this->getDoctrine()->getManager()->persist($presupuesto);
        return $this->formAction($request,$presupuesto, $contenidoPresRepository,$productoRepository);
    }


    /**
     * @Route("/presupuesto/{id}", name="presupuestos_form",requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function formAction(Request $request, Presupuesto $presupuesto, ContenidoPresRepository $contenidoPresRepository, ProductoRepository $productoRepository){

        $form = $this->createForm(PresupuestoType::class,$presupuesto);
        $form->handleRequest($request);



        if($form->isSubmitted() && $form->isValid()){

            $contrato = $form->get('contrato')->getData();

            if($presupuesto->getContenido()){

                $stock = $contenidoPresRepository->obtenerContenido($presupuesto);

                if($presupuesto->isEstado()){

                    foreach($stock as $producto){
                        /** @var Producto $prod */
                      $prod = $productoRepository->obtenerProducto($producto->getProducto());
                       if($prod[0]->getCantidad() < $stock[0]->getCantidad() ){

                            $this->addFlash('error','Error: no hay stock de algunos de los productos del presupuesto');
                            return $this->redirectToRoute('presupuestos_form',['id'=> $presupuesto->getId()]);

                        }else{

                           $prod[0]->setCantidad($prod[0]->getCantidad() - $stock[0]->getCantidad() );
                        }
                    }
                }
               else{

                    foreach($stock as $producto){
                        /** @var Producto $prod */
                        $prod = $productoRepository->obtenerProducto($producto->getProducto());
                        $prod[0]->setCantidad($prod[0]->getCantidad() + $stock[0]->getCantidad() );
                    }
                }
            }

            if($contrato){

                $nombreOriginal = pathinfo($contrato->getClientOriginalName(),PATHINFO_FILENAME);
                $guardarNuevo = $nombreOriginal.'-'.uniqid().'.'.$contrato->guessExtension();
                $contrato->move($this->getParameter('directoriocontratos'), $guardarNuevo);
                $presupuesto->setContrato($guardarNuevo);
            }

            try {

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success','Se han guardado los datos con éxito');

            }catch (\Exception $ex){

                $this->addFlash('error', 'Error: no se ha podido guardar los cambios');
            }

        }

        return $this->render('presupuestos/form.html.twig',[

            'form' => $form->createView(),
            'presupuesto'=> $presupuesto
        ]);
    }

    /**
     * @Route("/presupuesto/eliminar/{id}", name="presupuestos_eliminar", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function eliminarAction(Request $request, Presupuesto $presupuesto){

        if ($request->getMethod() == 'POST'){


            try {

                $cli = $this->getDoctrine()->getManager();
                $cli->remove($presupuesto);
                $cli->flush();
                $this->addFlash('success','presupuesto borrado con éxito');
                return $this->redirectToRoute('presupuestos_Listar');

            }catch (\Exception $ex){

                $this->addFlash('error','Error: no se ha podido borrar el presupesto');
            }

        }

        return $this->render('presupuestos/eliminar.html.twig',[

            'presupuesto' => $presupuesto

        ]);

    }

    /**
     * @Route("/informe/informe/{id}", name="presupuesto_informe", methods={"GET"})
     */

    public function informeAction(Request $request,Presupuesto $presupuesto, Environment $twig){

        $mpdfService = new MpdfService();
        $productos = $presupuesto->getContenido();

        $html = $twig->render('presupuestos/informe.html.twig',[

            'presupuesto'=> $presupuesto,
            'contenido'=> $productos

        ]);

        return $mpdfService->generatePdfResponse($html);
    }


}