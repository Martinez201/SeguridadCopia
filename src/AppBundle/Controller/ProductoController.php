<?php


namespace AppBundle\Controller;


use AppBundle\Repository\ProductoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class ProductoController extends Controller
{

    /**
     * @Route("/productos", name = "productos_Listar")
     */

    public function productosAction(ProductoRepository $productoRepository){

        $productos= $productoRepository->obtenerProductos();


        return $this->render('productos/listarProductos.html.twig',[

            'productos' => $productos
        ]);

    }
}