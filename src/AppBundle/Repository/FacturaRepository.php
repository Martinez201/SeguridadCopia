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

    public function obtenerFacturasPorFechas($fechaInicial, $fechaFinal){

        return $this->createQueryBuilder('fa')
            ->Where('fa.fecha BETWEEN :fechaInicial AND :fechaFinal')
            ->setParameter('fechaInicial',$fechaInicial)
            ->setParameter('fechaFinal',$fechaFinal)
            ->getQuery()
            ->getResult();

    }

    public function obtenerFacturasPorFechasCliente($fechaInicial, $fechaFinal,$cliente){

        return $this->createQueryBuilder('fa')
            ->Where('fa.fecha BETWEEN :fechaInicial AND :fechaFinal')
            ->andWhere('fa.cliente = :cliente')
            ->setParameter('fechaInicial',$fechaInicial)
            ->setParameter('fechaFinal',$fechaFinal)
            ->setParameter('cliente',$cliente)
            ->getQuery()
            ->getResult();

    }

}