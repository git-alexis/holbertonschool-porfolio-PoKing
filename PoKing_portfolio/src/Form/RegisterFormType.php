<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                'label' => '* Pseudo ',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9._-]+$/',
                        'message' => 'Caractères autorisés : a-z, A-Z, 0-9, \'.\', \'_\' et \'-\'',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => '* Password ',
                'mapped' => false,
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Minimum 8 caractères',
                    ]),
                ],
            ])
            ->add('surname', TextType::class, [
                'label' => '* Nom ( exemple : BILLEMONT ) ',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[A-Z\'- ]+$/',
                        'message' => 'Caractères autorisés : A-Z, \', \'-\', et \' \'',
                    ]),
                ],
            ])
            ->add('name', TextType::class, [
                'label' => '* Prénom ( exemple : Alexis ) ',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[A-Z][a-z\'- ]+$/',
                        'message' => 'Caractères autorisés : A-Z, a-z, \', \'-\', et \' \'',
                    ]),
                ],
            ])
            ->add('mail', EmailType::class, [
                'label' => '* Adresse e-mail ',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                        'message' => 'E-mail valide ( exemple : nom@exemple.com )',
                    ]),
                ],
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => '* Numéro de téléphone ',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d{10}$/',
                        'message' => 'Numéro de téléphone valide : 10 chiffres',
                    ]),
                ],
            ])
            ->add('birthday', DateType::class, [
                'label' => '* Date de naissance ',
                'widget' => 'single_text',
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse ',
                'required' => false,
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville ',
                'required' => false,
            ])
            ->add('postcode', TextType::class, [
                'label' => 'Code postal ',
                'required' => false,
            ])
            ->add('register', SubmitType::class, [
                'label' => 'Save account',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
