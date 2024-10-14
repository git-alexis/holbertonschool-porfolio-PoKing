<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;

class MyAccountFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                'label' => '* Pseudo ',
                'attr' => [
                    'readonly' => true,
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
            ->add('name', TextType::class, [
                'label' => '* Nom ( exemple : BILLEMONT ) ',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[A-Z\'\- ]+$/',
                        'message' => 'Caractères autorisés : A-Z, \', \'-\', et \' \'',
                    ]),

                ],
            ])
            ->add('surname', TextType::class, [
                'label' => '* Prénom ( exemple : Alexis ) ',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[A-Z][a-z\'\- ]+$/',
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
            ->add('address', TextType::class, [
                'label' => 'Adresse ',
                'required' => false,
            ])
            ->add('postcode', TextType::class, [
                'label' => 'Code postal ',
                'required' => false,
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville ',
                'required' => false,
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
            ->add('update', SubmitType::class, [
                'label' => 'Update account',
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
