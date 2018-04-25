<?php

namespace App\Form;

use App\Entity\Trades;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TradesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('activities', EntityType::class, array(
                'class' => 'App\Entity\Activity',
                'placeholder' => 'Choisir un groupe d\'activité',
                'choice_label'  => 'name',
                'label' => 'Groupe d\'activité',
                'attr' => array('class' => 'select2')
            ))
            ->add('name', TextType::class, array(
                'label' => 'Nom de l\'activité'
            ))
            ->add('code')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trades::class,
        ]);
    }
}
