<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Cliente;
use AppBundle\Form\Type\ClienteType;
use AppBundle\Repository\ClienteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class ClienteController extends Controller
{

    /**
     * @Route("/clientes", name = "clientes_Listar")
     */

    public function clientesAction(ClienteRepository $clienteRepository){

        $clientes = $clienteRepository->obtenerClientesOrdenados();


        return $this->render('clientes/listarClientes.html.twig',[

            'clientes' => $clientes
        ]);

    }

    /**
     * @Route("/clientes/{id}", name= "clientes_form", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function formAction(Request $request, Cliente $cliente){

        $form = $this->createForm(ClienteType::class, $cliente);
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

        return $this->render('clientes/from.html.twig',[

            'form' => $form->createView(),
            'cliente' => $cliente

        ]);
    }

}