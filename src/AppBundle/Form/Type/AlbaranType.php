<?php


namespace AppBundle\Form\Type;

use AppBundle\Entity\Albaran;
use AppBundle\Entity\Empleado;
use AppBundle\Entity\Producto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlbaranType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('empleado',EntityType::class,[

                'label'=> 'Empleado:',
                'class'=> Empleado::class,
                'placeholder'=>'<-Seleccione un empleado->'
            ])
            ->add('fecha',DateType::class,[

                'label' => 'Fecha:'


            ])
            ->add('cantidad', NumberType::class,[

                'label'=> 'Unidades:'
            ])
            ->add('proveedor', TextType::class,[

                'label'=> 'Proveedor:'
            ])
            ->add('productos',EntityType::class,[

                'label'=>'Productos:',
                'class'=> Producto::class,
                'multiple'=> true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class'=> Albaran::class
        ]);
    }

}