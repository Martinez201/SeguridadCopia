<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Cliente;
use AppBundle\Entity\Empleado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ClienteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cliente::class);
    }

    public function obtenerClientesOrdenadosQueryBuilder(Empleado $empleado = null){

        $qb = $this->createQueryBuilder('c')
            ->addSelect('d')
            ->leftJoin('c.datosBancarios','d')
            ->orderBy('c.nombre')
            ->addOrderBy('c.apellidos');

        if($empleado){
            $qb->where('c.provincia = :provincia')
                ->setParameter('provincia', $empleado->getProvincia());
        }

        return $qb;

    }

    public function obtenerCampos(){

        return $this->obtenerClientesOrdenadosQueryBuilder()
            ->setMaxResults(1)
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

    public function obtenerResultados2($palabra){


        return $this->createQueryBuilder('cli')
            ->Where('cli.apellidos LIKE :texto')
            ->setParameter('texto','%'.$palabra.'%')
            ->getQuery()
            ->getResult();
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

    public function obtenerClienteId($id){
        return $this->createQueryBuilder('cl')
            ->where('cl.id = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getResult();
    }

}