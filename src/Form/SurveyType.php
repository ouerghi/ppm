<?php

namespace App\Form;

use App\Entity\Government;
use App\Entity\Survey;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SurveyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$government = $options['government'];
	    $drc ='ROLE_DRC';
        $builder
            ->add('start', DateTimeType::class, array(
                'label' => 'date début',
                'widget' => 'single_text',
                'format' => 'yyyy HH:mm:ss dd-MM',
                'input' => 'datetime',
                'html5' => false,
                'attr' => ['class' => 'date_survey', 'placeholder' => 'date de début']
            ))
	        ->add('end', DateTimeType::class, array(
		        'label' => 'date fin',
		        'widget' => 'single_text',
		        'format' => 'yyyy HH:mm:ss dd-MM',
		        'input' => 'datetime',
		        'html5' => false,
		        'attr' => ['class' => 'date_survey', 'placeholder' => 'date de fin']
	        ))
            ->add('description', TextareaType::class, array(
                'label' => 'Description',
	            'attr' => array('placeholder' => 'description')
            ))
            ->add('users', EntityType::class, array(
            	'class' => 'App\Entity\User',
	            'placeholder' => 'Choisir un utilisateur',
	            'choice_label'  => 'username',
	            'multiple' => true,
	            'query_builder' => function( UserRepository $user) use ($government, $drc ) {
            		return $user->findByRoleByGovernment($government, $drc);
	            },
	            'attr' => array('class' => 'select2', 'placeholder' => 'choisir un utilisateur')
            ))
            ->add('save', SubmitType::class, array(
            	'attr' => ['class' => 'btn btn-primary'],
	            'label' => 'enregistrer'
            ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Survey::class,
	        $resolver->setRequired('government'),
	        $resolver->setAllowedTypes('government', array(Government::class))
        ]);
    }
}
