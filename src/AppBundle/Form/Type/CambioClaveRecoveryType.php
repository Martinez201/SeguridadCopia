<?php


namespace AppBundle\Form\Type;


use AppBundle\Form\Model\CambioClaveRecoveryModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CambioClaveRecoveryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
           $builder
               ->add('nuevaClave', RepeatedType::class,[
                   'type'=> PasswordType::class,
                   'first_options'=>[

                       'label'=>'Nueva contraseña'
                   ],
                   'second_options'=>[

                       'label'=> 'Repita la contraseña:'
                   ]

               ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class'=> CambioClaveRecoveryModel::class

        ]);
    }


}