<?php


namespace AppBundle\Repository;

use AppBundle\Entity\Albaran;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class AlbaranRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Albaran::class);
    }

    public function obtenerAlbaranesOrdenadosQueryBuilder(){

        return $this->createQueryBuilder('a')
            ->orderBy('a.fecha');


    }

    public function obtenerAlbaranesOrdenados(){

        return $this->obtenerAlbaranesOrdenadosQueryBuilder()
            ->getQuery()
            ->getResult();
    }
}