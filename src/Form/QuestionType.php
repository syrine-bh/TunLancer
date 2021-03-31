<?php

namespace App\Form;

use App\Entity\Concour;
use App\Entity\Questiontab;
use App\Entity\Quiz;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('questions')
            ->add('quiz',EntityType::class,[
        'class'=>Quiz::class,
        'choice_label'=>'nom',
        'multiple'=>False
    ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Questiontab::class,
        ]);
    }
}
