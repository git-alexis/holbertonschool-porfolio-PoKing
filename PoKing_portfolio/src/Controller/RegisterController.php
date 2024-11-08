<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Profile;
use App\Form\RegisterFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, Security $security): Response
    {
        $new_user = new User();

        $form = $this->createForm(RegisterFormType::class, $new_user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pseudo = $form->get('pseudo')->getData();

            $existingUser = $entityManager->getRepository(User::class)->findOneBy(['pseudo' => $pseudo]);

            if ($existingUser) {
                $this->addFlash('error', 'Pseudo already used. Please choose a new one.');
            } else {
                $profile = $entityManager->getRepository(Profile::class)->findOneBy(['label' => 'noMember']);

                $new_user->setProfile($profile);

                $new_user->setPassword(
                    $passwordHasher->hashPassword(
                        $new_user,
                        $form->get('plainPassword')->getData()
                    )
                );

                $entityManager->persist($new_user);
                $entityManager->flush();

                $this->addFlash('success', 'Account created successfully. You can now log in.');
            }
        }

        return $this->render('register/register.html.twig', [
            'registerForm' => $form->createView(),
        ]);
    }
}
