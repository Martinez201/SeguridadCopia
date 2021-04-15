<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Cliente;
use AppBundle\Entity\Empleado;
use AppBundle\Entity\Factura;
use AppBundle\Entity\Parte;
use AppBundle\Repository\ClienteRepository;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class ApiController extends Controller
{

    /**
     * @Route("/movil/entrar", name= "usuario_entrar_movil")
     */

    public function entrarAction(AuthenticationUtils $authenticationUtils){

        $error = $authenticationUtils->getLastAuthenticationError();
        $ultimoUsuario = $authenticationUtils->getLastUsername();

        if ($error == null){

            return new JsonResponse($ultimoUsuario);

        }
        else{

            return new JsonResponse($error);

        }
    }

    /**
     * @Route("/movil/salir", name="usuario_salir_movil")
     */

    public function salirAction(){

    }

    /**
     * @Route("/movil/cliente/buscar", name="cliente_buscar_movil")
     */

    public function buscarCliente(ClienteRepository $clienteRepository, Request $request){


        if($request->isXmlHttpRequest()){

            $palabra = $request->get('palabra');

            $resultado = $clienteRepository->obtenerResultados($palabra);

            return new JsonResponse($resultado);
        }

        return new JsonResponse("");
    }

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
            'provincia'=> $cliente->getProvincia(),
            'estado'=>$cliente->isEstado()
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
            'Instalador'=> $empleado->isInstalador()
        );
    }

    public function serializeFactura(Factura $factura){

        return array(
            'Empleado'=> $factura->getEmpleado(),
            'Cliente'=> $factura->getCliente(),
            'Fecha'=> $factura->getFecha(),
            'PVP_IVA'=> $factura->getPrecioConIva(),
            'PVP_SIN_IVA'=> $factura->getPrecioSinIva(),
            'Concepto'=> $factura->getConcepto()
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
            'Delegacion'=> $parte->getDelegacion()
        );

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