<?php

namespace App\Form;

use App\Entity\Instrument;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstrumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('icon', null, [ //null permet de laisser Symfony deviner le type de champ de formulaire
               'label' => 'Class Font Awesome',  // pour changer le nom du label
                //'help' => 'Font awesome class name',    pour mettre une légende
               //'required' => true
            ])

// ne pas toucher le nom des propriétés générées par Symfony
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Instrument::class,
        ]);
    }
}
