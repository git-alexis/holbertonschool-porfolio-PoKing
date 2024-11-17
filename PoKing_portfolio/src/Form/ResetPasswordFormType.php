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
use Symfony\Component\Validator\Constraints\NotBlank;

class ResetPasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Add the plainPassword field (new password)
        $builder
            ->add('plainPassword', PasswordType::class, [
                'label' => '* New password ',
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
            // Add the confirmPassword field (confirm new password)
            ->add('confirmPassword', PasswordType::class, [
                'label' => '* Confirm new password ',
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
        ;
    }
}
