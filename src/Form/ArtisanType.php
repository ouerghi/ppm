<?php

namespace App\Form;


use App\Entity\Activity;
use App\Entity\Artisan;
use App\Repository\DelegationRepository;
use App\Repository\VilleRepository;

use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ArtisanType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $gov = $options['government'];

        $grade = array(
	        'Bac' => 'bac',
	        'CAP' => 'cap',
	        'BTP' => 'btp',
	        'BTS' => 'bts',
	        'License' => 'license',
	        'Master' => 'master',
	        'Ingénieur' => 'ingeneieur'
        );

        $builder
            ->add('firstName', TextType::class, array(
                'label' => 'prénom de l\'artisan',
                'attr' => array(
                    'placeholder' => 'Prénom de l\'artisan',
                )
            ))
            ->add('lastName', TextType::class, array(
                'label' => 'Nom de l\'artisan',
                'attr' => array(
                    'placeholder' => 'Nom de l\'artisan',
                )
            ))
	        ->add('grade',ChoiceType::class, array(
	        	'choices' => $grade,
		        'label' => 'Niveau',
		        'required' => true,
		        'attr' => ['class' => 'select2', 'required' => true,]
	        ))
	        ->add('nationality', TextType::class,[
	        	'label' => 'Nationalité',
		        'attr' => array(
			        'placeholder' => 'Nationnalité'
		        )
	        ])
	        ->add('adresse', TextType::class, array(
		        'attr' => array(
			        'placeholder' => 'Adresse '
		        )))
	        ->add('zip', IntegerType::class, array(
		        'attr' => array(
			        'placeholder' => 'Zip'
		        )))
	        ->add('employee', IntegerType::class, array(
			        'label' => 'Nombre d\'employé',
			        'attr' => array(
				        'placeholder' => 'Nombre d\'employé',
				        'required' => true,
	        )))
	        ->add('qualification', TextType::class, array(
		        'attr' => array(
			        'placeholder' => 'Choisir une qualification'
	        )))

	        ->add('local', ChoiceType::class, array(
		          'choices' => [
			        'Locataire' => '1',
			        'propriétaire' => '0'
		        ],
		          'label' => 'type locale ',
		          'attr' => ['class' => 'select2', 'required' => true]
	        ))
            ->add('birthday', BirthdayType::class, array(
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'birthday','required' => true,]
            ))
            ->add('cin', SearchType::class, array(
                'attr' => array(
                    'placeholder' => 'Cin de  l\'artisan',
                    'class' => 'ui-widget',
	                'data-minlength' =>8,
	                'data-error' => 'merci de mettre un numéro valide',
	                'maxlength' =>8,
	                'pattern' => '[0-9]+$'

                )
            ))
            ->add('dateCreation', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'dateCreation','required' => true,]
            ))

            ->add('juridique', EntityType::class, array(
                'class' => 'App\Entity\Juridique',
                'placeholder' => 'Choisir une forme juridique',
                'choice_label' => 'name',
                'attr'  => array('class' => 'select2 ','required' => true,)
            ))
            ->add('delegation', EntityType::class, array(
                'class'         => 'App\Entity\Delegation',
                'placeholder' => 'Choisir une délégation',
                'choice_label'  => 'name',
                'query_builder' => /**
                 * @param VilleRepository $ville
                 * @return \Doctrine\ORM\QueryBuilder
                 */
                    function(DelegationRepository $government) use($gov) {
                    return $government->getDelegation($gov);
                },
                'attr'  => array('class' => 'select2 ville ', 'required' => true,)
            ))
            ->add('activity', EntityType::class, array(
                'class'         => 'App\Entity\Activity',
                'placeholder' => 'Choisir un groupe d\'activité',
                'label' => 'Choisir un groupe d\'activité',
                'choice_label'  => 'name',
                'attr'  => array('class' => 'select2 activity', 'required' => true,)
            ))

        ;
        $formModifier = function (FormInterface $form, Activity $activity = null) {
            $trades = null === $activity ? array() : $activity->getTrades();

            $form->add('trades', EntityType::class, array(
                'class' => 'App\Entity\Trades',
                'placeholder' => 'Choisir une activité',
                'label' => 'Choisir une activité',
                'choice_label'  => 'name',
                'attr'  => array('class' => 'select2 trade'),
                'choices' => $trades,
            ));
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // entity, Activity
                $data = $event->getData();

                $formModifier($event->getForm(), $data->getActivity());
            }
        );

        $builder->get('activity')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $activity = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $activity);
            }
        );
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
