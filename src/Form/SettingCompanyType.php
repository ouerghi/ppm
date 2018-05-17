<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Activity;
use App\Entity\Government;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingCompanyType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('government', EntityType::class, array(
				'class'         => 'App\Entity\Government',
				'placeholder' => '',
				'label' => 'Choisir un gouvernorat',
				'choice_label'  => 'name',
				'attr'  => array('class' => 'select2 ')
			))
			->add('activity', EntityType::class, array(
				'class'         => 'App\Entity\Activity',
				'placeholder' => '',
				'label' => 'Choisir un groupe d\'activité',
				'choice_label'  => 'name',
				'attr'  => array('class' => 'select2 activity')
			))

		;

		$formModifier = function (FormInterface $form, Government $government = null) {
			$delegation = null === $government ? array() : $government->getDelegation();

			$form->add('delegation', EntityType::class, array(
				'class' => 'App\Entity\Delegation',
				'placeholder' => '',
				'label' => 'Choisir une délégation',
				'choice_label'  => 'name',
				'attr'  => array('class' => 'select2 '),
				'choices' => $delegation,
			));
		};

		$builder->addEventListener(
			FormEvents::PRE_SET_DATA,
			function (FormEvent $event) use ($formModifier) {
				// entity, Activity
				$data = $event->getData();

				$formModifier($event->getForm(), $data->getGovernment());
			}
		);

		$builder->get('government')->addEventListener(
			FormEvents::POST_SUBMIT,
			function (FormEvent $event) use ($formModifier) {
				// It's important here to fetch $event->getForm()->getData(), as
				// $event->getData() will get you the client data (that is, the ID)
				$government = $event->getForm()->getData();

				// since we've added the listener to the child, we'll have to pass on
				// the parent to the callback functions!
				$formModifier($event->getForm()->getParent(), $government);
			}
		);

		$formModifier1 = function (FormInterface $form, Activity $activity = null) {
			$trades = null === $activity ? array() : $activity->getTrades();

			$form->add('trades', EntityType::class, array(
				'class' => 'App\Entity\Trades',
				'placeholder' => '',
				'label' => 'Choisir une activité',
				'choice_label'  => 'name',
				'attr'  => array('class' => 'select2 trade'),
				'choices' => $trades,
			));
		};

		$builder->addEventListener(
			FormEvents::PRE_SET_DATA,
			function (FormEvent $event) use ($formModifier1) {
				// entity, Activity
				$data = $event->getData();

				$formModifier1($event->getForm(), $data->getActivity());
			}
		);

		$builder->get('activity')->addEventListener(
			FormEvents::POST_SUBMIT,
			function (FormEvent $event) use ($formModifier1) {
				// It's important here to fetch $event->getForm()->getData(), as
				// $event->getData() will get you the client data (that is, the ID)
				$activity = $event->getForm()->getData();

				// since we've added the listener to the child, we'll have to pass on
				// the parent to the callback functions!
				$formModifier1($event->getForm()->getParent(), $activity);
			}
		);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Company::class,
		]);
	}
}
