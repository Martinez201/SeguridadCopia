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


    public function obtenerResultados($palabra){


        return $this->createQueryBuilder('cli')
                ->Where('cli.apellidos LIKE :texto')
                ->setParameter('texto','%'.$palabra.'%')
                ->getQuery()
                ->getArrayResult();
    }

    public function obtenerClientesDelegacion($delegacion,$estado){

        return $this->createQueryBuilder('cl')
            ->where('cl.provincia = :delegacion')
            ->andwhere('cl.estado = :estado')
            ->setParameter('delegacion',$delegacion)
            ->setParameter('estado',$estado)
            ->getQuery()
            ->getResult();
    }

    public function obtenerClientesEstado($estado){

        return $this->createQueryBuilder('cl')
            ->where('cl.estado = :estado')
            ->setParameter('estado',$estado)
            ->getQuery()
            ->getResult();
    }

}