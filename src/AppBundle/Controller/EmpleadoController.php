<?php


namespace AppBundle\Controller;


use AppBundle\Repository\EmpleadoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class EmpleadoController extends Controller
{

    /**
     * @Route("/empleados", name="empleados_listar")
     */

    public function indexAction(EmpleadoRepository $empleadoRepository){

        $empleados = $empleadoRepository->obtenerEmpleados();

        return $this->render('empleados/listarEmpleados.html.twig',[

            'empleados' => $empleados

        ]);

    }

}