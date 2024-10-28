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

            $existingLabel = $entityManager->getRepository(Event::class)->findOneBy(['label' => $label]);

            if ($existingLabel) {
                $this->addFlash('error', 'Le libellé est déjà utilisé. Veuillez en choisir un autre.');
            } else {
                $entityManager->persist($event);
                $entityManager->flush();

                $this->addFlash('success', 'La manche a été créé avec succès. Vous pouvez maintenant en créer d\'autre.');
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

        $existingRegistration = $entityManager->getRepository(Registration::class)
            ->findOneBy(['event' => $event, 'user' => $user]);

        if (!$existingRegistration) {
            $registration = new Registration();
            $registration->setEvent($event);
            $registration->setUser($user);

            $registration->setRegistrationDate(new \DateTime());

            $registration->setRegistrationTime(new \DateTime());

            $entityManager->persist($registration);
            $entityManager->flush();

            $this->addFlash('success', 'Vous êtes inscrit à cet événement.');
        } else {
            $this->addFlash('error', 'Vous êtes déjà inscrit à cet événement.');
        }

        return $this->redirectToRoute('app_event_view', ['id' => $event->getId()]);
    }

    #[Route('/{id}/unregister', name: 'app_event_unregister', methods: ['POST'])]
    public function unregister(Event $event, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $existingRegistration = $entityManager->getRepository(Registration::class)
            ->findOneBy(['event' => $event, 'user' => $user]);

        if ($existingRegistration) {
            $entityManager->remove($existingRegistration);
            $entityManager->flush();

            $this->addFlash('success', 'Votre désinscription a été effectuée.');
        } else {
            $this->addFlash('error', 'Vous n\'êtes pas inscrit à cet événement.');
        }

        return $this->redirectToRoute('app_event_view', ['id' => $event->getId()]);
    }

    #[Route('/{id}/export-pdf', name: 'app_event_pdf_export', methods: ['POST'])]
    public function exportPdf(int $id, RegistrationRepository $registrationRepository): Response
    {
        $registrations = $registrationRepository->findBy(['event' => $id]);

        $options = new Options();
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);

        $html = $this->renderView('event/registration_list.html.twig', [
            'registrations' => $registrations,
        ]);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        return $dompdf->stream('inscrits.pdf', [
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
            $entityManager->flush();

            return $this->redirectToRoute('app_event_view', ['id' => $event->getId()], Response::HTTP_SEE_OTHER);
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
            $registrations = $entityManager->getRepository(Registration::class)->findBy(['event' => $event]);
            $ranckings = $ranckingRepository->findBy(['event' => $event]);

            foreach ($registrations as $registration) {
                $entityManager->remove($registration);

                $entityManager->flush();
            }

            foreach ($ranckings as $rancking) {
                $entityManager->remove($rancking);

                $entityManager->flush();
            }

            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_event_listing', [], Response::HTTP_SEE_OTHER);
    }
}
