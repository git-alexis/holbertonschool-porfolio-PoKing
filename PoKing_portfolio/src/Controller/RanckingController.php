<?php

namespace App\Controller;

use App\Entity\Rancking;
use App\Form\RanckingFormType;
use App\Repository\RanckingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/rancking')]
final class RanckingController extends AbstractController
{
    #[Route(name: 'app_rancking_listing', methods: ['GET'])]
    public function listing(RanckingRepository $ranckingRepository): Response
    {
        return $this->render('rancking/listing.html.twig', [
            'ranckings' => $ranckingRepository->findAll(),
        ]);
    }

    #[Route('/create', name: 'app_rancking_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rancking = new Rancking();
        $form = $this->createForm(RanckingFormType::class, $rancking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $label = $form->get('label')->getData();

            $existingLabel = $entityManager->getRepository(Rancking::class)->findOneBy(['label' => $label]);
            if ($existingLabel) {
                $this->addFlash('error', 'Le libellé est déjà utilisé. Veuillez en choisir un autre.');
            } else {
                $entityManager->persist($rancking);
                $entityManager->flush();

                $this->addFlash('success', 'Le classement a été créé avec succès. Vous pouvez maintenant en créer d\'autre.');
            }
        }

        return $this->render('rancking/create.html.twig', [
            'rancking' => $rancking,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rancking_view', methods: ['GET'])]
    public function view(Rancking $rancking): Response
    {
        return $this->render('rancking/view.html.twig', [
            'rancking' => $rancking,
        ]);
    }

    #[Route('/{id}/update', name: 'app_rancking_update', methods: ['GET', 'POST'])]
    public function update(Request $request, Rancking $rancking, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RanckingFormType::class, $rancking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_rancking_listing', [], Response::HTTP_SEE_OTHER);
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
