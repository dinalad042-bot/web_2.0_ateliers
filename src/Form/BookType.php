<?php

namespace App\Form;

use App\Entity\Auther;
use App\Entity\Book;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('ref', TextType::class)
            ->add('publicationDate', DateType::class)
            ->add('published',CheckboxType::class)
            // Champ Category : Liste déroulante (ChoiceType)
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'Science-Fiction' => 'Science-Fiction',
                    'Mystery' => 'Mystery',
                    'Autobiography' => 'Autobiography',
                ],
                // On peut aussi utiliser 'expanded' => false, 'multiple' => false pour une simple liste déroulante
            ])

            // Champ Author : Relation ManyToOne vers l'entité Author
            // EntityType est souvent utilisé pour les relations Doctrine
            ->add('auther', EntityType::class, [
                'class' => Auther::class,
                'choice_label' => 'name', // Afficher le nom d'utilisateur de l'auteur dans la liste
            ])

            // Bouton de soumission
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
