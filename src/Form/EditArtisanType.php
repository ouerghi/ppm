<?php

namespace App\Form;


use App\Entity\Artisan;
use App\Repository\DelegationRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditArtisanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $gov = $options['government'];

        $builder
            ->add('lastName', TextType::class, array('label' => 'Nom de l\'artisan'))
            ->add('firstName', TextType::class, array('label' => 'Prénom de l\'artisan'))
            ->add('cin', TextType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined('government');

        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Artisan::class,
            'government' => null
        ]);
    }
}
