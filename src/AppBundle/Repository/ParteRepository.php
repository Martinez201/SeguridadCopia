<?php


namespace AppBundle\Repository;

use AppBundle\Entity\Delegacion;
use AppBundle\Entity\Empleado;
use AppBundle\Entity\Parte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


class ParteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parte::class);
    }

    public function obtenerPartesOrdenadosQueryBuilder($sw,Delegacion $delegacion = null){

        $qb= $this->createQueryBuilder('p')
            ->addSelect('d')
            ->addSelect('e')
            ->addSelect('c')
            ->leftJoin('p.delegacion','d')
            ->leftJoin('p.empleado','e')
            ->leftJoin('p.cliente','c')
            ->orderBy('p.fecha');

        if($delegacion && !$sw){

            $qb->andWhere('p.delegacion = :delegacion')
                ->setParameter('delegacion',$delegacion);
        }

        return $qb;

    }

    public function obtenerPartesOrdenados($sw = 0){

        return $this->obtenerPartesOrdenadosQueryBuilder($sw)
            ->getQuery()
            ->getResult();
    }

    public function obtenerPartesPorFechas($fechaInicial, $fechaFinal, $estado){

        return $this->createQueryBuilder('pa')
            ->Where('pa.fecha BETWEEN :fechaInicial AND :fechaFinal')
            ->andWhere('pa.estado = :estado')
            ->setParameter('fechaInicial',$fechaInicial)
            ->setParameter('fechaFinal',$fechaFinal)
            ->setParameter('estado',$estado)
            ->getQuery()
            ->getResult();


    }

    public function obtenerPartesPorFechasDelegacion($fechaInicial, $fechaFinal, $delegacion,$estado){

        return $this->createQueryBuilder('pa')
            ->Where('pa.fecha BETWEEN :fechaInicial AND :fechaFinal')
            ->andWhere('pa.delegacion = :delegacion')
            ->andWhere('pa.estado = :estado')
            ->setParameter('fechaInicial',$fechaInicial)
            ->setParameter('fechaFinal',$fechaFinal)
            ->setParameter('delegacion',$delegacion)
            ->setParameter('estado',$estado)
            ->getQuery()
            ->getResult();

    }

    public function obtenerPartesEstado($estado){

        return $this->createQueryBuilder('pa')
            ->where('pa.estado = :estado')
            ->setParameter('estado',$estado)
            ->getQuery()
            ->getResult();
    }

    public function obtenerPartesPorFechasCantidad($fechaInicial, $fechaFinal){

        return $this->createQueryBuilder('pa')
            ->select('COUNT(pa)')
            ->Where('pa.fecha BETWEEN :fechaInicial AND :fechaFinal')
            ->setParameter('fechaInicial',$fechaInicial)
            ->setParameter('fechaFinal',$fechaFinal)
            ->getQuery()
            ->getSingleScalarResult();

    }


}