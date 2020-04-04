<?php


namespace AppBundle\Repository;

use AppBundle\Entity\Factura;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class FacturaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Factura::class);
    }


    public function obtenerFacturasOrdenadas(){

        return $this->createQueryBuilder('f')
            ->addSelect('e')
            ->addSelect('c')
            ->leftJoin('f.empleado','e')
            ->leftJoin('f.cliente','c')
            ->orderBy('f.fecha')
            ->getQuery()
            ->getResult();
    }
}