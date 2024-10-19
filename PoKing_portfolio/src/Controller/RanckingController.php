<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Rancking;
use App\Form\RanckingFormType;
use App\Repository\EventRepository;
use App\Repository\RanckingRepository;
use App\Repository\RegistrationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/rancking')]
final class RanckingController extends AbstractController
{
    #[Route(name: 'app_rancking_listing', methods: ['GET'])]
    public function listing(EventRepository $eventRepository): Response
    {
        return $this->render('rancking/listing.html.twig', [
            'events' => $eventRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_rancking_view', methods: ['GET'])]
    public function view(Rancking $rancking): Response
    {
        return $this->render('rancking/view.html.twig', [
            'rancking' => $rancking,
        ]);
    }

    #[Route('/{id}/create', name: 'app_rancking_create', methods: ['GET', 'POST'])]
    public function create(Event $event, RegistrationRepository $registrationRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $rancking = new Rancking();
        $form = $this->createForm(RanckingFormType::class, $rancking);
        $form->handleRequest($request);

        $registrations = $registrationRepository->findBy(['event' => $event]);
        $pseudoList = [];

        foreach ($registrations as $registration) {
            $pseudo = $registration->getUser()->getPseudo();
            $pseudoList[] = $pseudo;
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $rancking->setEvent($event);
            $entityManager->persist($rancking);
            $entityManager->flush();

            return $this->redirectToRoute('app_rancking_listing', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rancking/create.html.twig', [
            'pseudoList' => $pseudoList,
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/update', name: 'app_rancking_update', methods: ['GET', 'POST'])]
    public function update(Request $request, Rancking $rancking, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RanckingFormType::class, $rancking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_rancking_view', ['id' => $rancking->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rancking/update.html.twig', [
            'rancking' => $rancking,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rancking_delete', methods: ['POST'])]
    public function delete(Request $request, Rancking $rancking, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rancking->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($rancking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_rancking_listing', [], Response::HTTP_SEE_OTHER);
    }
}
