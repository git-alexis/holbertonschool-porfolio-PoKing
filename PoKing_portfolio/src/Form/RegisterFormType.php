<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Positive;
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
        // Add 'pseudo' field with a regex constraint for allowed characters
        $builder
            ->add('pseudo', TextType::class, [
                'label' => '* Pseudo ',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9._\-]+$/',
                        'message' => 'Allowed characters : a-z, A-Z, 0-9, \'.\', \'_\' et \'-\'',
                    ]),
                ],
            ])
            // Add 'plainPassword' field with a length constraint (minimum 8 characters)
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
            // Add 'surname' field with a regex constraint for allowed characters
            ->add('surname', TextType::class, [
                'label' => '* Surname ( example : BILLEMONT ) ',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[A-Z\'\- ]+$/',
                        'message' => 'Allowed characters : A-Z, \', \'-\', et \' \'',
                    ]),
                ],
            ])
            // Add 'name' field with a regex constraint for allowed characters
            ->add('name', TextType::class, [
                'label' => '* Name ( example : Alexis ) ',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[A-Z][a-z\'\- ]+$/',
                        'message' => 'Allowed characters : A-Z, a-z, \', \'-\', et \' \'',
                    ]),
                ],
            ])
            // Add 'mail' field with a regex constraint for valid email format
            ->add('mail', EmailType::class, [
                'label' => '* E-mail ',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9._\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/',
                        'message' => 'Valid e-mail ( example : nom@example.com )',
                    ]),
                ],
            ])
            // Add 'phoneNumber' field with a regex constraint for valid phone number format
            ->add('phoneNumber', TextType::class, [
                'label' => '* Phone number ( exanple : 01.02.03.04.05 ) ',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^(0[1-9])(\.[0-9]{2}){4}$/',
                        'message' => 'Valid phone number : 01.02.03.04.05',
                    ]),
                ],
            ])
            // Add 'birthday' field with a date widget (single text input)
            ->add('birthday', DateType::class, [
                'label' => '* Birthday ',
                'widget' => 'single_text',
            ])
            // Add 'address' field with a regex constraint and length limit
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
            // Add 'city' field with a regex constraint and length limit
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
            // Add 'postcode' field with regex for valid postcode and positive number check
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
