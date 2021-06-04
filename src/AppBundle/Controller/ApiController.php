<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Albaran;
use AppBundle\Entity\Cliente;
use AppBundle\Entity\ContenidoAlbaran;
use AppBundle\Entity\ContenidoPresupuesto;
use AppBundle\Entity\DatosBancarios;
use AppBundle\Entity\Delegacion;
use AppBundle\Entity\Empleado;
use AppBundle\Entity\Factura;
use AppBundle\Entity\Parte;
use AppBundle\Entity\Presupuesto;
use AppBundle\Entity\Producto;
use AppBundle\Repository\AlbaranRepository;
use AppBundle\Repository\ClienteRepository;
use AppBundle\Repository\ContenidoPresRepository;
use AppBundle\Repository\ContenidoRepository;
use AppBundle\Repository\DatosBancariosRepository;
use AppBundle\Repository\DelegacionRepository;
use AppBundle\Repository\EmpleadoRepository;
use AppBundle\Repository\FacturaRepository;
use AppBundle\Repository\ParteRepository;
use AppBundle\Repository\PresupuestoRepository;
use AppBundle\Repository\ProductoRepository;
use DateTime;
use Pagerfanta\Adapter\ArrayAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;


class ApiController extends Controller
{
    public function serializeCliente(Cliente $cliente){

        return array(
          'Nombre'=> $cliente->getNombre(),
            'Apellidos'=> $cliente->getApellidos(),
            'Ciudad'=> $cliente->getCiudad(),
            'Postal'=> $cliente->getCPostal(),
            'DNI'=> $cliente->getDni(),
            'Email'=>$cliente->getEmail(),
            'Telefono'=>$cliente->getTelefono(),
            'Nacimiento'=> $cliente->getFechaNacimiento()->format('d-m-Y'),
            'Direccion'=> str_replace(',',' ',$cliente->getDireccion()),
            'Provincia'=> $cliente->getProvincia(),
            'Estado'=>$cliente->isEstado(),
            'Id'=> $cliente->getId()
        );

    }

    public function serializeDatosBancarios(DatosBancarios  $datosBancarios){

        /** Cliente cliente */
        $cliente = $datosBancarios->getCliente();

        $arrayCliente = [];
        $arrayCliente[] = $cliente->getNombre();
        $arrayCliente[] = $cliente->getApellidos();
        $arrayCliente[] = $cliente->getId();

        return array(
            'Id'=> $datosBancarios->getId(),
            'Cliente'=>$arrayCliente,
            'Iban'=> $datosBancarios->getIban(),
            'Moneda'=> $datosBancarios->getMoneda(),
            'Entidad'=> $datosBancarios->getEntidad(),
            'Sucursal'=> $datosBancarios->getSucursal(),
            'Bic'=> $datosBancarios->getBic()
        );

    }
    public function serializeDelegacion(Delegacion $delegacion){

        return array(
            'Id'=> $delegacion->getId(),
            'Nombre'=> $delegacion->getNombre(),
            'Provincia'=> $delegacion->getProvincia(),
            'Direccion'=> str_replace(',',' ',$delegacion->getDireccion()),
            'Postal'=> $delegacion->getCPostal(),
            'Telefono'=> $delegacion->getTelefono(),
            'Email'=> $delegacion->getEmail(),
        );
    }

    public function serializeAlbaran(Albaran $albaran){
        /**@var Albaran proveedor */
        $proveedor = $albaran;

        /**@var ContenidoAlbaran contAlba */

        $empleado = $proveedor->getEmpleado();

        $arrayEmpleado = [];
        $arrayEmpleado[] = $empleado->getNombre();
        $arrayEmpleado[] = $empleado->getApellidos();
        $arrayEmpleado[] = $empleado->getId();

        return array(
            'Id'=> $albaran->getId(),
            'Fecha'=> $albaran->getFecha()->format('d-m-Y'),
            'Proveedor'=> $albaran->getProveedor() ,
            'Empleado'=> $arrayEmpleado,
        );
    }

