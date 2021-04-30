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
use AppBundle\Repository\ClienteRepository;
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
            'Edad'=>$cliente->getFechaNacimiento(),
            'Direccion'=> $cliente->getDireccion(),
            'Provincia'=> $cliente->getProvincia(),
            'Estado'=>$cliente->isEstado(),
            'Id'=> $cliente->getId()
        );

    }

    public function serializeDatosBancarios(DatosBancarios  $datosBancarios){

        return array(
            'Id'=> $datosBancarios->getId(),
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
            'Direccion'=> $delegacion->getDireccion(),
            'Postal'=> $delegacion->getCPostal(),
            'Telefono'=> $delegacion->getTelefono(),
            'Email'=> $delegacion->getEmail(),
        );
    }

    public function serializeAlbaran(Albaran $albaran){

        return array(
            'Id'=> $albaran->getId(),
            'Fecha'=> $albaran->getFecha(),
            'Proveedor'=> $albaran->getProveedor(),
            'Empleado'=> $albaran->getEmpleado(),
            'Contenido'=> $albaran->getContenido()
        );
    }

    public function serializeContenidoAlbaran(ContenidoAlbaran $contenidoAlbaran){

        return array(
            'Id'=> $contenidoAlbaran->getId(),
            'Producto'=> $contenidoAlbaran->getProducto(),
            'Cantidad'=> $contenidoAlbaran->getCantidad(),
            'Total'=> $contenidoAlbaran->getTotal(),
            'Albaran'=> $contenidoAlbaran->getAlbaran()
        );
    }

    public function serializeContenidoPresupuesto(ContenidoPresupuesto $contenidoPresupuesto){

        return array(
            'Id'=>$contenidoPresupuesto->getId(),
            'Cantidad'=> $contenidoPresupuesto->getCantidad(),
            'Total'=> $contenidoPresupuesto->getTotal(),
            'Producto'=> $contenidoPresupuesto->getProducto(),
            'Presupuesto'=> $contenidoPresupuesto->getPresupuesto()
        );

    }

    public function serializePresupuesto(Presupuesto $presupuesto){

        return array(
            'Id'=> $presupuesto->getId(),
            'Fecha'=> $presupuesto->getFecha(),
            'Empleado'=> $presupuesto->getEmpleado(),
            'Instalacion'=> $presupuesto->getInstalacion(),
            'Estado'=> $presupuesto->isEstado(),
            'Contrato'=> $presupuesto->getContrato(),
            'Contenido'=> $presupuesto->getContenido(),
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

        return array(
            'Nombre'=> $empleado->getNombre(),
            'Apellidos'=> $empleado->getApellidos(),
            'Dni'=> $empleado->getDni(),
            'Edad'=> $empleado->getEdad(),
            'Telefono'=> $empleado->getTelefono(),
            'Direccion'=> $empleado->getDireccion(),
            'Ciudad'=>$empleado->getCiudad(),
            'Postal'=> $empleado->getCPostal(),
            'Provincia'=> $empleado->getProvincia(),
            'Email'=> $empleado->getEmail(),
            'Usuario'=> $empleado->getUsuario(),
            'Password'=> $empleado->getPassword(),
            'Roles'=> $empleado->getRoles(),
            'Delegacion'=> $empleado->getDelegacion(),
            'Administrador'=> $empleado->isAdministrador(),
            'Gestor'=> $empleado->isGestor(),
            'Comercial'=> $empleado->isComercial(),
            'Instalador'=> $empleado->isInstalador(),
            'Id'=> $empleado->getId()
        );
    }

    public function serializeFactura(Factura $factura){

        return array(
            'Empleado'=> $factura->getEmpleado(),
            'Cliente'=> $factura->getCliente(),
            'Fecha'=> $factura->getFecha(),
            'PVP_IVA'=> $factura->getPrecioConIva(),
            'PVP_SIN_IVA'=> $factura->getPrecioSinIva(),
            'Concepto'=> $factura->getConcepto(),
            'Id'=> $factura->getId()
        );
    }

    public function serializeParte(Parte $parte){

        return array(
            'Cliente'=> $parte->getCliente(),
            'Detalle'=> $parte->getDetalle(),
            'Empleado'=> $parte->getEmpleado(),
            'Fecha'=> $parte->getFecha(),
            'Observaciones'=>$parte->getObservaciones(),
            'Estado'=> $parte->isEstado(),
            'Tipo'=> $parte->getTipo(),
            'Delegacion'=> $parte->getDelegacion(),
            'Id'=> $parte->getId()
        );

    }

    /**
     * @Route("/movil/parte/form", name = "partes_formulario_constructor")
     */

    public function ParteFormBuild(){

        $formulario = array(

            'Campos'=> array(
                        'Cliente'=> 'Int',
                        'Detalle'=> 'String',
                        'Empleado'=> 'Int',
                        'Fecha'=> 'DateTime',
                        'Observaciones'=>'String',
                        'Estado'=> 'Boolean',
                        'Tipo'=> 'Int',
                        'Delegacion'=> 'Int',
                        'Id'=> 'Int'
                    )
        );

        $response = new JsonResponse($formulario,200);

        return $response;
    }

    /**
     * @Route("/movil/clientes", name = "clientes_Listar_movil")
     */

    public function clientesAction(ClienteRepository $clienteRepository){

        $clientes = $clienteRepository->findAll();

        $data = array('clientes'=>array());
        foreach ($clientes as $cliente){
            $data['clientes'][] = $this->serializeCliente($cliente);
        }

        $response = new JsonResponse($data,200);

        return $response;
    }

    /**
     * @Route("/movil/camposFormulario", name = "clientes_Listar_campos")
     */

    public function clientesCampos(ClienteRepository $clienteRepository){

        $clientes = $clienteRepository->obtenerCampos();

        $data = array('clientes'=>array());
        foreach ($clientes as $cliente){
            $data['clientes'][] = $this->serializeCliente($cliente);
        }

        $response = new JsonResponse($data,200);

        return $response;
    }
}