<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class EditActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', HiddenType::class)
            ->add('lastName', HiddenType::class)
            ->add('ville', EntityType::class, array(
                'class'         => 'App\Entity\Ville',
                'choice_label'  => 'location',
                'attr'  => array('class' => 'hidden ')
            ))
        ;
    }

     // inherit a artisan type
    public function getParent ()
    {
        return ArtisanType::class;
    }


}
