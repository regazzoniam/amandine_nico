<?php

namespace App\Form;

use App\Entity\Country;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CountryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr'=>[
                    'placeholder'=> 'Nom'
                ]
            ])
            ->add('nationality', TextType::class, [
                'attr'=>[
                    'placeholder'=> 'Nationalité'
                ]
            ])
            ->add('code', TextType::class, [
                'attr'=>[
                    'placeholder'=> 'Code'
                ]
            ])
            ->add('slug', TextType::class, [
                'attr'=>[
                    'placeholder'=> 'Slug'
                ]
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
            'data_class' => Country::class,
        ]);
    }
}
