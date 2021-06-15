<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Empleado;
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

    public function obtenerPresupuestosOrdenadosQueryBuilder(Empleado $empleado = null){

        $qb = $this->createQueryBuilder('p')
            ->addSelect('e')
            ->leftJoin('p.empleado','e')
            ->orderBy('p.fecha');

        if($empleado){
            $qb->where('p.empleado = :empleado')
                ->setParameter('empleado',$empleado);
        }

        return $qb;
    }

    public function obtenerPresupuestosOrdenados(){

        return $this->obtenerPresupuestosOrdenadosQueryBuilder()
            ->getQuery()
            ->getResult();
    }

    public function obtenerPresupuestosPorFechasCantidad($fechaInicial, $fechaFinal){

        return $this->createQueryBuilder('pre')
            ->select('COUNT(pre)')
            ->Where('pre.fecha BETWEEN :fechaInicial AND :fechaFinal')
            ->setParameter('fechaInicial',$fechaInicial)
            ->setParameter('fechaFinal',$fechaFinal)
            ->getQuery()
            ->getSingleScalarResult();

    }

    public function obtenerPresupuestosPorEmpleado($empleado){

        return $this->createQueryBuilder('pre')
            ->Where('pre.empleado = :empleado')
            ->setParameter('empleado',$empleado)
            ->getQuery()
            ->getResult();

    }
    public function obtenerPresupuestosPorFechas($fechaInicial, $fechaFinal){

        return $this->createQueryBuilder('pre')
            ->Where('pre.fecha BETWEEN :fechaInicial AND :fechaFinal')
            ->setParameter('fechaInicial',$fechaInicial)
            ->setParameter('fechaFinal',$fechaFinal)
            ->getQuery()
            ->getResult();

    }

    public function obtenerPresupuestosPorFechasEmpleado($fechaInicial, $fechaFinal,$empleado){

        return $this->createQueryBuilder('pre')
            ->Where('pre.fecha BETWEEN :fechaInicial AND :fechaFinal')
            ->andWhere('pre.empleado = :empleado')
            ->setParameter('fechaInicial',$fechaInicial)
            ->setParameter('fechaFinal',$fechaFinal)
            ->setParameter('empleado',$empleado)
            ->getQuery()
            ->getResult();

    }

    public function obtenerPresupuestoId($id){
        return $this->createQueryBuilder('cl')
            ->where('cl.id = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getResult();
    }


}