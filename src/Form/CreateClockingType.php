<?php

namespace App\Form;

use App\Entity\Clocking;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateClockingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('clockingUser', EntityType::class, [
                'class' => User::class,
                'choice_label' => function (User $user) {
                    return $user->getLastName() . ' ' . $user->getFirstName();
                },
                'label' => 'entity.Clocking.clockingUser',
            ])
            ->add('date', DateType::class, [
                'label' => 'entity.Clocking.date',
            ])
            ->add('clockingDetails', CollectionType::class, [
                'entry_type' => ClockingDetailType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Créer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Clocking::class,
        ]);
    }
}