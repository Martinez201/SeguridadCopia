<?php


namespace AppBundle\Form\Type;


use AppBundle\Entity\Cliente;
use AppBundle\Entity\Empleado;
use AppBundle\Entity\Presupuesto;
use AppBundle\Entity\Producto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PresupuestoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('empleado', EntityType::class,[

                'label'=>'Empleado:',
                'class'=> Empleado::class,
                'placeholder'=> '<-Seleccione un empleado->'

            ])
            ->add('cliente', EntityType::class,[

                'label'=> 'Cliente:',
                'class'=> Cliente::class,
                'placeholder'=>'<-Seleccione un cliente->'
            ])
            ->add('instalacion',TextType::class,[

                'label'=> 'Instalación(Dirección):'
            ])
            ->add('fecha', DateType::class,[

                'label'=> 'Fecha prevista(Instalación):'
            ])
            ->add('precioConIva',NumberType::class,[

                'label'=> 'Precio con Iva:'
            ])
            ->add('precioSinIva',NumberType::class,[

                'label'=> 'Precio sin Iva:'
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

            'data_class'=> Presupuesto::class
        ]);
    }

}