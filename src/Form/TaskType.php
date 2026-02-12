<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Saisir le titre de la tâche'
            ])
            ->add('content', TextType::class, [
                'label' => 'Saisir le contenu de la tâche'
            ])
            ->add('createdAt', DateType::class, [
                'label' => 'Saisir la date de création de la tâche'
            ])
            ->add('expiredAt', null, [
                'widget' => 'single_text',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter une tâche'
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
