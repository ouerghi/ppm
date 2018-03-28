<?php

namespace App\Form;


use App\Entity\Activity;
use App\Entity\Artisan;
use App\Repository\VilleRepository;

use Symfony\Component\Form\FormInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
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

        $builder
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('cin', NumberType::class )
            ->add('ville', EntityType::class, array(
                'class'         => 'App\Entity\Ville',
                'placeholder' => 'Choice your ville',
                'choice_label'  => 'location',
                'query_builder' => /**
                 * @param VilleRepository $ville
                 * @return \Doctrine\ORM\QueryBuilder
                 */
                    function(VilleRepository $ville) use($gov) {
                    return $ville->getGovernment($gov);
                },
                'attr'  => array('class' => 'select2 ville ')
            ))
            ->add('activity', EntityType::class, array(
                'class'         => 'App\Entity\Activity',
                'placeholder' => 'Choice your activity',
                'choice_label'  => 'name',
                'attr'  => array('class' => 'select2 activity')
            ))

        ;
        $formModifier = function (FormInterface $form, Activity $activity = null) {
            $trades = null === $activity ? array() : $activity->getTrades();

            $form->add('trades', EntityType::class, array(
                'class' => 'App\Entity\Trades',
                'placeholder' => 'Choose your trade',
                'choice_label'  => 'name',
                'attr'  => array('class' => 'select2 trade'),
                'choices' => $trades,
            ));
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
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
