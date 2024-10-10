<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class ResetPasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                'label' => '* Pseudo',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9._-]+$/',
                        'message' => 'Caractères autorisés : a-z, A-Z, 0-9, ., _ et -',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => '* New password',
                'mapped' => false,
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Minimum 8 caractères',
                    ]),
                ],
            ])
            ->add('confirmPassword', PasswordType::class, [
                'label' => '* Confirm new password',
                'mapped' => false,
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Minimum 8 caractères',
                    ]),
                ],
            ])
            ->add('reinitialize', SubmitType::class, [
                'label' => 'reinitialize',
            ])
        ;
    }
}
