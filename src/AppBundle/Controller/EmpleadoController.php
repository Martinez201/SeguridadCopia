<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Empleado;
use AppBundle\Form\Model\CambioClave;
use AppBundle\Form\Type\CambioClaveType;
use AppBundle\Form\Type\EmpleadoType;
use AppBundle\Form\Type\MyUsuarioType;
use AppBundle\Repository\EmpleadoRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use TFox\MpdfPortBundle\Service\MpdfService;
use Twig\Environment;




class EmpleadoController extends Controller
{

    /**
     * @Route("/empleados/{page}", name="empleados_listar")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
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
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */

    public function nuevoAction(Request $request,UserPasswordEncoderInterface $encoder,\Swift_Mailer $swift_Mailer ){

        $nuevoEmpleado = new Empleado();
        $nuevoEmpleado->setEdad(new \DateTime());
        $em = $this->getDoctrine()->getManager();
        $em->persist($nuevoEmpleado);

        return $this->formAction($request,$nuevoEmpleado, $encoder,$swift_Mailer );
    }


    /**
     * @Route("/empleado/{id}", name= "empleados_form", requirements={"id" = "\d+"}, methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */

    public function formAction(Request $request, Empleado $empleado, UserPasswordEncoderInterface $encoder,\Swift_Mailer $swift_Mailer){

        $form = $this->createForm(EmpleadoType::class, $empleado);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

            $imagen = $form->get('avatar')->getData();
            $clave = $form->get('clave')->getData();

            if($form->get('mensaje')->getData() === 1){

                $mensaje = (new \Swift_Message('Datos de acceso'))
                    ->setFrom('jesus.martinez.gonzalez1993@gmail.com')
                    ->setTo($form->get('email')->getData())
                    ->setBody(      $this->renderView('empleados/emailEmpleados.html.twig',[

                        'clave' => $form->get('clave')->getData(),
                        'usuario'=> $form->get('usuario')->getData()

                    ]),
                        'text/html'
                    );

                $swift_Mailer->send($mensaje);
            }

            if($imagen){

                $nombreOriginal = pathinfo($imagen->getClientOriginalName(),PATHINFO_FILENAME);
                $guardarNuevo = $nombreOriginal.'-'.uniqid().'.'.$imagen->guessExtension();
                $imagen->move($this->getParameter('directorioAvatares'), $guardarNuevo);
                $empleado->setAvatar($guardarNuevo);
            }

            if($clave){

                $empleado->setClave($encoder->encodePassword($empleado,$clave));

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
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
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
     * @Route("/perfil", name="usuario_perfil_form", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_USER')")
     */

    public  function perfilAction(Request $request){

        $usuario = $this->getUser();
        $form = $this->createForm(MyUsuarioType::class,$usuario);
        $form->handleRequest($request);
        $imagen = $form->get('avatar')->getData();

        if($imagen){

            $nombreOriginal = pathinfo($imagen->getClientOriginalName(),PATHINFO_FILENAME);
            $guardarNuevo = $nombreOriginal.'-'.uniqid().'.'.$imagen->guessExtension();
            $imagen->move($this->getParameter('directorioAvatares'), $guardarNuevo);
            $usuario->setAvatar($guardarNuevo);


        }

        if($form->isSubmitted() && $form->isValid()){

            try {

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success','Se han guardado los datos con éxito');

            }catch (\Exception $ex){

                $this->addFlash('error', 'Error: no se ha podido guardar los cambios');
            }

        }

        return $this->render('empleados/perfil_form.html.twig',[

            'form' => $form->createView(),
            'usuario'=> $usuario
        ]);

    }

    /**
     * @Route("/perfil/usuario", name="usuario_perfil")
     * @Security("is_granted('ROLE_USER')")
     */

    public  function perfilUsuarioAction(){

        $usuario = $this->getUser();


        return $this->render('empleados/perfil_usuario_form.html.twig',[

            'usuario'=> $usuario

        ]);

    }

    /**
     * @Route("/perfil/clave", name="usuario_cambiar_clave")
     * @Security("is_granted('ROLE_USER')")
     */

    public function cambioClaveAction(Request $request, UserPasswordEncoderInterface $encoder){

        $cambioClave = new CambioClave();

        $form = $this->createForm(CambioClaveType::class, $cambioClave);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            try {

                $em = $this->getDoctrine()->getManager();

                /**@var Empleado $user*/
                $user = $this->getUser();
                $user->setClave(

                    $encoder->encodePassword($user,$cambioClave->getNuevaClave())

                );

                $em->flush();
                $this->addFlash('success','Se ha cambiado la contraseña con éxito');
                return $this->redirectToRoute('usuario_perfil');

            }catch (\Exception $ex){

                $this->addFlash('error','Error: no se ha podido cambiar la contraseña');

            }

        }

        return $this->render('empleados/cambioClaveForm.html.twig',[

            'formulario'=> $form->createView()

        ]);
    }

    /**
     * @Route("/perfil/clave/{id}", name="admin_cambiar_clave")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */

    public function establecerAction(Request $request, UserPasswordEncoderInterface $encoder, Empleado $empleado){

        $cambioCLave = new CambioClave();

        $form = $this->createForm(CambioClaveType::class, $cambioCLave,[

            'es_admin'=> true
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){

            try {

                $em = $this->getDoctrine()->getManager();
                $empleado->setClave(

                    $encoder->encodePassword($empleado, $cambioCLave->getNuevaClave())

                );
                $em->flush();
                $this->addFlash('success','Se ha cambiado la contraseña con éxito');
                $this->redirectToRoute('empleados_form',['id'=> $empleado->getId()]);

            }catch (\Exception $ex){

                $this->addFlash('error','Error: No se ha podido cambiar la contraseña');

            }

        }

        return $this->render('empleados/establecerClave.html.twig',[

            'formulario'=> $form->createView(),
            'empleado'=> $empleado

        ]);
    }

}