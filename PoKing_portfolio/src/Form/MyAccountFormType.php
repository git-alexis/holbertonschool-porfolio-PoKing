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
use Symfony\Component\Validator\Constraints\Positive;
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
                        'minMessage' => '8 characters minimum',
                    ]),
                ],
            ])
            ->add('surname', TextType::class, [
                'label' => '* Surname ( example : BILLEMONT ) ',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[A-Z\'\- ]+$/',
                        'message' => 'Allowed characters : A-Z, \', \'-\', et \' \'',
                    ]),
                ],
            ])
            ->add('name', TextType::class, [
                'label' => '* Name ( example : Alexis ) ',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[A-Z][a-z\'\- ]+$/',
                        'message' => 'Allowed characters : A-Z, a-z, \', \'-\', et \' \'',
                    ]),
                ],
            ])
            ->add('mail', EmailType::class, [
                'label' => '* E-mail ',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9._\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/',
                        'message' => 'Valid e-mail ( example : nom@example.com )',
                    ]),
                ],
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => '* Phone number ',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d{10}$/',
                        'message' => 'Valid phone number : 10 numbers',
                    ]),
                ],
            ])
            ->add('birthday', DateType::class, [
                'label' => '* Birthday ',
                'widget' => 'single_text',
            ])
            ->add('address', TextType::class, [
                'label' => 'Address ',
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9\'._\- ]+$/',
                        'message' => 'Allowed characters : a-z, A-Z, 0-9, \', \'.\', \'_\', \'-\' et \' \'',
                    ]),
                    new Length([
                        'max' => 100,
                        'maxMessage' => '100 characters maximum',
                    ]),
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'City ',
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9\'._\- ]+$/',
                        'message' => 'Allowed characters : a-z, A-Z, 0-9, \', \'.\', \'_\', \'-\' et \' \'',
                    ]),
                    new Length([
                        'max' => 100,
                        'maxMessage' => '100 characters maximum',
                    ]),
                ],
            ])
            ->add('postcode', TextType::class, [
                'label' => 'Postcode ',
                'required' => false,
                'constraints' => [
                    new Positive(['message' => 'Postcode must be a positive number']),
                    new Regex([
                        'pattern' => '/^\d{5}$/',
                        'message' => 'Valid postcode : 5 numbers',
                    ]),
                ],
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
