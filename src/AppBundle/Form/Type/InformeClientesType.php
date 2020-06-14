<?php


namespace AppBundle\Form\Type;


use AppBundle\Form\Model\InformeClientesModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InformeClientesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('estado',ChoiceType::class,[

                'label' => 'Estado',
                'choices' =>[

                    'Alta' => true,
                    'Baja' => false
                ],
                'placeholder'=> '<-Seleccione una opción->'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class'=>InformeClientesModel::class

        ]);
    }

}