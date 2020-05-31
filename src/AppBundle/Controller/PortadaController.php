<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PortadaController extends Controller
{
    /**
     * @Route("/", name="portada")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('portadas/portada.html.twig');
    }


    /**
     * @Route("/presupuesto/portada", name="presupuesto_portada")
     * @Security("is_granted('ROLE_COMERCIAL')")
     */

    public function portadaAction(){

        return $this->render('portadas/portadaPrespuestos.html.twig');

    }

    /**
     * @Route("/presupuesto/documentacion", name="presupuesto_documentacion")
     * @Security("is_granted('ROLE_COMERCIAL')")
     */

    public function portadaDocumentacionAction(){

        return $this->render('presupuestos/documentacion.html.twig');

    }


    /**
     * @Route("/factura/portada", name="factura_portada")
     * @Security("is_granted('ROLE_GESTOR')")
     */

    public function portadaFacturas(){

        return $this->render('portadas/facturaPortada.html.twig');

    }


    /**
     * @Route("/cliente/portada", name="cliente_portada")
     * @Security("is_granted('ROLE_GESTOR')")
     */

    public function portadaClientes(){

        return $this->render('portadas/clientePortada.html.twig');

    }

    /**
     * @Route("/parte/portada", name="parte_portada")
     * @Security("is_granted('ROLE_INSTALADOR')")
     */

    public function portadaPartes(){

        return $this->render('portadas/partesPortada.html.twig');

    }


    /**
     * @Route("/producto/portada", name="producto_portada")
     * @Security("is_granted('ROLE_GESTOR')")
     */

    public function portadaProductos(){

        return $this->render('portadas/productosPortada.html.twig');

    }

    /**
     * @Route("/albaran/portada", name="albaran_portada")
     * @Security("is_granted('ROLE_GESTOR')")
     */

    public function portadaAlbaranes(){

        return $this->render('portadas/albaranesPortada.html.twig');

    }

    /**
     * @Route("/delegacion/portada", name="delegacion_portada")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */

    public function portadaDelegaciones(){

        return $this->render('portadas/delegacionesPortada.html.twig');

    }

    /**
     * @Route("/empleado/portada", name="empleado_portada")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */

    public function portadaEmpleados(){

        return $this->render('portadas/empleadoPortada.html.twig');

    }


}
