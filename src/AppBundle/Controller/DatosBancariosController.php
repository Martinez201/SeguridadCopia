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
     * @Route("/clientes/domiciliacion/{id}", name = "listar_datos")
     */

    public function clientesAction(DatosBancariosRepository $datosBancariosRepository, Cliente $cliente){

        $datos = $datosBancariosRepository->datosBancariosCliente($cliente);


        return $this->render('datosBancarios/listarDatosBancarios.html.twig',[

            'datos' => $datos,
            'cliente' => $cliente
        ]);

    }

    /**
     * @Route("/domiciliacion/alta/{id}", name="altas_domiciliacion",requirements={"id" = "\d+"}, methods={"GET","POST"})
     *
     */

    public function nuevoAction(Request $request,Cliente $cliente){

        $datosBancarios = new DatosBancarios();
        $this->getDoctrine()->getManager()->persist($datosBancarios);
        return $this->formAction($request,$datosBancarios,$cliente);

    }


    /**
     * @Route("/domiciliacion/{id}"), name="cliente_eliminar", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public  function formAction(Request $request, DatosBancarios $datosBancarios,Cliente $cliente){

        $form = $this->createForm(DatosBancariosType::class,$datosBancarios);
        $form->handleRequest($request);

        $datosBancarios->setCliente($cliente);

        if($form->isSubmitted() && $form->isValid()){

            try {

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success','Se han guardado los datos con éxito');

            }catch (\Exception $ex){

                $this->addFlash('error', 'Error: no se ha podido guardar los cambios');
            }

        }

        return $this->render('datosBancarios/form.html.twig',[

            'form'=> $form->createView(),
            'datos'=> $datosBancarios,


        ]);
    }

    /**
     *@Route("/domiciliacion/eliminar/{id}"), name="domiciliacion_eliminar", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function eliminarAction(Request $request, DatosBancarios $datosBancarios){

        if ($request->getMethod() == 'POST'){


            try {

                $cli = $this->getDoctrine()->getManager();
                $cli->remove($datosBancarios);
                $cli->flush();
                $this->addFlash('success','Domiciliación  eliminada éxito');
                return $this->redirectToRoute('clientes_Listar');

            }catch (\Exception $ex){

                $this->addFlash('error','Error: no se ha eliminar la domiciliación');
            }

        }

        return $this->render('datosBancarios/eliminar.html.twig',[

            'datos' => $datosBancarios

        ]);

    }
}