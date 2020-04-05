<?php


namespace AppBundle\Form\Type;


use AppBundle\Entity\Producto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',TextType::class,[

                'label'=> 'Nombre:'
            ])
            ->add('tipo', ChoiceType::class,[

                'label'=> 'Tipo:',
                'choices'=>[

                    'Producto'=>'Producto',
                    'Servicio'=>'Servicio'
                ]
            ])
            ->add('precio', NumberType::class,[

                'label'=> 'Precio:'
            ])
            ->add('cantidad', NumberType::class,[

                'label'=> 'Stock:'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

            $resolver->setDefaults([

                'data_class'=> Producto::class
            ]);
    }

}