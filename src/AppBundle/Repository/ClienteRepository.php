<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Cliente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ClienteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cliente::class);
    }

    public function obtenerClientesOrdenadosQueryBuilder(){

        return $this->createQueryBuilder('c')
            ->addSelect('d')
            ->leftJoin('c.datosBancarios','d')
            ->orderBy('c.nombre')
            ->addOrderBy('c.apellidos');


    }

    public function obtenerClientesOrdenados(){

        return $this->obtenerClientesOrdenadosQueryBuilder()
            ->getQuery()
            ->getResult();
    }

    public function obtenerCliente(Cliente $cliente){

        return $this->createQueryBuilder('c')
            ->addSelect('d')
            ->leftJoin('c.datosBancarios','d')
            ->where('c.id = :cliente')
            ->setParameter('cliente',$cliente)
            ->getQuery()
            ->getResult();
    }

}