<?php

namespace App\Form;

use App\Entity\User;
use App\Repository\VilleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('ville', EntityType::class, array(
                'class'         => 'App\Entity\Ville',
                'placeholder' => 'Choose the ville',
                'choice_label'  => 'location',
                'query_builder' => function(VilleRepository $ville) {
                    return $ville->getVille()
//                        ->select('v.government')
//                        ->distinct()
//                        ->where('v.order is not null')
                        ;
                },
                'attr'  => array(
                    'class' => 'ville',
                )
            ))
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
