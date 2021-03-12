<?php

namespace App\Form;

use App\Entity\Concour;
use App\Entity\Questiontab;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddQuestionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('questions')
//            ->add('concour',EntityType::class,[
//                'class'=>Concour::class,
//                'choice_label'=>'name',
//                'multiple'=>False
//            ])
//
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Questiontab::class,
        ]);
    }
}
