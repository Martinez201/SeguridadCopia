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
use ClassesWithParents\E;
use DateTime;
use Pagerfanta\Adapter\ArrayAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;
use function Couchbase\passthruEncoder;


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
            'Ciudad'=> $delegacion->getCiudad()
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
     * @Route("/movil/alta/presupuesto", name="altas_presupuesto_movil", methods={"GET","POST"})
     */

    public function nuevaActioPresupuesto(Request $request, EmpleadoRepository  $empleadoRepository){

        $datos = json_decode($request->getContent(),true);


        /** @var Empleado $empleado */
        $empleado = $empleadoRepository->find(intval($datos["empleado"]));

        $presupuesto = new Presupuesto();

        $presupuesto->setFecha(date_create_from_format('d-m-Y',$datos["fecha"]));
        $presupuesto->setEmpleado($empleado);
        $presupuesto->setInstalacion($datos["instalacion"]);

        if ($datos["estado"] == "FALSE"){

            $presupuesto->setEstado(false);
        }else{

            $presupuesto->setEstado(true);
        }


        $this->getDoctrine()->getManager()->persist($presupuesto);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $response = new JsonResponse($presupuesto,200);

        return $response;
    }

    /**
     * @Route("/movil/alta/albaran", name="altas_albaranes_movil", methods={"GET","POST"})
     */

    public function nuevaActioAlbaran(Request $request, EmpleadoRepository  $empleadoRepository){

        $datos = json_decode($request->getContent(),true);


        /** @var Empleado $empleado */
        $empleado = $empleadoRepository->find(intval($datos["empleado"]));

        $albaran = new Albaran();

        $albaran->setFecha(date_create_from_format('d-m-Y',$datos["fecha"]));
        $albaran->setEmpleado($empleado);
        $albaran->setProveedor($datos["proveedor"]);

        $this->getDoctrine()->getManager()->persist($albaran);

        $em = $this->getDoctrine()->getManager();
        $em->flush();


        $response = new JsonResponse($albaran,200);

        return $response;
    }

    /**
     * @Route("/movil/alta/empleado", name="altas_empleado_movil", methods={"GET","POST"})
     */

    public function nuevaActionEmpleado(Request $request, DelegacionRepository  $delegacionRepository /*, UserPasswordEncoderInterface $passwordEncoder */){

        $datos = json_decode($request->getContent(),true);

        /**@var  Delegacion $delegacion */
        $delegacion = $delegacionRepository->find(intval($datos["delegacion"]));

        $administrador = true;
        $comercial = true;
        $instalador = true;
        $gestor = true;

        if ($datos["admin"] == "FALSE"){

            $administrador = false;

        }

        if ($datos["comercial"] == "FALSE"){

            $comercial = false;

        }


        if ($datos["instalador"] == "FALSE"){

            $instalador = false;

        }


        if ($datos["gestor"] == "FALSE"){

            $gestor = false;

        }


        $empleado = new Empleado();
        $empleado->setNombre($datos["nombre"]);
        $empleado->setEdad(date_create_from_format('d-m-Y',$datos["nacimiento"]));
        $empleado->setDelegacion($delegacion);
        $empleado->setDni($datos["dni"]);
        $empleado->setApellidos($datos["apellidos"]);
        $empleado->setTelefono($datos["telefono"]);
        $empleado->setEmail($datos["email"]);
        $empleado->setCPostal($datos["cPostal"]);
        $empleado->setCiudad($datos["ciudad"]);
        $empleado->setProvincia($datos["provincia"]);
        $empleado->setDireccion($datos["direccion"]);
        $empleado->setAvatar("");
        $empleado->setComercial($comercial);
        $empleado->setGestor($gestor);
        $empleado->setInstalador($instalador);
        $empleado->setUsuario($datos["usuario"]);
        $empleado->setAdministrador($administrador);
        $empleado->setClave($datos["password"]);
        //$clave = $passwordEncoder->encodePassword($empleado,$datos["password"]);
        // $empleado->setClave($clave);


        $this->getDoctrine()->getManager()->persist($empleado);

        $em = $this->getDoctrine()->getManager();
        $em->flush();


        $response = new JsonResponse($empleado,200);

        return $response;

    }

    /**
     * @Route("/movil/alta/parte", name="altas_parte_movil", methods={"GET","POST"})
     */

    public function nuevaActionParte(Request $request , ClienteRepository $clienteRepository, EmpleadoRepository  $empleadoRepository){

        $datos = json_decode($request->getContent(),true);

        /**@var  Cliente $cliente */
        $cliente = $clienteRepository->find(intval($datos["cliente"]));


        /** @var Empleado $empleado */
        $empleado = $empleadoRepository->find(intval($datos["empleado"]));



        /**  Parte parte */
        $parte = new Parte();

        $parte->setCliente($cliente);
        $parte->setObservaciones($datos["observaciones"]);
        $parte->setDelegacion($empleado->getDelegacion());
        $parte->setEstado($datos["estado"]);
        $parte->setFecha(date_create_from_format('d-m-Y',$datos["fecha"]));
        $parte->setDetalle($datos["detalle"]);

        if ($datos["tipo"] == "AVERÍA"){

            $parte->setTipo(3);

        }else if($datos["tipo"] == "MANTENIMIENTO"){

            $parte->setTipo(2);

        }else{

            $parte->setTipo(1);

        }

        $parte->setEmpleado($empleado);



        $this->getDoctrine()->getManager()->persist($parte);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $response = new JsonResponse($empleado->getDelegacion(),200);

        return $response;
    }



    /**
     * @Route("/movil/alta/cliente", name="altas_clientes_movil", methods={"GET","POST"})
     */

    public function nuevaActionCliente(Request $request){

        $datos = json_decode($request->getContent(),true);

        /** Cliente clienteNuevo */

        $clienteNuevo = new Cliente();

        $clienteNuevo->setCiudad($datos["ciudad"]);
        $clienteNuevo->setApellidos($datos["apellidos"]);
        $clienteNuevo->setDireccion($datos["direccion"]);
        $clienteNuevo->setProvincia($datos["provincia"]);
        $clienteNuevo->setCPostal($datos["cPostal"]);
        $clienteNuevo->setEmail($datos["email"]);
        $clienteNuevo->setTelefono($datos["telefono"]);
        $clienteNuevo->setNombre($datos["nombre"]);
        $clienteNuevo->setDni($datos["dni"]);
        $clienteNuevo->setFechaNacimiento(date_create_from_format('d-m-Y',$datos["nacimiento"]));

        if ($datos["estado"] == "BAJA"){

            $clienteNuevo->setEstado(false);

        }else{

            $clienteNuevo->setEstado(true);
        }

        $this->getDoctrine()->getManager()->persist($clienteNuevo);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $response = new JsonResponse($clienteNuevo,200);

        return $response;
    }



    /**
     * @Route("/movil/alta/delegacion", name="altas_delegaciones_movil", methods={"GET","POST"})
     */

    public function nuevaActionDelegacion(Request $request, DelegacionRepository $delegacionRepository){

        $datos = json_decode($request->getContent(),true);

        /**  Delegacion delegacionNueva */

        $delegacionNueva = new Delegacion();

        $delegacionNueva->setCiudad($datos["ciudad"]);
        $delegacionNueva->setDireccion($datos["direccion"]);
        $delegacionNueva->setProvincia($datos["provincia"]);
        $delegacionNueva->setCPostal($datos["cPostal"]);
        $delegacionNueva->setEmail($datos["email"]);
        $delegacionNueva->setTelefono($datos["telefono"]);
        $delegacionNueva->setNombre($datos["identificacion"]);

        $this->getDoctrine()->getManager()->persist($delegacionNueva);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $response = new JsonResponse($delegacionNueva,200);

        return $response;
    }



    /**
     * @Route("/movil/alta/producto", name="altas_producto_movil", methods={"GET","POST"})
     */

    public function nuevaActionProducto(Request $request ){

        $datos = json_decode($request->getContent(),true);


        $producto= new Producto();
        $producto->setNombre($datos["nombre"]);
        $producto->setTipo($datos["tipo"]);
        $producto->setCantidad(intval($datos["stock"]));
        $producto->setImagen("");
        $producto->setPrecio(floatval($datos["precio"]));


        $this->getDoctrine()->getManager()->persist($producto);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $response = new JsonResponse($producto,200);

        return $response;
    }

    /**
     * @Route("/movil/alta/factura", name="altas_factura_movil", methods={"GET","POST"})
     */

    public function nuevaActionFactura(Request $request  , ClienteRepository $clienteRepository, EmpleadoRepository  $empleadoRepository){

        $datos = json_decode($request->getContent(),true);


        /**@var  Cliente $cliente */
        $cliente = $clienteRepository->find(intval($datos["cliente"]));


        /** @var Empleado $empleado */
        $empleado = $empleadoRepository->find(intval($datos["empleado"]));


        $factura = new Factura();
        $factura->setEmpleado($empleado);
        $factura->setFecha(date_create_from_format('d-m-Y',$datos["fecha"]));
        $factura->setCliente($cliente);
        $factura->setConcepto($datos["concepto"]);
        $factura->setPrecioSinIva(floatval($datos["precio"]));
        $factura->setPrecioConIva(floatval($datos["precio"]));

        $this->getDoctrine()->getManager()->persist($factura);

        $em = $this->getDoctrine()->getManager();
        $em->flush();


        $response = new JsonResponse($factura,200);

        return $response;
    }



    /**
     * @Route("/movil/login", name="inicio_session_movil", methods={"GET","POST"})
     */

    public function comprobarDatosUsuario(Request $request, EmpleadoRepository $empleadoRepository){

        $datos = json_decode($request->getContent(),true);


        $respuesta = $empleadoRepository->comprobarCredenciales($datos["usuario"],$datos["dni"]);


        $response = new JsonResponse($respuesta,200);

        return $response;

    }

    /**
     * @Route("/movil/clientes/buscar", name="buscar_cliente_movil", methods={"GET","POST"})
     */

    public function buscarClienteMovil(Request $request, ClienteRepository $clienteRepository){

        $datos = json_decode($request->getContent(),true);
        $data = array();

        /**@var Cliente $respuesta*/
        $clientes = $clienteRepository->obtenerResultados2($datos["busqueda"]);

        foreach ($clientes as $cliente){

            $data [$cliente->getId()] = $this->serializeCliente($cliente);

        }

        $response = new JsonResponse($data,200);

        return $response;

    }

    /**
     * @Route("/movil/albaranes/buscar", name="buscar_albaran_movil", methods={"GET","POST"})
     */

    public function buscarAlbaranMovil(Request $request, AlbaranRepository $albaranRepository){

        $datos = json_decode($request->getContent(),true);
        $data = array();

        /**@var Albaran $respuesta*/
        $albaranes = $albaranRepository->obtenerResultados2($datos["busqueda"]);

        foreach ($albaranes as $albaran){

            $data [$albaran->getId()] = $this->serializeAlbaran($albaran);

        }

        $response = new JsonResponse($data,200);

        return $response;

    }


    /**
     * @Route("/movil/delegaciones/buscar", name="buscar_delegacion_movil", methods={"GET","POST"})
     */

    public function buscarDelegacionMovil(Request $request, DelegacionRepository $delegacionRepository){

        $datos = json_decode($request->getContent(),true);
        $data = array();

        /**@var Cliente $respuesta*/
        $delegaciones = $delegacionRepository->obtenerResultados2($datos["busqueda"]);

        foreach ($delegaciones as $delegacion){

            $data [$delegacion->getId()] = $this->serializeDelegacion($delegacion);

        }

        $response = new JsonResponse($data,200);

        return $response;

    }


    /**
     * @Route("/movil/empleados/buscar/form", name="buscar_empleados_movil_form", methods={"GET","POST"})
     */

    public function buscarEmpleadoMovil(Request $request, EmpleadoRepository $empleadoRepository){

        $datos = json_decode($request->getContent(),true);
        $data = array();

        $empleados = $empleadoRepository->obtenerEmpleadoId(intval($datos["busqueda"]));

        foreach ($empleados as $empleado){

            $data [$empleado->getId()] = $this->serializeEmpleado($empleado);

        }

        $response = new JsonResponse($data,200);

        return $response;

    }

    /**
     * @Route("/movil/cliente/buscar/form", name="buscar_cliente_movil_form", methods={"GET","POST"})
     */

    public function buscarClienteFormMovil(Request $request, ClienteRepository $clienteRepository){

        $datos = json_decode($request->getContent(),true);
        $data = array();

        $clientes = $clienteRepository->obtenerClienteId(intval($datos["busqueda"]));

        foreach ($clientes as $cliente){

            $data [$cliente->getId()] = $this->serializeCliente($cliente);

        }

        $response = new JsonResponse($data,200);

        return $response;

    }

    /**
     * @Route("/movil/albaran/buscar/form", name="buscar_albaran_movil_form", methods={"GET","POST"})
     */

    public function buscarAlbaranFormMovil(Request $request, AlbaranRepository $albaranRepository){

        $datos = json_decode($request->getContent(),true);
        $data = array();

        $albaranes = $albaranRepository->obtenerAlbaranId(intval($datos["busqueda"]));

        foreach ($albaranes as $albaran){

            $data [$albaran->getId()] = $this->serializeAlbaran($albaran);

        }

        $response = new JsonResponse($data,200);

        return $response;

    }

    /**
     * @Route("/movil/factura/buscar/form", name="buscar_factura_movil_form", methods={"GET","POST"})
     */

    public function buscarFacturaFormMovil(Request $request, FacturaRepository $facturaRepository){

        $datos = json_decode($request->getContent(),true);
        $data = array();

        $facturas = $facturaRepository->obtenerFacturaId(intval($datos["busqueda"]));

        foreach ($facturas as $factura){

            $data [$factura->getId()] = $this->serializeFactura($factura);

        }

        $response = new JsonResponse($data,200);

        return $response;

    }

    /**
     * @Route("/movil/delegacion/buscar/form", name="buscar_delegacion_movil_form", methods={"GET","POST"})
     */

    public function buscarDelegacionFormMovil(Request $request, DelegacionRepository $delegacionRepository){

        $datos = json_decode($request->getContent(),true);
        $data = array();

        $delegaciones = $delegacionRepository->obtenerDelegacionId(intval($datos["busqueda"]));

        foreach ($delegaciones as $delegacion){

            $data [$delegacion->getId()] = $this->serializeDelegacion($delegacion);

        }

        $response = new JsonResponse($data,200);

        return $response;

    }

    /**
     * @Route("/movil/producto/buscar/form", name="buscar_producto_movil_form", methods={"GET","POST"})
     */

    public function buscarProductoFormMovil(Request $request, ProductoRepository $productoRepository){

        $datos = json_decode($request->getContent(),true);
        $data = array();

        $productos = $productoRepository->obtenerProductoId(intval($datos["busqueda"]));

        foreach ($productos as $producto){

            $data [$producto->getId()] = $this->serializeProducto($producto);

        }

        $response = new JsonResponse($data,200);

        return $response;

    }

    /**
     * @Route("/movil/parte/buscar/form", name="buscar_parte_movil_form", methods={"GET","POST"})
     */

    public function buscarParteFormMovil(Request $request, ParteRepository $parteRepository){

        $datos = json_decode($request->getContent(),true);
        $data = array();

        $partes= $parteRepository->obtenerParteId(intval($datos["busqueda"]));

        foreach ($partes as $parte){

            $data [$parte->getId()] = $this->serializeParte($parte);

        }

        $response = new JsonResponse($data,200);

        return $response;

    }
    /**
     * @Route("/movil/presupuesto/buscar/form", name="buscar_presupuesto_movil_form", methods={"GET","POST"})
     */

    public function buscarPresupuestoFormMovil(Request $request, PresupuestoRepository $presupuestoRepository){

        $datos = json_decode($request->getContent(),true);
        $data = array();

        $presupuestos = $presupuestoRepository->obtenerPresupuestoId(intval($datos["busqueda"]));

        foreach ($presupuestos as $presupuesto){

            $data [$presupuesto->getId()] = $this->serializePresupuesto($presupuesto);

        }

        $response = new JsonResponse($data,200);

        return $response;

    }

    /**
     * @Route("/movil/parte/modificar", name="parte_movil_modificar", methods={"GET","POST"})
     */

    public function parteModificarMovil(Request $request, ParteRepository $parteRepository){

        $datos = json_decode($request->getContent(),true);
        $respuesta = array('Succes'=>200);


        /**@var Parte $parte */
        $parte = $parteRepository->find(intval($datos["id"]));

        $parte->setDetalle($datos["detalle"]);
        $parte->setTipo($datos["tipo"]);
        $parte->setObservaciones($datos["observaciones"]);
        $parte->setFecha(date_create_from_format('d-m-Y',$datos["fecha"]));
        $parte->setEstado($datos["estado"]);


        $em = $this->getDoctrine()->getManager();
        $em->flush();
        $response = new JsonResponse($respuesta,200);

        return $response;

    }

    /**
     * @Route("/movil/delegacion/modificar", name="delegacion_movil_modificar", methods={"GET","POST"})
     */

    public function delegacionModificarMovil(Request $request, DelegacionRepository $delegacionRepository){

        $datos = json_decode($request->getContent(),true);
        $respuesta = array('Succes'=>200);


        /**@var Delegacion $delegacion */
        $delegacion = $delegacionRepository->find(intval($datos["id"]));

        $delegacion->setNombre($datos["identificacion"]);
        $delegacion->setDireccion($datos["direccion"]);
        $delegacion->setCiudad($datos["ciudad"]);
        $delegacion->setProvincia($datos["provincia"]);
        $delegacion->setEmail($datos["email"]);
        $delegacion->setTelefono($datos["telefono"]);
        $delegacion->setCPostal($datos["cPostal"]);


        $em = $this->getDoctrine()->getManager();
        $em->flush();
        $response = new JsonResponse($respuesta,200);

        return $response;

    }

    /**
     * @Route("/movil/factura/modificar", name="factura_movil_modificar", methods={"GET","POST"})
     */

    public function facturaModificarMovil(Request $request, FacturaRepository  $facturaRepository){

        $datos = json_decode($request->getContent(),true);

        /**@var Factura $factura */
        $factura = $facturaRepository->find(intval($datos["facturaId"]));



        $factura->setPrecioSinIva(floatval($datos["precioC"]));
        $factura->setPrecioConIva(floatval($datos["precio"]));
        $factura->setFecha(date_create_from_format('d-m-Y',$datos["fecha"]));
        $factura->setConcepto($datos["concepto"]);


        $em = $this->getDoctrine()->getManager();
        $em->flush();
        $response = new JsonResponse($factura,200);

        return $response;

    }

    /**
     * @Route("/movil/producto/modificar", name="producto_movil_modificar", methods={"GET","POST"})
     */

    public function productoModificarMovil(Request $request, ProductoRepository $productoRepository){

        $datos = json_decode($request->getContent(),true);

        $respuesta = array('Succes'=>200);

        /**@var Producto $producto */
        $producto= $productoRepository->find(intval($datos["productoId"]));


        $producto->setNombre($datos["nombre"]);
        $producto->setTipo($datos["tipo"]);
        $producto->setCantidad(intval($datos["stock"]));
        $producto->setPrecio(floatval($datos["precio"]));


        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $response = new JsonResponse($respuesta,200);

        return $response;

    }

    /**
     * @Route("/movil/cliente/modificar", name="cliente_movil_modificar", methods={"GET","POST"})
     */
    public function clienteModificarMovil(Request $request, ClienteRepository $clienteRepository){

        $datos = json_decode($request->getContent(),true);

        $respuesta = array('Succes'=>200);

        /**@var Cliente $cliente */
        $cliente= $clienteRepository->find(intval($datos["Id"]));


        $cliente->setNombre($datos["nombre"]);
        $cliente->setNombre($datos["apellidos"]);
        $cliente->setNombre($datos["direccion"]);
        $cliente->setNombre($datos["ciudad"]);
        $cliente->setNombre($datos["provincia"]);
        $cliente->setNombre($datos["email"]);
        $cliente->setNombre($datos["telefono"]);
        $cliente->setNombre($datos["cPostal"]);
        $cliente->setNombre($datos["dni"]);
        $cliente->setNombre(date_create_from_format('d-m-Y',$datos["nacimiento"]));
        $cliente->setNombre($datos["estado"]);


        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $response = new JsonResponse($respuesta,200);

        return $response;

    }

    /**
     * @Route("/movil/albaran/modificar", name="albaran_movil_modificar", methods={"GET","POST"})
     */

    public function albaranModificarMovil(Request $request,AlbaranRepository $albaranRepository){

        $datos = json_decode($request->getContent(),true);
        $respuesta = array('Succes'=>200);

        /**@var Albaran $albaran */
        $albaran = $albaranRepository->find(intval($datos["id"]));

        $albaran->setFecha(date_create_from_format('d-m-Y',$datos["fecha"]));
        $albaran->setProveedor($datos["proveedor"]);


        $em = $this->getDoctrine()->getManager();
        $em->flush();



        $response = new JsonResponse($respuesta,200);

        return $response;

    }

    /**
     * @Route("/movil/empleado/modificar", name="empleado_movil_modificar", methods={"GET","POST"})
     */

    public function empleadoModificarMovil(Request $request, EmpleadoRepository $empleadoRepository,UserPasswordEncoderInterface $passwordEncoder,DelegacionRepository  $delegacionRepository){

        $datos = json_decode($request->getContent(),true);
        $respuesta = array('Succes'=>200);

        /**@var Empleado $empleado */
        $empleado = $empleadoRepository->find(intval($datos["id"]));

        /**@var Delegacion $delegacion */
        $delegacion = $delegacionRepository->find(intval($datos["delegacion"]));


        $empleado->setUsuario($datos["usuario"]);
        $empleado->setClave($passwordEncoder->encodePassword($empleado,$datos["password"]));
        $empleado->setNombre($datos["nombre"]);
        $empleado->setApellidos($datos["apellidos"]);
        $empleado->setDireccion($datos["direccion"]);
        $empleado->setCiudad($datos["ciudad"]);
        $empleado->setProvincia($datos["provincia"]);
        $empleado->setEmail($datos["email"]);
        $empleado->setTelefono($datos["telefono"]);
        $empleado->setCPostal($datos["cPostal"]);
        $empleado->setDni($datos["dni"]);
        $empleado->setEdad(date_create_from_format('d-m-Y',$datos["nacimiento"]));
        $empleado->setDelegacion($delegacion);

        if ($datos["comercial"] == "true"){

            $empleado->setComercial(true);
        }

        if ($datos["gestor"] == "true"){

            $empleado->setGestor(true);
        }

        if ($datos["instalador"] == "true"){

            $empleado->setInstalador(true);
        }

        if ($datos["admin"] == "true"){

            $empleado->setAdministrador(true);
        }

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $response = new JsonResponse($respuesta,200);

        return $response;

    }



}