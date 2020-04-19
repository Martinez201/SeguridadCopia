<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Empleado;
use AppBundle\Entity\Parte;
use AppBundle\Form\Type\ParteInstalador;
use AppBundle\Form\Type\ParteType;
use AppBundle\Repository\ParteRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 */

class ParteController extends Controller
{
    /**
     * @Route("/partes/{page}",name="partes_Listar")
     */

    public function partesAction(ParteRepository $parteRepository,$page=1){

        if ($this->isGranted('ROLE_COMERCIAL')){

            $partes = $parteRepository->obtenerPartesOrdenadosQueryBuilder(0);
            $adaptador = new DoctrineORMAdapter($partes, false);
            $pager = new Pagerfanta($adaptador);
        }

        if ($this->isGranted('ROLE_INSTALADOR')){

            /**@var Empleado */
            $usuario = $this->getUser();

            $partes = $parteRepository->obtenerPartesOrdenadosQueryBuilder(0,$usuario->getDelegacion());
            $adaptador = new DoctrineORMAdapter($partes, false);
            $pager = new Pagerfanta($adaptador);

        }

        if ($this->isGranted('ROLE_ADMINISTRADOR')){

            $partes = $parteRepository->obtenerPartesOrdenadosQueryBuilder(1);
            $adaptador = new DoctrineORMAdapter($partes, false);
            $pager = new Pagerfanta($adaptador);
        }


        try {

            $pager
                ->setMaxPerPage(8)
                ->setCurrentPage($page);

        }catch (OutOfRangeCurrentPageException $ex){

            $pager->setCurrentPage(1);

        }


        return $this->render('partes/listarPartes.html.twig',[

            'partes'=> $partes,
            'paginador'=> $pager
        ]);
    }

    /**
     * @Route("/parte/altas",name="partes_alta", methods={"GET","POST"})
     * @Security("is_granted('ROLE_GESTOR')")
     */

    public function nuevoAction(Request $request){

        $nuevoParte = new Parte();
        $em = $this->getDoctrine()->getManager();
        $em->persist($nuevoParte);

        return $this->formAction($request,$nuevoParte);
    }

    /**
     * @Route("/parte/{id}", name="partes_form", requirements={"id" = "\d+"}, methods={"GET","POST"})
     *@Security("is_granted('PARTE_MOSTRAR',parte)")
     */

    public function formAction(Request $request, Parte $parte){

        if ($this->getUser()->isInstalador()){

            $form = $this->createForm(ParteInstalador::class,$parte);
            $form->handleRequest($request);
            dump(2);
        }
        else{

            $form = $this->createForm(ParteType::class,$parte);
            $form->handleRequest($request);

        }


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
     * @Route("/parte/eliminar/{id}", name="partes_eliminar",requirements={"id" = "\d+"}, methods={"GET","POST"})
     * @Security("is_granted('ROLE_GESTOR')")
     */

    public function eliminarAction(Request $request, Parte $parte){

        if($request->getMethod() == "POST"){


            try {

                $em = $this->getDoctrine()->getManager();
                $em->remove($parte);
                $em->flush();
                $this->addFlash('success','Parte borrado con éxito');
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