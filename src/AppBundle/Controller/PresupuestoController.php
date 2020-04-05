<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Presupuesto;
use AppBundle\Form\Type\PresupuestoType;
use AppBundle\Repository\PresupuestoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PresupuestoController extends Controller
{
    /**
     * @Route("/presupuestos",name="presupuestos_Listar")
     */

    public function partesAction(PresupuestoRepository $presupuestoRepository){

        $presupuestos = $presupuestoRepository->obtenerPresupuestosOrdenados();

        return $this->render('presupuestos/listarPresupuestos.html.twig',[

            'presupuestos'=> $presupuestos
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