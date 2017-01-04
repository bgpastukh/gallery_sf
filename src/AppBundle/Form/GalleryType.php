<?php

namespace AppBundle\Form;

use AppBundle\Entity\Gallery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalleryType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ...
            ->add('file', FileType::class, ['label' => 'Image (jpg/jpeg/png)', 'attr' => ['class' => 'btn btn-lg btn-default choose rf']])
            ->add('comment', TextType::class, ['label' => 'Comment', 'attr' => ['class' => 'comment rf']])
            ->add('submit', SubmitType::class, ['label' => 'Send', 'attr' => ['class' => 'btn btn-lg btn-default submit']])
            // ...
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Gallery::class,
            'csrf_protection'   => false
        ));
    }
}