<?php


namespace AppBundle\Form\Type;


use AppBundle\Form\Model\InformePartesModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InformePartesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaInicial',DateType::class,[

                'label'=> 'Fecha Inicial',
                'widget'=> 'single_text'

            ])
            ->add('fechaFinal', DateType::class,[

                'label'=>'Fecha Final',
                'widget'=> 'single_text'

            ])
            ->add('estado', ChoiceType::class,[

                'label'=>'Estado',
                'choices'=>[

                    'Abierto'=>1,
                    'Cerrado'=>0
                ],
                'placeholder'=> '<- Seleccione una opción ->'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class'=>InformePartesModel::class

        ]);
    }

}