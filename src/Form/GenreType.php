<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $genreChoises = $options['genre_choices'];

        foreach ($genreChoises as $genres){
            $builder->add($genres, CheckboxType::class, [
                'label' => $genres,
                'mapped' => false,
                'required' => false,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);

        // Déclarez l'option personnalisée genre_choices
        $resolver->setRequired(['genre_choices']);
    }
}





