<?php

namespace App\Form;

use App\Entity\Forum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod('GET')
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'required' => false,
                'attr'=>[
                    'placeholder'=> 'Titre'
                ]
            ])
            ->add('date_beginning', DateType::class, [
                'label' => 'Date de création',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('date_end', DateType::class, [
                'label' => 'Date de clôture',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('publisher', SubmitType::class, [
                'label' => 'Envoyer',
                'attr'=>[
                    'class' => 'btn btn-green'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // 'data_class' => Forum::class,
        ]);
    }
}
