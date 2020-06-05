<?php


namespace AppBundle\Form\Type;


use AppBundle\Form\Model\MensajeModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MensajeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class,[

                'label'=> 'Email:'
            ])
            ->add('asunto',TextType::class,[

                'label'=>'Asunto:'
            ])
            ->add('mensaje',TextareaType::class,[

                'label'=> 'Mensaje:'
            ])
            ->add('adjunto', FileType::class,[

                'label' => 'Adjunto:',
                'required'=> false,
                'mapped'=>false,
                'constraints'=>[
                    new File([
                        'maxSize'=> '10000k',
                        'mimeTypes'=>[
                            'image/jpeg',
                            'image/x-icon',
                            'image/gif',
                            'image/png',
                            'application/x-rar-compressed',
                            'application/zip',
                            'application/x-7z-compressed',
                            'application/pdf',
                            'application/msword',
                            'application/vnd.oasis.opendocument.text'
                        ],
                        'mimeTypesMessage'=>'Error: Archivo de imagen no válido',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class'=>MensajeModel::class

        ]);
    }


}