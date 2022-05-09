<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\Publisher;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublisherType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [

            ])
            ->add('website', TextType::class, [

            ])
            ->add('slug', TextType::class, [

            ])
            ->add('country', EntityType::class, [
                'class'=>Country::class,
                'choice_label'=>'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        //formulaire basé sur l'entité publisher
        $resolver->setDefaults([
            'data_class' => Publisher::class,
        ]);
    }
}
