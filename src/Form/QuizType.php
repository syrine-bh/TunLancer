<?php

namespace App\Form;

use App\Entity\Concour;
use App\Entity\Quiz;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class
//                ,[
//                'attr'=> [
//                    'placeholder'=>"Nom quiz"]]
            )
            ->add('couleur',ColorType::class)

            ->add('nbQuestions'
//                'attr'=> [
//                    'placeholder'=>"Nombre questions"]
//                ]
            )
            ->add('concour',EntityType::class,[
                'class'=>Concour::class,
                'choice_label'=>'nom',
                'multiple'=>False
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quiz::class,
        ]);
    }
}
