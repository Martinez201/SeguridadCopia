<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Presupuesto;
use Symfony\Component\Form\AbstractType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class PresupuestoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry )
    {
        parent::__construct($registry, Presupuesto::class );
    }

    public function obtenerPresupuestosOrdenadosQueryBuilder(){

        return $this->createQueryBuilder('p')
            ->addSelect('e')
            ->leftJoin('p.empleado','e')
            ->orderBy('p.fecha');

    }

    public function obtenerPresupuestosOrdenados(){

        return $this->obtenerPresupuestosOrdenadosQueryBuilder()
            ->getQuery()
            ->getResult();
    }

}