<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Rancking;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class RanckingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('event', EntityType::class, [
                'class' => Event::class,
                'choice_label' => function (Event $event) {
                    return $event->getLabel();
                },
            ])
            ->add('season', TextType::class, [
                'label' => '* Season ',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9\'._\- ]+$/',
                        'message' => 'Caractères autorisés : a-z, A-Z, 0-9, \', \'.\', \'_\', \'-\' et \' \'',
                    ]),
                    new Length(['min' => 1, 'minMessage' => 'La saison doit être renseignée']),
                ],
            ])
            ->add('label', TextType::class, [
                'label' => '* Label ',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9\'._\- ]+$/',
                        'message' => 'Caractères autorisés : a-z, A-Z, 0-9, \', \'.\', \'_\', \'-\' et \' \'',
                    ]),
                    new Length(['min' => 1, 'minMessage' => 'Le libellé doit être renseigné']),
                ],
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => function (User $user) {
                    return $user->getPseudo();
                },
            ])
            ->add('rankingPosition', NumberType::class, [
                'label' => '* Ranking position ',
                'constraints' => [
                    new Positive(['message' => 'Le stack doit être un entier positif']),
                ],
            ])
            ->add('points', NumberType::class, [
                'label' => '* Points ',
                'constraints' => [
                    new Positive(['message' => 'Le stack doit être un entier positif']),
                ],
            ])
            ->add('killsNumber', NumberType::class, [
                'label' => '* Kills number ',
                'constraints' => [
                    new Positive(['message' => 'Le stack doit être un entier positif']),
                ],
            ])
            ->add('eliminatedBy', TextType::class, [
                'label' => '* Eliminated by ',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9._-]+$/',
                        'message' => 'Caractères autorisés : a-z, A-Z, 0-9, \'.\', \'_\' et \'-\'',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rancking::class,
        ]);
    }
}
