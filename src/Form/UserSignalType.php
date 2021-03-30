<?php

namespace App\Form;

use App\Entity\Usersignal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSignalType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $reasons = array(
            'Contenu inapproprié' => '0',
            'Racism' => '1',
            'Violence' => '2',
            'Harrasment' => '3',
            'False_Profile' => '4',
            'other' => '5'
        );

        $builder
            ->add('reason', ChoiceType::class, [
                'choices' => $reasons,

            ])
            ->add('state', HiddenType::class)
            ->add('content')
            ->add('receiver', HiddenType::class)
            ->add('sender', HiddenType::class);

    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\UserSignal'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'usersignal';
    }


}
