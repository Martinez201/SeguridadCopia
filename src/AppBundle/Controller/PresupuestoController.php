<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Presupuesto;
use AppBundle\Form\Type\PresupuestoType;
use AppBundle\Repository\PresupuestoRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PresupuestoController extends Controller
{
    /**
     * @Route("/presupuestos/{page}",name="presupuestos_Listar")
     */

    public function partesAction(PresupuestoRepository $presupuestoRepository,$page = 1){

        $presupuestos = $presupuestoRepository->obtenerPresupuestosOrdenadosQueryBuilder();
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
     * @Route("/presupuestos/alta", name="altas_presupuestos", methods={"GET","POST"})
     */

    public function nuevaAction(Request $request){

        $presupuesto = new Presupuesto();
        $this->getDoctrine()->getManager()->persist($presupuesto);
        return $this->formAction($request,$presupuesto);
    }


    /**
     * @Route("/presupuestos/{id}", name="presupuestos_form",requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function formAction(Request $request, Presupuesto $presupuesto){

        $form = $this->createForm(PresupuestoType::class,$presupuesto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $precioConIva = $form->get('precioSinIva')->getData() * 0.21;
            $presupuesto->setPrecioConIva($form->get('precioSinIva')->getData()+$precioConIva);

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
}