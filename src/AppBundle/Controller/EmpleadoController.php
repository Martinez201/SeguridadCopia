<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Empleado;
use AppBundle\Form\Type\EmpleadoType;
use AppBundle\Repository\EmpleadoRepository;
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
 * @Security("is_granted('ROLE_ADMINISTRADOR')")
 */


class EmpleadoController extends Controller
{

    /**
     * @Route("/empleados/{page}", name="empleados_listar")
     */

    public function indexAction(EmpleadoRepository $empleadoRepository,$page=1){

        $empleados = $empleadoRepository->obtenerEmpleadosQueryBuilder();
        $adaptador = new DoctrineORMAdapter($empleados,false);
        $pager = new Pagerfanta($adaptador);

        try {
            $pager
                ->setMaxPerPage(8)
                ->setCurrentPage($page);
        }catch (OutOfRangeCurrentPageException $ex){

            $pager->setCurrentPage(1);

        }

        return $this->render('empleados/listarEmpleados.html.twig',[

            'empleados' => $empleados,
            'paginador'=> $pager

        ]);

    }

    /**
     * @Route("empleado/alta", name="alta_empleados", methods={"GET","POST"})
     */

    public function nuevoAction(Request $request){

        $nuevoEmpleado = new Empleado();
        $em = $this->getDoctrine()->getManager();
        $em->persist($nuevoEmpleado);

        return $this->formAction($request,$nuevoEmpleado);
    }


    /**
     * @Route("/empleado/{id}", name= "empleados_form", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function formAction(Request $request, Empleado $empleado){

        $form = $this->createForm(EmpleadoType::class, $empleado);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

            $imagen = $form->get('avatar')->getData();

            if($imagen){

                $nombreOriginal = pathinfo($imagen->getClientOriginalName(),PATHINFO_FILENAME);
                $guardarNuevo = $nombreOriginal.'-'.uniqid().'.'.$imagen->guessExtension();
                $imagen->move($this->getParameter('directorioAvatares'), $guardarNuevo);
                $empleado->setAvatar($guardarNuevo);
            }
            try {

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('succes','Se han guardado los datos con éxito');
                return $this->redirectToRoute('empleados_listar');



            }catch (\Exception $ex){

                $this->addFlash('error','Error: No se a podido guardar los cambios');

            }

        }

        return $this->render('empleados/form.html.twig',[

            'form' => $form->createView(),
            'empleado' => $empleado

        ]);
    }


    /**
     * @Route("/empleado/eliminar/{id}", name="empleados_eliminar",requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function  eliminarAction(Request $request, Empleado $empleado){

        if($request->getMethod() == "POST"){


            try {

                $em = $this->getDoctrine()->getManager();
                $em->remove($empleado);
                $em->flush();
                $this->addFlash('success','Empleado dado de baja con éxito');
                return $this->redirectToRoute('empleados_listar');

            }catch (\Exception $ex){

                $this->addFlash('error','Error: No se a podido dar de baja al empleado.');
                return $this->redirectToRoute('empleados_form',['id'=> $empleado->getId()]);
            }

        }

        return $this->render('empleados/eliminar.html.twig',[

            'empleado' => $empleado

        ]);

    }

    /**
     * @Route("/empleado/informe", name="empleado_informe", methods={"GET"})
     */

    public function  informeAction(Request $request, EmpleadoRepository $empleadoRepository, Environment $twig){

        $empleados = $empleadoRepository->obtenerEmpleadosOrdenados();
        $mpdfService = new MpdfService();
        $html = $twig->render('empleados_informe.html.twig',[

            'empleados'=> $empleados
        ]);

        return $mpdfService->generatePdfResponse($html);
    }
}