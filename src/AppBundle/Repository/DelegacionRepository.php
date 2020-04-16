<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Delegacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class DelegacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Delegacion::class);
    }

    public function obtenerDelegaciones(){

        return $this->createQueryBuilder('d')
            ->orderBy('d.provincia')
            ->getQuery()
            ->getResult();

    }
}