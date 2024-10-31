<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\MyAccountFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/my-account')]
class MyAccountController extends AbstractController
{
    #[Route(name: 'app_my_account', methods: ['GET', 'POST', 'PUT'])]
    public function myAccount(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(MyAccountFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Compte mis à jour avec succès.');
        }

        return $this->render('my_account/my_account.html.twig', [
            'myAccountForm' => $form->createView(),
        ]);
    }
}
