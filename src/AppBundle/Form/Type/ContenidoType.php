<?php


namespace AppBundle\Form\Type;


use AppBundle\Entity\ContenidoAlbaran;
use AppBundle\Entity\Producto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContenidoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('producto', EntityType::class,[

                'label'=>'Producto:',
                'class'=> Producto::class,
                'placeholder'=>'<-Seleccione un producto->'
            ])
            ->add('cantidad',NumberType::class,[

                'label'=>'Cantidad:'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class'=> ContenidoAlbaran::class

        ]);
    }

}