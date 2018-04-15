<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class User1Type extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $role = array(
            'DRC' => 'ROLE_DRC',
            'DMS' => 'ROLE_DMS',
            'Responsable' => 'ROLE_RESPONSABLE',
            'Administrateur' => 'ROLE_ADMIN'
        );
        $builder
            ->add('username')
            ->add('roles', ChoiceType::class, array(
                'choices' => $role,
                'multiple' => true,
                'expanded' => true,
                'required' => true,
                'label' => 'Role users',

            ) )
            ->add('isActive')
            ->add('government', EntityType::class, array(
                'class'         => 'App\Entity\Government',
                'placeholder' => 'Choisir le gouvernorat',
                'choice_label'  => 'name',
                'attr'  => array(
                    'class' => 'select2',
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
