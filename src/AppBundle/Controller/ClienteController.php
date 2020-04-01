<?php


namespace AppBundle\Controller;


use AppBundle\Repository\ClienteRepository;
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
}