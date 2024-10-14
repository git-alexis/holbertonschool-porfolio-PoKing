<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Event;
use App\Entity\Place;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('season')
            ->add('label')
            ->add('startingDate', null, [
                'widget' => 'single_text',
            ])
            ->add('finishDate', null, [
                'widget' => 'single_text',
            ])
            ->add('startingTime', null, [
                'widget' => 'single_text',
            ])
            ->add('finishTime', null, [
                'widget' => 'single_text',
            ])
            ->add('stack')
            ->add('comment')
            ->add('registrationOpeningDate', null, [
                'widget' => 'single_text',
            ])
            ->add('registrationClosingDate', null, [
                'widget' => 'single_text',
            ])
            ->add('registrationOpeningTime', null, [
                'widget' => 'single_text',
            ])
            ->add('registrationClosingTime', null, [
                'widget' => 'single_text',
            ])
            ->add('place', EntityType::class, [
                'class' => Place::class,
                'choice_label' => function (Place $place) {
                    return $place->getName() . ' - ' . $place->getAddress() . ' - ' . $place->getCity() . ' - ' . $place->getPostcode();
                }
            ])
            ->add('contact', EntityType::class, [
                'class' => Contact::class,
                'choice_label' => function (Contact $contact) {
                    return $contact->getSurname() . ' - ' . $contact->getName() . ' - ' . $contact->getRole();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
