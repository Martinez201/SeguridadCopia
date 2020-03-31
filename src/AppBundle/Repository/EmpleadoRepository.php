<?php

namespace AppBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use AppBundle\Entity\Empleado;


class EmpleadoRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Empleado::class);
    }


    function obtenerEmpleados(){

        return $this->createQueryBuilder('ep')
            ->addSelect('ep')
            ->orderBy('ep.nombre')
            ->addOrderBy('ep.apellidos')
            ->getQuery()
            ->getResult();

    }

}