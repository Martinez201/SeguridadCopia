<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Empleado;
use AppBundle\Form\Type\EmpleadoType;
use AppBundle\Repository\EmpleadoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EmpleadoController extends Controller
{

    /**
     * @Route("/empleados", name="empleados_listar")
     */

    public function indexAction(EmpleadoRepository $empleadoRepository){

        $empleados = $empleadoRepository->obtenerEmpleados();

        return $this->render('empleados/listarEmpleados.html.twig',[

            'empleados' => $empleados

        ]);

    }


    /**
     * @Route("/empleados/{id}", name= "empleados_form", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function formAction(Request $request, Empleado $empleado){

        $form = $this->createForm(EmpleadoType::class, $empleado);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

            $imagen = $form->get('avatar')->getData();

            if($imagen){

                $nombreOriginal = pathinfo($imagen->getClientOriginalName(),PATHINFO_FILENAME);
                $guardarNuevo = $nombreOriginal.'-'.uniqid().'.'.$imagen->guessExtension();

            }
            try {

                $imagen->move($this->getParameter('directorioAvatares'),$guardarNuevo);
                $empleado->setAvatar($guardarNuevo);

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('succes','Se han guardado los datos con éxito');



            }catch (\Exception $ex){

                $this->addFlash('error','Error: No se a podido guardar los cambios');

            }

        }

        return $this->render('empleados/form.html.twig',[

            'form' => $form->createView(),
            'empleado' => $empleado

        ]);
    }

}