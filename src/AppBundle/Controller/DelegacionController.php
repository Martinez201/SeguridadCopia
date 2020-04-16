<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Delegacion;
use AppBundle\Form\Type\DelegacionType;
use AppBundle\Repository\DelegacionRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DelegacionController extends Controller
{

    /**
     * @Route("/delegaciones/{page}", name="delegaciones_listar")
     */

    public function delegacionesAction(DelegacionRepository $delegacionRepository, $page = 1)
    {

        $delegaciones = $delegacionRepository->obtenerDelegacionesQueryBuilder();
        $adaptador = new DoctrineORMAdapter($delegaciones, false);
        $pager = new Pagerfanta($adaptador);

        try {

            $pager
                ->setMaxPerPage(8)
                ->setCurrentPage($page);

        }catch (OutOfRangeCurrentPageException $ex){

            $pager->setCurrentPage(1);

        }
        return $this->render('delegaciones/listar.html.twig', [

            'delegaciones' => $delegaciones,
            'paginador'=> $pager
        ]);
    }

    /**
     * @Route("/delegacion/alta", name="altas_delegaciones", methods={"GET","POST"})
     */

    public function nuevaAction(Request $request)
    {

        $delegacion = new Delegacion();
        $this->getDoctrine()->getManager()->persist($delegacion);
        return $this->formAction($request, $delegacion);
    }


    /**
     * @Route("/delegacion/{id}", name="delegaciones_form", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function formAction(Request $request, Delegacion $delegacion)
    {

        $form = $this->createForm(DelegacionType::class, $delegacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', 'Se han guardado los datos con éxito');
                return $this->redirectToRoute('delegaciones_listar');

            } catch (\Exception $ex) {

                $this->addFlash('error', 'Error: no se ha podido guardar los cambios');
            }

        }

        return $this->render('delegaciones/from.html.twig', [

            'form' => $form->createView(),
            'delegacion' => $delegacion

        ]);

    }

    /**
     * @Route("/delegacion/eliminar/{id}", name="delegacion_eliminar", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function eliminarAction(Request $request, Delegacion $delegacion)
    {

        if ($request->getMethod() == 'POST') {


            try {

                $cli = $this->getDoctrine()->getManager();
                $cli->remove($delegacion);
                $cli->flush();
                $this->addFlash('success', 'Delegación dada de baja con éxito');
                return $this->redirectToRoute('delegaciones_listar');

            } catch (\Exception $ex) {

                $this->addFlash('error', 'Error: no se ha podido dar de baja a la Delegación');
            }

        }

        return $this->render('delegaciones/eliminar.html.twig', [

            'delegacion' => $delegacion

        ]);

    }

}