<?php

namespace App\Form;

use App\Entity\Survey;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SurveyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('start', DateTimeType::class, array(
                'label' => 'Début',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'date_survey']
            ))
            ->add('end', DateTimeType::class, array(
                'label' => 'Fin',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'date_survey']
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'Description'
            ))
            ->remove('user')
            ->remove('artisan')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Survey::class,
        ]);
    }
}
