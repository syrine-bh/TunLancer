<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom')

            ->add('Prenom',TextType::class)
            ->add('Tel')
            ->add('Email',Emailtype::class)
            ->add('Password', PasswordType::class)
            ->add('Pays')
            ->add('Role', ChoiceType::class, array(

                    'choices' => array(
                        'Freelancer' => 'Freelancer',
                        'Entreprise' =>  'Entreprise',
                        'Chercheur de travail' => 'Chercheur de travail',
                    )
                ))
            ->add('Photo', FileType::class,[
                'label' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('Bibliography')

            ->add('Age')
            ->add('Sexe', ChoiceType::class, array(
                'choices' => array(
                    'Homme' => 'Homme',
                    'Femme' =>  'Femme',

                )
            ))

            ->getForm()
         ->add('submit',SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Users'
        ]);
    }
}
