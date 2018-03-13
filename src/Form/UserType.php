<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

//type field use
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // the array of list of roles
        $role = array(
            'DRC' => 'ROLE_DRC',
            'DMS' => 'ROLE_DMS',
            'Responsable' => 'ROLE_RESPONSABLE',
            'Administrateur' => 'ROLE_ADMIN'
        );
        // our builder he present a registration form
        $builder
            ->add('username', TextType::class)
            ->add('password', PasswordType::class)
            ->add('roles', ChoiceType::class, array(
                'choices' => $role,
                'multiple' => true,
                'expanded' => true,
                'required' => true,
                'label' => 'Role users',


            ) )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // class User
            'data_class' => User::class,
        ]);
    }
}