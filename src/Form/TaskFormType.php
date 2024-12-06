<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Length;

class TaskFormType extends BaseFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $fieldsWithConstraints = [
            'name' => [
                new NotNull(),
                new Length(['max' => 255, 'min' => 3]),
            ],
            'description' => [
                new NotNull(),
            ]
        ];

        $this->addFieldsWithConstraints($builder, $fieldsWithConstraints);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
            'csrf_protection' => false,
        ]);
    }
}