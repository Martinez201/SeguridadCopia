<?php


namespace AppBundle\Repository;

use AppBundle\Entity\Albaran;
use AppBundle\Entity\Empleado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class AlbaranRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Albaran::class);
    }

    public function obtenerAlbaranesOrdenadosQueryBuilder(Empleado $empleado = null){

         $qb = $this->createQueryBuilder('a')
            ->orderBy('a.fecha');

        if($empleado){

            $qb->andWhere('a.empleado = :empleado')
                ->setParameter('empleado',$empleado);
        }
        return $qb;
    }

    public function obtenerAlbaranesOrdenados(){

        return $this->obtenerAlbaranesOrdenadosQueryBuilder()
            ->getQuery()
            ->getResult();
    }

    public function obtenerResultados2($palabra){

        return $this->createQueryBuilder('al')
            ->Where('al.fecha LIKE :texto')
            ->setParameter('texto','%'.$palabra.'%')
            ->getQuery()
            ->getResult();
    }

    public function obtenerAlbaranId($id){
        return $this->createQueryBuilder('cl')
            ->where('cl.id = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getResult();
    }

}