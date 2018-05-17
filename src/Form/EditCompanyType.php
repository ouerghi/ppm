<?php

namespace App\Form;


use App\Entity\Company;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditCompanyType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$gov = $options['government'];

		$builder
			->add('name', TextType::class)
			->add('adresse', TextType::class, array(
				'attr' => array(
					'placeholder' => 'Adresse '
				)))
			->add('zip', IntegerType::class, array(
				'attr' => array(
					'placeholder' => 'Zip'
				)))
			->add('local', ChoiceType::class, array(
				'choices' => [
					'Locataire' => '1',
					'propriétaire' => '0'
				],
				'label' => 'type locale ',
				'attr' => ['class' => 'select2', 'required' => true]
			))
			->add('juridique', EntityType::class, array(
				'class' => 'App\Entity\Juridique',
				'placeholder' => 'Choisir une forme juridique',
				'choice_label' => 'name',
				'attr'  => array('class' => 'select2 ','required' => true,)
			))
			->add('local', ChoiceType::class, array(
				'choices' => [
					'Locataire' => '1',
					'propriétaire' => '0'
				],
				'label' => 'type locale ',
				'attr' => ['class' => 'select2', 'required' => true]
			))
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefined('government');

		$resolver->setDefaults([
			// uncomment if you want to bind to a class
			'data_class' => Company::class,
			'government' => null
		]);
	}
}
