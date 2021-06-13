<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Delegacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use AppBundle\Entity\Empleado;


class EmpleadoRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Empleado::class);
    }


    function obtenerEmpleadosQueryBuilder(){

        return $this->createQueryBuilder('ep')
            ->addSelect('ep')
            ->orderBy('ep.nombre')
            ->addOrderBy('ep.apellidos');

    }

    function obtenerEmpleadosOrdenados(){

        return $this->obtenerEmpleadosQueryBuilder()
            ->getQuery()
            ->getResult();
    }

    function comprobarCredenciales( $usuario, $dni){

        return $this->createQueryBuilder('em')
            ->where('em.usuario = :usuario')
            ->andWhere('em.dni = :dni')
            ->setParameter('usuario',$usuario)
            ->setParameter('dni',$dni)
            ->getQuery()
            ->getArrayResult();
    }

    function obtenerEmpleadosDelegacion(Delegacion $delegacion){

        return $this->createQueryBuilder('em')
            ->where('em.delegacion = :delegacion')
            ->setParameter('delegacion',$delegacion)
            ->orderBy('em.nombre')
            ->addOrderBy('em.apellidos')
            ->getQuery()
            ->getResult();


    }

    function obtenerEmpleadoUsuario($usuario){

        return $this->createQueryBuilder('em')
            ->where('em.usuario = :usuario')
            ->setParameter('usuario',$usuario)
            ->getQuery()
            ->getResult();
    }

}