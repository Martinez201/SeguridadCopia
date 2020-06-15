<?php


namespace AppBundle\Form\Type;


use AppBundle\Entity\Cliente;
use AppBundle\Entity\Empleado;
use AppBundle\Entity\Presupuesto;
use AppBundle\Entity\Producto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PresupuestoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('instalacion',TextType::class,[

                'label'=> 'Dirección de la instalación'
            ])
            ->add('fecha', DateType::class,[

                'label'=> 'Fecha prevista de instalación',
                'widget'=> 'single_text'
            ])
            ->add('precioSinIva',NumberType::class,[

                'label'=> 'Precio sin Iva'
            ])
            ->add('contrato', FileType::class,[

                'label' => 'Documentación (ZIP)',
                'mapped' => false,
                'required'=> false,
                'constraints'=>[
                    new File([
                        'maxSize'=> '10000k',
                        'mimeTypes'=>[
                            'application/x-7z-compressed',
                            'application/zip',
                            'application/x-rar-compressed'
                        ],
                        'mimeTypesMessage'=>'Error: Archivo  no válido',
                    ])
                ],


            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class'=> Presupuesto::class
        ]);
    }

}