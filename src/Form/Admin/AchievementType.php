<?php

namespace App\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AchievementType extends AbstractType
{
    public const TYPES = [
        0 => '',
        1 => '%',
        2 => 'лет'
    ];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('count', NumberType::class, ['required' => true])
            ->add('count_type', ChoiceType::class, ['required' => true, 'choices' => array_flip(self::TYPES)])
            ->add('title', TextType::class, ['required' => true])
            ->add('description', TextareaType::class, ['required' => true]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => null,
                'allow_extra_fields' => true,
            ]
        );
    }
}
