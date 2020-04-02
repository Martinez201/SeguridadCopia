<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Cliente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ClienteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cliente::class);
    }

    public function obtenerClientesOrdenados(){

        return $this->createQueryBuilder('c')
            ->addSelect('c')
            ->orderBy('c.nombre')
            ->addOrderBy('c.apellidos')
            ->getQuery()
            ->getResult();

    }

}