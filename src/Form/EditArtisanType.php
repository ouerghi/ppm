<?php

namespace App\Form;


use App\Entity\Artisan;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditArtisanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('cin', TextType::class)
            ->add('activity', EntityType::class, array(
                'class'         => 'App\Entity\Activity',
                'placeholder' => 'Choice your activity',
                'choice_label'  => 'name',
            ))
            ->add('trades', EntityType::class, array(
                'class' => 'App\Entity\Trades',
                'placeholder' => 'Choose your trade',
                'choice_label'  => 'name',
            ))
            ->add('ville', EntityType::class, array(
                'class'         => 'App\Entity\Ville',
                'placeholder' => 'Choice your ville',
                'choice_label'  => 'location',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Artisan::class,
        ]);
    }
}
