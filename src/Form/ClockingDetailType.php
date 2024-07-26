<?php

namespace App\Form;

use App\Entity\ClockingDetail;
use App\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClockingDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('project', EntityType::class, [
                'class' => Project::class,
                'choice_label' => 'name',
                'attr' => ['class' => 'text-black border border-gray-200 rounded-md px-2 py-2 focus:outline-none focus:border-red w-full mb-4'],
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-400 mb-2'],
            ])
            ->add('duration', IntegerType::class,[
                'attr' => ['class' => 'text-black border border-gray-200 rounded-md px-2 py-2 focus:outline-none focus:border-red w-full mb-4'],
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-400 mb-2'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClockingDetail::class,
        ]);
    }
}