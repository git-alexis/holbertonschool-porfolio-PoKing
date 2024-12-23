<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Registration;
use App\Form\EventFormType;
use App\Repository\EventRepository;
use App\Repository\RanckingRepository;
use App\Repository\RegistrationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/event')]
final class EventController extends AbstractController
{
    #[Route(name: 'app_event_listing', methods: ['GET'])]
    public function listing(EventRepository $eventRepository): Response
    {
        return $this->render('event/listing.html.twig', [
            // search for all existing events
            'events' => $eventRepository->findAll(),
        ]);
    }

    #[Route('/create', name: 'app_event_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Event();

        $form = $this->createForm(EventFormType::class, $event, [
            'is_edit' => false,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $label = $form->get('label')->getData();
            // check if the event name already exists in database
            $existingLabel = $entityManager->getRepository(Event::class)->findOneBy(['label' => $label]);

            // if this is the case, error message
            if ($existingLabel) {
                $this->addFlash('error', 'Label already used. Please choose another.');
            } else {
                // retrieves the dates entered
                $registrationOpeningDate = $form->get('registrationOpeningDate')->getData();
                $registrationClosingDate = $form->get('registrationClosingDate')->getData();
                $startingDate = $form->get('startingDate')->getData();
                $finishDate = $form->get('finishDate')->getData();

                // converts dates into the correct format
                $formattedRegistrationOpeningDate = $registrationOpeningDate->format('Ymd');
                $formattedRegistrationClosingDate = $registrationClosingDate->format('Ymd');
                $formattedStartingDate = $startingDate->format('Ymd');
                $formattedFinishDate = $finishDate->format('Ymd');

                // if the dates order is incorrect, error message
                if ( !($formattedRegistrationOpeningDate < $formattedRegistrationClosingDate && ($formattedRegistrationClosingDate < $formattedStartingDate || $formattedRegistrationClosingDate == $formattedStartingDate)
                && ($formattedStartingDate < $formattedFinishDate || $formattedStartingDate == $formattedFinishDate))) {
                    $this->addFlash('error', 'Wrong dates, right order : current date <= registration opening date < registration closing date <= event starting date <= event finish date.');
                } else {
                    // saves the event in the database with a success message
                    $entityManager->persist($event);
                    $entityManager->flush();

                    $this->addFlash('success', 'Event created successfully. You can now create another.');
                }
            }
        }

        return $this->render('event/create.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_event_view', methods: ['GET'])]
    public function view(Event $event, RegistrationRepository $registrationRepository): Response
    {
        // searches for all registrants for the event passed in parameter
        $registrations = $registrationRepository->findBy(['event' => $event]);

        return $this->render('event/view.html.twig', [
            'event' => $event,
            'registrations' => $registrations,
        ]);
    }

    #[Route('/{id}/register', name: 'app_event_register', methods: ['POST'])]
    public function register(Event $event, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        // searches for one registrant for the event passed in parameter
        $existingRegistration = $entityManager->getRepository(Registration::class)
            ->findOneBy(['event' => $event, 'user' => $user]);

        // if there is no associated registration, saves the registration in the database with a success message
        if (!$existingRegistration) {
            $registration = new Registration();
            $registration->setEvent($event);
            $registration->setUser($user);

            $registration->setRegistrationDate(new \DateTime());

            $registration->setRegistrationTime(new \DateTime());

            $entityManager->persist($registration);
            $entityManager->flush();

            $this->addFlash('success', 'You are registered for this event.');
        } else {
            // otherwise error message
            $this->addFlash('error', 'You have already registered for this event.');
        }

        return $this->redirectToRoute('app_event_view', ['id' => $event->getId()]);
    }

    #[Route('/{id}/unregister', name: 'app_event_unregister', methods: ['POST'])]
    public function unregister(Event $event, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        // searches for one registrant for the event passed in parameter
        $existingRegistration = $entityManager->getRepository(Registration::class)
            ->findOneBy(['event' => $event, 'user' => $user]);

        // if there is associated registration, removes the registration in the database with a success message
        if ($existingRegistration) {
            $entityManager->remove($existingRegistration);
            $entityManager->flush();

            $this->addFlash('success', 'You are no longer registered for this event.');
        } else {
            // otherwise error message
            $this->addFlash('error', 'You are not yet registered for this event.');
        }

        return $this->redirectToRoute('app_event_view', ['id' => $event->getId()]);
    }

    #[Route('/{id}/export-pdf', name: 'app_event_pdf_export', methods: ['POST'])]
    public function exportPdf(int $id, RegistrationRepository $registrationRepository): Response
    {
        // searches for all registrants for the event passed in parameter
        $registrations = $registrationRepository->findBy(['event' => $id]);

        // Configures Dompdf options, including the default font
        $options = new Options();
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);

        // Generates HTML content from the Twig template with the list of registrations
        $html = $this->renderView('event/registration_list.html.twig', [
            'registrations' => $registrations,
        ]);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        // Converts HTML to PDF
        $dompdf->render();

        return $dompdf->stream('inscrits.pdf', [
            // Forces download PDF file
            'Attachment' => true,
        ]);
    }

    #[Route('/{id}/update', name: 'app_event_update', methods: ['GET', 'POST'])]
    public function update(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventFormType::class, $event, [
            'is_edit' => true,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // retrieves the dates entered
            $registrationOpeningDate = $form->get('registrationOpeningDate')->getData();
            $registrationClosingDate = $form->get('registrationClosingDate')->getData();
            $startingDate = $form->get('startingDate')->getData();
            $finishDate = $form->get('finishDate')->getData();

            // converts dates into the correct format
            $formattedRegistrationOpeningDate = $registrationOpeningDate->format('Ymd');
            $formattedRegistrationClosingDate = $registrationClosingDate->format('Ymd');
            $formattedStartingDate = $startingDate->format('Ymd');
            $formattedFinishDate = $finishDate->format('Ymd');

            // if the dates order is incorrect, error message
            if ( !($formattedRegistrationOpeningDate < $formattedRegistrationClosingDate && ($formattedRegistrationClosingDate < $formattedStartingDate || $formattedRegistrationClosingDate == $formattedStartingDate)
            && ($formattedStartingDate < $formattedFinishDate || $formattedStartingDate == $formattedFinishDate))) {
                $this->addFlash('error', 'Wrong dates, right order : registration opening date < registration closing date <= event starting date <= event finish date.');
            } else {
                // updates the event in the database and redirects to event details
                $entityManager->flush();

                return $this->redirectToRoute('app_event_view', ['id' => $event->getId()], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('event/update.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_event_delete', methods: ['POST'])]
    public function delete(Request $request, Event $event, RanckingRepository $ranckingRepository, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->getPayload()->getString('_token'))) {
            // searches for all registrants for the event passed in parameter
            $registrations = $entityManager->getRepository(Registration::class)->findBy(['event' => $event]);
            // searches for all rankings for the event passed in parameter
            $ranckings = $ranckingRepository->findBy(['event' => $event]);

            // removes all registrations
            foreach ($registrations as $registration) {
                $entityManager->remove($registration);

                $entityManager->flush();
            }

            // removes all rankings
            foreach ($ranckings as $rancking) {
                $entityManager->remove($rancking);

                $entityManager->flush();
            }

            // removes the event
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_event_listing', [], Response::HTTP_SEE_OTHER);
    }
}