    public function serializePresupuesto(Presupuesto $presupuesto){

        /** Empleado empleado */
        $empleado = $presupuesto->getEmpleado();

        $arrayEmpleado = [];
        $arrayEmpleado[] = $empleado->getNombre();
        $arrayEmpleado[] = $empleado->getApellidos();
        $arrayEmpleado[] = $empleado->getId();

        return array(
            'Id'=> $presupuesto->getId(),
            'Fecha'=> $presupuesto->getFecha()->format('d-m-Y'),
            'Empleado'=> $arrayEmpleado,
            'Instalacion'=> str_replace(',',' ',$presupuesto->getInstalacion()),
            'Estado'=> $presupuesto->isEstado(),
            'Contrato'=> $presupuesto->getContrato(),

        );

    }

    public function serializeProducto(Producto $producto){

        return array(
            'Nombre'=>$producto->getNombre(),
            'Cantidad'=> $producto->getCantidad(),
            'Tipo'=> $producto->getTipo(),
            'Precio'=> $producto->getPrecio(),
            'Imagen'=>$producto->getImagen(),
            'Id'=> $producto->getId()
        );
    }

    public function serializeEmpleado(Empleado $empleado){

        /**@var Delegacion delegacion */
        $delegacion = $empleado->getDelegacion();

        $delegacionArray = [];
        $delegacionArray[] = $delegacion->getId();
        $delegacionArray[] = $delegacion->getProvincia();
        $delegacionArray[] = $delegacion->getCiudad();
        $delegacionArray[] = str_replace(',',' ',$delegacion->getDireccion());
        $delegacionArray[] = $delegacion->getNombre();
        $delegacionArray[] = $delegacion->getTelefono();
        $delegacionArray[] = $delegacion->getEmail();

        return array(
            'Nombre'=> $empleado->getNombre(),
            'Apellidos'=> $empleado->getApellidos(),
            'Dni'=> $empleado->getDni(),
            'Edad'=> $empleado->getEdad()->format('d-m-Y'),
            'Telefono'=> $empleado->getTelefono(),
            'Direccion'=> str_replace(',',' ',$empleado->getDireccion()),
            'Ciudad'=>$empleado->getCiudad(),
            'Postal'=> $empleado->getCPostal(),
            'Provincia'=> $empleado->getProvincia(),
            'Email'=> $empleado->getEmail(),
            'Usuario'=> $empleado->getUsuario(),
            'Password'=> $empleado->getPassword(),
            'Roles'=> $empleado->getRoles(),
            'Delegacion'=> $delegacionArray,
            'Administrador'=> $empleado->isAdministrador(),
            'Gestor'=> $empleado->isGestor(),
            'Comercial'=> $empleado->isComercial(),
            'Instalador'=> $empleado->isInstalador(),
            'avatar'=> $empleado->getAvatar(),
            'Id'=> $empleado->getId()
        );
    }

    public function serializeFactura(Factura $factura){

        /** Empleado empleado */
        $empleado = $factura->getEmpleado();
        /** Cliente cliente */
        $cliente = $factura->getCliente();

        $arrayEmpleado = [];
        $arrayEmpleado[] = $empleado->getNombre();
        $arrayEmpleado[] = $empleado->getApellidos();
        $arrayEmpleado[] = $empleado->getId();

        $arrayCliente = [];
        $arrayCliente[] = $cliente->getNombre();
        $arrayCliente[] = $cliente->getApellidos();
        $arrayCliente[] = $cliente->getId();


        return array(
            'Empleado'=> $arrayEmpleado,
            'Cliente'=> $arrayCliente,
            'Fecha'=> $factura->getFecha()->format('d-m-Y'),
            'PVP_IVA'=> $factura->getPrecioConIva(),
            'PVP_SIN_IVA'=> $factura->getPrecioSinIva(),
            'Concepto'=> $factura->getConcepto(),
            'Id'=> $factura->getId()
        );
    }

