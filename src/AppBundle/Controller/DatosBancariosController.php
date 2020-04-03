<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Cliente;
use AppBundle\Entity\DatosBancarios;
use AppBundle\Form\Type\DatosBancariosType;
use AppBundle\Repository\ClienteRepository;
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
     * @Route("/domiciliacion/{id}"), name="cliente_eliminar", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public  function formAction(Request $request, DatosBancarios $datosBancarios){

        $form = $this->createForm(DatosBancariosType::class,$datosBancarios);
        $form->handleRequest($request);

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
            'datos'=> $datosBancarios

        ]);
    }

}