<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Empleado;
use AppBundle\Form\Model\CambioClaveRecoveryModel;
use AppBundle\Form\Type\CambioClaveRecoveryType;
use AppBundle\Form\Type\RecuperarClaveType;
use AppBundle\Repository\EmpleadoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Translation\TranslatorInterface;

class SeguridadController extends Controller
{

    /**
     * @Route("/entrar", name= "usuario_entrar")
     */

    public function entrarAction(AuthenticationUtils $authenticationUtils){

        $error = $authenticationUtils->getLastAuthenticationError();
        $ultimoUsuario = $authenticationUtils->getLastUsername();

        return $this->render('seguridad/entrar.html.twig',[

            'error'=> $error,
            'ultimo_usuario'=> $ultimoUsuario

        ]);

    }

    /**
     * @Route("/salir", name="usuario_salir")
     */

    public function salirAction(){

    }

    /**
     * @Route("/restablecer", name="restablecer_clave_login", methods={"GET","POST"})
     */

    public function passwordResetAction(
        \Swift_Mailer $swift_Mailer,
        Session $session,
        TranslatorInterface $translator,
        EmpleadoRepository $empleadoRepository,
        Request $request

    ){

        $form = $this->createForm(RecuperarClaveType::class);
        $form->handleRequest($request);

        $email = $form->get('email')->getData();


        if ($form->isSubmitted() && $form->isValid()){

            $envio = $this->passwordResetRequest($email,$swift_Mailer,$empleadoRepository);

        }

        return $this->render('seguridad/login_password_reset.html.twig',[

            'form'=> $form->createView()

        ]);
    }

    public function passwordResetRequest($email, \Swift_Mailer $swift_Mailer,EmpleadoRepository $empleadoRepository ){

        /**@var Empleado $usuario */

        $usuario = $empleadoRepository->findOneBy(['email'=> $email]);


        if (null === $usuario){

            $this->addFlash('error','Error: no hay ningún usuario con ese email');

        }
        else{

            $expire = (int) '5';


            if ($usuario->getToken() && $usuario->getExpireToken() >  new \DateTime()){

                $this->addFlash('error','Error: ya se ha pedido un restablecimiento de contraseña recientemente intentelo mas tarde');

            }
            else{

                $token = bin2hex(random_bytes(16));
                $usuario->setToken($token);

                $valided = new \DateTime();
                $valided->add(new \DateInterval('PT'.$expire.'M'));

                $usuario->setExpireToken($valided);

                $mensaje = (new \Swift_Message('Restablecer Contraseña'))
                    ->setFrom('jesus.martinez.gonzalez1993@gmail.com')
                    ->setTo($email)
                    ->setBody(

                        $this->renderView('seguridad/emailRecovery.html.twig',[

                            'token' => $token,
                            'usuario'=> $usuario->getId()

                        ]),
                        'text/html'

                    );

                $this->getDoctrine()->getManager()->flush();
                $swift_Mailer->send($mensaje);
                $this->addFlash('succes','Enivado link para restablecer la contraseña al correo');


            }
        }
        return  $this->redirectToRoute('usuario_entrar');
    }


    /**
     * @Route("/restablecer/{usuario}/{token}", name= "restablecer_clave_login_do", methods={"GET","POST"})
     */

    public function passResetAction(Request $request, EmpleadoRepository $empleadoRepository, UserPasswordEncoderInterface $passwordEncoder,$usuario,$token){


        /**@var Empleado $usuario1 */
        $usuario1 = $empleadoRepository->findOneBy([

            'id'=> $usuario,
            'token'=> $token
        ]);


        if (null === $usuario1 || ($usuario1->getExpireToken() < new \DateTime())){

            $this->addFlash('error','Error: no se ha podido cambiar la contraseña');
            return $this->redirectToRoute('usuario_entrar');

        }

        $form = $this->createForm(CambioClaveRecoveryType::class);
        $form->handleRequest($request);

        $contra = $form->get('nuevaClave')->getData();

        if($form->isSubmitted() && $form->isValid()){

            $clave = $passwordEncoder->encodePassword($usuario1,$contra);

            $usuario1
                ->setClave($clave)
                ->setToken(null)
                ->setTokenType(null);

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('succes','Contraseña cambiada con éxito');

            return $this->redirectToRoute('usuario_entrar');

        }

        return $this->render('seguridad/clave_reset.html.twig',[

            'form'=> $form->createView(),
            'usuario'=> $usuario

        ]);

    }

}