    public function serializeParte(Parte $parte){

        /** @var Delegacion delegacion */
        $delegacion = $parte->getDelegacion();

        /** Empleado empleado */
        $empleado = $parte->getEmpleado();
        /** Cliente cliente */
        $cliente = $parte->getCliente();


        $arrayEmpleado = [];
        $arrayEmpleado[] = $empleado->getNombre();
        $arrayEmpleado[] = $empleado->getApellidos();
        $arrayEmpleado[] = $empleado->getId();

        $arrayCliente = [];
        $arrayCliente[] = $cliente->getNombre();
        $arrayCliente[] = $cliente->getApellidos();
        $arrayCliente[] = $cliente->getId();

        $delegacionArray = [];
        $delegacionArray[] = $delegacion->getId();
        $delegacionArray[] = $delegacion->getProvincia();
        $delegacionArray[] = $delegacion->getCiudad();
        $delegacionArray[] = str_replace(',',' ',$delegacion->getDireccion());
        $delegacionArray[] = $delegacion->getNombre();
        $delegacionArray[] = $delegacion->getTelefono();
        $delegacionArray[] = $delegacion->getEmail();

        return array(
            'Cliente'=> $arrayCliente,
            'Detalle'=> $parte->getDetalle(),
            'Empleado'=> $arrayEmpleado,
            'Fecha'=> $parte->getFecha()->format('d-m-Y'),
            'Observaciones'=>$parte->getObservaciones(),
            'Estado'=> $parte->isEstado(),
            'Tipo'=> $parte->getTipo(),
            'Delegacion'=> $delegacionArray,
            'Id'=> $parte->getId()
        );

    }

    /**
     * @Route("/movil/delegaciones", name = "delegaciones_Listar_movil")
     */

    public function delegacionesAction(DelegacionRepository $delegacionRepository){

        $delegaciones = $delegacionRepository->findAll();

        $data = array();
        foreach ($delegaciones as $delegacion){
            $data [$delegacion->getId()] = $this->serializeDelegacion($delegacion);
        }

        $response = new JsonResponse($data,200);

        return $response;
    }

    /**
     * @Route("/movil/presupuestos", name = "presupuestos_Listar_movil")
     */

    public function presupuestosAction(PresupuestoRepository $presupuestoRepository){

        $presupuestos = $presupuestoRepository->findAll();

        $data = array();
        foreach ($presupuestos as $presupuesto){
            $data [$presupuesto->getId()] = $this->serializePresupuesto($presupuesto);
        }

        $response = new JsonResponse($data,200);

        return $response;
    }

    /**
     * @Route("/movil/datosBancarios", name = "datosBancarios_Listar_movil")
     */

    public function datosBancariosAction(DatosBancariosRepository $datosBancariosRepository){

        $datosBancarios = $datosBancariosRepository->findAll();

        $data = array();
        foreach ($datosBancarios as $datos){
            $data [$datos->getId()] = $this->serializeDatosBancarios($datos);
        }

        $response = new JsonResponse($data,200);

        return $response;
    }

    /**
     * @Route("/movil/productos", name = "productos_Listar_movil")
     */

    public function productosAction(ProductoRepository $productoRepository){

        $productos = $productoRepository->findAll();

        $data = array();
        foreach ($productos as $producto){
            $data [$producto->getId()] = $this->serializeProducto($producto);
        }

        $response = new JsonResponse($data,200);

        return $response;
    }

    /**
     * @Route("/movil/empleados", name = "empleados_Listar_movil")
     */

    public function empleadosAction(EmpleadoRepository $empleadoRepository){

        $empleados= $empleadoRepository->findAll();

        $data = array();
        foreach ($empleados as $empleado){
            $data [$empleado->getId()] = $this->serializeEmpleado($empleado);
        }

        $response = new JsonResponse($data,200);

        return $response;
    }

