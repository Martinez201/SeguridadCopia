<?php


namespace AppBundle\Form\Type;


use AppBundle\Entity\Cliente;
use AppBundle\Entity\DatosBancarios;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DatosBancariosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('iban', TextType::class,[

                'label'=> 'IBAM'
            ])
            ->add('moneda', TextType::class,[

                'label'=> 'Moneda'
            ])
            ->add('entidad',TextType::class,[

                'label'=> 'Entidad'
            ])
            ->add('sucursal', NumberType::class,[

                'label'=> 'Sucursal'
            ])
            ->add('bic',TextType::class,[

                'label'=> 'Código B.I.C'
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class'=> DatosBancarios::class
        ]);
    }


}