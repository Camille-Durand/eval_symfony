<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                'attr' => ['class' => 'input'],
                'empty_data' => '',
                'label' => 'Titre:',
                'label_attr' => ['class' => 'input'],
                'required' => true
                ])

            ->add('content', TextareaType::class,[
                'attr' => ['class' => 'input'],
                'empty_data' => '',
                'label' => 'Titre:',
                'label_attr' => ['class' => 'input'],
                'required' => true
                ])

            ->add('expiryDate', null, [
                'widget' => 'single_text',
            ])
            ->add('statut')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
