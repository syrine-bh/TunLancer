<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Postuler;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;



class PostulerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('email')
          /*  ->add('annonce',EntityType::class,[
                'class' => Annonce::class,
                'choice_label' => 'nom',

            ])*/
            ->add('nom')
            ->add('prenom')
            ->add('message')
            ->add('telephone')
            ->add('cv',FileType::class, [
                'label' => null,
                'attr' => ['placeholder' => 'Choose file'],
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2000k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])

            ->add('Ajouter', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Postuler::class,
        ]);
    }
}
