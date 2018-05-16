<?php

namespace App\Form;

use App\Entity\Delegation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class DelegationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('government', EntityType::class, array(
                'class' => 'App\Entity\Government',
                'placeholder' => 'Choisir un gouvernorat',
                'choice_label'  => 'name',
                'label' => 'Gouvernorat',
                'attr' => array('class' => 'select2')
            ))
            ->add('name', TextType::class, array(
                'label' => 'Nom'
            ))
            ->add('code', TextType::class, array(
                'label' => 'Code'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Delegation::class,
        ]);
    }
}
