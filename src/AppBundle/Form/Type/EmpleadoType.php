<?php


namespace AppBundle\Form\Type;


use AppBundle\Entity\Delegacion;
use AppBundle\Entity\Empleado;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EmpleadoType extends AbstractType
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
            ->add('edad',DateType::class,[

                'label'=> 'Fecha nacimiento',
                'years'=> range(date('1910'),date('Y')-18),
                'widget'=>'single_text'
            ])
            ->add('telefono',TextType::class,[

                'label'=> 'Teléfono'
            ])
            ->add('direccion',TextType::class,[

                'label'=> 'Dirección'
            ])
            ->add('ciudad',TextType::class,[

                'label'=> 'Ciudad'
            ])
            ->add('cPostal',TextType::class,[

                'label'=> 'Código postal'
            ])
            ->add('provincia',TextType::class,[

                'label'=> 'Provincia'
            ])
            ->add('email',EmailType::class,[

                'label'=> 'Correo electrónico'
            ])
            ->add('direccion',TextType::class,[

                'label'=> 'Dirección'
            ])
            ->add('administrador',CheckboxType::class,[

                'label'=> 'Administrador',
                'required'=> false
            ])
            ->add('gestor',CheckboxType::class,[

                'label'=> 'Gestor',
                'required'=> false
            ])
            ->add('instalador',CheckboxType::class,[

                'label'=> 'Instalador',
                'required'=> false
            ])
            ->add('comercial',CheckboxType::class,[

                'label'=> 'Comercial',
                'required'=> false
            ])
            ->add('usuario',TextType::class,[

                'label'=> 'Usuario'
            ])
            ->add('clave', PasswordType::class,[

                'label'=> 'Contraseña (provisional)'

            ])
            ->add('delegacion', EntityType::class,[

                'label'=> 'Delegación',
                'class' => Delegacion::class,
                'placeholder'=> '<-Selecione una delegación->'

            ])
            ->add('avatar', FileType::class,[

                'label' => 'Avatar',
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
            ])
            ->add('mensaje',ChoiceType::class,[

                'mapped'=>false,
                'label'=>'¿Enviar usuario y contraseña?',
                'choices'=>[

                    'Si'=> 1,
                    'No'=> 0
                ],
                'placeholder'=>'<- Seleccione una opcion ->',
                'required'=>false

            ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class'=> Empleado::class

        ]);
    }

}