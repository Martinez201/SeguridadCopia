<?php


namespace AppBundle\Repository;

use AppBundle\Entity\Cliente;
use AppBundle\Entity\DatosBancarios;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class DatosBancariosRepository extends  ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DatosBancarios::class);
    }

    public function datosBancariosCliente(Cliente $cliente){

        return $this->createQueryBuilder('d')
            ->where('d.cliente = :cliente')
            ->setParameter('cliente',$cliente)
            ->getQuery()
            ->getResult();

    }

}