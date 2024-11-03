<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

abstract class BaseFormType extends AbstractType
{
    protected function addFieldsWithConstraints(FormBuilderInterface $builder, array $fieldsWithConstraints): void
    {
        foreach ($fieldsWithConstraints as $fieldName => $constraints) {
            $builder->add($fieldName, TextType::class, [
                'constraints' => $constraints,
            ]);
        }
    }
    public function customGetErrors($form): array
    {
        $errors_list = [];

        foreach ($form->getErrors() as $error) {
            $errors_list[$form->getName()][] = $error->getMessage();
        }
        foreach ($form as $child) {
            if (!$child->isValid()) {
                foreach ($child->getErrors() as $error) {
                    $errors_list[$child->getName()][] = $error->getMessage();
                }
            }
        }
        return $errors_list;
    }
}