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

    public function obtenerDelegacionesQueryBuilder(){

        return $this->createQueryBuilder('d')
            ->orderBy('d.provincia');


    }

    public function obtenerDelegaciones(){

        return $this->obtenerDelegacionesQueryBuilder()
            ->getQuery()
            ->getResult();

    }

    public function obtenerResultados2($palabra){


        return $this->createQueryBuilder('del')
            ->Where('del.nombre LIKE :texto')
            ->setParameter('texto','%'.$palabra.'%')
            ->getQuery()
            ->getResult();
    }
}