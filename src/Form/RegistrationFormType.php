<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('username', TextType::class, [
                'label' => 'Nazwa użytkownika:',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Hasła muszą być takie same',
                'options' => [
                    'attr' => ['class' => 'password-field']
                ],
                'required' => true,
                'first_options' => [
                    'label' => 'Hasło:',
                    'attr' => ['class' => 'form-control']
                ],
                'second_options' => [
                    'label' => 'Powtórz hasło:',
                    'attr' => ['class' => 'form-control']
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Zarejestruj się',
                'attr' =>[
                    'class' => 'btn btn-success mt-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
