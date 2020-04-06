<?php


namespace AppBundle\Form\Type;


use AppBundle\Entity\Producto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

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
            ])
            ->add('imagen', FileType::class,[

                'label' => 'Imagen:',
                'mapped' => false,
                'required'=> false,
                'constraints'=>[
                    new File([
                        'maxSize'=> '5000k',
                        'mimeTypes'=>[
                            'image/jpeg',
                            'image/x-icon',
                            'image/gif',
                            'image/png'
                        ],
                        'mimeTypesMessage'=>'Error: Archivo de imagen no válido',
                    ])
                ],


            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

            $resolver->setDefaults([

                'data_class'=> Producto::class
            ]);
    }

}