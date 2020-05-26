<?php


namespace AppBundle\Form\Type;


use AppBundle\Entity\Delegacion;
use AppBundle\Entity\Empleado;
use AppBundle\Form\Model\InformeEmpleadosModel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InformeEmpleadoDelegacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('delegacion',EntityType::class,[

                'class'=> Delegacion::class,
                'label'=>'Delegación:',
                'placeholder'=>'<- Seleccione delegación ->',
                'required'=> false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class'=> InformeEmpleadosModel::class

        ]);
    }


}