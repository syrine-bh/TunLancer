<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
class EditUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom',TextareaType::class)
            ->add('Prenom',TextareaType::class)
            ->add('Tel', TextareaType::class)
            ->add('Email', TextareaType::class)
            ->add('password', TextareaType::class)
            ->add('Role', TextareaType::class)
            ->add('photo', TextareaType::class)
            ->add('bibliography', TextareaType::class)

        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }

    public function builddForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom',TextType::class,
                ['constraints'=>[ new NotBlank(['message'=>'merci d\'entrer un nom',])
            ],'required'=> true,
            'attr'=> ['class'=>'form-control'], ])

            ->add('Prenom',TextareaType::class,
                ['constraints'=>[ new NotBlank(['message'=>'merci dentrer un prenom',])
            ],'required'=> true,
            'attr'=> ['class'=>'form-control'], ])

            ->add('Tel')
            ->add('Email',Emailtype::class,
                ['constraints'=>[ new NotBlank(['message'=>'merci dentrer un mail',])
            ],'required'=> true,
            'attr'=> ['class'=>'form-control'], ])
            ->add('Password', PasswordType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                ],
            ])

                      ->add('Role',ChoiceType::class,[
                'choices'=>[
                    'freelancer'=>'ROLE_freelancer',
                    'entreprise'=>'ROLE_entreprise',
                    'chercheur de travail'=>'ROLE_chercheur de travail',
                    'Administrateur'=>'ROLE_admin'],
        'expanded' =>  true,
         'multiple '=>  true,
        'label'=> 'Roles'])
        ->add ('valider',SubmitType::class)

            ->add('photo')
            ->add('bibliography')
        ;
    }

    public function confiigureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
