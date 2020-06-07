<?php


namespace AppBundle\Form\Type;


use AppBundle\Entity\Delegacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DelegacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class,[

                'label'=>'Identificación'
            ])
            ->add('direccion', TextType::class,[

                'label'=>'Dirección'
            ])
            ->add('ciudad', TextType::class,[

                'label'=> 'Ciudad'

            ])
            ->add('provincia', TextType::class,[

                'label'=> 'Provincia'
            ])
            ->add('cPostal', TextType::class, [

                'label'=> 'Código Postal'

            ])
            ->add('telefono', TextType::class,[

                'label'=> 'Teléfono'

            ])
            ->add('email', TextType::class,[

                'label'=>'Email'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([

            'data_class'=> Delegacion::class

        ]);

    }

}