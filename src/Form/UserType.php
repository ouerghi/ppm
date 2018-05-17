<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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
            'Responsable' => 'ROLE_RESPONSABLE',
            'Administrateur' => 'ROLE_ADMIN'
        );
        // our builder he present a registration form
        $builder
            ->add('username', TextType::class, array(
                'label'=> 'Nom utilisateur',
	            'attr' => array(
	            	'pattern' => '^[A-Za-z0-9_]+$',
		            'data-error' => 'login avec des lettres et des nombres et sans espace ',
	                'placeholder' => 'Nom Utilisateur'
	            )
            ))
	        ->add('email', EmailType::class, array(
	        	'attr' => array('data-error' => 'cette adresse email est invalide', 'placeholder' => 'Email')
	        ))
            ->add('government', EntityType::class, array(
                'class'         => 'App\Entity\Government',
                'placeholder' => 'Selectionner un gouvernorat',
                'label'=> 'Gouvernorat',
                'choice_label'  => 'name',
                'attr'  => array(
                    'class' => 'government',
                )
            ))
            ->add('password', PasswordType::class, array(
	            'attr' => array(
		            'minlength'=> '5',
		            'data-error' => 'votre mot de passe doit avoir au moins 5 caractères de long.',
		            'placeholder' => 'Password'
	            )

            ))
            ->add('roles', ChoiceType::class, array(
                'choices' => $role,
                'multiple' => true,
                'expanded' => true,
                'required' => true,
                'label' => 'Role Utilisateurs',
	            'attr' => array('data-error' => 'champ obligatoire')

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
