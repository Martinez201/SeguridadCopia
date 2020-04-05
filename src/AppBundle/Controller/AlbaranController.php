<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Albaran;
use AppBundle\Form\Type\AlbaranType;
use AppBundle\Repository\AlbaranRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AlbaranController extends Controller
{

    /**
     * @Route("/albaranes",name="albaranes_Listar")
     */

    public function albaranesAction(AlbaranRepository $albaranRepository){

        $albaranes = $albaranRepository->obtenerAlbaranesOrdenados();

        return $this->render('albaranes/albaranesListar.html.twig',[

            'albaranes'=> $albaranes

        ]);
    }

    /**
     * @Route("/albaranes/alta", name="altas_albaranes", methods={"GET","POST"})
     */

    public function nuevaAction(Request $request){

        $albaran = new Albaran();
        $this->getDoctrine()->getManager()->persist($albaran);
        return $this->formAction($request,$albaran);
    }


    /**
     * @Route("/albaranes/{id}", name="albaranes_form",requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function formAction(Request $request, Albaran $albaran){

        $form = $this->createForm(AlbaranType::class,$albaran);
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

        return $this->render('albaranes/form.html.twig',[

            'form' => $form->createView(),
            'albaran'=> $albaran
        ]);
    }

    /**
     * @Route("/albaranes/eliminar/{id}", name="albaranes_eliminar", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function eliminarAction(Request $request, Albaran $albaran){

        if ($request->getMethod() == 'POST'){


            try {

                $cli = $this->getDoctrine()->getManager();
                $cli->remove($albaran);
                $cli->flush();
                $this->addFlash('success','albarán dado de baja con éxito');
                return $this->redirectToRoute('albaranes_Listar');

            }catch (\Exception $ex){

                $this->addFlash('error','Error: no se ha podido dar de baja al albarán');
            }

        }

        return $this->render('albaranes/eliminar.html.twig',[

            'albaran' => $albaran

        ]);

    }
}