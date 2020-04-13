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


    public function obtenerFacturasOrdenadasQueryBuilder(){

        return $this->createQueryBuilder('f')
            ->addSelect('e')
            ->addSelect('c')
            ->leftJoin('f.empleado','e')
            ->leftJoin('f.cliente','c')
            ->orderBy('f.fecha');
    }

    public function obtenerFacturasOrdenadas(){

        return $this->obtenerFacturasOrdenadasQueryBuilder()
            ->getQuery()
            ->getResult();
    }

    public function obtenerFactura(Factura $factura){

        return $this->createQueryBuilder('f')
            ->addSelect('e')
            ->addSelect('c')
            ->leftJoin('f.empleado','e')
            ->leftJoin('f.cliente','c')
            ->where('f.id = :factura')
            ->setParameter('factura',$factura)
            ->getQuery()
            ->getResult();
    }
}