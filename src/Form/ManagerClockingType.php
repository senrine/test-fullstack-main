<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ManagerClockingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'entity.Clocking.date',
            ])
            ->add('users', CollectionType::class, [
                'entry_type' => EntityType::class,
                'entry_options' => [
                    'class' => User::class,
                    'choice_label' => function (User $user) {
                        return $user->getLastName() . ' ' . $user->getFirstName();
                    },
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
                'label' => 'entity.Clocking.clockingUsers',
            ])
            ->add('clockingDetails', CollectionType::class, [
                'entry_type' => ClockingDetailType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
                'label' => 'entity.Clocking.clockingDetails',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Créer',
                'attr' => ['class' => 'form-submit'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}