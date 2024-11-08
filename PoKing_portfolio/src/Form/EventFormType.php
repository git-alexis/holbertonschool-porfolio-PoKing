<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Event;
use App\Entity\Place;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isEdit = $options['is_edit'];

        $builder
            ->add('season', TextType::class, [
                'label' => '* Season ',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9\'._\- ]+$/',
                        'message' => 'Allowed characters : a-z, A-Z, 0-9, \', \'.\', \'_\', \'-\' et \' \'',
                    ]),
                    new Length(['min' => 1, 'minMessage' => 'Season must be filled in']),
                ],
            ])
            ->add('label', TextType::class, [
                'label' => '* Label ( example : MTT of the 28/10/2024 )',
                'attr' => [
                    'readonly' => $isEdit ? true : false,
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9\'._\- \/]+$/',
                        'message' => 'Allowed characters : a-z, A-Z, 0-9, \', \'.\', \'_\', \'-\', \' \' and \'/\'',
                    ]),
                    new Length(['min' => 1, 'minMessage' => 'Label must be filled in']),
                ],
            ])
            ->add('stack', NumberType::class, [
                'label' => '* Stack ',
                'constraints' => [
                    new Positive(['message' => 'Stack must be a positive number']),
                ],
            ])
            ->add('comment', TextType::class, [
                'label' => 'Comment ',
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                        'maxMessage' => '255 characters maximum',
                    ]),
                ],
            ])
            ->add('registrationOpeningDate', DateType::class, [
                'label' => '* Registration opening date ',
                'widget' => 'single_text',
            ])
            ->add('registrationOpeningTime', TimeType::class, [
                'label' => '* Registration opening time ',
                'widget' => 'single_text',
            ])
            ->add('registrationClosingDate', DateType::class, [
                'label' => '* Registration closing date ',
                'widget' => 'single_text',
            ])
            ->add('registrationClosingTime', TimeType::class, [
                'label' => '* Registration closing time ',
                'widget' => 'single_text',
            ])
            ->add('startingDate', DateType::class, [
                'label' => '* Event opening date ',
                'widget' => 'single_text',
            ])
            ->add('startingTime', TimeType::class, [
                'label' => '* Event opening time ',
                'widget' => 'single_text',
            ])
            ->add('finishDate', DateType::class, [
                'label' => '* Event closing date ',
                'widget' => 'single_text',
            ])
            ->add('finishTime', TimeType::class, [
                'label' => '* Event closing time ',
                'widget' => 'single_text',
            ])
            ->add('place', EntityType::class, [
                'label' => '* Place ',
                'class' => Place::class,
                'choice_label' => function (Place $place) {
                    return $place->getName() . ' - ' . $place->getAddress() . ' - ' . $place->getCity() . ' - ' . $place->getPostcode();
                },
            ])
            ->add('contact', EntityType::class, [
                'label' => '* Contact ',
                'class' => Contact::class,
                'choice_label' => function (Contact $contact) {
                    return $contact->getSurname() . ' - ' . $contact->getName() . ' - ' . $contact->getRole();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
            'is_edit' => false,
        ]);
    }
}
