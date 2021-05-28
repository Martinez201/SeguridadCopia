<?php


namespace AppBundle\Repository;


use AppBundle\Entity\ContenidoPresupuesto;
use AppBundle\Entity\Presupuesto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ContenidoPresRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContenidoPresupuesto::class);
    }

    public function obtenerContenido(Presupuesto $presupuesto){

        return $this->createQueryBuilder('c')
            ->addSelect('p')
            ->leftJoin('c.producto','p')
            ->where('c.presupuesto = :presupuesto')
            ->setParameter('presupuesto',$presupuesto)
            ->getQuery()
            ->getResult();
    }

    public function obtenerContenidoApi(Presupuesto $presupuesto){

        return $this->createQueryBuilder('c')
            ->addSelect('p')
            ->leftJoin('c.producto','p')
            ->where('c.presupuesto = :presupuesto')
            ->setParameter('presupuesto',$presupuesto)
            ->getQuery()
            ->getArrayResult();
    }

}