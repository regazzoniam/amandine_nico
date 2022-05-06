<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchBarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('searchValue', TextType::class, [
                //On peut renvoyer une donnée vide
                'required' => false,
                'attr' => [
                    'placeholder' => 'Search',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'attr' => [
               'action' => '/search' // Définit à la main l'action du formulaire
           ]
        ]);
    }
}