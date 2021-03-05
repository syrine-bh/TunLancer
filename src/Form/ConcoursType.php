<?php

namespace App\Form;

use App\Entity\Concour;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
                    'placeholder'=>"Nom concour"
                ]
            ])
            ->add('sujet',TextType::class,[
                'attr'=> [
                    'placeholder'=>"Donnez le sujet de votre concour"
                ]
            ])
            ->add('description',TextareaType::class,[
                'attr'=> [
                    'placeholder'=>"Donnez plus de détails sur votre concour"
                ]
            ])
            ->add('dateDebut',DateType::class,[
                'widget'=>'single_text',
            'input'=>'datetime'])
            ->add('dateFin',DateType::class,[
                'widget'=>'single_text',
                'input'=>'datetime'])

            ;



    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Concour::class,
        ]);
    }
}
