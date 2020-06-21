<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Cliente;
use AppBundle\Entity\Empleado;
use AppBundle\Form\Type\ClienteType;
use AppBundle\Repository\ClienteRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("is_granted('ROLE_GESTOR')")
 */


class ClienteController extends Controller
{

    /**
     * @Route("/clientes/{page}", name = "clientes_Listar")
     */

    public function clientesAction(ClienteRepository $clienteRepository,$page=1){
        /** @var Empleado $usuario */
        $usuario = $this->getUser();

        if(!$usuario->isAdministrador()){

            $clientes = $clienteRepository->obtenerClientesOrdenadosQueryBuilder($usuario);
        }
        else{

            $clientes = $clienteRepository->obtenerClientesOrdenadosQueryBuilder();
        }

        $adaptador = new DoctrineORMAdapter($clientes, false);
        $pager = new Pagerfanta($adaptador);
        try {

            $pager
                ->setMaxPerPage(8)
                ->setCurrentPage($page);

        }catch (OutOfRangeCurrentPageException $ex){

            $pager->setCurrentPage(1);

        }


        return $this->render('clientes/listarClientes.html.twig',[

            'clientes' => $clientes,
            'paginador'=> $pager
        ]);

    }

    /**
     * @Route("/cliente/alta", name="altas_clientes", methods={"GET","POST"})
     */

    public function nuevaAction(Request $request){

        $cliente = new Cliente();
        $this->getDoctrine()->getManager()->persist($cliente);
        return $this->formAction($request,$cliente);
    }

    /**
     * @Route("/cliente/{id}", name= "clientes_form", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function formAction(Request $request, Cliente $cliente){

        $form = $this->createForm(ClienteType::class, $cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            try {

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success','Se han guardado los datos con éxito');
                return $this->redirectToRoute('clientes_Listar');

            }catch (\Exception $ex){

                $this->addFlash('error', 'Error: no se ha podido guardar los cambios');
            }

        }

        return $this->render('clientes/from.html.twig',[

            'form' => $form->createView(),
            'cliente' => $cliente

        ]);
    }

    /**
     * @Route("/cliente/eliminar/{id}", name="cliente_eliminar", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */

    public function eliminarAction(Request $request, Cliente $cliente){

        if ($request->getMethod() == 'POST'){


            try {

                $cli = $this->getDoctrine()->getManager();
                $cli->remove($cliente);
                $cli->flush();
                $this->addFlash('success','Cliente dado de baja con éxito');
                return $this->redirectToRoute('clientes_Listar');

            }catch (\Exception $ex){

                $this->addFlash('error','Error: no se ha podido dar de baja al cliente');
            }

        }

        return $this->render('clientes/eliminar.html.twig',[

            'cliente' => $cliente

        ]);

    }

    /**
     * @Route("/cliente/buscar", name="cliente_buscar")
     */

    public function buscarCliente(ClienteRepository $clienteRepository, Request $request){


        if($request->isXmlHttpRequest()){

            $palabra = $request->get('palabra');

                $resultado = $clienteRepository->obtenerResultados($palabra);

                return new JsonResponse($resultado);
        }

        return $this->redirectToRoute('clientes_Listar');
    }
}