<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchBarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('searchValue')
            ->add('submit', SubmitType::class, [
                'label' => '<i class="fa-regular fa-magnifying-glass"></i>',
                'label_html' => true,
                'attr' => [
                        'class' => 'btn btn-primary',
                        'placeholder' => 'Search',
                ]
            ])
        ;
    }
}