<?php

namespace App\Form;

use App\Entity\Forum;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('title', TextType::class,[
                'label'=> 'Titre',
                'attr' => [
                    'placeholder' =>'Titre'
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label'=>'Envoyer',
                'attr' => [
                    'class' => 'btn btn-green'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forum::class
        ]);
    }
}
