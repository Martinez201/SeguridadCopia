<?php


namespace AppBundle\Controller;


use AppBundle\Form\Type\MensajeFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class MensajesController extends Controller
{

    /**
     * @Route("/mensaje", name="envioMensaje", methods={"GET","POST"})
     */
    public function envioAction(Request $request,\Swift_Mailer $swift_Mailer){

        $form = $this->createForm(MensajeFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ){

            $textoMensaje = $form->get('mensaje')->getData();
            $asunto = $form->get('asunto')->getData();
            $receptor = $form->get('email')->getData();

            $mensaje = (new \Swift_Message($asunto))
                ->setFrom('jesus.martinez.gonzalez1993@gmail.com')
                ->setTo($receptor)
                ->setBody( $textoMensaje);

            $swift_Mailer->send($mensaje);

            $this->addFlash('success','Mensaje enviado');
        }

        return $this->render('mensajes/mensajeEmail.html.twig',[

            'form' => $form->createView()
        ]);
    }

}