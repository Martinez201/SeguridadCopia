<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Cliente;
use AppBundle\Entity\DatosBancarios;
use AppBundle\Form\Type\DatosBancariosType;
use AppBundle\Repository\DatosBancariosRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class DatosBancariosController extends Controller
{

    /**
     * @Route("/domiciliacion/{id}", name = "listar_datos")
     */

    public function clientesAction(DatosBancariosRepository $datosBancariosRepository, Cliente $cliente){

        $datos = $datosBancariosRepository->datosBancariosCliente($cliente);


        return $this->render('datosBancarios/listarDatosBancarios.html.twig',[

            'datos' => $datos,
            'cliente' => $cliente
        ]);

    }

    /**
     * @Route("/datosbanco/alta/{id}", name="domiciliacion_alta",methods={"GET","POST"})
     */

    public function nuevaAction(Request $request,Cliente $cliente){

        $datosBancarios = new DatosBancarios();
        $this->getDoctrine()->getManager()->persist($datosBancarios);
        $datosBancarios->setCliente($cliente);
        return $this->formAction($request,$datosBancarios);
    }

    /**
     * @Route("/datosbanco/{id}", name= "domiciliacion_form", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function formAction(Request $request, DatosBancarios $datosBancarios){

        $form = $this->createForm(DatosBancariosType::class, $datosBancarios);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            try {

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success','Se han guardado los datos con éxito');

            }catch (\Exception $ex){

                $this->addFlash('error', 'Error: no se ha podido guardar los cambios');
            }

        }

        return $this->render('datosBancarios/form.html.twig',[

            'form' => $form->createView(),
            'datos' => $datosBancarios

        ]);
    }

    /**
     * @Route("/datosbanco/eliminar/{id}", name="domiciliacion_eliminar", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */
    public function eliminarAction(Request $request, DatosBancarios $datosBancarios){

        if ($request->getMethod() == 'POST'){


            try {

                $cli = $this->getDoctrine()->getManager();
                $cli->remove($datosBancarios);
                $cli->flush();
                $this->addFlash('success','Domiciliación borrada con éxito');
                return $this->redirectToRoute('clientes_Listar');

            }catch (\Exception $ex){

                $this->addFlash('error','Error: no se ha podido borrar la domiciliación');
            }

        }

        return $this->render('datosBancarios/eliminar.html.twig',[

            'datos' => $datosBancarios

        ]);

    }
}