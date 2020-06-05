<?php


namespace AppBundle\Controller;


use AppBundle\Form\Model\MensajeModel;
use AppBundle\Form\Type\MensajeFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class MensajesController extends Controller
{

    /**
     * @Route("/mensaje", name="envioMensaje", methods={"GET","POST"})
     *  @Security("is_granted('ROLE_GESTOR')")
     */
    public function envioAction(Request $request,\Swift_Mailer $swift_Mailer){

        $mensaje = new MensajeModel();

        $form = $this->createForm(MensajeFormType::class,$mensaje);
        $form->handleRequest($request);




        if ($form->isSubmitted() && $form->isValid() ){
            /** @var  UploadedFile $aAdjunto  */
            $aAdjunto = $form->get('adjunto')->getData();

            $textoMensaje = $mensaje->getMensaje();
            $asunto = $mensaje->getAsunto();
            $receptor = $form->get('email')->getData();

            $mensaje = (new \Swift_Message($asunto))
                ->setFrom('jesus.martinez.gonzalez1993@gmail.com')
                ->setTo($receptor)
                ->setBody( $textoMensaje)
                ->attach(\Swift_Attachment::fromPath( $aAdjunto->getPathname())->setFilename($aAdjunto->getClientOriginalName()));


            $swift_Mailer->send($mensaje);

            $this->addFlash('success','Mensaje enviado');

        }

        return $this->render('mensajes/mensajeEmail.html.twig',[

            'form' => $form->createView()
        ]);
    }

}