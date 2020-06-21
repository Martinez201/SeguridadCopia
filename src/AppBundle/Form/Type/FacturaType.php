<?php


namespace AppBundle\Form\Type;


use AppBundle\Entity\Cliente;
use AppBundle\Entity\Empleado;
use AppBundle\Entity\Factura;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FacturaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $usuario = $options['user'];

        $builder
            ->add('cliente', EntityType::class,[

                'label'=> 'Cliente',
                'class'=> Cliente::class,
                'query_builder'=> function(EntityRepository $entityRepository) use($usuario){

                    $qb = $entityRepository->createQueryBuilder('cli')
                        ->where('cli.estado = 1');

                    if (!$usuario->isAdministrador()){

                        $qb->andWhere('cli.provincia = :provincia')
                            ->setParameter('provincia', $usuario->getDelegacion()->getProvincia());
                    }


                    return $qb;

                },
                'placeholder'=>'<-Seleccione un cliente->'
            ])
            ->add('fecha', DateType::class,[

                'label'=> 'Fecha',
                'years'=> range(date('1980'),date('Y')),
                'widget'=> 'single_text'
            ])
            ->add('precioSinIva',NumberType::class,[

                'label'=> 'Precio sin Iva'
            ])
            ->add('concepto', TextType::class,[

                'label'=> 'Concepto'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class'=> Factura::class,
            'user' => null
        ]);
    }


}