<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;

class MyAccountFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Add pseudo field (read-only, cannot be changed)
        $builder
            ->add('pseudo', TextType::class, [
                'label' => '* Pseudo ',
                'attr' => [
                    'readonly' => true,
                ],
            ])
            // Add password field with constraints (minimum 8 characters)
            ->add('plainPassword', PasswordType::class, [
                'label' => '* Password ',
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'This field cannot be empty.',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => '8 characters minimum',
                    ]),
                ],
            ])
            // Add surname field (uppercase letters, valid special characters)
            ->add('surname', TextType::class, [
                'label' => '* Surname ( example : BILLEMONT ) ',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank([
                        'message' => 'This field cannot be empty.',
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Z\'\- ]+$/',
                        'message' => 'Allowed characters : A-Z, \', \'-\', and \' \'',
                    ]),
                ],
            ])
            // Add name field (first letter uppercase, valid special characters)
            ->add('name', TextType::class, [
                'label' => '* Name ( example : Alexis ) ',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank([
                        'message' => 'This field cannot be empty.',
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Z][a-z\'\- ]+$/',
                        'message' => 'Allowed characters : A-Z, a-z, \', \'-\', and \' \'',
                    ]),
                ],
            ])
            // Add email field with validation for valid format
            ->add('mail', EmailType::class, [
                'label' => '* E-mail ',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank([
                        'message' => 'This field cannot be empty.',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9._\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/',
                        'message' => 'Valid e-mail ( example : nom@example.com )',
                    ]),
                ],
            ])
            // Add phone number field with specific format validation (e.g., 01.02.03.04.05)
            ->add('phoneNumber', TextType::class, [
                'label' => '* Phone number ( exanple : 01.02.03.04.05 ) ',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank([
                        'message' => 'This field cannot be empty.',
                    ]),
                    new Regex([
                        'pattern' => '/^(0[1-9])(\.[0-9]{2}){4}$/',
                        'message' => 'Valid phone number : 01.02.03.04.05',
                    ]),
                ],
            ])
            // Add birthday field with date picker widget
            ->add('birthday', DateType::class, [
                'label' => '* Birthday ',
                'widget' => 'single_text',
            ])
            // Add address field (optional, with special character and length validation)
            ->add('address', TextType::class, [
                'label' => 'Address ',
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9\'._\- ]+$/',
                        'message' => 'Allowed characters : a-z, A-Z, 0-9, \', \'.\', \'_\', \'-\' and \' \'',
                    ]),
                    new Length([
                        'max' => 100,
                        'maxMessage' => '100 characters maximum',
                    ]),
                ],
            ])
            // Add city field (optional, with special character and length validation)
            ->add('city', TextType::class, [
                'label' => 'City ',
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9\'._\- ]+$/',
                        'message' => 'Allowed characters : a-z, A-Z, 0-9, \', \'.\', \'_\', \'-\' and \' \'',
                    ]),
                    new Length([
                        'max' => 100,
                        'maxMessage' => '100 characters maximum',
                    ]),
                ],
            ])
            // Add postcode field (optional, with validation for 5 digits)
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
