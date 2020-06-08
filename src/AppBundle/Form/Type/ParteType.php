<?php


namespace AppBundle\Form\Type;


use AppBundle\Entity\Cliente;
use AppBundle\Entity\Delegacion;
use AppBundle\Entity\Empleado;
use AppBundle\Entity\Parte;
use AppBundle\Repository\ClienteRepository;
use AppBundle\Repository\DelegacionRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $usuario = $options['user'];
        $builder
            ->add('cliente', EntityType::class,[

                'label'=> 'Cliente:',
                'class'=> Cliente::class,
                'query_builder'=> function(EntityRepository $entityRepository) use($usuario){

                    $qb = $entityRepository->createQueryBuilder('cli');

                    if (!$usuario->isAdministrador()){

                        $qb->where('cli.provincia = :provincia')
                            ->setParameter('provincia', $usuario->getDelegacion()->getProvincia());
                    }


                    return $qb;

                },
                'placeholder'=>'<-Seleccione un cliente->'
            ])
            ->add('detalle', TextareaType::class,[

                'label'=> 'Detalles:'
            ])
            ->add('tipo', ChoiceType::class,[

                'label'=> 'Tipo:',
                'choices'=>[

                    'Instalación'=> 1,
                    'Mantenimiento'=> 2,
                    'Avería'=>3
                ]

            ])
            ->add('observaciones', TextareaType::class,[

                'label'=> 'Observaciones:'
            ])
            ->add('fecha', DateType::class,[

                'label'=> 'Fecha:',
                'years'=> range(date('1980'),date('Y')),
                'widget'=> 'single_text'
            ])
            ->add('estado', ChoiceType::class,[

                'label'=> 'Estado:',
                'choices'=>[
                    'Abierto'=> true,
                    'Cerrado'=> false
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
     $resolver->setDefaults([

         'data_class'=> Parte::class,
         'user' => null

     ]);

    }

}