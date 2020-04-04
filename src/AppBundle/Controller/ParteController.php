<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Parte;
use AppBundle\Form\Type\ParteType;
use AppBundle\Repository\ParteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class ParteController extends Controller
{
    /**
     * @Route("/partes",name="partes_Listar")
     */

    public function partesAction(ParteRepository $parteRepository){

        $partes = $parteRepository->obtenerPartesOrdenados();

        return $this->render('partes/listarPartes.html.twig',[

            'partes'=> $partes
        ]);
    }

    /**
     * @Route("/partes/altas",name="partes_alta", methods={"GET","POST"})
     */

    public function nuevoAction(Request $request){

        $nuevoParte = new Parte();
        $em = $this->getDoctrine()->getManager();
        $em->persist($nuevoParte);

        return $this->formAction($request,$nuevoParte);
    }

    /**
     * @Route("/partes/{id}", name="partes_form", requirements={"id" = "\d+"}, methods={"GET","POST"})
     *
     */

    public function formAction(Request $request, Parte $parte){

        $form = $this->createForm(ParteType::class,$parte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            try {

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success','Se ha guardado los cambios con éxito');
                return $this->redirectToRoute('partes_Listar');

            }catch (\Exception $ex){

                $this->addFlash('error','Error: no se ha podido guardar los cambios');

            }

        }

        return $this->render('partes/form.html.twig',[

            'form'=> $form->createView(),
            'parte'=> $parte
        ]);
    }

    /**
     * @Route("/partes/eliminar/{id}", name="partes_eliminar",requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function eliminarAction(Request $request, Parte $parte){

        if($request->getMethod() == "POST"){


            try {

                $em = $this->getDoctrine()->getManager();
                $em->remove($parte);
                $em->flush();
                $this->addFlash('success','Partes borrado con éxito');
                return $this->redirectToRoute('partes_Listar');

            }catch (\Exception $ex){

                $this->addFlash('error', 'Error: no se ha podido borrar el parte');
            }

        }

        return $this->render('partes/eliminar.html.twig',[

            'parte'=> $parte
        ]);
    }
}