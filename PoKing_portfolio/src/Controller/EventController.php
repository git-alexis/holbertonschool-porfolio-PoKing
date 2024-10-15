<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventFormType;
use App\Repository\EventRepository;
use App\Repository\RegistrationRepository;
use Doctrine\ORM\EntityManagerInterface;
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
        $form = $this->createForm(EventFormType::class, $event);
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

    #[Route('/{id}/update', name: 'app_event_update', methods: ['GET', 'POST'])]
    public function update(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventFormType::class, $event);
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
    public function delete(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_event_listing', [], Response::HTTP_SEE_OTHER);
    }
}