    /**
     * @Route("/movil/clientes", name = "clientes_Listar_movil")
     */

    public function clientesAction(ClienteRepository $clienteRepository){

        $clientes = $clienteRepository->findAll();

        $data = array();
        foreach ($clientes as $cliente){
            $data [$cliente->getId()] = $this->serializeCliente($cliente);
        }

        $response = new JsonResponse($data,200);

        return $response;
    }

    /**
     * @Route("/movil/partes", name = "partes_Listar_movil")
     */

    public function partesAction(ParteRepository $parteRepository){

        $partes = $parteRepository->findAll();

        $data = array();
        foreach ($partes as $parte){
            $data [$parte->getId()] = $this->serializeParte($parte);
        }

        $response = new JsonResponse($data,200);

        return $response;
    }

    /**
     * @Route("/movil/facturas", name = "facturas_Listar_movil")
     */

    public function facturasAction(FacturaRepository $facturaRepository){

        $facturas = $facturaRepository->findAll();

        $data = array();
        foreach ($facturas as $factura){
            $data [$factura->getId()] = $this->serializeFactura($factura);
        }

        $response = new JsonResponse($data,200);

        return $response;
    }

    /**
     * @Route("/movil/albaranes", name = "albaranes_Listar_movil")
     */

    public function albaranesAction(AlbaranRepository $albaranRepository){

        $albaranes = $albaranRepository->findAll();

        $data = array();
        foreach ($albaranes as $albaran){
            $data [$albaran->getId()] = $this->serializeAlbaran($albaran);
        }

        $response = new JsonResponse($data,200);

        return $response;
    }

    /**
     * @Route("/movil/albaran/{id}",requirements={"id" = "\d+"}, name = "albaran_contenido_Listar_movil")
     */

    public function albaranContenidoAction(ContenidoRepository $albaranContenidoRepository, Albaran $albaran){

        $albaranes = $albaranContenidoRepository->obtenerContenidoApi($albaran);


        $data = array();
        foreach ($albaranes as $albaran){

            $productoArray = [];
            $productoArray[] = $albaran['producto']['nombre'];
            $productoArray[] = $albaran['producto']['tipo'];
            $productoArray[] = $albaran['producto']['precio'];

            $data [$albaran['id']] = array(
                'Id'=> $albaran['id'],
                'Producto'=>  $productoArray,
                'Cantidad'=> $albaran['cantidad'],
                'Total'=> $albaran['total'],
            );


        }

        $response = new JsonResponse($data,200);

        return $response;
    }
    /**
     * @Route("/movil/presupuesto/{id}",requirements={"id" = "\d+"}, name = "presupuesto_contenido_Listar_movil")
     */

    public function presupuestoContenidoAction(ContenidoPresRepository $contenidoPresRepository, Presupuesto $presupuesto){

        $contenidos = $contenidoPresRepository->obtenerContenidoApi($presupuesto);


        $data = array();

        foreach ($contenidos as $contenido){

            $productoArray = [];
            $productoArray[] = $contenido['producto']['nombre'];
            $productoArray[] = $contenido['producto']['tipo'];
            $productoArray[] = $contenido['producto']['precio'];

            $data [$contenido['id']] = array(
                'Id'=> $contenido['id'],
                'Producto'=>  $productoArray,
                'Cantidad'=> $contenido['cantidad'],
                'Total'=> $contenido['total'],
            );


        }

        $response = new JsonResponse($data,200);

        return $response;
    }


    /**
     * @Route("/movil/buscar/delegacion", name="buscar_delegaciones", methods={"GET","POST"})
     */

    public function nuevaAction(Request $request, DelegacionRepository $delegacionRepository){

        $datos = $request->get('delegacion');

        return new JsonResponse($datos);
    }



}