<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Producto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ProductoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Producto::class);
    }

    function obtenerProductosQueryBuilder(){

        return $this->createQueryBuilder('p')
            ->addSelect('p')
            ->orderBy('p.nombre');


    }

    function obtenerProductos(){

        return $this->obtenerProductosQueryBuilder()
            ->getQuery()
            ->getResult();
    }


    function obtenerProducto($producto){

        return $this->createQueryBuilder('pro')
            ->where('pro.id = :producto')
            ->setParameter('producto',$producto)
            ->getQuery()
            ->getResult();

    }

}