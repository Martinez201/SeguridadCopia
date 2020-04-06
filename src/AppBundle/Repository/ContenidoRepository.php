<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Albaran;
use AppBundle\Entity\ContenidoAlbaran;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ContenidoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContenidoAlbaran::class);
    }

    public function obtenerContenido(Albaran $albaran){

        return $this->createQueryBuilder('c')
            ->addSelect('p')
            ->leftJoin('c.producto','p')
            ->where('c.albaran = :albaran')
            ->setParameter('albaran',$albaran)
            ->getQuery()
            ->getResult();
    }

}