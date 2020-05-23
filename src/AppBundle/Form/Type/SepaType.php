<?php


namespace AppBundle\Form\Type;


use AppBundle\Form\Model\SepaModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SepaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaInicial', DateType::class,[

                'label'=>'Fecha Inicio:',
                'years'=> range(date('1910'),date('Y')-18)

            ])
            ->add('fechaFinal',DateType::class,[

                'label'=>'Fecha Fin:',
                'years'=> range(date('1910'),date('Y'))

            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class'=> SepaModel::class

        ]);
    }

}