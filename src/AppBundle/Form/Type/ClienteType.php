<?php


namespace AppBundle\Form\Type;


use AppBundle\Entity\Cliente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',TextType::class,[

                'label'=> 'Nombre'
            ])
            ->add('apellidos',TextType::class,[

                'label'=> 'Apellidos'
            ])
            ->add('dni',TextType::class,[

                'label'=> 'D.N.I'
            ])
            ->add('fechaNacimiento',DateType::class,[

                'label'=> 'Fecha nacimiento',
                'years'=> range(date('1920'),date('Y')-18),
                'widget'=> 'single_text'
            ])
            ->add('direccion',TextType::class,[

                'label'=> 'Dirección'
            ])
            ->add('ciudad', TextType::class,[

                'label'=> 'Ciudad'
            ])
            ->add('CPostal', TextType::class,[

                'label'=> 'Código Postal'
            ])
            ->add('provincia', TextType::class,[

                'label'=> 'Provincia'
            ])
            ->add('telefono', TextType::class,[

                'label'=> 'Teléfono'
            ])
            ->add('email', TextType::class,[

                'label'=> 'Email'
            ])
            ->add('estado',ChoiceType::class,[

                'label' => 'Estado',
                'choices' =>[

                    'Alta' => true,
                    'Baja' => false
                ]
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => Cliente::class
        ]);
    }

}