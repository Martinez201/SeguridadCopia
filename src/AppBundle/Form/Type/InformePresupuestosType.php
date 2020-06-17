<?php


namespace AppBundle\Form\Type;


use AppBundle\Entity\Empleado;
use AppBundle\Form\Model\InformePresupuestosModel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InformePresupuestosType extends AbstractType
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

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class' => InformePresupuestosModel::class

            ]);
    }

}