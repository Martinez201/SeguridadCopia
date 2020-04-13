<?php


namespace AppBundle\Repository;

use AppBundle\Entity\Parte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


class ParteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parte::class);
    }

    public function obtenerPartesOrdenadosQueryBuilder(){

        return $this->createQueryBuilder('p')
            ->addSelect('d')
            ->addSelect('e')
            ->addSelect('c')
            ->leftJoin('p.delegacion','d')
            ->leftJoin('p.empleado','e')
            ->leftJoin('p.cliente','c')
            ->orderBy('p.fecha');

    }

    public function obtenerPartesOrdenados(){

        return $this->obtenerPartesOrdenadosQueryBuilder()
            ->getQuery()
            ->getResult();
    }

}