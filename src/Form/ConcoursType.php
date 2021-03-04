<?php

namespace App\Form;

use App\Entity\Concour;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ConcoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'attr'=> [
                    'placeholder'=>"Nom concours"
                ]
            ])
            ->add('sujet',TextType::class,[
                'attr'=> [
                    'placeholder'=>"Donnez le sujet de votre concours"
                ]
            ])
            ->add('description',TextareaType::class,[
                'attr'=> [
                    'placeholder'=>"Donnez plus de détails sur votre concours"
                ]
            ])
            ->add('dateDebut')
            ->add('dateFin')


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Concour::class,
        ]);
    }
}
