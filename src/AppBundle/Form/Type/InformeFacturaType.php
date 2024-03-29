<?php


namespace AppBundle\Form\Type;


use AppBundle\Entity\Cliente;
use AppBundle\Form\Model\InformeFacturaModel;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class InformeFacturaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $usuario = $options['user'];
        $builder
            ->add('fechaPrincipio',DateType::class,[

                'label'=> 'Fecha Inicial',
                'widget'=> 'single_text'

            ])
            ->add('fechaFinal', DateType::class,[

                'label'=>'Fecha Final',
                'widget'=> 'single_text'

            ])

            ->add('cliente', EntityType::class ,[

                'label'=>'Cliente',
                'required'=> false,
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
                'placeholder'=>'<- Seleccione un cliente ->',


            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class'=> InformeFacturaModel::class,
            'user'=> null

        ]);
    }
}