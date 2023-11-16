<?php

namespace App\Form;

use App\Entity\Livre;
use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isbn')
            ->add('titre')
            ->add('dateEdition')
            ->add('numberPages')
            ->add('resume')
            ->add('thumbnail')
            ->add('smallThumbnail')
            ->add('classified')
            ->add('lecteurs')
            ->add('recommandateurs')
            ->add('owner', EntityType::class, [
                'class' => Author::class,  // La classe de l'entité Author
                'choice_label' => 'nom',  // Le champ de l'entité Author à afficher dans le formulaire
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
