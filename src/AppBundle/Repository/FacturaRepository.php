<?php


namespace AppBundle\Repository;

use AppBundle\Entity\Empleado;
use AppBundle\Entity\Factura;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class FacturaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Factura::class);
    }


    public function obtenerFacturasOrdenadasQueryBuilder(Empleado $empleado = null){

        $qb = $this->createQueryBuilder('f')
            ->addSelect('e')
            ->addSelect('c')
            ->leftJoin('f.empleado','e')
            ->leftJoin('f.cliente','c')
            ->orderBy('f.fecha');

        if($empleado){

            $qb->where('f.empleado = :empleado')
                ->setParameter('empleado',$empleado);
        }

        return $qb;
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

    public function obtenerFacturasPorFechasProvincia($fechaInicial, $fechaFinal, $empleado = null){

        return $this->createQueryBuilder('fa')
            ->addSelect('m')
            ->leftJoin('fa.empleado','m')
            ->Where('fa.fecha BETWEEN :fechaInicial AND :fechaFinal')
            ->setParameter('fechaInicial',$fechaInicial)
            ->setParameter('fechaFinal',$fechaFinal)
            ->andWhere('m.provincia = :empleado')
            ->setParameter('empleado',$empleado)
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


    public function obtenerFacturasPorFechasCantidadProvincia($fechaInicial, $fechaFinal,  $empleado = null){

        return $this->createQueryBuilder('fa')
            ->addSelect('m')
            ->leftJoin('fa.empleado','m')
            ->select('COUNT(fa)')
            ->Where('fa.fecha BETWEEN :fechaInicial AND :fechaFinal')
            ->setParameter('fechaInicial',$fechaInicial)
            ->setParameter('fechaFinal',$fechaFinal);

    }

    public function obtenerFacturasPorFechasCantidad($fechaInicial, $fechaFinal){

        return $this->createQueryBuilder('fa')
            ->select('COUNT(fa)')
            ->Where('fa.fecha BETWEEN :fechaInicial AND :fechaFinal')
            ->setParameter('fechaInicial',$fechaInicial)
            ->setParameter('fechaFinal',$fechaFinal);

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

    public function obtenerFacturaId($id){
        return $this->createQueryBuilder('cl')
            ->where('cl.id = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getResult();
    }

}