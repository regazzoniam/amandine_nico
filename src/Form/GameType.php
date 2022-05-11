<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\Game;
use App\Entity\Genre;
use App\Entity\Publisher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr'=>[
                    'placeholder'=> 'Nom'
                ]
            ])
            ->add('price', TextType::class, [
                'attr'=>[
                    'placeholder'=> 'Prix'
                ]
            ])
            ->add('description', TextType::class, [
                'attr'=>[
                    'placeholder'=> 'Description'
                ]
            ])
            ->add('thumbnailCover', TextType::class, [
                'attr'=>[
                    'placeholder'=> 'Image du jeu'
                ]
            ])
            ->add('thumbnailLogo', TextType::class, [
                'attr'=>[
                    'placeholder'=> 'Logo du jeu'
                ]
            ])
            ->add('slug', TextType::class, [
                'attr'=>[
                    'placeholder'=> 'Slug'
                ]
            ])
            ->add('countries', EntityType::class, [
                'class'=>Country::class,
                'choice_label'=>'name',
                // on ajoute ces lignes pour avoir des checkboxs et pour pouvoir sélectionné plusieurs pays 
                'multiple'      => true,
                'expanded'      => true
            ])
            ->add('genres', EntityType::class, [
                'class'=>Genre::class,
                'choice_label'=>'name',
                // on ajoute ces lignes pour avoir des checkboxs et pour pouvoir sélectionné plusieurs pays 
                'multiple'      => true,
                'expanded'      => true
            ])
            ->add('publisher', EntityType::class, [
                'class'=>Publisher::class,
                'choice_label'=>'name',
            ])
            ->add('submit', SubmitType::class, [
                'label'=>'Envoyer',
                'attr'=> [
                    'class'=>'btn btn-green'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
