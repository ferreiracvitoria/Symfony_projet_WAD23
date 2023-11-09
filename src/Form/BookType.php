<?php

namespace App\Form;

use App\Entity\Livre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('isbn')
            // ->add('titre')
            // ->add('dateEdition')
            // ->add('numberPages')
            // ->add('resume')
            // ->add('thumbnail')
            // ->add('smallThumbnail')
            // ->add('owner')
            // ->add('classified')
            // ->add('lecteurs')
            // ->add('recommandateurs')
            ->add('titre', TextType::class, ['label' => 'Titre du livre']);

        ;
    }
    

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }

    // public function configureOptions(OptionsResolver $resolver): void
    // {
    //     $resolver->setDefaults([
    //         'data_class' => Livre::class,
    //     ]);
    // }
}
