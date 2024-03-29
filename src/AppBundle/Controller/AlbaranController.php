<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Albaran;
use AppBundle\Entity\ContenidoAlbaran;
use AppBundle\Entity\Empleado;
use AppBundle\Form\Type\AlbaranType;
use AppBundle\Repository\AlbaranRepository;
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
 * @Security("is_granted('ROLE_GESTOR')")
 */


class AlbaranController extends Controller
{

    /**
     * @Route("/albaranes/{page}",name="albaranes_Listar")
     */

    public function albaranesAction(AlbaranRepository $albaranRepository,$page = 1){
        /** @var Empleado $usuario */
        $usuario = $this->getUser();

        if(!$usuario->isAdministrador()){

            $albaranes = $albaranRepository->obtenerAlbaranesOrdenadosQueryBuilder($usuario);
        }
        else{

            $albaranes = $albaranRepository->obtenerAlbaranesOrdenadosQueryBuilder();
        }

        $adaptador = new DoctrineORMAdapter($albaranes, false);
        $pager = new Pagerfanta($adaptador);

        try {

            $pager
                ->setMaxPerPage(8)
                ->setCurrentPage($page);

        }catch (OutOfRangeCurrentPageException $ex){

            $pager->setCurrentPage(1);

        }
        return $this->render('albaranes/albaranesListar.html.twig',[

            'albaranes'=> $albaranes,
            'paginador'=> $pager

        ]);
    }

    /**
     * @Route("/albaran/alta", name="altas_albaranes", methods={"GET","POST"})
     */

    public function nuevaAction(Request $request){

        /** @var Empleado $usuario */
        $usuario = $this->getUser();

        $albaran = new Albaran();
        $albaran->setFecha(new \DateTime());
        $albaran->setEmpleado($usuario);
        $this->getDoctrine()->getManager()->persist($albaran);
        return $this->formAction($request,$albaran);

        //
    }


    /**
     * @Route("/albaran/{id}", name="albaranes_form",requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function formAction(Request $request, Albaran $albaran){

        $form = $this->createForm(AlbaranType::class,$albaran);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            try {

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success','Se han guardado los datos con éxito');
                return $this->redirectToRoute("contenido_Listar",['id' => $albaran->getId()]);

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
     * @Route("/albaran/eliminar/{id}", name="albaranes_eliminar", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function eliminarAction(Request $request, Albaran $albaran){

        if ($request->getMethod() == 'POST'){


            try {

                $cli = $this->getDoctrine()->getManager();
                $cli->remove($albaran);
                $cli->flush();
                $this->addFlash('success','albarán borrado con éxito');
                return $this->redirectToRoute('albaranes_Listar');

            }catch (\Exception $ex){

                $this->addFlash('error','Error: no se ha podido borrar albarán');
            }

        }

        return $this->render('albaranes/eliminar.html.twig',[

            'albaran' => $albaran

        ]);

    }

    /**
     * @Route("albaran/informe/{id}", name="albaran_informe", methods={"GET"})
     */

    public function informeAction(Request $request, Albaran $albaran,Environment $twig){

        $mpdfService = new MpdfService();
        $productos = $albaran->getContenido();

        $html = $twig->render('albaranes/iformeAlbaran.htm.twig',[

            'albaran'=> $albaran,
            'contenido'=> $productos

        ]);

        return $mpdfService->generatePdfResponse($html);
    }



}